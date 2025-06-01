<?php

namespace Database\Seeders;
use App\Models\faculty_offices;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultyOfficesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = [
            ['name' => 'FSKTM', 'department' => '1'],
            ['name' => 'FKEE', 'department' => '2'],
            ['name' => 'FKAAB', 'department' => '3'],
            ['name' => 'FPTV', 'department' => '4'],
            ['name' => 'FPTP', 'department' => '5'],
            ['name' => 'FKMP', 'department' => '6'],
            ['name' => 'FAST', 'department' => '7'],
            ['name' => 'FTK', 'department' => '8'],
            ['name' => 'PPD', 'department' => '9'],
            ['name' => 'PTTA', 'department' => '10'],
            ['name' => 'PPP', 'department' => '11'],
        ];

        foreach ($offices as $office) {
            faculty_offices::create($office);
        }
    }
}
