<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    
    public function run(): void
    {
        Category::create(['name' => 'Religión']);
        Category::create(['name' => 'Família']);
        Category::create(['name' => 'Maternidad']);
        Category::create(['name' => 'Fraternidad']);
        Category::create(['name' => 'Salud']);
        Category::create(['name' => 'Educación']);
        Category::create(['name' => 'Eventos']);
    }
}