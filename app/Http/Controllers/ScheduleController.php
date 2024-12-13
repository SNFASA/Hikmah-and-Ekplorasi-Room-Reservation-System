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
        $rooms = DB::table('rooms')
            ->select( 'no_room', 'name')
            ->where('status', 'valid')
            ->get();

        return view('backend.schedule.create', [
            'invalid_date' => null,
            'invalid_time_start' => null,
            'invalid_time_end' => null,
            'rooms' => $rooms,
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
    
        return view('backend.schedule.edit', compact('schedule', 'rooms'));
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
