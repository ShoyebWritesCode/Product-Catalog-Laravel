<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mapping;

class MappingSeeder extends Seeder
{
    public function run(): void
    {
        $categoryMappings = [
            1 => 5,
            2 => 7,
            3 => 9,
            4 => 11,
        ];

        for ($i = 1; $i <= 100; $i++) {
            $categoryId = ($i % 4) + 1;

            Mapping::factory()->create([
                'product_id' => $i,
                'catagory_id' => $categoryMappings[$categoryId],
            ]);
        }
    }
}
