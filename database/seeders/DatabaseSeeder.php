<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\account::factory(10)->create();
        \App\Models\color::factory(10)->create();
        \App\Models\type::factory(10)->create();
        \App\Models\product::factory(10)->create();
        

    }
}
