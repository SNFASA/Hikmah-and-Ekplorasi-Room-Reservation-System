<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesEquipmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories_equipment')->insert([
            ['name' => 'Projector'],
            ['name' => 'Monitor'],
            ['name' => 'Speaker'],
            ['name' => 'Chair'],
            ['name' => 'Table'],
            ['name' => 'Whiteboard'],
        ]);
    }
}
