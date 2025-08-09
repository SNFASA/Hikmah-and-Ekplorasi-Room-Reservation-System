<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->where('data->is_deleted', '!=', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backend.notification.index', compact('notifications'));
    }

    public function show(Request $request)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $request->id)
            ->where('data->is_deleted', '!=', true)
            ->first();

        if ($notification) {
            $notification->markAsRead();

            if (isset($notification->data['actionURL'])) {
                return redirect($notification->data['actionURL']);
            }
        }

        return auth()->user()->role === 'admin'
            ? redirect()->route('admin')
            : redirect()->route('home');
    }
public function detail($id)
{
    $notification = auth()->user()
        ->notifications()
        ->where('id', $id)
        ->where('data->is_deleted', '!=', true)
        ->firstOrFail();

    $data = $notification->data;

    // Optional: mark as read when viewing detail
    $notification->markAsRead();

    if (!isset($data['type'])) {
        abort(400, 'Notification type is missing.');
    }

    switch ($data['type']) {
        case 'booking':
            // Load full booking detail like booking.show
            $booking = \App\Models\bookings::with([
                'room.electronics',
                'room.furnitures',
                'room.type',
                'listStudentBookings',
            ])->findOrFail($data['booking_id']);

            return view('backend.notification.detail-booking', compact('notification', 'booking'));

        case 'feedback':
            // Example: load feedback if type is feedback
            $feedback = \App\Models\Feedback::findOrFail($data['feedback_id']);
            return view('backend.notification.detail-feedback', compact('notification', 'feedback'));

        default:
            // Fallback: just show raw notification data
            return view('backend.notification.detail', compact('notification'));
    }
}


    public function markRead($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->where('data->is_deleted', '!=', true)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read.']);
        }

        return response()->json(['message' => 'Notification not found.'], 404);
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications
            ->where('data.is_deleted', '!=', true)
            ->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    public function clearAll()
    {
        $user = auth()->user();

        foreach ($user->notifications as $notification) {
            $data = $notification->data;
            $data['is_deleted'] = true;
            $notification->data = $data;
            $notification->save();
        }

        return back()->with('success', 'All notifications cleared.');
    }

    public function delete($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $data = $notification->data;
            $data['is_deleted'] = true;
            $notification->data = $data;
            $notification->save();

            request()->session()->flash('success', 'Notification successfully deleted');
        } else {
            request()->session()->flash('error', 'Notification not found');
        }

        return back();
    }
}
