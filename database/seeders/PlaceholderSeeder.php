<?php

namespace Database\Seeders;

use App\Models\Placeholder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaceholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Placeholder::factory()->name()->create();
        Placeholder::factory()->id()->create();
        Placeholder::factory()->total()->create();
        Placeholder::factory()->link()->create();
    }
}
