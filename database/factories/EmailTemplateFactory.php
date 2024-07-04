<?php

namespace Database\Factories;

use App\Models\EmailTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmailTemplate>
 */
class EmailTemplateFactory extends Factory
{
    protected $model = EmailTemplate::class;

    public function definition(): array
    {
        return [
            'name' => "Customer Order",
            'subject' => "Order Confirmation",
            'code' => "120",
            'content' => "<p><span>hi, [name] your order is confirmed</span></p>
                          <p><span>[total]</span></p>
                          <p><span>[link]</span></p>
                          <p><span>[id]</span></p>"
        ];
    }

    public function adminNotice(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => "Admin Notice",
                'subject' => "Order Confirmation",
                'code' => "110",
                'content' => "<h1>hi</h1>"
            ];
        });
    }
}
