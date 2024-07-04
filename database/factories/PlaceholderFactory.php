<?php

namespace Database\Factories;

use App\Models\Placeholder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PlaceholderFactory extends Factory
{
    protected $model = Placeholder::class;
    public function definition(): array
    {
        return [];
    }

    public function name(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => "[name]",
            ];
        });
    }
    public function id(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => "[id]",
            ];
        });
    }
    public function total(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => "[total]",
            ];
        });
    }
    public function link(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => "[link]",
            ];
        });
    }
}
