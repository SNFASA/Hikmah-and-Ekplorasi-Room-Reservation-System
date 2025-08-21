<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationRemainder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reservation;
    public $reservationUsers;
    public $furnitures;
    public $electronics;
    public $durationHours;

    public function __construct($user, $reservation, $reservationUsers, $furnitures, $electronics, $durationHours)
    {
        $this->user = $user;
        $this->reservation = $reservation;
        $this->reservationUsers = $reservationUsers;
        $this->furnitures = $furnitures;
        $this->electronics = $electronics;
        $this->durationHours = $durationHours;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Facility Reservation Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation_reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}