<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class departmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            // FSKTM (Faculty of Computer Science and Information Technology)
            ['name' => 'Department of Software Engineering', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Information Security', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Multimedia Computing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Web Technology', 'created_at' => now(), 'updated_at' => now()],

            // FKEE (Faculty of Electrical Engineering)
            ['name' => 'Department of Electrical Engineering', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Electronic Engineering (Computer Engineering)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Mechatronics Engineering', 'created_at' => now(), 'updated_at' => now()],

            // FKAAB (Faculty of Civil Engineering and Built Environment)
            ['name' => 'Department of Civil Engineering', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Structural Engineering', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Construction Management', 'created_at' => now(), 'updated_at' => now()],

            // FPTV (Faculty of Technical and Vocational Education)
            ['name' => 'Department of Civil Engineering Construction', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Electrical and Electronics', 'created_at' => now(), 'updated_at' => now()],

            // FPTP (Faculty of Technology Management and Technopreneurship)
            ['name' => 'Department of Technology Management', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Innovation', 'created_at' => now(), 'updated_at' => now()],

            // FKMP (Faculty of Mechanical and Manufacturing Engineering)
            ['name' => 'Department of Mechanical Engineering', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Manufacturing Engineering', 'created_at' => now(), 'updated_at' => now()],

            // FAST (Faculty of Applied Science and Technology)
            ['name' => 'Department of Food Technology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Industrial Chemistry', 'created_at' => now(), 'updated_at' => now()],

            // FTK (Faculty of Technology and Knowledge)
            ['name' => 'Department of Electrical Engineering Technology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Mechanical Engineering Technology', 'created_at' => now(), 'updated_at' => now()],

            // PPD (Centre for Diploma Studies)
            ['name' => 'Department of Computer Science', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department of Civil Engineering', 'created_at' => now(), 'updated_at' => now()],

        ]);
    }
}
