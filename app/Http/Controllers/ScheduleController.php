<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Room;
use DB;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Check if the user has access to the schedule pages. If not, throw a 403
     * error. This middleware is applied to all methods in this controller.
     */
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
        $schedules = Schedule::orderBy('id', 'ASC')->paginate(10);
        return view('backend.schedule.index', compact('schedules'));
    }

    /**
     * Create a new schedule record.
     * 
     * This method fetches all valid rooms, unavailable slots from schedule_booking table,
     * and booked slots from the bookings table, and passes them to the view.
     * 
     * @return mixed
     */
    public function create()
    {
        // Fetch available rooms
        $rooms = DB::table('rooms')
            ->select('no_room', 'name')
            ->where('status', 'valid')
            ->get();
    
        // Fetch unavailable slots from the schedule_booking table
        $unavailableSlots = DB::table('schedule_booking')
            ->select('invalid_date', 'invalid_time_start', 'invalid_time_end')
            ->get();
    
        // Fetch booked slots from the bookings table
        $bookedSlots = DB::table('bookings')
            ->select('booking_date', 'booking_time_start', 'booking_time_end')
            ->get();
    
        // Pass all required variables to the view
        return view('backend.schedule.create', [
            'rooms' => $rooms,
            'unavailableSlots' => $unavailableSlots,
            'bookedSlots' => $bookedSlots,
            'invalid_date' => null,
            'invalid_time_start' => null,
            'invalid_time_end' => null,
        ]);
    }
    

    /**
     * Store a newly created schedule record in storage.
     * 
     * This method validates the input and creates a new schedule record in the
     * Schedule table. It will also associate the schedule record with the room
     * specified in the input. If the schedule is successfully created, it will
     * redirect to the schedules index page with a success message. If the
     * schedule is not successfully created, it will redirect back to the create
     * form with the errors.
     * 
     * 
     * 
     */
    public function store(Request $request)
    {
        $request->validate([
            'invalid_date' => 'required|date',
            'invalid_time_start' => 'required|date_format:H:i',
            'invalid_time_end' => 'required|date_format:H:i|after:invalid_time_start',
            'no_room' => 'required|integer|exists:rooms,no_room',
        ]);

        Schedule::create([
            'invalid_date' => $request->input('invalid_date'),
            'invalid_time_start' => $request->input('invalid_time_start'),
            'invalid_time_end' => $request->input('invalid_time_end'),
            'roomid' => $request->input('no_room'),
        ]);

        return redirect()->route('schedule.index')->with('success', 'Schedule created successfully.');
    }

    /**
     * Show the form for editing the specified schedule.
     * 
     * This method fetches the specified schedule record from the Schedule table,
     * and also fetches the list of available rooms and unavailable slots from
     * the Rooms and Schedule tables. It then passes the schedule and other data
     * to the edit view.
     * 
     * param int $id The ID of the schedule to be edited.
     * return The edit view with the schedule and other data.
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $rooms = DB::table('rooms')
            ->select('no_room', 'name')
            ->where('status', 'valid')
            ->get();
    
        // Fetch unavailable and booked slots
        $unavailableSlots = DB::table('schedule_booking')
            ->select('invalid_date', 'invalid_time_start', 'invalid_time_end')
            ->get();
    
        $bookedSlots = DB::table('bookings')
            ->select('booking_date', 'booking_time_start', 'booking_time_end')
            ->get();
    
        // Pass schedule and other data to the view
        return view('backend.schedule.edit', compact('schedule', 'rooms', 'unavailableSlots', 'bookedSlots'));
    }
    
    
    
    /**
     * Update the specified schedule in storage.
     *
     * Validates the request data and updates the specified schedule record in
     * the Schedule table. The request data is validated against the following
     * rules:
     *  - invalid_date: required, date
     *  - invalid_time_start: required, date_format:H:i
     *  - invalid_time_end: required, date_format:H:i, after:invalid_time_start
     *  - no_room: required, exists:rooms,no_room
     * 
     * Redirects to the schedule index with a success message if the update is
     * successful.
     * 
     * @param \Illuminate\Http\Request $request The incoming request instance.
     * @param int $id The ID of the schedule to be updated.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
    
        $request->validate([
            'invalid_date' => 'required|date',
            'invalid_time_start' => 'required|date_format:H:i',
            'invalid_time_end' => 'required|date_format:H:i|after:invalid_time_start',
            'no_room' => 'required|exists:rooms,no_room',
        ]);
    
        $schedule->update([
            'invalid_date' => $request->input('invalid_date'),
            'invalid_time_start' => $request->input('invalid_time_start'),
            'invalid_time_end' => $request->input('invalid_time_end'),
            'roomid' => $request->input('no_room'),
        ]);
    
        return redirect()->route('backend.schedule.index')->with('success', 'Schedule updated successfully.');
    }
    

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('backend.schedule.index')->with('success', 'Schedule deleted successfully.');
    }

    /**
     * Bootstrap any application services.
     *
     * This method registers a custom validator for time fields to ensure that
     * the time is in the correct format. The validator checks for a valid time
     * in the format HH:MM, i.e. 00:00 to 23:59.
     */
    public function boot()
    {
        // Custom validation for time
        Validator::extend('time', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $value);
        }, 'The :attribute must be a valid time in HH:MM format.');
    }
}
