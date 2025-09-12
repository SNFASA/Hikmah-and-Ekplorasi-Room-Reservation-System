<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backend.notification.index', compact('notifications'));
    }

    public function show(Request $request)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $request->id)
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            })
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
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            })
            ->firstOrFail();

        $data = $notification->data;

        // Optional: mark as read when viewing detail
        $notification->markAsRead();

        if (!isset($data['type'])) {
            abort(400, 'Notification type is missing.');
        }

        switch ($data['type']) {
            case 'booking':
                // Load full booking detail
                $booking = \App\Models\Bookings::with([
                    'room.electronics',
                    'room.furnitures',
                    'room.type',
                    'listStudentBookings',
                ])->findOrFail($data['booking_id']);

                return view('backend.notification.detail', compact('notification', 'booking'));

            case 'reservation':
                // Load full reservation detail
                $reservation = \App\Models\FasilitesReservation::with([
                    'room.electronics', 
                    'room.furnitures',
                    'facultyOffice'
                ])->findOrFail($data['reservation_id']);

                // Get reservation users
                $reservationUsers = collect();
                
                // Get the user who created the reservation
                if ($reservation->created_by_matric_no) {
                    $createdByUser = \DB::table('list_student_booking')
                        ->join('users', 'list_student_booking.no_matriks', '=', 'users.no_matriks')
                        ->where('list_student_booking.id', $reservation->created_by_matric_no)
                        ->select('users.name', 'users.email', 'users.no_matriks')
                        ->first();
                    
                    if ($createdByUser) {
                        $reservationUsers->push($createdByUser);
                    }
                }
                
                // Get the staff user (if different from created_by)
                if ($reservation->staff_id_matric_no && $reservation->staff_id_matric_no != $reservation->created_by_matric_no) {
                    $staffUser = \DB::table('list_student_booking')
                        ->join('users', 'list_student_booking.no_matriks', '=', 'users.no_matriks')
                        ->where('list_student_booking.id', $reservation->staff_id_matric_no)
                        ->select('users.name', 'users.email', 'users.no_matriks')
                        ->first();
                    
                    if ($staffUser) {
                        $reservationUsers->push($staffUser);
                    }
                }

                return view('backend.notification.detail-reservation', compact('notification', 'reservation', 'reservationUsers'));

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
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            })
            ->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read.']);
        }

        return response()->json(['message' => 'Notification not found.'], 404);
    }

    public function markAllRead()
    {
        $notifications = auth()->user()->unreadNotifications()
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            })
            ->get();

        foreach($notifications as $notification) {
            $notification->markAsRead();
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    public function clearAll()
    {
        $user = auth()->user();

        // Get all non-deleted notifications
        $notifications = $user->notifications()
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            })
            ->get();

        foreach ($notifications as $notification) {
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
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            })
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

    /**
     * Get unread notification count for AJAX requests
     */
    public function getCount()
    {
        $count = auth()->user()
            ->unreadNotifications()
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            })
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Helper method to get non-deleted notifications
     */
    private function getNonDeletedNotifications()
    {
        return auth()->user()
            ->notifications()
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            });
    }

    /**
     * Helper method to get non-deleted unread notifications
     */
    private function getNonDeletedUnreadNotifications()
    {
        return auth()->user()
            ->unreadNotifications()
            ->where(function($query) {
                $query->whereNull('data->is_deleted')
                      ->orWhere('data->is_deleted', '!=', true);
            });
    }
}