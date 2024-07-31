<?php

namespace Database\Factories;

use App\Models\Images;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class ImagesFactory extends Factory
{
    protected $model = Images::class;

    public function definition()
    {
        // Get all image files from the specified directory
        $imageFiles = File::files(public_path('images'));
        $images = array_map(function ($file) {
            return $file->getFilename();
        }, $imageFiles);

        // Return a random image filename
        return [
            'path' => $images[array_rand($images)],
        ];
    }
}
