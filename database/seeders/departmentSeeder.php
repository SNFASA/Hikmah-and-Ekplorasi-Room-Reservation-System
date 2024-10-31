<?php

namespace Database\Seeders;

use App\Models\department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class departmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        department::create([
            'name' => 'software engineering',
            
        ]);
    }
}
