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
        $students = User::where('role', 'student')->get();
        return view('backend.booking.create', compact('students'));
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
