<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class BookingReminderMail extends Mailable{
    use SerializesModels;

    public $user;
    public $booking;
    public $users;
    public $furnitures;
    public $electronics;
    public $durationHours;

    public function __construct($user, $booking, $users, $furnitures, $electronics, $durationHours)
    {
        $this->user = $user;
        $this->booking = $booking;
        $this->users = $users;
        $this->furnitures = $furnitures;
        $this->electronics = $electronics;
        $this->durationHours = $durationHours;
    }

    public function build()
    {
        return $this->subject('Booking Reminder')
                    ->view('emails.booking_reminder');
    }
    
}
