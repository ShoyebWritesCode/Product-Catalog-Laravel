<?php

namespace Database\Seeders;

use App\Models\Catagory;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Catagory::factory()->Toy()->create();
        Catagory::factory()->Food()->create();
        Catagory::factory()->Electrical()->create();
        Catagory::factory()->Housing()->create();
        Catagory::factory()->Car()->create();
        Catagory::factory()->Puzzle()->create();
        Catagory::factory()->Phone()->create();
        Catagory::factory()->Computer()->create();
        Catagory::factory()->Snack()->create();
        Catagory::factory()->Drink()->create();
        Catagory::factory()->Bed()->create();
        Catagory::factory()->Table()->create();
    }
}
