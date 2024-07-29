<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Images;
use Illuminate\Database\Seeder;
use Database\Factories\ImagesFactory;

class ImageSeeder extends Seeder
{
    public function run()
    {
        // Get all existing products
        $products = Product::all();

        foreach ($products as $product) {
            // Assign 3 random images to the product using the ImageFactory
            for ($j = 0; $j < 3; $j++) {
                Images::factory()->create([
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
