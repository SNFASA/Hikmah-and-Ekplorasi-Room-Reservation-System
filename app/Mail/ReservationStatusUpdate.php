<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ReservationStatusUpdate extends Mailable
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
        $status = ucfirst($this->reservation->status);
        $subject = "Facility Reservation {$status} - Reservation #{$this->reservation->id}";
        
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation_status_update',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // Attach the reservation document if it exists
        if ($this->reservation->file_path && Storage::exists($this->reservation->file_path)) {
            $attachments[] = Attachment::fromStorage($this->reservation->file_path)
                ->as($this->reservation->file_original_name ?? 'reservation_document')
                ->withMime($this->getFileMimeType($this->reservation->file_type));
        }
        
        return $attachments;
    }
    
    /**
     * Get proper MIME type for file attachment
     */
    private function getFileMimeType($fileType)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];
        
        return $mimeTypes[strtolower($fileType)] ?? 'application/octet-stream';
    }
}