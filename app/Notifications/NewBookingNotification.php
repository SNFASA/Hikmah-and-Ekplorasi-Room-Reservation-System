<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Bookings;

class NewBookingNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Bookings $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): array
    {
        return [
            'type' => 'booking',
            'booking_id' => $this->booking->id,
            'title' => 'New Room Booking',
            'message' => 'A new room booking has been submitted for ' . $this->booking->room->name ?? 'Room #' . $this->booking->no_room,
            'booking_date' => $this->booking->booking_date,
            'booking_time_start' => $this->booking->booking_time_start,
            'booking_time_end' => $this->booking->booking_time_end,
            'purpose' => $this->booking->purpose,
            'room_name' => $this->booking->room->name ?? 'Room #' . $this->booking->no_room,
            'phone_number' => $this->booking->phone_number,
            'status' => $this->booking->status,
            'actionURL' => '/admin/bookings/' . $this->booking->id,
            'created_at' => $this->booking->created_at,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'booking',
            'booking_id' => $this->booking->id,
            'title' => 'New Room Booking',
            'message' => 'A new room booking has been submitted for ' . ($this->booking->room->name ?? 'Room #' . $this->booking->no_room),
            'booking_date' => $this->booking->booking_date,
            'booking_time_start' => $this->booking->booking_time_start,
            'booking_time_end' => $this->booking->booking_time_end,
            'purpose' => $this->booking->purpose,
            'room_name' => $this->booking->room->name ?? 'Room #' . $this->booking->no_room,
            'phone_number' => $this->booking->phone_number,
            'status' => $this->booking->status,
            'actionURL' => '/admin/bookings/' . $this->booking->id,
            'fas' => 'fa-calendar-alt', // FontAwesome icon for booking
            'created_at' => now(),
            'is_deleted' => false,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.booking';
    }
}