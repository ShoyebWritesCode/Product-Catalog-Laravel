<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Catagory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $imageFiles = File::files(public_path('images'));
        $images = array_map(function ($file) {
            return $file->getFilename();
        }, $imageFiles);

        $randomImage = function () use ($images) {
            return $images[array_rand($images)];
        };

        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 10000), // Adjust range as needed
            // 'image' => $randomImage(),
            // 'image1' => $randomImage(),
            // 'image2' => $randomImage(),
        ];
    }
}
