<?php

namespace App\Http\Controllers;
use App\Mail\ReservationRemainder;
use App\Models\FasilitesReservation;
use App\Models\faculty_offices;
use App\Models\Room;
use  Illuminate\Support\Facades\DB;
use App\Models\list_student_booking;
use Illuminate\Http\Request;
use App\Models\User;
   use Illuminate\Support\Facades\Notification;
   use App\Notifications\NewReservationNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\ReservationEmail;
use Illuminate\Support\Facades\Hash;

class FacilitiesReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Allow access if the user is either an admin, a user, or a PPP
            if (!auth()->user() ||
                (!auth()->user()->isAdmin() && !auth()->user()->isUser() && !auth()->user()->isPpp())) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }
    public function index()
    {
        $reservation = FasilitesReservation::with('room', 'listStudentBooking', 'facultyOffice')
            ->orderBy('created_at', 'DESC') // Changed to DESC for newest first
            ->paginate(10);
        
        return view('backend.reservation.index', compact('reservation'));
    }
    public function create()
    {
            $rooms = Room::all();
            $facultie = faculty_offices::all();
            $participant_category = ['Staff', 'VVIP', 'Public', 'Student', 'Other'];
            $event_type = ['Physical','Online'];
            
            // Remove the students variable since we're using text input now
            return view('backend.reservation.create', compact('rooms', 'facultie', 'participant_category', 'event_type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'staff_id_matric_no' => 'required|string|max:255',
            'faculty_office_id' => 'required|exists:faculty_offices,no_facultyOffice',
            'contact_no' => 'required|string|max:255',
            'room_selections' => 'required|array|min:1',
            'room_selections.*.room_id' => 'required|string',
            'room_selections.*.other_room_description' => 'required_if:room_selections.*.room_id,other|nullable|string|max:255',
            'purpose_program_name' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:' . now()->addDays(3)->format('Y-m-d'),
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'no_of_participants' => 'required|integer|min:1',
            'participant_category' => 'required|in:Staff,VVIP,Public,Student,Other',
            'other_participant_category' => 'required_if:participant_category,Other|nullable|string|max:255',
            'event_type' => 'required|in:Physical,Online',
            'document_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'declaration_accepted' => 'required|accepted',
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        // Custom validation for room selections with "other" option
        foreach ($request->room_selections as $index => $roomSelection) {
            if ($roomSelection['room_id'] === 'other') {
                if (empty($roomSelection['other_room_description']) || trim($roomSelection['other_room_description']) === '') {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Please specify the room name for "Other" selection in Room #' . ($index + 1));
                }
            }
        }

        // -------------------------------------------------------------
        // Resolve the logged-in creator via list_student_booking (AUTO-CREATE if needed)
        // -------------------------------------------------------------
        $auth = auth()->user();
        $authNoMatriks = $auth->no_matriks ?? $auth->student_id ?? null; // prefer no_matriks; fallback to student_id
        if (!$authNoMatriks) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Your account is missing a matric number (no_matriks). Please contact administrator.');
        }

        // Ensure the logged-in user has a list_student_booking record
        $creatorLSB = list_student_booking::firstOrCreate([
            'no_matriks' => $authNoMatriks,
        ]);
        $createdByMatricNo = $creatorLSB->id; // this is the FK expected by created_by_matric_no

        // -------------------------------------------------------------
        // Validate the STAFF/REQUESTED matric no: Check if exists in users table
        // If not in users, CREATE new user first, then ensure lsb row exists
        // If user exists, ensure an lsb row exists (create only then).
        // -------------------------------------------------------------
        $matricNo = trim($request->staff_id_matric_no);
        $user = User::where('no_matriks', $matricNo)->first();
        
        if (!$user) {
            // Create new user record first
            $user = User::firstOrCreate(
                ['no_matriks' => $matricNo],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'facultyOffice' => $request->faculty_office_id,
                    'course' => null,
                    'password' => Hash::make($matricNo),
                    'role' => 'user',
                ]
            );
        }

        // Now ensure the list_student_booking record exists
        $studentBookingRecord = list_student_booking::firstOrCreate([
            'no_matriks' => $matricNo,
        ]);
        $staffIdMatricNoId = $studentBookingRecord->id; // this is the FK expected by staff_id_matric_no

        // Basic time sanity when same date
        if ($request->start_date === $request->end_date && $request->start_time >= $request->end_time) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'End time must be after start time when booking for the same date.');
        }

        $createdReservations = [];
        $conflictRooms = [];

        DB::beginTransaction();
        try {
            foreach ($request->room_selections as $roomSelection) {
                $roomId = $roomSelection['room_id'];
                $otherDescription = $roomSelection['other_room_description'] ?? null;

                if ($roomId !== 'other') {
                    // Conflict with UNAVAILABLE schedule (time overlap)
                    $conflictWithUnavailable = DB::table('schedule_booking')
                        ->where('roomid', $roomId)
                        ->whereBetween('invalid_date', [$request->start_date, $request->end_date])
                        ->where(function ($q) use ($request) {
                            $q->where('invalid_time_start', '<', $request->end_time)
                            ->where('invalid_time_end',   '>', $request->start_time);
                        })
                        ->exists();

                    if ($conflictWithUnavailable) {
                        $room = Room::where('no_room', $roomId)->first();
                        $conflictRooms[] = $room->name ?? ("Room ID: $roomId");
                        continue;
                    }

                    // Conflict with EXISTING reservations (date and time windows)
                    $conflictWithReservations = FasilitesReservation::where('room_id', $roomId)
                        ->whereNotIn('status', ['Rejected', 'Cancelled'])
                        ->where(function ($q) use ($request) {
                            $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                            ->orWhereBetween('end_date',   [$request->start_date, $request->end_date])
                            ->orWhere(function ($qq) use ($request) { // enclosing case
                                $qq->where('start_date', '<=', $request->start_date)
                                    ->where('end_date',   '>=', $request->end_date);
                            })
                            ->orWhere(function ($qq) use ($request) { // same-day time overlap
                                $qq->whereColumn('start_date', 'end_date')
                                    ->where('start_date', $request->start_date)
                                    ->where('start_time', '<', $request->end_time)
                                    ->where('end_time',   '>', $request->start_time);
                            });
                        })
                        ->exists();

                    if ($conflictWithReservations) {
                        $room = Room::where('no_room', $roomId)->first();
                        $conflictRooms[] = $room->name ?? ("Room ID: $roomId");
                        continue;
                    }
                }

                // Handle file upload (kept as your existing helper)
                $fileData = $this->handleFileUpload($request->file('document_file'));

                // Create the reservation
                $reservation = FasilitesReservation::create([
                    'created_by_matric_no' => $createdByMatricNo, // FK to list_student_booking.id
                    'email' => $request->email,
                    'name' => $request->name,
                    'staff_id_matric_no' => $staffIdMatricNoId,   // FK to list_student_booking.id of staff/request owner
                    'faculty_office_id' => $request->faculty_office_id,
                    'contact_no' => $request->contact_no,
                    'room_id' => $roomId === 'other' ? null : $roomId,
                    'other_room_description' => $roomId === 'other' ? $otherDescription : null,
                    'purpose_program_name' => $request->purpose_program_name,
                    'start_date' => $request->start_date,
                    'start_time' => $request->start_time,
                    'end_date' => $request->end_date,
                    'end_time' => $request->end_time,
                    'no_of_participants' => $request->no_of_participants,
                    'participant_category' => $request->participant_category,
                    'other_participant_category' => $request->other_participant_category,
                    'event_type' => $request->event_type,
                    'file_path' => $fileData['path'],
                    'file_original_name' => $fileData['original_name'],
                    'file_size' => $fileData['size'],
                    'file_type' => $fileData['type'],
                    'declaration_accepted' => $request->boolean('declaration_accepted') ? 1 : 0,
                    'status' => $request->status,
                ]);

                $createdReservations[] = $reservation;

                // Attach student to reservation if your controller provides it
                if (method_exists($this, 'attachStudentToReservation')) {
                    $this->attachStudentToReservation($reservation, $createdByMatricNo, $staffIdMatricNoId);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create reservation(s). ' . $e->getMessage());
        }

        // AFTER COMMIT: send emails & notify admins
        if (count($createdReservations) > 0) {
            $admins = User::where('role', 'admin')->get();
            
            foreach ($createdReservations as $reservation) {
                // Send notification to admins (database + real-time via Pusher)
                Notification::send($admins, new NewReservationNotification($reservation));
                
                // Send emails to reservation users
                if (class_exists('App\\Http\\Controllers\\EmailController')) {
                    $emailController = new \App\Http\Controllers\EmailController();
                    if (method_exists($emailController, 'sendReservationEmail')) {
                        try {
                            $emailController->sendReservationEmailViaQueue($reservation->id);
                        } catch (\Exception $e) {
                            \Log::error('Failed to send reservation email: ' . $e->getMessage());
                        }
                    }
                }
            }
        }

        // Build response message
        $successCount = count($createdReservations);
        $conflictCount = count($conflictRooms);
        if ($successCount > 0 && $conflictCount > 0) {
            $baseMessage = "Successfully created {$successCount} reservation(s). However, {$conflictCount} room(s) could not be reserved due to conflicts: " . implode(', ', $conflictRooms);
            return redirect()->route('backend.reservation.index')->with('warning', $baseMessage);
        } elseif ($successCount > 0) {
            $baseMessage = $successCount === 1 ? 'Reservation created successfully.' : "Successfully created {$successCount} reservations.";
            return redirect()->route('backend.reservation.index')->with('success', $baseMessage);
        }

        $baseMessage = "No reservations could be created. All selected rooms have conflicts: " . implode(', ', $conflictRooms);
        return redirect()->route('backend.reservation.create')->withInput()->with('error', $baseMessage);
    }
    /**
     * Handle file upload and return file data
     */
    private function handleFileUpload($file)
    {
        if (!$file) {
            throw new \Exception('No file uploaded');
        }

        // Generate unique filename
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        
        // Store file in public/uploads/reservations directory
        $filePath = $file->storeAs('public/reservations', $fileName);
        
        // Get file size and mime type
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        
        return [
            'path' => $filePath,
            'original_name' => $originalName,
            'size' => $fileSize,
            'type' => $mimeType,
            'name' => $fileName
        ];
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'admin_comment' => 'nullable|string|max:1000',
        ]);

        $reservation = FasilitesReservation::findOrFail($id);
        
        // Store old status for comparison
        $oldStatus = $reservation->status;
        
        // Update reservation status and admin comment
        $reservation->update([
            'status' => $request->status,
            'admin_comment' => $request->admin_comment,
            'admin_updated_by' => auth()->id(),
            'admin_updated_at' => now(),
        ]);

        // Send status update email only if status actually changed
        if ($oldStatus !== $request->status) {
            $emailController = new \App\Http\Controllers\EmailController();
            $emailController->sendReservationStatusUpdateEmail($reservation->id);
        }

        return redirect()->back()
            ->with('success', 'Reservation status updated successfully and notification email sent.');
    }
    public function show($id) {
        $reservation = FasilitesReservation::with([
            'room.furnitures',
            'room.electronics',
            'room.type',
            'createdBy.user',
            'listStudentBooking.user',
            'facultyOffice'
        ])->findOrFail($id);
        
        return view('backend.reservation.show', compact('reservation'));
    }
    public function edit($id)
    {
        $reservation = FasilitesReservation::findOrFail($id);
        $rooms = Room::all();
        $facultie = faculty_offices::all(); 
        $students = list_student_booking::all();
        
        // Get current user's matric number
        $auth = auth()->user();
        $currentUserMatricNo = $auth->no_matriks ?? $auth->student_id ?? null;
        
        // Determine user permissions
        $isAdmin = $auth->role === 'admin';
        $isOwner = false;
        
        if ($currentUserMatricNo) {
            // Check if current user is the creator or the staff member
            $creatorRecord = list_student_booking::find($reservation->created_by_matric_no);
            $staffRecord = list_student_booking::find($reservation->staff_id_matric_no);
            
            $isOwner = ($creatorRecord && $creatorRecord->no_matriks === $currentUserMatricNo) ||
                    ($staffRecord && $staffRecord->no_matriks === $currentUserMatricNo);
        }
        
        // Define what fields can be edited
        $canEditAll = $isOwner;
        $canEditAdminFields = $isAdmin;
        
        // If user has no permissions, redirect or show error
        if (!$canEditAll && !$canEditAdminFields) {
            return redirect()->route('backend.reservation.index')
                ->with('error', 'You do not have permission to edit this reservation.');
        }
        
        // Get dropdown options
        $participant_category = ['Staff', 'VVIP', 'Public', 'Student', 'Other'];
        $event_type = ['Physical', 'Online'];
        $status_options = ['Pending', 'Approved', 'Rejected', 'Cancelled'];
        
        return view('backend.reservation.edit', compact(
            'reservation',
            'rooms',
            'facultie',
            'students',
            'participant_category',
            'event_type',
            'status_options',
            'canEditAll',
            'canEditAdminFields',
            'isAdmin',
            'isOwner'
        ));
    }

    public function update(Request $request, $id)
    {
        $reservation = FasilitesReservation::findOrFail($id);
        
        // Get current user's matric number and role
        $auth = auth()->user();
        $currentUserMatricNo = $auth->no_matriks ?? $auth->student_id ?? null;
        $isAdmin = $auth->role === 'admin';
        
        // Determine user permissions (same logic as edit method)
        $isOwner = false;
        if ($currentUserMatricNo) {
            $creatorRecord = list_student_booking::find($reservation->created_by_matric_no);
            $staffRecord = list_student_booking::find($reservation->staff_id_matric_no);
            
            $isOwner = ($creatorRecord && $creatorRecord->no_matriks === $currentUserMatricNo) ||
                    ($staffRecord && $staffRecord->no_matriks === $currentUserMatricNo);
        }
        
        $canEditAll = $isOwner;
        $canEditAdminFields = $isAdmin;
        
        if (!$canEditAll && !$canEditAdminFields) {
            return redirect()->route('backend.reservation.index')
                ->with('error', 'You do not have permission to update this reservation.');
        }
        
        // Define validation rules based on permissions
        if ($canEditAll) {
            // Full validation for owners
            $validationRules = [
                'email' => 'required|email',
                'name' => 'required|string|max:255',
                'staff_id_matric_no' => 'required|string|max:255',
                'faculty_office_id' => 'required|exists:faculty_offices,no_facultyOffice',
                'contact_no' => 'required|string|max:255',
                'room_id' => 'required|string',
                'other_room_description' => 'required_if:room_id,other|nullable|string|max:255',
                'purpose_program_name' => 'required|string|max:255',
                'start_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_date' => 'required|date|after_or_equal:start_date',
                'end_time' => 'required|date_format:H:i',
                'no_of_participants' => 'required|integer|min:1',
                'participant_category' => 'required|in:Staff,VVIP,Public,Student,Other',
                'other_participant_category' => 'required_if:participant_category,Other|nullable|string|max:255',
                'event_type' => 'required|in:Physical,Online',
                'document_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            ];
        } else {
            // Admin-only validation
            $validationRules = [
                'status' => 'required|in:Pending,Approved,Rejected,Cancelled',
                'admin_comment' => 'nullable|string|max:1000',
            ];
        }
        
        $request->validate($validationRules);
        
        DB::beginTransaction();
        try {
            $originalStatus = $reservation->status; // Store original status
            
            if ($canEditAll) {
                // Handle full update for owners
                
                // Handle staff_id_matric_no update (similar to store logic)
                $matricNo = trim($request->staff_id_matric_no);
                $user = User::where('no_matriks', $matricNo)->first();
                
                if (!$user) {
                    $user = User::firstOrCreate(
                        ['no_matriks' => $matricNo],
                        [
                            'name' => $request->name,
                            'email' => $request->email,
                            'facultyOffice' => $request->faculty_office_id,
                            'course' => null,
                            'password' => Hash::make($matricNo),
                            'role' => 'user',
                        ]
                    );
                }
                
                $studentBookingRecord = list_student_booking::firstOrCreate([
                    'no_matriks' => $matricNo,
                ]);
                
                // Handle file upload if new file provided
                $updateData = [
                    'email' => $request->email,
                    'name' => $request->name,
                    'staff_id_matric_no' => $studentBookingRecord->id,
                    'faculty_office_id' => $request->faculty_office_id,
                    'contact_no' => $request->contact_no,
                    'room_id' => $request->room_id === 'other' ? null : $request->room_id,
                    'other_room_description' => $request->room_id === 'other' ? $request->other_room_description : null,
                    'purpose_program_name' => $request->purpose_program_name,
                    'start_date' => $request->start_date,
                    'start_time' => $request->start_time,
                    'end_date' => $request->end_date,
                    'end_time' => $request->end_time,
                    'no_of_participants' => $request->no_of_participants,
                    'participant_category' => $request->participant_category,
                    'other_participant_category' => $request->other_participant_category,
                    'event_type' => $request->event_type,
                ];
                
                // Handle file upload if provided
                if ($request->hasFile('document_file')) {
                    $fileData = $this->handleFileUpload($request->file('document_file'));
                    $updateData = array_merge($updateData, [
                        'file_path' => $fileData['path'],
                        'file_original_name' => $fileData['original_name'],
                        'file_size' => $fileData['size'],
                        'file_type' => $fileData['type'],
                    ]);
                }
                
                $reservation->update($updateData);
                
            } elseif ($canEditAdminFields) {
                // Admin-only update
                $updateData = [
                    'status' => $request->status,
                    'admin_updated_by' => $auth->id,
                    'admin_updated_at' => now(),
                ];
                
                if ($request->filled('admin_comment')) {
                    $updateData['admin_comment'] = $request->admin_comment;
                }
                
                $reservation->update($updateData);
            }
            
            DB::commit();
            
            // Send status update email only if status actually changed
            if ($canEditAdminFields && isset($updateData['status']) && $originalStatus !== $updateData['status']) {
                try {
                    if (class_exists('App\\Http\\Controllers\\EmailController')) {
                        $emailController = new \App\Http\Controllers\EmailController();
                        if (method_exists($emailController, 'sendReservationStatusUpdateEmail')) {
                            $emailController->sendReservationStatusUpdateEmail($reservation->id);
                            \Log::info('Reservation status update email sent for reservation ID: ' . $reservation->id);
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to send reservation status update email: ' . $e->getMessage());
                    // Don't fail the update if email fails
                }
            }
            
            $message = $canEditAll ? 'Reservation updated successfully.' : 'Reservation status updated successfully.';
            return redirect()->route('backend.reservation.index')->with('success', $message);
            
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update reservation. ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        // Logic to delete the specified facility reservation
        $reservation = FasilitesReservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('backend.reservation.index')->with('success', 'Reservation deleted successfully.');
    }
}
