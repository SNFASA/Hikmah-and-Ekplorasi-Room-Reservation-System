<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Bookings;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $purposes = ['Group Discussion', 'Project Work', 'Meeting', 'Interview Prep', 'Study Session', 'Presentation Prep'];
        $roomIds = range(1, 33);
        $faker = \Faker\Factory::create('ms_MY');

        for ($i = 0; $i < 30; $i++) {
            // Generate random weekday date in June/July 2025
            do {
                $bookingDate = Carbon::create(2025, rand(6, 7), rand(1, 28));
            } while ($bookingDate->isWeekend());

            // Generate booking start and end times between 8:00 and 18:00
            $startHour = rand(8, 16);
            $startMinute = rand(0, 1) ? 0 : 30;
            $duration = rand(1, 2); // 1 or 2 hours
            $startTime = Carbon::createFromTime($startHour, $startMinute);
            $endTime = (clone $startTime)->addHours($duration);

            if ($endTime->hour > 18) {
                $endTime = Carbon::createFromTime(18, 0);
            }

            $noRoom = $faker->randomElement($roomIds);
            $phoneNumber = $faker->phoneNumber;

            $booking = Bookings::create([
                'booking_date' => $bookingDate->format('Y-m-d'),
                'booking_time_start' => $startTime->format('H:i'),
                'booking_time_end' => $endTime->format('H:i'),
                'duration' => $duration,
                'purpose' => $faker->randomElement($purposes),
                'no_room' => $noRoom,
                'phone_number' => $phoneNumber,
                'status' => 'approved',
            ]);

            $studentsCount = rand(4, 6);
            for ($j = 0; $j < $studentsCount; $j++) {
                $prefix = $faker->randomElement(['A', 'C']);
                $matrik = $prefix . $faker->numerify('#######');
                $name = $faker->name;

                // Create student user
                User::firstOrCreate(
                    ['no_matriks' => $matrik],
                    [
                        'name' => $name,
                        'facultyOffice' => null,
                        'course' => null,
                        'email' => $matrik . '@student.uthm.edu.my',
                        'password' => Hash::make($matrik),
                        'role' => 'user',
                    ]
                );

                // Insert into list_student_booking
                $listId = DB::table('list_student_booking')->insertGetId([
                    'no_matriks' => $matrik,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert into booking_user pivot table
                DB::table('booking_user')->insert([
                    'booking_id' => $booking->id,
                    'list_student_booking_id' => $listId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
