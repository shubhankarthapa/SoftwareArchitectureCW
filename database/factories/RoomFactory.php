<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Standard', 'Deluxe', 'Suite', 'Executive'];
        
        return [
            'hotel_id' => Hotel::factory(),
            'name' => fake()->randomElement($types) . ' Room',
            'description' => fake()->sentence(),
            'type' => fake()->randomElement($types),
            'capacity' => fake()->numberBetween(1, 6),
            'price_per_night' => fake()->randomFloat(2, 100, 500),
            'amenities' => fake()->randomElements(['WiFi', 'TV', 'Air Conditioning', 'Private Bathroom', 'Mini Bar', 'Balcony'], fake()->numberBetween(3, 5)),
            'images' => [fake()->imageUrl(), fake()->imageUrl()],
            'is_available' => true,
            'room_number' => fake()->unique()->numberBetween(100, 999),
        ];
    }
}
