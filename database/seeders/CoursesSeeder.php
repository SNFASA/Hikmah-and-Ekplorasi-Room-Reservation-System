<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('courses')->insert([
            // FSKTM (1)
            ['name' => 'BACHELOR OF COMPUTER SCIENCE (SOFTWARE ENGINEERING) WITH HONOURS', 'department' => 1],
            ['name' => 'BACHELOR OF COMPUTER SCIENCE (INFORMATION SECURITY) WITH HONOURS', 'department' => 1],
            ['name' => 'BACHELOR OF COMPUTER SCIENCE (MULTIMEDIA COMPUTING) WITH HONOURS', 'department' => 1],
            ['name' => 'BACHELOR OF COMPUTER SCIENCE (WEB TECHNOLOGY) WITH HONOURS', 'department' => 1],

            // FKEE (2)
            ['name' => 'BACHELOR OF ELECTRICAL ENGINEERING WITH HONOURS', 'department' => 2],
            ['name' => 'BACHELOR OF ELECTRONIC ENGINEERING (COMPUTER ENGINEERING) WITH HONOURS', 'department' => 2],
            ['name' => 'BACHELOR OF MECHATRONICS ENGINEERING WITH HONOURS', 'department' => 2],

            // FKAAB (3)
            ['name' => 'BACHELOR OF CIVIL ENGINEERING WITH HONOURS', 'department' => 3],
            ['name' => 'BACHELOR OF STRUCTURAL ENGINEERING WITH HONOURS', 'department' => 3],
            ['name' => 'BACHELOR OF CONSTRUCTION MANAGEMENT WITH HONOURS', 'department' => 3],

            // FPTV (4)
            ['name' => 'BACHELOR OF VOCATIONAL EDUCATION (CIVIL ENGINEERING CONSTRUCTION) WITH HONOURS', 'department' => 4],
            ['name' => 'BACHELOR OF VOCATIONAL EDUCATION (ELECTRICAL AND ELECTRONICS) WITH HONOURS', 'department' => 4],

            // FPTP (5)
            ['name' => 'BACHELOR OF TECHNOLOGY MANAGEMENT WITH HONOURS', 'department' => 5],
            ['name' => 'BACHELOR OF TECHNOLOGY MANAGEMENT (INNOVATION) WITH HONOURS', 'department' => 5],

            // FKMP (6)
            ['name' => 'BACHELOR OF MECHANICAL ENGINEERING WITH HONOURS', 'department' => 6],
            ['name' => 'BACHELOR OF MANUFACTURING ENGINEERING WITH HONOURS', 'department' => 6],

            // FAST (7)
            ['name' => 'BACHELOR OF APPLIED SCIENCE (FOOD TECHNOLOGY) WITH HONOURS', 'department' => 7],
            ['name' => 'BACHELOR OF INDUSTRIAL CHEMISTRY WITH HONOURS', 'department' => 7],

            // FTK (8)
            ['name' => 'BACHELOR OF TECHNOLOGY IN ELECTRICAL ENGINEERING WITH HONOURS', 'department' => 8],
            ['name' => 'BACHELOR OF TECHNOLOGY IN MECHANICAL ENGINEERING WITH HONOURS', 'department' => 8],

            // PPD (9)
            ['name' => 'DIPLOMA IN COMPUTER SCIENCE', 'department' => 9],
            ['name' => 'DIPLOMA IN CIVIL ENGINEERING', 'department' => 9],
        ]);
    }
}
