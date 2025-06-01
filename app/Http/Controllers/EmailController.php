<?php
namespace App\Http\Controllers;
use App\Models\bookings;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReminderMail;

class EmailController extends Controller
{
    public function sendBookingEmail($bookingId)
    {
        $booking = bookings::with(['users', 'furnitures', 'electronics'])->findOrFail($bookingId);
        $bookingUsers = $booking->users;
        $durationHours = now()->diffInHours($booking->booking_time_end); // corrected attribute
    
        foreach ($bookingUsers as $user) {
            if ($user && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($user->email)->send(
                    new BookingReminderMail(
                        (object)[
                            'name' => $user->name,
                            'email' => $user->email,
                        ],
                        $booking,
                        $bookingUsers,
                        $booking->furnitures,
                        $booking->electronics,
                        $durationHours
                    )
                );
                \Log::info("Sent to: " . $user->email);
            } else {
                \Log::warning("Invalid or missing email for user: " . json_encode($user));
            }
        }
    
        return true;
    }
    
}

