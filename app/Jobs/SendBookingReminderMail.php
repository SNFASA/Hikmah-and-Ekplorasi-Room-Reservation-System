<?php

namespace App\Jobs;

// app/Jobs/SendBookingReminderMail.php

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\BookingReminderMail;
use Illuminate\Support\Facades\Mail;

class SendBookingReminderMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $booking;
    public $bookingUsers;
    public $furnitures;
    public $electronics;
    public $durationHours;


    public function __construct($user, $booking, $bookingUsers, $furnitures, $electronics, $durationHours)
    {
        $this->user = $user;
        $this->booking = $booking;
        $this->bookingUsers = $bookingUsers;
        $this->furnitures = $furnitures;
        $this->electronics = $electronics;
        $this->durationHours = $durationHours;
    }

    public function handle()
    {
        Mail::to($this->user->email)->send(
            new BookingReminderMail(
                (object)[
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ],
                $this->booking,
                $this->bookingUsers,
                $this->furnitures,
                $this->electronics,
                $this->durationHours
            )
        );
    }
}
