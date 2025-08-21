<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\FasilitesReservation;

class NewReservationNotification extends Notification
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Facility Reservation - Admin Notification')
                    ->line('A new facility reservation has been submitted and requires your review.')
                    ->line('Reservation ID: #' . $this->reservation->id)
                    ->line('Requested by: ' . $this->reservation->name)
                    ->line('Email: ' . $this->reservation->email)
                    ->line('Purpose: ' . $this->reservation->purpose_program_name)
                    ->line('Date: ' . \Carbon\Carbon::parse($this->reservation->start_date)->format('F j, Y'))
                    ->line('Time: ' . \Carbon\Carbon::parse($this->reservation->start_time)->format('g:i A') . ' - ' . \Carbon\Carbon::parse($this->reservation->end_time)->format('g:i A'))
                    ->line('Status: ' . ucfirst($this->reservation->status))
                    ->action('View Reservation', url('/admin/reservations/' . $this->reservation->id))
                    ->line('Please review and take appropriate action on this reservation.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'title' => 'New Facility Reservation',
            'message' => 'A new facility reservation has been submitted by ' . $this->reservation->name,
            'reservation_name' => $this->reservation->name,
            'reservation_email' => $this->reservation->email,
            'purpose' => $this->reservation->purpose_program_name,
            'start_date' => $this->reservation->start_date,
            'start_time' => $this->reservation->start_time,
            'status' => $this->reservation->status,
            'url' => '/admin/reservations/' . $this->reservation->id,
        ];
    }
}