<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'no_matriks' => 'MATR123456', // You may replace this with an actual matriculation number
            'name' => 'NABIL',
            'email' => 'nabil@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 'Admin',  // Set to either 'student' or 'staff' to match ENUM options
            'facultyOffice' => 1, // Assuming this is an existing faculty_office ID
            'course' => 1,        // Assuming this is an existing course ID
        ]);
    }
}
