<?php

namespace App\Jobs;

use App\Mail\ReservationRemainder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReservationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reservation;
    public $reservationUser;
    public $furniture;
    public $electronic;
    public $user;
    public function __construct()
    {
        $this->user = $user;
        $this->reservation = $reservation;
        $this->reservationUser = $reservationUser;
        $this->furniture = $furniture;
        $this->electronic = $electronic;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
                Mail::to($this->user->email)->send(
            new ReservationRemainder(
                (object)[
                    'name' => $this->reservationUser->name,
                    'email' => $this->reservationUser->email,
                ],
                $this->reservation,
                $this->furnitures,
                $this->electronic,
                
            )
        );
    }
}
