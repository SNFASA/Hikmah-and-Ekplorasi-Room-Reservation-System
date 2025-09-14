<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\ActivityLogger;

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
        $batchId = Str::uuid();

        try {
            $createdSchedules = [];
            
            foreach ($roomIds as $roomId) {
                $scheduleId = DB::table('schedule_booking')->insertGetId([
                    'invalid_date' => $request->invalid_date,
                    'invalid_time_start' => $request->invalid_time_start,
                    'invalid_time_end' => $request->invalid_time_end,
                    'roomid' => $roomId,
                    'batch_id' => $batchId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $createdSchedules[] = $scheduleId;
                
                // Get room name for better logging
                $roomName = DB::table('rooms')->where('no_room', $roomId)->value('name');
                
                // Log each schedule creation
                ActivityLogger::log('schedule', 'created', "Schedule unavailable time created for {$roomName} on {$request->invalid_date}", [
                    'model_type' => 'schedule_booking',
                    'model_id' => $scheduleId,
                    'new_values' => [
                        'invalid_date' => $request->invalid_date,
                        'invalid_time_start' => $request->invalid_time_start,
                        'invalid_time_end' => $request->invalid_time_end,
                        'room_id' => $roomId,
                        'room_name' => $roomName,
                        'batch_id' => $batchId
                    ],
                    'status' => 'completed'
                ]);
            }

            // Log batch creation summary
            $roomCount = count($roomIds);
            ActivityLogger::log('schedule', 'batch_created', "Created {$roomCount} schedule entries for unavailable time on {$request->invalid_date}", [
                'model_type' => 'schedule_booking_batch',
                'model_id' => $batchId,
                'new_values' => [
                    'batch_id' => $batchId,
                    'schedule_ids' => $createdSchedules,
                    'room_count' => $roomCount,
                    'invalid_date' => $request->invalid_date
                ],
                'status' => 'completed'
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating schedule: ' . $e->getMessage());
            
            ActivityLogger::log('schedule', 'creation_failed', "Failed to create schedule for {$request->invalid_date}", [
                'status' => 'failed',
                'severity' => 'error',
                'new_values' => [
                    'error' => $e->getMessage(),
                    'invalid_date' => $request->invalid_date
                ]
            ]);

            return redirect()->back()->with('error', 'Failed to create schedule. Please try again.');
        }

        return redirect()->route('schedule.index')->with('success', 'Unavailable time(s) set successfully.');
    }

    public function edit($id)
    {
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

        try {
            $existing = DB::table('schedule_booking')->where('id', $id)->first();

            if (!$existing) {
                return redirect()->route('schedule.index')->with('error', 'Schedule not found.');
            }

            // Get room name for logging
            $roomName = DB::table('rooms')->where('no_room', $existing->roomid)->value('name');

            // Store old values for logging
            $oldValues = [
                'invalid_date' => $existing->invalid_date,
                'invalid_time_start' => $existing->invalid_time_start,
                'invalid_time_end' => $existing->invalid_time_end,
                'room_name' => $roomName
            ];

            // Update the schedule
            $updated = DB::table('schedule_booking')->where('id', $id)->update([
                'invalid_date' => $request->invalid_date,
                'invalid_time_start' => $request->invalid_time_start,
                'invalid_time_end' => $request->invalid_time_end,
                'updated_at' => now(),
            ]);

            if ($updated) {
                // Log the update
                ActivityLogger::log('schedule', 'updated', "Schedule updated for {$roomName} - changed from {$existing->invalid_date} to {$request->invalid_date}", [
                    'model_type' => 'schedule_booking',
                    'model_id' => $id,
                    'old_values' => $oldValues,
                    'new_values' => [
                        'invalid_date' => $request->invalid_date,
                        'invalid_time_start' => $request->invalid_time_start,
                        'invalid_time_end' => $request->invalid_time_end,
                        'room_name' => $roomName
                    ],
                    'status' => 'completed'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error updating schedule: ' . $e->getMessage());
            
            ActivityLogger::log('schedule', 'update_failed', "Failed to update schedule ID {$id}", [
                'model_type' => 'schedule_booking',
                'model_id' => $id,
                'status' => 'failed',
                'severity' => 'error',
                'new_values' => [
                    'error' => $e->getMessage()
                ]
            ]);

            return redirect()->back()->with('error', 'Failed to update schedule. Please try again.');
        }

        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $schedule = DB::table('schedule_booking')->where('id', $id)->first();
            
            if (!$schedule) {
                return redirect()->back()->with('error', 'Schedule not found!');
            }
            
            $room = DB::table('rooms')->where('no_room', $schedule->roomid)->value('name');
            
            // Store data for logging before deletion
            $scheduleData = [
                'schedule_id' => $id,
                'room_id' => $schedule->roomid,
                'room_name' => $room,
                'invalid_date' => $schedule->invalid_date,
                'invalid_time_start' => $schedule->invalid_time_start,
                'invalid_time_end' => $schedule->invalid_time_end,
                'batch_id' => $schedule->batch_id
            ];
            
            $deleted = DB::table('schedule_booking')->where('id', $id)->delete();

            if ($deleted) {
                // Log successful deletion
                ActivityLogger::log('schedule', 'deleted', "Schedule deleted for {$room} on {$schedule->invalid_date}", [
                    'model_type' => 'schedule_booking',
                    'model_id' => $id,
                    'old_values' => $scheduleData,
                    'status' => 'completed'
                ]);
                
                Log::info('Schedule booking deleted', $scheduleData);
                
                return redirect()->back()->with('success', "Schedule for {$room} has been deleted successfully!");
            } else {
                // Log failed deletion
                ActivityLogger::log('schedule', 'deletion_failed', "Failed to delete schedule for {$room}", [
                    'model_type' => 'schedule_booking',
                    'model_id' => $id,
                    'status' => 'failed',
                    'severity' => 'warning'
                ]);
                
                return redirect()->back()->with('error', 'Failed to delete schedule. Please try again.');
            }
            
        } catch (\Exception $e) {
            Log::error('Error deleting schedule booking', [
                'schedule_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            ActivityLogger::log('schedule', 'deletion_error', "Error occurred while deleting schedule ID {$id}", [
                'model_type' => 'schedule_booking',
                'model_id' => $id,
                'status' => 'failed',
                'severity' => 'error',
                'new_values' => [
                    'error' => $e->getMessage()
                ]
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while deleting the schedule. Please try again.');
        }
    }
    
    public function bulkDestroy(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if (empty($ids)) {
                return response()->json(['error' => 'No schedules selected for deletion'], 400);
            }
            
            $schedules = DB::table('schedule_booking')->whereIn('id', $ids)->get();
            
            if ($schedules->count() !== count($ids)) {
                return response()->json(['error' => 'Some schedules not found'], 404);
            }
            
            // Store schedule data before deletion for logging
            $schedulesData = $schedules->map(function($schedule) {
                $roomName = DB::table('rooms')->where('no_room', $schedule->roomid)->value('name');
                return [
                    'id' => $schedule->id,
                    'room_name' => $roomName,
                    'invalid_date' => $schedule->invalid_date,
                    'room_id' => $schedule->roomid
                ];
            })->toArray();
            
            $deletedCount = DB::table('schedule_booking')->whereIn('id', $ids)->delete();

            if ($deletedCount > 0) {
                // Log bulk deletion
                ActivityLogger::log('schedule', 'bulk_deleted', "Bulk deleted {$deletedCount} schedules", [
                    'model_type' => 'schedule_booking_bulk',
                    'old_values' => [
                        'deleted_count' => $deletedCount,
                        'schedule_ids' => $ids,
                        'schedules_data' => $schedulesData
                    ],
                    'status' => 'completed'
                ]);
                
                Log::info('Bulk schedule booking deletion', [
                    'deleted_count' => $deletedCount,
                    'schedule_ids' => $ids,
                    'deleted_by' => auth()->user()->id
                ]);
                
                return response()->json([
                    'success' => "{$deletedCount} schedule(s) deleted successfully!"
                ]);
            } else {
                ActivityLogger::log('schedule', 'bulk_deletion_failed', "Failed to bulk delete schedules", [
                    'status' => 'failed',
                    'severity' => 'warning',
                    'new_values' => ['attempted_ids' => $ids]
                ]);
                
                return response()->json(['error' => 'Failed to delete schedules'], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Error in bulk schedule deletion', [
                'error' => $e->getMessage(),
                'ids' => $request->input('ids', [])
            ]);
            
            ActivityLogger::log('schedule', 'bulk_deletion_error', "Error in bulk schedule deletion", [
                'status' => 'failed',
                'severity' => 'error',
                'new_values' => [
                    'error' => $e->getMessage(),
                    'attempted_ids' => $request->input('ids', [])
                ]
            ]);
            
            return response()->json(['error' => 'An error occurred during bulk deletion'], 500);
        }
    }
    
    public function destroyByBatch($batchId)
    {
        try {
            $schedules = DB::table('schedule_booking')->where('batch_id', $batchId)->get();
            
            if ($schedules->isEmpty()) {
                return redirect()->back()->with('error', 'No schedules found with the specified batch ID!');
            }
            
            // Store batch data for logging
            $batchData = $schedules->map(function($schedule) {
                $roomName = DB::table('rooms')->where('no_room', $schedule->roomid)->value('name');
                return [
                    'id' => $schedule->id,
                    'room_name' => $roomName,
                    'invalid_date' => $schedule->invalid_date
                ];
            })->toArray();
            
            $deletedCount = DB::table('schedule_booking')->where('batch_id', $batchId)->delete();
            
            if ($deletedCount > 0) {
                ActivityLogger::log('schedule', 'batch_deleted', "Deleted batch {$batchId} containing {$deletedCount} schedules", [
                    'model_type' => 'schedule_booking_batch',
                    'model_id' => $batchId,
                    'old_values' => [
                        'batch_id' => $batchId,
                        'deleted_count' => $deletedCount,
                        'schedules_data' => $batchData
                    ],
                    'status' => 'completed'
                ]);
                
                Log::info('Batch schedule deletion', [
                    'batch_id' => $batchId,
                    'deleted_count' => $deletedCount,
                    'deleted_by' => auth()->user()->id
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
            
            ActivityLogger::log('schedule', 'batch_deletion_error', "Error deleting batch {$batchId}", [
                'model_type' => 'schedule_booking_batch',
                'model_id' => $batchId,
                'status' => 'failed',
                'severity' => 'error',
                'new_values' => ['error' => $e->getMessage()]
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while deleting the batch schedules');
        }
    }
    
    public function softDestroy($id)
    {
        try {
            $schedule = DB::table('schedule_booking')->where('id', $id)->first();
            
            if (!$schedule) {
                return redirect()->back()->with('error', 'Schedule not found!');
            }
            
            $updated = DB::table('schedule_booking')
                ->where('id', $id)
                ->update(['deleted_at' => now()]);
            
            if ($updated) {
                $room = DB::table('rooms')->where('no_room', $schedule->roomid)->value('name');
                
                ActivityLogger::log('schedule', 'soft_deleted', "Schedule archived for {$room} on {$schedule->invalid_date}", [
                    'model_type' => 'schedule_booking',
                    'model_id' => $id,
                    'old_values' => [
                        'room_name' => $room,
                        'invalid_date' => $schedule->invalid_date,
                        'status' => 'active'
                    ],
                    'new_values' => [
                        'status' => 'archived',
                        'deleted_at' => now()->toString()
                    ],
                    'status' => 'completed'
                ]);
                
                Log::info('Schedule booking soft deleted', [
                    'schedule_id' => $id,
                    'room_name' => $room,
                    'deleted_by' => auth()->user()->id
                ]);
                
                return redirect()->back()->with('success', "Schedule for {$room} has been archived successfully!");
            }
            
            return redirect()->back()->with('error', 'Failed to archive schedule');
            
        } catch (\Exception $e) {
            Log::error('Error soft deleting schedule', [
                'schedule_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            ActivityLogger::log('schedule', 'soft_deletion_error', "Error archiving schedule ID {$id}", [
                'model_type' => 'schedule_booking',
                'model_id' => $id,
                'status' => 'failed',
                'severity' => 'error',
                'new_values' => ['error' => $e->getMessage()]
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while archiving the schedule');
        }
    }
}