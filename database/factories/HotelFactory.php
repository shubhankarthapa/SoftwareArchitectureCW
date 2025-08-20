<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Hotel',
            'description' => fake()->paragraph(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'website' => fake()->url(),
            'stars' => fake()->numberBetween(1, 5),
            'amenities' => fake()->randomElements(['WiFi', 'Pool', 'Spa', 'Restaurant', 'Gym', 'Bar', 'Beach Access'], fake()->numberBetween(3, 6)),
            'images' => [fake()->imageUrl(), fake()->imageUrl()],
            'is_active' => true,
        ];
    }
}
