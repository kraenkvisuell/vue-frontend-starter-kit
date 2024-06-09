<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
        ];
    }
}
