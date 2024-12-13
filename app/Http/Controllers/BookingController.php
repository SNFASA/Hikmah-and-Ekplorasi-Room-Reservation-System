<?php
namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\list_student_booking;
use App\Models\User;
use App\Models\room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized access. Admins only.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $bookings = Bookings::with('room', 'listStudentBookings')
        ->orderBy('booking_date', 'ASC')
        ->orderBy('booking_time_start', 'ASC')
        ->paginate(10);
    

        return view('backend.booking.index', compact('bookings'));
    }

    public function create()
    {
        // Fetch all unavailable dates and times from schedule_booking
        $unavailableSlots = DB::table('schedule_booking')->get(['invalid_date', 'invalid_time_start', 'invalid_time_end']);
    
        // Fetch already booked dates and times from Bookings table
        $bookedSlots = DB::table('bookings')
            ->select('booking_date', 'booking_time_start', 'booking_time_end')
            ->get();
    
        $students = User::where('role', 'student')->get();
    
        return view('backend.booking.create', compact('students', 'unavailableSlots', 'bookedSlots'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'booking_time_start' => 'required|date_format:H:i',
            'booking_time_end' => 'required|date_format:H:i|after:booking_time_start',
            'purpose' => 'required|string|max:255',
            'no_room' => 'required|exists:rooms,no_room',
            'phone_number' => 'required|string|max:15',
            'students' => 'required|array|min:1',
            'students.*' => 'required|exists:users,no_matriks',
        ]);
    
        // Check if the selected date and time overlap with any unavailable time slots from schedule_booking
        $conflictWithUnavailable = DB::table('schedule_booking')
            ->where('invalid_date', $request->booking_date)
            ->where(function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    // Check if the start time overlaps with any unavailable time
                    $subQuery->where('invalid_time_start', '<', $request->booking_time_end)
                             ->where('invalid_time_end', '>', $request->booking_time_start);
                });
            })
            ->exists();
    
        if ($conflictWithUnavailable) {
            return back()->withErrors(['booking_time_start' => 'Selected time is unavailable due to schedule conflict.']);
        }
    
        // Check if the selected date and time overlap with any already booked slots for the selected room
        $conflictWithBooked = DB::table('bookings')
            ->where('no_room', $request->no_room)  // Ensure the same room is being checked
            ->where('booking_date', $request->booking_date)
            ->where(function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    // Check if the start time overlaps with any booked time
                    $subQuery->where('booking_time_start', '<', $request->booking_time_end)
                             ->where('booking_time_end', '>', $request->booking_time_start);
                });
            })
            ->exists();
    
        if ($conflictWithBooked) {
            return back()->withErrors(['booking_time_start' => 'Selected time is already booked for this room.']);
        }
    
        $duration = $this->calculateDuration($request->booking_time_start, $request->booking_time_end);
    
        $booking = Bookings::create([
            'booking_date' => $request->booking_date,
            'booking_time_start' => $request->booking_time_start,
            'booking_time_end' => $request->booking_time_end,
            'duration' => $duration,
            'purpose' => $request->purpose,
            'no_room' => $request->no_room,
            'phone_number' => $request->phone_number,
            'status' => 'approved',
        ]);
    
        $this->attachStudentsToBooking($booking, $request->students);
    
        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }
    
    
    public function edit($id)
    {
        $booking = Bookings::findOrFail($id);
        $rooms = room::all();
        $students = User::where('role', 'student')->get();
        $selectedStudents = $booking->listStudentBookings->pluck('no_matriks')->toArray(); // Fix: Use pluck on a collection

        return view('backend.booking.edit', compact('booking', 'rooms', 'students', 'selectedStudents'));
    }

    public function update(Request $request, $id)
    {
        $booking = Bookings::findOrFail($id);

        $request->validate([
            'booking_date' => 'required|date',
            'booking_time_start' => 'required|date_format:H:i',
            'booking_time_end' => 'required|date_format:H:i|after:booking_time_start',
            'purpose' => 'required|string|max:255',
            'no_room' => 'required|exists:rooms,no_room',
            'phone_number' => 'required|string|max:15',
            'students' => 'required|array|min:1',
            'students.*' => 'required|exists:users,no_matriks',
        ]);
                // Check if the selected date and time overlap with any unavailable time slots from schedule_booking
                $conflictWithUnavailable = DB::table('schedule_booking')
                ->where('invalid_date', $request->booking_date)
                ->where(function ($query) use ($request) {
                    $query->where(function ($subQuery) use ($request) {
                        // Check if the start time overlaps with any unavailable time
                        $subQuery->where('invalid_time_start', '<', $request->booking_time_end)
                                 ->where('invalid_time_end', '>', $request->booking_time_start);
                    });
                })
                ->exists();
        
            if ($conflictWithUnavailable) {
                return back()->withErrors(['booking_time_start' => 'Selected time is unavailable due to schedule conflict.']);
            }
        
            // Check if the selected date and time overlap with any already booked slots for the selected room
            $conflictWithBooked = DB::table('bookings')
                ->where('no_room', $request->no_room)  // Ensure the same room is being checked
                ->where('booking_date', $request->booking_date)
                ->where(function ($query) use ($request) {
                    $query->where(function ($subQuery) use ($request) {
                        // Check if the start time overlaps with any booked time
                        $subQuery->where('booking_time_start', '<', $request->booking_time_end)
                                 ->where('booking_time_end', '>', $request->booking_time_start);
                    });
                })
                ->exists();
        
            if ($conflictWithBooked) {
                return back()->withErrors(['booking_time_start' => 'Selected time is already booked for this room.']);
            }

        $duration = $this->calculateDuration($request->booking_time_start, $request->booking_time_end);

        $booking->update([
            'booking_date' => $request->booking_date,
            'booking_time_start' => $request->booking_time_start,
            'booking_time_end' => $request->booking_time_end,
            'duration' => $duration,
            'purpose' => $request->purpose,
            'no_room' => $request->no_room,
            'phone_number' => $request->phone_number,
        ]);

        $this->attachStudentsToBooking($booking, $request->students);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        $booking = Bookings::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }

    private function attachStudentsToBooking($booking, $students)
    {
        $booking->listStudentBookings()->detach();

        foreach ($students as $no_matriks) {
            $studentBooking = list_student_booking::firstOrCreate(['no_matriks' => $no_matriks]);
            $booking->listStudentBookings()->attach($studentBooking->id);
        }
    }

    private function calculateDuration($start, $end)
    {
        return Carbon::parse($start)->diffInMinutes(Carbon::parse($end));
    }
    public function getBookingsByMonth()
    {
    // Get the number of bookings grouped by month
    $bookings = DB::table('bookings')
        ->select(DB::raw('MONTH(booking_date) as month, COUNT(*) as total_bookings'))
        ->groupBy(DB::raw('MONTH(booking_date)'))
        ->orderBy(DB::raw('MONTH(booking_date)'), 'asc')
        ->get();

    // Format the data for the frontend
    $formattedBookings = $bookings->map(function($booking) {
        return [
            'month' => date('F', mktime(0, 0, 0, $booking->month, 10)), // Get month name
            'total_bookings' => $booking->total_bookings,
        ];
    });

    return response()->json($formattedBookings);
    }

}
