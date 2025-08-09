<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        // Fix: Use the correct model table
        $schedules = DB::table('schedule_booking')->orderBy('id', 'ASC')->paginate(10);
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

        $batchId = Str::uuid(); // unique ID for this group

        foreach ($roomIds as $roomId) {
            DB::table('schedule_booking')->insert([
                'invalid_date' => $request->invalid_date,
                'invalid_time_start' => $request->invalid_time_start,
                'invalid_time_end' => $request->invalid_time_end,
                'roomid' => $roomId,
                'batch_id' => $batchId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('schedule.index')->with('success', 'Unavailable time(s) set successfully.');
    }

    public function edit($id)
    {
        // Fix: Use query builder since model might be problematic
        $schedule = DB::table('schedule_booking')->where('id', $id)->first();
        
        if (!$schedule) {
            return redirect()->route('backend.schedule.index')->with('error', 'Schedule not found.');
        }

        $rooms = DB::table('rooms')->select('no_room', 'name')->where('status', 'valid')->get();

        $unavailableSlots = DB::table('schedule_booking')
            ->select('invalid_date', 'invalid_time_start', 'invalid_time_end')
            ->get();

        $bookedSlots = DB::table('bookings')
            ->select('booking_date', 'booking_time_start', 'booking_time_end')
            ->get();

        // Handle room IDs
        $scheduleRooms = is_string($schedule->roomid) ? json_decode($schedule->roomid, true) : [$schedule->roomid];

        return view('backend.schedule.edit', compact('schedule', 'rooms', 'unavailableSlots', 'bookedSlots', 'scheduleRooms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invalid_date' => 'required|date',
            'invalid_time_start' => 'required|date_format:H:i',
            'invalid_time_end' => 'required|date_format:H:i|after:invalid_time_start',
        ]);

        $existing = DB::table('schedule_booking')->where('id', $id)->first();

        if (!$existing) {
            return redirect()->route('schedule.index')->with('error', 'Schedule not found.');
        }

        // Update only this specific row (not whole batch)
        DB::table('schedule_booking')->where('id', $id)->update([
            'invalid_date' => $request->invalid_date,
            'invalid_time_start' => $request->invalid_time_start,
            'invalid_time_end' => $request->invalid_time_end,
            'updated_at' => now(),
        ]);

        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully.');
    }


    /**
     * Remove the specified schedule booking from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Find the schedule booking record
            $schedule = DB::table('schedule_booking')->where('id', $id)->first();
            
            if (!$schedule) {
                return redirect()->back()->with('error', 'Schedule not found!');
            }
            
            // Get room name for logging/notification purposes
            $room = DB::table('rooms')->where('no_room', $schedule->roomid)->value('name');
            
            // Delete the schedule booking
            $deleted = DB::table('schedule_booking')->where('id', $id)->delete();
            
            if ($deleted) {
                // Log the deletion
                Log::info('Schedule booking deleted', [
                    'schedule_id' => $id,
                    'room_id' => $schedule->roomid,
                    'room_name' => $room,
                    'invalid_date' => $schedule->invalid_date,
                    'deleted_by' => auth()->user()->id ?? 'system'
                ]);
                
                return redirect()->back()->with('success', "Schedule for {$room} has been deleted successfully!");
            } else {
                return redirect()->back()->with('error', 'Failed to delete schedule. Please try again.');
            }
            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error deleting schedule booking', [
                'schedule_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while deleting the schedule. Please try again.');
        }
    }
    
    /**
     * Bulk delete multiple schedule bookings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if (empty($ids)) {
                return response()->json(['error' => 'No schedules selected for deletion'], 400);
            }
            
            // Validate that all IDs exist
            $schedules = DB::table('schedule_booking')->whereIn('id', $ids)->get();
            
            if ($schedules->count() !== count($ids)) {
                return response()->json(['error' => 'Some schedules not found'], 404);
            }
            
            // Delete the schedules
            $deletedCount = DB::table('schedule_booking')->whereIn('id', $ids)->delete();
            
            if ($deletedCount > 0) {
                // Log bulk deletion
                Log::info('Bulk schedule booking deletion', [
                    'deleted_count' => $deletedCount,
                    'schedule_ids' => $ids,
                    'deleted_by' => auth()->user()->id ?? 'system'
                ]);
                
                return response()->json([
                    'success' => "{$deletedCount} schedule(s) deleted successfully!"
                ]);
            } else {
                return response()->json(['error' => 'Failed to delete schedules'], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Error in bulk schedule deletion', [
                'error' => $e->getMessage(),
                'ids' => $request->input('ids', [])
            ]);
            
            return response()->json(['error' => 'An error occurred during bulk deletion'], 500);
        }
    }
    
    /**
     * Delete schedule bookings by batch ID
     *
     * @param  string  $batchId
     * @return \Illuminate\Http\Response
     */
    public function destroyByBatch($batchId)
    {
        try {
            // Find schedules with the given batch ID
            $schedules = DB::table('schedule_booking')->where('batch_id', $batchId)->get();
            
            if ($schedules->isEmpty()) {
                return redirect()->back()->with('error', 'No schedules found with the specified batch ID!');
            }
            
            // Delete all schedules in the batch
            $deletedCount = DB::table('schedule_booking')->where('batch_id', $batchId)->delete();
            
            if ($deletedCount > 0) {
                Log::info('Batch schedule deletion', [
                    'batch_id' => $batchId,
                    'deleted_count' => $deletedCount,
                    'deleted_by' => auth()->user()->id ?? 'system'
                ]);
                
                return redirect()->back()->with('success', "{$deletedCount} schedule(s) from batch deleted successfully!");
            } else {
                return redirect()->back()->with('error', 'Failed to delete batch schedules');
            }
            
        } catch (\Exception $e) {
            Log::error('Error deleting schedule batch', [
                'batch_id' => $batchId,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while deleting the batch schedules');
        }
    }
    
    /**
     * Soft delete (if you want to implement soft deletes later)
     * Note: This would require adding a 'deleted_at' column to your table
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function softDestroy($id)
    {
        try {
            $schedule = DB::table('schedule_booking')->where('id', $id)->first();
            
            if (!$schedule) {
                return redirect()->back()->with('error', 'Schedule not found!');
            }
            
            // Update with deleted_at timestamp (requires adding deleted_at column)
            $updated = DB::table('schedule_booking')
                ->where('id', $id)
                ->update(['deleted_at' => now()]);
            
            if ($updated) {
                $room = DB::table('rooms')->where('no_room', $schedule->roomid)->value('name');
                
                Log::info('Schedule booking soft deleted', [
                    'schedule_id' => $id,
                    'room_name' => $room,
                    'deleted_by' => auth()->user()->id ?? 'system'
                ]);
                
                return redirect()->back()->with('success', "Schedule for {$room} has been archived successfully!");
            }
            
            return redirect()->back()->with('error', 'Failed to archive schedule');
            
        } catch (\Exception $e) {
            Log::error('Error soft deleting schedule', [
                'schedule_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while archiving the schedule');
        }
    }
}

