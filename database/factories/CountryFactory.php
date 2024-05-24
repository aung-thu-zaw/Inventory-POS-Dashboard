<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->unique()->country(),
            "iso_code" => fake()->unique()->countryCode(),
            "currency" => fake()->unique()->currencyCode(),
            'created_at' => fake()->dateTimeBetween('-4 months', now()),
        ];
    }
}
