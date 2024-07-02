<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notification;
use Illuminate\Support\Str;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {


        return [
            'id' => Str::uuid(),
            'type' => 'App\Notifications\OrderPlaced',
            'notifiable_type' => 'App\Models\Admin',
            'notifiable_id' => 1,
            'data' => json_encode([
                'order_id' => $this->faker->unique()->numberBetween(1, 100),
                'order_total' => $this->faker->numberBetween(100, 5000),
                'order_date' => $this->faker->dateTimeThisMonth()->format('Y-m-d\TH:i:s.u\Z'),
            ]),
            'read_at' => $this->faker->optional()->dateTime(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
