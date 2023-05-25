<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Block>
 */
class BlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'blocker_id' => random_int(1, 100),
            // 'blocked_id' => random_int(1, 100),
            'blocker_id' => fake()->numberBetween(1, 100),
            'blocked_id' => fake()->numberBetween(1, 100),

        ];
    }
}
