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
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\ReservationEmail;
use App\Notifications\NewReservationNotification;

class FaciliesReservationController extends Controller
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
        $reservation = FasilitesReservation::with('room','listStudentBookings','faculty')
            ->orderBy('created_at', 'ASC')
            ->get();
        return view('backend.facilitiesReservation.index', compact('reservation'));
    }
    public function create()
    {
        $rooms = Room::all();
        $faculties = faculty_offices::all();
        $students = list_student_booking::all();
        return view('backend.facilitiesReservation.create', compact('rooms', 'faculties', 'students'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'created_by_matric_no' => 'required|exists:list_student_booking,id',
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'staff_id_matric_no' => 'required|exists:list_student_booking,id',
            'faculty_office_id' => 'required|exists:faculty_offices,no_facultyOffice',
            'contact_no'=>'required|string|max:255',
            'room_id' => 'required|exists:rooms,no_room',
            'other_room_description'=>'required|string|max:255',
            'purpose_program_name' => 'required|string|max:255',
            'start_date'=> 'required|date',
            'start_time'=> 'required|date_format:H:i',
            'end_date'=> 'required|date',
            'end_time'=> 'required|date_format:H:i',
            'no_of_participants' => 'required|integer',
            'participant_category' => 'required|in:Staff,VVIP,Public,Student,Other',
            'other_participant_category' => 'required_if:participant_category,Other|string|max:255',
            'event_type'=>'required|in:Physical,Online',
            'file_name'=> 'required|string|max:255',
            'file_path' => 'required|string|max:255',
            'file_original_name' => 'required|string|max:255',
            'file_size' => 'required|integer',
            'file_type'=>'required|string|max:255',
            'declaration_accepted'=> 'required|boolean',
            'status'=>'required|in:Pending,Approved,Rejected',
        ]);

        // check unavailable schedule
        $conflictWithUnavailable = \DB::table('schedule_bboking')
            ->whereBetween('invalid_date', [$request->start_date, $request->end_date])
            ->where(function($query) use ($request){
                $query->where('start_time', '<=', $request->start_time)
                    ->where('end_time', '>=', $request->end_time);
            })
            ->exists();

        if ($conflictWithUnavailable) {
            return redirect()->route('backend.facilitiesReservation.create')
                ->with('error', 'The selected date range conflicts with an unavailable time slot.');
        }

        // save reservation
        $reservation = FasilitesReservation::create([
            'created_by_matric_no' => $request->created_by_matric_no,
            'email' => $request->email,
            'name' => $request->name,
            'staff_id_matric_no' => $request->staff_id_matric_no,
            'faculty_office_id' => $request->faculty_office_id,
            'contact_no'=>$request->contact_no,
            'room_id' => $request->room_id,
            'other_room_description'=>$request->other_room_description,
            'purpose_program_name' => $request->purpose_program_name,
            'start_date'=>$request->start_date,
            'start_time'=>$request->start_time,
            'end_date'=>$request->end_date,
            'end_time'=>$request->end_time,
            'no_of_participants' => $request->no_of_participants,
            'participant_category' => $request->participant_category,
            'other_participant_category' => $request->other_participant_category,
            'event_type'=>$request->event_type,
            'file_name'=>$request->file_name,
            'file_path' => $request->file_path,
            'file_original_name' => $request->file_original_name,
            'file_size' => $request->file_size,
            'file_type'=>$request->file_type,
            'declaration_accepted'=>$request->declaration_accepted,
            'status'=>$request->status
        ]);

        // attach student
        $this->attachStudentToReservation($reservation, $request->created_by_matric_no, $request->staff_id_matric_no);

        // Send email using EmailController
        $emailController = new \App\Http\Controllers\EmailController();
        $emailController->sendReservationEmail($reservation->id);

        // Send notification to admins
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewReservationNotification($reservation));

        return redirect()->route('backend.facilitiesReservation.index')
            ->with('success', 'Reservation created successfully.');
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
    public function show($id){
        $reservation = FasilitesReservation::with('room', 'listStudentBookings', 'faculty')
            ->findOrFail($id);
        return view('backend.facilitiesReservation.show', compact('reservation'));
    }
    public function edit($id){
       $reservation = FasilitesReservation::findOrFail($id);
        $rooms = Room::all();
        $faculties = faculty_offices::all();
        $students = list_student_booking::all();
        return view('backend.facilitiesReservation.edit', compact('reservation', 'rooms', 'faculties', 'students'));
    }
    public function update(Request $request, $id)
    {
        // Logic to update the specified facility reservation
    }
    public function destroy($id)
    {
        // Logic to delete the specified facility reservation
        $reservation = FasilitesReservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('backend.facilitiesReservation.index')->with('success', 'Reservation deleted successfully.');
    }
}
