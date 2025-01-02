<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Room;
use DB;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
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
        $schedules = Schedule::orderBy('id', 'ASC')->paginate(10);
        return view('backend.schedule.index', compact('schedules'));
    }

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

    public function boot()
    {
        // Custom validation for time
        Validator::extend('time', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $value);
        }, 'The :attribute must be a valid time in HH:MM format.');
    }
}
