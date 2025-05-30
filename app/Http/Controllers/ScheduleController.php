<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $rooms = DB::table('rooms')->select('no_room', 'name')->where('status', 'valid')->get();

        $unavailableSlots = DB::table('schedule_booking')
            ->select('invalid_date', 'invalid_time_start', 'invalid_time_end')
            ->get();

        $bookedSlots = DB::table('bookings')
            ->select('booking_date', 'booking_time_start', 'booking_time_end')
            ->get();

        return view('backend.schedule.create', [
            'rooms' => $rooms,
            'unavailableSlots' => $unavailableSlots,
            'bookedSlots' => $bookedSlots,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'invalid_date' => 'required|date',
            'invalid_time_start' => 'nullable|date_format:H:i',
            'invalid_time_end' => 'nullable|date_format:H:i|after:invalid_time_start',
            'no_room' => 'nullable|array',
            'no_room.*' => 'nullable|exists:rooms,no_room',
            'apply_to_all' => 'nullable|boolean',
        ]);

        $roomIds = $request->apply_to_all ? DB::table('rooms')->pluck('no_room')->toArray() : ($request->input('no_room') ?? []);

        foreach ($roomIds as $roomId) {
            DB::table('schedule_booking')->insert([
                'invalid_date' => $request->invalid_date,
                'invalid_time_start' => $request->invalid_time_start,
                'invalid_time_end' => $request->invalid_time_end,
                'roomid' => $roomId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('schedule.index')->with('success', 'Unavailable time(s) set successfully.');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $rooms = DB::table('rooms')->select('no_room', 'name')->where('status', 'valid')->get();

        $unavailableSlots = DB::table('schedule_booking')
            ->select('invalid_date', 'invalid_time_start', 'invalid_time_end')
            ->get();

        $bookedSlots = DB::table('bookings')
            ->select('booking_date', 'booking_time_start', 'booking_time_end')
            ->get();

        // Decode stored room IDs (assuming JSON stored)
        $scheduleRooms = is_string($schedule->roomid) ? json_decode($schedule->roomid, true) : [$schedule->roomid];

        return view('backend.schedule.edit', compact('schedule', 'rooms', 'unavailableSlots', 'bookedSlots', 'scheduleRooms'));
    }

public function update(Request $request, $id)
{
    $request->validate([
        'invalid_date' => 'required|date',
        'invalid_time_start' => 'required|date_format:H:i',
        'invalid_time_end' => 'required|date_format:H:i|after:invalid_time_start',
        'no_room' => 'required_if:apply_to_all,0|array',
        'no_room.*' => 'exists:rooms,no_room',
        'apply_to_all' => 'boolean',
    ]);

    // Determine the room IDs to apply
    $roomIds = $request->apply_to_all
        ? DB::table('rooms')->where('status', 'valid')->pluck('no_room')->toArray()
        : ($request->input('no_room') ?? []);

    // Delete the existing schedule row
    DB::table('schedule_booking')->where('id', $id)->delete();

    // Insert a new row for each room
    foreach ($roomIds as $roomId) {
        DB::table('schedule_booking')->insert([
            'invalid_date' => $request->invalid_date,
            'invalid_time_start' => $request->invalid_time_start,
            'invalid_time_end' => $request->invalid_time_end,
            'roomid' => $roomId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully.');
}


    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedule.index')->with('success', 'Schedule deleted successfully.');
    }
        public function boot()
    {
        Validator::extend('time', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^([01]?\d|2[0-3]):[0-5]\d$/', $value);
        }, 'The :attribute must be a valid time in HH:MM format.');
    }
}
