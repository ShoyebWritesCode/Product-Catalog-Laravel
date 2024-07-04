<?php

namespace Database\Factories;

use App\Models\Catagory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CatagoryFactory extends Factory
{
    protected $model = Catagory::class;
    public function definition(): array
    {
        return [
            //
        ];
    }
    public function Toy(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 1,
                'name' => "Toy",
            ];
        });
    }
    public function Food(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 2,
                'name' => "Food",
            ];
        });
    }
    public function Electrical(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 3,
                'name' => "Electrical",
            ];
        });
    }
    public function Housing(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 4,
                'name' => "Housing",
            ];
        });
    }
    public function Car(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 5,
                'name' => "Car",
                "parent_id" => 1
            ];
        });
    }
    public function Puzzle(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 6,
                'name' => "Puzzle",
                "parent_id" => 1
            ];
        });
    }
    public function Snack(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 7,
                'name' => "Snack",
                "parent_id" => 2
            ];
        });
    }
    public function Drink(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 8,
                'name' => "Drink",
                "parent_id" => 2
            ];
        });
    }
    public function Phone(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 9,
                'name' => "Phone",
                "parent_id" => 3
            ];
        });
    }
    public function Computer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 10,
                'name' => "Computer",
                "parent_id" => 3
            ];
        });
    }
    public function Bed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 11,
                'name' => "Bed",
                "parent_id" => 4
            ];
        });
    }
    public function Table(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'id' => 12,
                'name' => "Table",
                "parent_id" => 4
            ];
        });
    }
}
