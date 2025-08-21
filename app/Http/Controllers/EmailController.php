<?php
namespace App\Http\Controllers;

use App\Models\bookings;
use App\Models\FasilitesReservation;
use App\Mail\ReservationRemainder;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReminderMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function sendReservationEmail($reservationId)
    {
        $reservation = FasilitesReservation::findOrFail($reservationId);
        
        // Get common data
        $data = $this->getReservationEmailData($reservation);
        
        // Send email to each user
        foreach ($data['reservationUsers'] as $user) {
            if ($user && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($user->email)->send(
                    new ReservationRemainder(
                        $user,
                        $reservation,
                        $data['reservationUsers'],
                        $data['furnitures'],
                        $data['electronics'],
                        $data['durationHours']
                    )
                );
                \Log::info("Reservation email sent to: " . $user->email);
            } else {
                \Log::warning("Invalid or missing email for user: " . json_encode($user));
            }
        }
    
        return true;
    }

    public function sendReservationStatusUpdateEmail($reservationId)
    {
        $reservation = FasilitesReservation::findOrFail($reservationId);
        
        // Get common data
        $data = $this->getReservationEmailData($reservation);
        
        // Send status update email to each user
        foreach ($data['reservationUsers'] as $user) {
            if ($user && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($user->email)->send(
                    new \App\Mail\ReservationStatusUpdate(
                        $user,
                        $reservation,
                        $data['reservationUsers'],
                        $data['furnitures'],
                        $data['electronics'],
                        $data['durationHours']
                    )
                );
                \Log::info("Reservation status update email sent to: " . $user->email);
            } else {
                \Log::warning("Invalid or missing email for user: " . json_encode($user));
            }
        }
    
        return true;
    }

    private function getReservationEmailData($reservation)
    {
        // Get reservation users (both created_by and staff users)
        $reservationUsers = collect();
        
        // Get the user who created the reservation
        $createdByUser = DB::table('list_student_booking')
            ->join('users', 'list_student_booking.no_matriks', '=', 'users.no_matriks')
            ->where('list_student_booking.id', $reservation->created_by_matric_no)
            ->select('users.name', 'users.email', 'users.no_matriks')
            ->first();
        
        if ($createdByUser) {
            $reservationUsers->push($createdByUser);
        }
        
        // Get the staff user (if different from created_by)
        if ($reservation->staff_id_matric_no != $reservation->created_by_matric_no) {
            $staffUser = DB::table('list_student_booking')
                ->join('users', 'list_student_booking.no_matriks', '=', 'users.no_matriks')
                ->where('list_student_booking.id', $reservation->staff_id_matric_no)
                ->select('users.name', 'users.email', 'users.no_matriks')
                ->first();
            
            if ($staffUser) {
                $reservationUsers->push($staffUser);
            }
        }
        
        // Also send to the reservation email if it's different
        if ($reservation->email && $reservation->email != $createdByUser->email) {
            $reservationUsers->push((object)[
                'name' => $reservation->name,
                'email' => $reservation->email,
                'no_matriks' => 'N/A'
            ]);
        }
        
        // Get furnitures and electronics
        $furnitures = collect();
        $electronics = collect();
        
        if ($reservation->room_id) {
            $furnitures = DB::table('furnitures_room')
                ->join('furnitures', 'furnitures_room.furniture_id', '=', 'furnitures.no_furniture')
                ->where('furnitures_room.room_id', $reservation->room_id)
                ->pluck('furnitures.name');

            $electronics = DB::table('electronics_room')
                ->join('electronics', 'electronics_room.electronic_id', '=', 'electronics.no_electronic')
                ->where('electronics_room.room_id', $reservation->room_id)
                ->pluck('electronics.name');
        }
        
        // Calculate duration
        $startDateTime = Carbon::parse($reservation->start_date . ' ' . $reservation->start_time);
        $endDateTime = Carbon::parse($reservation->end_date . ' ' . $reservation->end_time);
        $durationHours = $startDateTime->diffInHours($endDateTime);
        
        return [
            'reservationUsers' => $reservationUsers,
            'furnitures' => $furnitures,
            'electronics' => $electronics,
            'durationHours' => $durationHours
        ];
    }
}