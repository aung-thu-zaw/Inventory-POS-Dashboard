<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'logo' => fake()->imageUrl(),
            'description' => fake()->paragraph(),
            'status' => fake()->boolean(),
            'created_at' => fake()->dateTimeBetween('-4 months', now()),
        ];
    }
}
