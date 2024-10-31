<?php

namespace Database\Seeders;
use App\Models\faculty_offices;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class faculty_officesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        faculty_offices::create([
            'name' => 'FSKTM',
            'department' => '1',
        ]);
    }
}
