<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shop_name'=>fake()->title(),
            'latitude'=>fake()->latitude(),
            'longitude'=>fake()->longitude(),
            'phone_number'=>fake()->phoneNumber(),
            'logo_photo'=>fake()->imageUrl(),
            'cover_photo'=>fake()->imageUrl(),

        ];
    }
}
