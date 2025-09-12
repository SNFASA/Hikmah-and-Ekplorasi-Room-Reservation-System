<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\FasilitesReservation;
use App\Models\Room;

class NewReservationNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $reservation;

    /**
     * Create a new notification instance.
     */
    public function __construct(FasilitesReservation $reservation)
    {
        $this->reservation = $reservation;
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
        $roomName = $this->getRoomName();
        
        return [
            'type' => 'reservation',
            'reservation_id' => $this->reservation->id,
            'title' => 'New Facility Reservation',
            'message' => 'A new facility reservation has been submitted by ' . $this->reservation->name,
            'reservation_name' => $this->reservation->name,
            'reservation_email' => $this->reservation->email,
            'purpose' => $this->reservation->purpose_program_name,
            'start_date' => $this->reservation->start_date,
            'start_time' => $this->reservation->start_time,
            'end_date' => $this->reservation->end_date,
            'end_time' => $this->reservation->end_time,
            'room_name' => $roomName,
            'no_of_participants' => $this->reservation->no_of_participants,
            'participant_category' => $this->reservation->participant_category,
            'event_type' => $this->reservation->event_type,
            'status' => $this->reservation->status,
            'actionURL' => '/admin/reservations/' . $this->reservation->id,
            'created_at' => $this->reservation->created_at,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $roomName = $this->getRoomName();
        
        return [
            'type' => 'reservation',
            'reservation_id' => $this->reservation->id,
            'title' => 'New Facility Reservation',
            'message' => 'A new facility reservation has been submitted by ' . $this->reservation->name,
            'reservation_name' => $this->reservation->name,
            'reservation_email' => $this->reservation->email,
            'purpose' => $this->reservation->purpose_program_name,
            'start_date' => $this->reservation->start_date,
            'start_time' => $this->reservation->start_time,
            'end_date' => $this->reservation->end_date,
            'end_time' => $this->reservation->end_time,
            'room_name' => $roomName,
            'no_of_participants' => $this->reservation->no_of_participants,
            'participant_category' => $this->reservation->participant_category,
            'event_type' => $this->reservation->event_type,
            'status' => $this->reservation->status,
            'actionURL' => '/admin/reservations/' . $this->reservation->id,
            'fas' => 'fa-building', // FontAwesome icon for reservation
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
        return 'new.reservation';
    }

    /**
     * Get room name for display
     */
    private function getRoomName(): string
    {
        if ($this->reservation->room_id) {
            $room = Room::where('no_room', $this->reservation->room_id)->first();
            return $room ? $room->name : 'Room #' . $this->reservation->room_id;
        } else {
            return $this->reservation->other_room_description ?? 'Other Room';
        }
    }
}