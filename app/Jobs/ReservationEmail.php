<?php

namespace App\Jobs;

use App\Mail\ReservationRemainder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ReservationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reservation;
    public $reservationUsers;
    public $furnitures;
    public $electronics;
    public $user;
    public $durationHours;

    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public $backoff = [10, 30, 60]; // Wait 10s, then 30s, then 60s between retries

    public function __construct($user, $reservation, $reservationUsers, $furnitures, $electronics, $durationHours)
    {
        $this->user = $user;
        $this->reservation = $reservation;
        $this->reservationUsers = $reservationUsers;
        $this->furnitures = $furnitures;
        $this->electronics = $electronics;
        $this->durationHours = $durationHours;
        
        // Add delay to avoid rate limiting
        $this->delay(rand(1, 5)); // Random delay between 1-5 seconds
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->user->email)->send(
                new ReservationRemainder(
                    $this->user,
                    $this->reservation,
                    $this->reservationUsers,
                    $this->furnitures,
                    $this->electronics,
                    $this->durationHours
                )
            );
            
            \Log::info("Queued reservation email sent successfully to: " . $this->user->email);
            
        } catch (\Exception $e) {
            \Log::error("Failed to send queued reservation email to " . $this->user->email . ": " . $e->getMessage());
            
            // Re-throw the exception to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        \Log::error("Reservation email job failed permanently for " . $this->user->email . ": " . $exception->getMessage());
    }
}