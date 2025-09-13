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
        try {
            $reservation = FasilitesReservation::findOrFail($reservationId);
            \Log::info('Starting to queue reservation emails for reservation ID: ' . $reservationId);
            
            // Get common data
            $data = $this->getReservationEmailData($reservation);
            
            $emailsQueued = 0;
            
            // Queue email jobs with staggered delays
            foreach ($data['reservationUsers'] as $index => $user) {
                if ($user && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                    // Dispatch job with increasing delay to avoid rate limiting
                    \App\Jobs\ReservationEmail::dispatch(
                        $user,
                        $reservation,
                        $data['reservationUsers'],
                        $data['furnitures'],
                        $data['electronics'],
                        $data['durationHours']
                    )->delay(now()->addSeconds($index * 3)); // 3 seconds apart
                    
                    $emailsQueued++;
                    \Log::info("Queued reservation email for: " . $user->email . " (delay: " . ($index * 3) . "s)");
                } else {
                    \Log::warning("Invalid or missing email for user: " . json_encode($user));
                }
            }
            
            \Log::info("Queued {$emailsQueued} reservation emails for reservation ID: {$reservationId}");
            return $emailsQueued > 0;
            
        } catch (\Exception $e) {
            \Log::error('Failed to queue reservation emails for reservation ' . $reservationId . ': ' . $e->getMessage());
            return false;
        }
    }

    public function sendReservationStatusUpdateEmail($reservationId)
    {
        try {
            $reservation = FasilitesReservation::with(['createdBy.user', 'listStudentBooking.user'])->findOrFail($reservationId);
            \Log::info('Starting to send reservation status update email for reservation ID: ' . $reservationId);
            
            // Get common data
            $data = $this->getReservationEmailData($reservation);
            
            $emailsSent = 0;
            $emailsFailed = 0;
            
            // Get unique email addresses to send to
            $emailAddresses = collect();
            
            // 1. Add creator email (person who created the reservation)
            $createdByUser = DB::table('list_student_booking')
                ->join('users', 'list_student_booking.no_matriks', '=', 'users.no_matriks')
                ->where('list_student_booking.id', $reservation->created_by_matric_no)
                ->select('users.name', 'users.email', 'users.no_matriks')
                ->first();
            
            if ($createdByUser && filter_var($createdByUser->email, FILTER_VALIDATE_EMAIL)) {
                $emailAddresses->push([
                    'name' => $createdByUser->name,
                    'email' => $createdByUser->email,
                    'type' => 'creator'
                ]);
            }
            
            // 2. Add reservation contact email if different
            if ($reservation->email && filter_var($reservation->email, FILTER_VALIDATE_EMAIL)) {
                // Only add if it's different from creator email
                if (!$emailAddresses->pluck('email')->contains($reservation->email)) {
                    $emailAddresses->push([
                        'name' => $reservation->name,
                        'email' => $reservation->email,
                        'type' => 'contact'
                    ]);
                }
            }
            
            \Log::info('Found ' . $emailAddresses->count() . ' unique email addresses for status update');
            
            // Send emails to each recipient with delay to avoid rate limiting
            foreach ($emailAddresses as $index => $recipient) {
                try {
                    // Add delay between emails to avoid rate limiting (except for first email)
                    if ($index > 0) {
                        sleep(3); // Wait 3 seconds between emails
                        \Log::info("Added 3-second delay before sending to: " . $recipient['email']);
                    }
                    
                    Mail::to($recipient['email'])->send(
                        new \App\Mail\ReservationStatusUpdate(
                            (object) $recipient,
                            $reservation,
                            $data['reservationUsers'],
                            $data['furnitures'],
                            $data['electronics'],
                            $data['durationHours']
                        )
                    );
                    $emailsSent++;
                    \Log::info("Reservation status update email sent to: " . $recipient['email'] . " (type: " . $recipient['type'] . ")");
                } catch (\Exception $e) {
                    $emailsFailed++;
                    \Log::error("Failed to send status update email to " . $recipient['email'] . ": " . $e->getMessage());
                    
                    // If rate limited, wait longer and retry once
                    if (strpos($e->getMessage(), 'Too many emails per second') !== false) {
                        \Log::info("Rate limited, waiting 5 seconds and retrying for: " . $recipient['email']);
                        sleep(5);
                        try {
                            Mail::to($recipient['email'])->send(
                                new \App\Mail\ReservationStatusUpdate(
                                    (object) $recipient,
                                    $reservation,
                                    $data['reservationUsers'],
                                    $data['furnitures'],
                                    $data['electronics'],
                                    $data['durationHours']
                                )
                            );
                            $emailsSent++;
                            $emailsFailed--;
                            \Log::info("Retry successful for: " . $recipient['email']);
                        } catch (\Exception $retryError) {
                            \Log::error("Retry also failed for " . $recipient['email'] . ": " . $retryError->getMessage());
                        }
                    }
                }
            }
            
            \Log::info("Status update email summary for ID {$reservationId}: {$emailsSent} sent, {$emailsFailed} failed");
            return $emailsSent > 0;
            
        } catch (\Exception $e) {
            \Log::error('Failed to send reservation status update email for reservation ' . $reservationId . ': ' . $e->getMessage());
            return false;
        }
    }

    public function sendReservationEmailViaQueue($reservationId)
    {
        // This is just an alias that calls the main method
        return $this->sendReservationEmail($reservationId);
    }

    public function sendReservationEmailDirect($reservationId)
    {
        try {
            $reservation = FasilitesReservation::findOrFail($reservationId);
            \Log::info('Starting to send reservation email directly for reservation ID: ' . $reservationId);
            
            // Get common data
            $data = $this->getReservationEmailData($reservation);
            
            $emailsSent = 0;
            $emailsFailed = 0;
            
            // Send email to each user with delay to avoid rate limiting
            foreach ($data['reservationUsers'] as $index => $user) {
                if ($user && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                    try {
                        // Add delay between emails to avoid rate limiting (except for first email)
                        if ($index > 0) {
                            sleep(2); // Wait 2 seconds between emails
                            \Log::info("Added 2-second delay before sending to: " . $user->email);
                        }
                        
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
                        $emailsSent++;
                        \Log::info("Reservation email sent successfully to: " . $user->email);
                    } catch (\Exception $e) {
                        $emailsFailed++;
                        \Log::error("Failed to send reservation email to " . $user->email . ": " . $e->getMessage());
                        
                        // If rate limited, wait longer and retry once
                        if (strpos($e->getMessage(), 'Too many emails per second') !== false) {
                            \Log::info("Rate limited, waiting 5 seconds and retrying for: " . $user->email);
                            sleep(5);
                            try {
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
                                $emailsSent++;
                                $emailsFailed--;
                                \Log::info("Retry successful for: " . $user->email);
                            } catch (\Exception $retryError) {
                                \Log::error("Retry also failed for " . $user->email . ": " . $retryError->getMessage());
                            }
                        }
                    }
                } else {
                    $emailsFailed++;
                    \Log::warning("Invalid or missing email for user: " . json_encode($user));
                }
            }
            
            \Log::info("Reservation email summary for ID {$reservationId}: {$emailsSent} sent, {$emailsFailed} failed");
            return $emailsSent > 0; // Return true if at least one email was sent
            
        } catch (\Exception $e) {
            \Log::error('Failed to send reservation email for reservation ' . $reservationId . ': ' . $e->getMessage());
            return false;
        }
    }

    private function getReservationEmailData($reservation)
    {
        try {
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
            if ($reservation->email && (!$createdByUser || $reservation->email != $createdByUser->email)) {
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
                $furnitures = DB::table('furniture_room')
                    ->join('furniture', 'furniture_room.id', '=', 'furniture.no_furniture')
                    ->where('furniture_room.room_id', $reservation->room_id)
                    ->pluck('furniture.name');

                $electronics = DB::table('electronic_equipment_room')
                    ->join('electronic_equipment', 'electronic_equipment_room.id', '=', 'electronic_equipment.no_electronicEquipment')
                    ->where('electronic_equipment_room.room_id', $reservation->room_id)
                    ->pluck('electronic_equipment.name');
            }
            
            // Fixed duration calculation
            $durationHours = 0;
            try {
                // Method 1: Parse date and time separately
                $startDate = Carbon::parse($reservation->start_date);
                $endDate = Carbon::parse($reservation->end_date);
                
                // Handle different time formats that might be stored
                $startTimeStr = $reservation->start_time;
                $endTimeStr = $reservation->end_time;
                
                // Remove any extra characters and ensure H:i format
                $startTimeStr = preg_replace('/[^0-9:]/', '', $startTimeStr);
                $endTimeStr = preg_replace('/[^0-9:]/', '', $endTimeStr);
                
                // Parse times
                $startTime = Carbon::createFromFormat('H:i', substr($startTimeStr, 0, 5));
                $endTime = Carbon::createFromFormat('H:i', substr($endTimeStr, 0, 5));
                
                // Combine date and time
                $startDateTime = $startDate->copy()->setTimeFrom($startTime);
                $endDateTime = $endDate->copy()->setTimeFrom($endTime);
                
                $durationHours = $startDateTime->diffInHours($endDateTime);
                
            } catch (\Exception $e) {
                // Fallback method
                try {
                    $startDateTime = Carbon::parse($reservation->start_date . ' ' . $reservation->start_time);
                    $endDateTime = Carbon::parse($reservation->end_date . ' ' . $reservation->end_time);
                    $durationHours = $startDateTime->diffInHours($endDateTime);
                } catch (\Exception $e2) {
                    \Log::warning('Could not calculate duration for reservation ' . $reservation->id . ', using default value of 1 hour');
                    $durationHours = 1; // Default fallback
                }
            }
            
            return [
                'reservationUsers' => $reservationUsers,
                'furnitures' => $furnitures,
                'electronics' => $electronics,
                'durationHours' => $durationHours
            ];
            
        } catch (\Exception $e) {
            \Log::error('Failed to get reservation email data for reservation ' . $reservation->id . ': ' . $e->getMessage());
            
            // Return minimal data to prevent complete failure
            return [
                'reservationUsers' => collect([(object)[
                    'name' => $reservation->name ?? 'Unknown User',
                    'email' => $reservation->email ?? 'no-email@example.com',
                    'no_matriks' => 'N/A'
                ]]),
                'furnitures' => collect(),
                'electronics' => collect(),
                'durationHours' => 1
            ];
        }
    }
}