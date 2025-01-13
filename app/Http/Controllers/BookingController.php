<?php
namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\list_student_booking;
use App\Models\User;
use App\Models\room;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\furniture;
use App\Models\electronic;
use App\Models\schedule;


class BookingController extends Controller
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
    
        $students = User::where('role', 'user')->get();
    
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
        'students' => 'required|array|min:4',
        'students.*.no_matriks' => 'required|max:255',
        'students.*.name' => 'required|max:255',
    ]);

    $students = $request->input('students');
    foreach ($students as $student) {
        User::firstOrCreate(
            ['no_matriks' => $student['no_matriks']],
            [
                'name' => $student['name'],
                'facultyOffice' => null,
                'course' => null,
                'email' => $student['no_matriks'] . '@student.uthm.edu.my',
                'password' => Hash::make($student['no_matriks']),
                'role' => 'user',
            ]
        );
    }

    // Check for scheduling conflicts in unavailable and booked slots
    $conflictWithUnavailable = DB::table('schedule_booking')
        ->where('invalid_date', $request->booking_date)
        ->where(function ($query) use ($request) {
            $query->where('invalid_time_start', '<', $request->booking_time_end)
                  ->where('invalid_time_end', '>', $request->booking_time_start);
        })
        ->exists();

    if ($conflictWithUnavailable) {
        return back()->withErrors(['booking_time_start' => 'Selected time is unavailable due to schedule conflict.']);
    }

    $conflictWithBooked = DB::table('bookings')
        ->where('no_room', $request->no_room)
        ->where('booking_date', $request->booking_date)
        ->where(function ($query) use ($request) {
            $query->where('booking_time_start', '<', $request->booking_time_end)
                  ->where('booking_time_end', '>', $request->booking_time_start);
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

    // Pass the original student array directly
    $this->attachStudentsToBooking($booking, $students);

    return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
}
public function edit($id)
{
    $booking = Bookings::findOrFail($id);
    $rooms = Room::all();
    
    // Fetch all students with their role as 'student'
    $students = User::where('role', 'student')->get();
    
    // Join `list_student_booking` and `users` to get both `no_matriks` and `name`
    $selectedStudents = DB::table('list_student_booking')
        ->join('users', 'list_student_booking.no_matriks', '=', 'users.no_matriks') 
        ->whereIn('list_student_booking.id', $booking->listStudentBookings->pluck('id')) 
        ->select('list_student_booking.no_matriks', 'users.name')
        ->get();

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
            'students' => 'required|array|min:4',
            'students.*.no_matriks' => 'required|max:255',
            'students.*.name' => 'required|max:255',
        ]);
    
        $students = $request->input('students');
        foreach ($students as $student) {
            User::firstOrCreate(
                ['no_matriks' => $student['no_matriks']],
                [
                    'name' => $student['name'],
                    'facultyOffice' => null,
                    'course' => null,
                    'email' => $student['no_matriks'] . '@student.uthm.edu.my',
                    'password' => Hash::make($student['no_matriks']),
                    'role' => 'user',
                ]
            );
        }
    
        // Check for scheduling conflicts in unavailable and booked slots
        $conflictWithUnavailable = DB::table('schedule_booking')
            ->where('invalid_date', $request->booking_date)
            ->where(function ($query) use ($request) {
                $query->where('invalid_time_start', '<', $request->booking_time_end)
                      ->where('invalid_time_end', '>', $request->booking_time_start);
            })
            ->exists();
    
        if ($conflictWithUnavailable) {
            return back()->withErrors(['booking_time_start' => 'Selected time is unavailable due to schedule conflict.']);
        }
    
        $conflictWithBooked = DB::table('bookings')
            ->where('no_room', $request->no_room)
            ->where('booking_date', $request->booking_date)
            ->where(function ($query) use ($request) {
                $query->where('booking_time_start', '<', $request->booking_time_end)
                      ->where('booking_time_end', '>', $request->booking_time_start);
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
    
        // Pass the original student array directly
        $this->attachStudentsToBooking($booking, $students);


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
        // Detach any existing students from the booking
        $booking->listStudentBookings()->detach();
    
        foreach ($students as $student) {
            // Check if the required data (no_matriks) is available
            if (isset($student['no_matriks'])) {
                $no_matriks = $student['no_matriks'];
    
                // Create or retrieve the student booking record based on no_matriks
                $studentBooking = list_student_booking::firstOrCreate(['no_matriks' => $no_matriks]);
    
                // Attach the student booking to the current booking
                $booking->listStudentBookings()->attach($studentBooking->id);
            }
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
public function showFilterForm()
    {
        $furnitureCategories = Furniture::getFurnitureCategories();
        $electronicCategories = Electronic::getElectronicCategories();
        $rooms = collect(); // Empty collection for rooms
        $type_room = 'All'; // Default value

        $date = null;
        $start_time = null;
        $end_time = null;
        $furniture_category = [];
        $electronic_category = [];

        return view('frontend.index', compact(
            'furnitureCategories', 'electronicCategories', 'rooms',
            'type_room', 'date', 'start_time', 'end_time',
            'furniture_category', 'electronic_category'
        ));
    }

    public function filterAvailableRooms(Request $request)
    {
        $validated = $request->validate([
            'type_room' => 'nullable|string',
            'date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'furniture_category' => 'nullable|array',
            'furniture_category.*' => 'nullable|String',
            'electronic_category' => 'nullable|array',
            'electronic_category.*' => 'nullable|String',
        ]);
    
        // Pass the request data as query parameters when redirecting back to the home route
        return redirect()->route('home', $request->all());
    }
    
    

   
public function showBookingForm($id, Request $request){
            $room = Room::findOrFail($id);
            $rooms = Room::with(['furnitures', 'electronics'])->get();
            $furnitureCategories = Furniture::getFurnitureCategories();
            $electronicCategories = Electronic::getElectronicCategories();
        
            $date = $request->query('date'); // Retrieves date from query string
            $start_time = $request->query('start_time');
            $end_time = $request->query('end_time');
        
            \Log::info("Booking Form Params:", compact('date', 'start_time', 'end_time')); // Debugging
        
            return view('frontend.pages.bookingform', [
                'room' => $room,
                'date' => $date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'furnitureCategories' => $furnitureCategories,
                'electronicCategories' => $electronicCategories,
            ]);
}
    
public function storeBookingForm( $id,Request $request){
         $request->validate([
             'booking_date' => 'required|date',
             'booking_time_start' => 'required|date_format:H:i',
             'booking_time_end' => 'required|date_format:H:i|after:booking_time_start',
             'purpose' => 'required|string|max:255',
             'no_room' => 'required|exists:rooms,no_room',
             'phone_number' => 'required|string|max:15',
             'students' => 'required|array|min:4',
             'students.*.no_matriks' => 'required|max:255',
             'students.*.name' => 'required|max:255',
         ]);
 
         $students = $request->input('students');
         foreach ($students as $student) {
             User::firstOrCreate(
                 ['no_matriks' => $student['no_matriks']],
                 [
                     'name' => $student['name'],
                     'facultyOffice' => null,
                     'course' => null,
                     'email' => $student['no_matriks'] . '@student.uthm.edu.my',
                     'password' => Hash::make($student['no_matriks']),
                     'role' => 'user',
                 ]
             );
         }
 
         $conflictWithUnavailable = DB::table('schedule_booking')
             ->where('invalid_date', $request->booking_date)
             ->where(function ($query) use ($request) {
                 $query->where('invalid_time_start', '<', $request->booking_time_end)
                       ->where('invalid_time_end', '>', $request->booking_time_start);
             })
             ->exists();
 
         if ($conflictWithUnavailable) {
             return back()->withErrors(['booking_time_start' => 'Selected time is unavailable due to schedule conflict.']);
         }
 
         $conflictWithBooked = DB::table('bookings')
             ->where('no_room', $request->no_room)
             ->where('booking_date', $request->booking_date)
             ->where(function ($query) use ($request) {
                 $query->where('booking_time_start', '<', $request->booking_time_end)
                       ->where('booking_time_end', '>', $request->booking_time_start);
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
 
         $this->attachStudentsToBooking($booking, $students);
         \Log::info("Request Data:", $request->all());
         return redirect()->route('home')->with('success', 'Booking created successfully.');
}
public function calendar()
     {
        $bookings = DB::table('bookings')
        ->join('rooms', 'bookings.no_room', '=', 'rooms.no_room')
        ->select(
            'booking_date as start',
            DB::raw("CONCAT(booking_date, ' ', booking_time_end) as end"),
            DB::raw("CONCAT('Booked: ', rooms.name) as title"), // Add room name to the title
            DB::raw("'primary' as color")
        )
        ->get();

        $invalidSchedules = DB::table('schedule_booking')
        ->join('rooms', 'schedule_booking.roomid', '=', 'rooms.no_room')
        ->select(
            'invalid_date as start',
            DB::raw("CONCAT(invalid_date, ' ', invalid_time_end) as end"),
            DB::raw("CONCAT('Invalid: ', rooms.name) as title"), // Add room name to the title
            DB::raw("'danger' as color")
        )
        ->get();
     
         // Merge events
         $events = $bookings->merge($invalidSchedules);
     
         return view('frontend.pages.calendarBooking', ['events' => $events]);
}

     //My. booking 
public function myBookings(Request $request)
     {
         // Get the current user's no_matriks
         $userNoMatriks = auth()->user()->no_matriks;
     
         // Fetch all bookings associated with the authenticated user
         $bookings = DB::table('bookings')
             ->join('rooms', 'bookings.no_room', '=', 'rooms.no_room')
             ->leftJoin('booking_user', 'bookings.id', '=', 'booking_user.booking_id')
             ->leftJoin('list_student_booking', 'booking_user.list_student_booking_id', '=', 'list_student_booking.id')
             ->leftJoin('users', 'list_student_booking.no_matriks', '=', 'users.no_matriks')
             ->select(
                 'rooms.name as room_name',
                 'bookings.id as booking_id',
                 'bookings.booking_date',
                 'bookings.booking_time_start',
                 'bookings.booking_time_end',
                 'users.name as student_name', // Fetch all student names
                 'users.no_matriks as student_no_matriks'
             )
             ->whereIn('bookings.id', function ($query) use ($userNoMatriks) {
                 $query->select('booking_user.booking_id')
                     ->from('booking_user')
                     ->join('list_student_booking', 'booking_user.list_student_booking_id', '=', 'list_student_booking.id')
                     ->where('list_student_booking.no_matriks', $userNoMatriks);
             })
             ->get();
     
         // Group bookings by booking ID
         $groupedBookings = $bookings->groupBy('booking_id')->map(function ($group) {
             $details = $group->first(); // Get the details for the booking
             $details->students = $group->pluck('student_name')->filter()->unique()->toArray(); // Collect unique student names
             return $details;
         });
        // dd($bookings);

         // Pass data to the view
         return view('frontend.pages.Mybooking', ['bookingDetails' => $groupedBookings]);
}
public function cancelBooking($id){
        $booking = Bookings::findOrFail($id);
        $booking->delete();

        return redirect()->route('home')->with('success', 'Booking deleted successfully.');
}
public function calendarAdmin()
{
       $bookings = DB::table('bookings')
       ->join('rooms', 'bookings.no_room', '=', 'rooms.no_room')
       ->select(
           'booking_date as start',
           DB::raw("CONCAT(booking_date, ' ', booking_time_end) as end"),
           DB::raw("CONCAT('Booked: ', rooms.name) as title"), // Add room name to the title
           DB::raw("'primary' as color")
       )
       ->get();

       $invalidSchedules = DB::table('schedule_booking')
       ->join('rooms', 'schedule_booking.roomid', '=', 'rooms.no_room')
       ->select(
           'invalid_date as start',
           DB::raw("CONCAT(invalid_date, ' ', invalid_time_end) as end"),
           DB::raw("CONCAT('Invalid: ', rooms.name) as title"), // Add room name to the title
           DB::raw("'danger' as color")
       )
       ->get();
    
        // Merge events
        $events = $bookings->merge($invalidSchedules);
    
        return view('backend.schedule.calender', ['events' => $events]);
}
public function Formedit($id)
{
    $booking = Bookings::findOrFail($id);
    $room = Room::findOrFail($id);
    $furnitureCategories = Furniture::getFurnitureCategories();
    $electronicCategories = Electronic::getElectronicCategories();
    
    // Fetch all students with their role as 'student'
    $students = User::where('role', 'student')->get();
    
    // Join `list_student_booking` and `users` to get both `no_matriks` and `name`
    $selectedStudents = DB::table('list_student_booking')
        ->join('users', 'list_student_booking.no_matriks', '=', 'users.no_matriks') 
        ->whereIn('list_student_booking.id', $booking->listStudentBookings->pluck('id')) 
        ->select('list_student_booking.no_matriks', 'users.name')
        ->get();

    return view('frontend.pages.bookingedit', compact('booking', 'room', 'students', 'selectedStudents', 'furnitureCategories', 'electronicCategories'));
}

public function Formupdate(Request $request, $id)
{
    // Retrieve the booking by ID
    $booking = Bookings::findOrFail($id);

    // Format the time inputs
    $request->merge([
        'booking_time_start' => date('H:i', strtotime($request->input('booking_time_start'))),
        'booking_time_end' => date('H:i', strtotime($request->input('booking_time_end'))),
    ]);

    // Validate the inputs
    $request->validate([
        'booking_date' => 'required|date',
        'booking_time_start' => 'required|date_format:H:i',
        'booking_time_end' => 'required|date_format:H:i|after:booking_time_start',
        'purpose' => 'required|string|max:255',
        'no_room' => 'required|exists:rooms,no_room',
        'phone_number' => 'required|string|max:15',
        'students' => 'required|array|min:4',
        'students.*.no_matriks' => 'required|max:255',
        'students.*.name' => 'required|max:255',
    ]);

    // Check for scheduling conflicts
    $conflictWithUnavailable = DB::table('schedule_booking')
        ->where('invalid_date', $request->booking_date)
        ->where(function ($query) use ($request) {
            $query->where('invalid_time_start', '<', $request->booking_time_end)
                  ->where('invalid_time_end', '>', $request->booking_time_start);
        })
        ->exists();

    if ($conflictWithUnavailable) {
        return back()->withErrors(['booking_time_start' => 'Selected time is unavailable due to schedule conflict.']);
    }

    $conflictWithBooked = DB::table('bookings')
        ->where('no_room', $request->no_room)
        ->where('booking_date', $request->booking_date)
        ->where(function ($query) use ($request) {
            $query->where('booking_time_start', '<', $request->booking_time_end)
                  ->where('booking_time_end', '>', $request->booking_time_start);
        })
        ->exists();

    if ($conflictWithBooked) {
        return back()->withErrors(['booking_time_start' => 'Selected time is already booked for this room.']);
    }

    // Update booking data
    $duration = $this->calculateDuration($request->booking_time_start, $request->booking_time_end);
    $booking->update([
        'booking_date' => $request->booking_date,
        'booking_time_start' => $request->booking_time_start,
        'booking_time_end' => $request->booking_time_end,
        'duration' => $duration,
        'purpose' => $request->purpose,
        'no_room' => $request->no_room,
        'phone_number' => $request->phone_number,
        'status' => 'approved',
    ]);

    // Update students
    $students = $request->input('students');
    $this->attachStudentsToBooking($booking, $students);

    return redirect()->route('home')->with('success', 'Booking updated successfully.');
}




}

