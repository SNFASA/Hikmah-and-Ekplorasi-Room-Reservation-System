<?php

namespace Database\Seeders;
use App\Models\Courses ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Courses::create([
            'name' => ' BACHELOR OF COMPUTER SCIENCE (SOFTWARE ENGINEERING) WITH HONOURS',
            'department' => '1',
        ]);
    }
}

