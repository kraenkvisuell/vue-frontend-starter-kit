<?php

namespace Database\Factories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CartFactory extends Factory
{
    public function definition(): array
    {
        return [
            'token' => Str::uuid()->toString(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Cart $cart) {
            $cart->invoice_address->update([
                'email' => $this->faker->email,
            ]);
        });
    }
}
