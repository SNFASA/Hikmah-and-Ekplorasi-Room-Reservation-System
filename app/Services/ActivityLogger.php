<?php
// app/Services/ActivityLogger.php
namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityLogger
{
    public static function log($activityType, $action, $description, $options = [])
    {
        $user = Auth::user();
        $request = request();

        return ActivityLog::create([
            'activity_type' => $activityType,
            'action' => $action,
            'description' => $description,
            'model_type' => isset($options['model_type']) ? $options['model_type'] : null,
            'model_id' => isset($options['model_id']) ? $options['model_id'] : null,
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : (isset($options['user_name']) ? $options['user_name'] : 'System'),
            'ip_address' => $request ? $request->ip() : null,
            'old_values' => isset($options['old_values']) ? $options['old_values'] : null,
            'new_values' => isset($options['new_values']) ? $options['new_values'] : null,
            'status' => isset($options['status']) ? $options['status'] : 'completed',
            'severity' => isset($options['severity']) ? $options['severity'] : 'info'
        ]);
    }

    // Specific logging methods for different modules
    public static function logBooking($action, $booking, $description = null)
    {
        $roomName = isset($booking->room) ? $booking->room->name : 'Unknown Room';
        $bookingStatus = isset($booking->status) ? $booking->status : 'completed';
        
        $descriptions = [
            'created' => "New booking created for {$roomName}",
            'updated' => "Booking updated for {$roomName}",
            'deleted' => "Booking deleted for {$roomName}",
            'approved' => "Booking approved for {$roomName}",
            'rejected' => "Booking rejected for {$roomName}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Booking action performed';

        return self::log('booking', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($booking),
            'model_id' => $booking->id,
            'status' => $bookingStatus
        ]);
    }

    public static function logReservation($action, $reservation, $description = null)
    {
        $roomInfo = 'Unknown Room';
        if (isset($reservation->room)) {
            $roomInfo = $reservation->room->name;
        } elseif (isset($reservation->other_room_description)) {
            $roomInfo = $reservation->other_room_description;
        }

        $descriptions = [
            'created' => "New facility reservation created for {$roomInfo}",
            'updated' => "Facility reservation updated for {$roomInfo}",
            'deleted' => "Facility reservation cancelled for {$roomInfo}",
            'approved' => "Facility reservation approved for {$roomInfo}",
            'rejected' => "Facility reservation rejected for {$roomInfo}",
            'status_changed' => "Facility reservation status changed to {$reservation->status} for {$roomInfo}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Reservation action performed';

        return self::log('reservation', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($reservation),
            'model_id' => $reservation->id,
            'status' => $reservation->status
        ]);
    }

    public static function logSchedule($action, $schedule, $description = null)
    {
        $scheduleName = isset($schedule->title) ? $schedule->title : (isset($schedule->name) ? $schedule->name : 'Schedule');
        $scheduleStatus = isset($schedule->status) ? $schedule->status : 'completed';
        
        $descriptions = [
            'created' => "New schedule created: {$scheduleName}",
            'updated' => "Schedule updated: {$scheduleName}",
            'deleted' => "Schedule deleted: {$scheduleName}",
            'published' => "Schedule published: {$scheduleName}",
            'cancelled' => "Schedule cancelled: {$scheduleName}",
            'rescheduled' => "Schedule rescheduled: {$scheduleName}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Schedule action performed';

        return self::log('schedule', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($schedule),
            'model_id' => $schedule->id,
            'status' => $scheduleStatus
        ]);
    }

    public static function logEquipment($action, $equipment, $type = 'equipment', $description = null)
    {
        $equipmentType = $type === 'furniture' ? 'Furniture' : 'Electronics';
        $equipmentStatus = isset($equipment->status) ? $equipment->status : 'completed';
        
        $descriptions = [
            'created' => "New {$equipmentType} added: {$equipment->name}",
            'updated' => "{$equipmentType} updated: {$equipment->name}",
            'deleted' => "{$equipmentType} removed: {$equipment->name}",
            'maintenance_scheduled' => "{$equipmentType} maintenance scheduled: {$equipment->name}",
            'maintenance_completed' => "{$equipmentType} maintenance completed: {$equipment->name}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Equipment action performed';

        return self::log($type, $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($equipment),
            'model_id' => $equipment->id,
            'status' => $equipmentStatus
        ]);
    }

    public static function logMaintenance($action, $maintenance, $description = null)
    {
        $equipmentName = isset($maintenance->equipment_name) ? $maintenance->equipment_name : 'equipment';
        $maintenanceStatus = isset($maintenance->status) ? $maintenance->status : 'pending';
        
        $descriptions = [
            'created' => "Maintenance scheduled for {$equipmentName}",
            'updated' => "Maintenance updated for {$equipmentName}",
            'completed' => "Maintenance completed for {$equipmentName}",
            'cancelled' => "Maintenance cancelled for {$equipmentName}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Maintenance action performed';

        return self::log('maintenance', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($maintenance),
            'model_id' => $maintenance->id,
            'status' => $maintenanceStatus
        ]);
    }

    public static function logUser($action, $user, $description = null)
    {
        $descriptions = [
            'created' => "New user account created: {$user->name}",
            'updated' => "User account updated: {$user->name}",
            'deleted' => "User account deleted: {$user->name}",
            'login' => "User logged in: {$user->name}",
            'logout' => "User logged out: {$user->name}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'User action performed';

        return self::log('user', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($user),
            'model_id' => $user->id
        ]);
    }

    public static function logFeedback($action, $feedback, $description = null)
    {
        $userName = isset($feedback->user_name) ? $feedback->user_name : 'Anonymous';
        $feedbackStatus = isset($feedback->status) ? $feedback->status : 'completed';
        
        $descriptions = [
            'created' => "New feedback submitted by {$userName}",
            'updated' => "Feedback updated",
            'responded' => "Admin responded to feedback",
            'resolved' => "Feedback marked as resolved"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Feedback action performed';

        return self::log('feedback', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($feedback),
            'model_id' => $feedback->id,
            'status' => $feedbackStatus
        ]);
    }

    public static function logRoom($action, $room, $description = null)
    {
        $descriptions = [
            'created' => "New room added: {$room->name}",
            'updated' => "Room updated: {$room->name}",
            'deleted' => "Room removed: {$room->name}",
            'maintenance' => "Room maintenance scheduled: {$room->name}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Room action performed';

        return self::log('room', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($room),
            'model_id' => $room->id
        ]);
    }

    public static function logFaculty($action, $faculty, $description = null)
    {
        $descriptions = [
            'created' => "New faculty/office added: {$faculty->name}",
            'updated' => "Faculty/office updated: {$faculty->name}",
            'deleted' => "Faculty/office removed: {$faculty->name}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Faculty action performed';

        return self::log('faculty', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($faculty),
            'model_id' => $faculty->id
        ]);
    }

    public static function logDepartment($action, $department, $description = null)
    {
        $descriptions = [
            'created' => "New department added: {$department->name}",
            'updated' => "Department updated: {$department->name}",
            'deleted' => "Department removed: {$department->name}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Department action performed';

        return self::log('department', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($department),
            'model_id' => $department->id
        ]);
    }

    public static function logCourse($action, $course, $description = null)
    {
        $descriptions = [
            'created' => "New course added: {$course->name}",
            'updated' => "Course updated: {$course->name}",
            'deleted' => "Course removed: {$course->name}"
        ];

        $defaultDescription = isset($descriptions[$action]) ? $descriptions[$action] : 'Course action performed';

        return self::log('course', $action, $description ? $description : $defaultDescription, [
            'model_type' => get_class($course),
            'model_id' => $course->id
        ]);
    }
}