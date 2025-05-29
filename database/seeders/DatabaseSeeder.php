<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        \App\Models\Color::factory(5)->create();
        \App\Models\Size::factory(3)->create();

        \App\Models\Item::factory(10)
            ->hasInventories(3) // crea 3 variantes por producto
            ->create();
    }
}
