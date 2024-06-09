<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BaseOrderSkuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'long_title' => $this->faker->words(2, true),
            'price_incl_vat' => $this->faker->numberBetween(100, 1000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'slug' => Str::slug($this->faker->word),
            'title' => $this->faker->word,
            'vat_percentage' => 7.7,
        ];
    }
}
