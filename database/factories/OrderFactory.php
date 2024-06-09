<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'placed_at' => now(),
            'payment_kind_slug' => 'stripe',
            'order_number' => rand(1000, 9999),
        ];
    }
}
