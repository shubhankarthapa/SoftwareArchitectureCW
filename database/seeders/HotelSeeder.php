<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Room;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample hotels
        $hotels = [
            [
                'name' => 'Grand Plaza Hotel',
                'description' => 'Luxury 5-star hotel in the heart of the city',
                'address' => '123 Main Street',
                'city' => 'New York',
                'country' => 'USA',
                'phone' => '+1-555-0123',
                'email' => 'info@grandplaza.com',
                'website' => 'https://grandplaza.com',
                'stars' => 5,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Gym'],
                'images' => ['hotel1.jpg', 'hotel2.jpg'],
                'is_active' => true
            ],
            [
                'name' => 'Seaside Resort',
                'description' => 'Beautiful beachfront resort with ocean views',
                'address' => '456 Beach Road',
                'city' => 'Miami',
                'country' => 'USA',
                'phone' => '+1-555-0456',
                'email' => 'info@seaside.com',
                'website' => 'https://seaside.com',
                'stars' => 4,
                'amenities' => ['WiFi', 'Pool', 'Beach Access', 'Restaurant', 'Bar'],
                'images' => ['resort1.jpg', 'resort2.jpg'],
                'is_active' => true
            ],
            [
                'name' => 'Mountain View Lodge',
                'description' => 'Cozy lodge with stunning mountain views',
                'address' => '789 Mountain Drive',
                'city' => 'Denver',
                'country' => 'USA',
                'phone' => '+1-555-0789',
                'email' => 'info@mountainview.com',
                'website' => 'https://mountainview.com',
                'stars' => 3,
                'amenities' => ['WiFi', 'Fireplace', 'Restaurant', 'Hiking Trails'],
                'images' => ['lodge1.jpg', 'lodge2.jpg'],
                'is_active' => true
            ]
        ];

        foreach ($hotels as $hotelData) {
            $hotel = Hotel::create($hotelData);
            
            // Create sample rooms for each hotel
            $this->createRoomsForHotel($hotel);
        }
    }

    private function createRoomsForHotel(Hotel $hotel): void
    {
        $roomTypes = [
            'Standard' => ['capacity' => 2, 'price' => 150.00],
            'Deluxe' => ['capacity' => 3, 'price' => 250.00],
            'Suite' => ['capacity' => 4, 'price' => 400.00],
            'Executive' => ['capacity' => 2, 'price' => 300.00]
        ];

        $roomNumber = 100;
        foreach ($roomTypes as $type => $details) {
            for ($i = 0; $i < 3; $i++) {
                Room::create([
                    'hotel_id' => $hotel->id,
                    'name' => $type . ' Room ' . ($i + 1),
                    'description' => 'Comfortable ' . $type . ' room with modern amenities',
                    'type' => $type,
                    'capacity' => $details['capacity'],
                    'price_per_night' => $details['price'],
                    'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Private Bathroom'],
                    'images' => ['room1.jpg', 'room2.jpg'],
                    'is_available' => true,
                    'room_number' => $hotel->id . $roomNumber++
                ]);
            }
        }
    }
}
