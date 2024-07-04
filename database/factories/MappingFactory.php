<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mapping;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mapping>
 */
class MappingFactory extends Factory
{
    protected $model = Mapping::class;
    public function definition(): array
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 100),
            'catagory_id' => $this->faker->numberBetween(1, 11),
        ];
    }
}
