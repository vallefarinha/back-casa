<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Category::create(['name' => 'Religión']);
        Category::create(['name' => 'Família']);
        Category::create(['name' => 'Maternidad']);
        Category::create(['name' => 'Fraternidad']);
        Category::create(['name' => 'Salud']);
        Category::create(['name' => 'Educación']);
        Category::create(['name' => 'Eventos']);
        }
}