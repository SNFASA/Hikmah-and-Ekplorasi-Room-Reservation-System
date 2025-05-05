<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Broadcasting\Channel;
class NewBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Booking',
            'fas' => 'fa-calendar-check',
            'booking_id' => $this->booking->id,
            'actionURL' => route('backend.booking.show', ['id' => $this->booking->id]),
        ];
    }
    
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'New Booking',
            'fas' => 'fa-calendar-check',
            'created_at' => now()->format('F d, Y h:i A'),
            'booking_id' => $this->booking->id,
            'actionURL' => route('backend.booking.show', ['id' => $this->booking->id]),
        ]);
    }
    
    public function broadcastOn()
    {
        return new Channel('admin-bookings'); // Public channel
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Booking',
            'fas' => 'fa-calendar',
            'actionURL' => route('backend.booking.show', ['id' => $this->booking->id]),
            'booking_id' => $this->booking->id, // optional but useful
        ];
        dd($this->booking->id);

    }
    

}
