<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Jobs\SendBookingReminderMail;
use App\Mail\BookingReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;

class SendBookingReminderMailTest extends TestCase
{
    use WithFaker;

    /** @test */
public function it_sends_booking_reminder_email()
{
    Mail::fake();

    $user = (object) [
        'name' => 'Test User',
        'email' => 'test@example.com'
    ];

    $booking = (object) [
        'booking_date' => now()->toDateString(),
        'booking_time_start' => '10:00',
        'booking_time_end' => '12:00',
        'purpose' => 'Test Meeting',
    ];

    $bookingUsers = collect([$user]); // fake user list
    $furnitures = ['Table', 'Chair'];
    $electronics = ['Projector', 'Speaker'];
    $durationHours = 2;

    $job = new \App\Jobs\SendBookingReminderMail(
        $user,
        $booking,
        $bookingUsers,
        $furnitures,
        $electronics,
        $durationHours
    );

    $job->handle();

    Mail::assertSent(\App\Mail\BookingReminderMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
}

}
