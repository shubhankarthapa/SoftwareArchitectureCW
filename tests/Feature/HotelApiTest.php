<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HotelApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_hotels()
    {
        // Create a hotel
        $hotel = Hotel::factory()->create();

        $response = $this->getJson('/api/hotels');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'address',
                            'city',
                            'country',
                            'stars',
                            'amenities',
                            'images',
                            'is_active',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]);
    }

    public function test_can_get_specific_hotel()
    {
        $hotel = Hotel::factory()->create();

        $response = $this->getJson("/api/hotels/{$hotel->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $hotel->id,
                        'name' => $hotel->name
                    ]
                ]);
    }

    public function test_can_get_hotel_rooms()
    {
        $hotel = Hotel::factory()->create();
        $room = Room::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->getJson("/api/hotels/{$hotel->id}/rooms");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'hotel_id',
                            'name',
                            'type',
                            'capacity',
                            'price_per_night',
                            'is_available'
                        ]
                    ]
                ]);
    }

    public function test_can_search_hotels()
    {
        $hotel = Hotel::factory()->create(['name' => 'Test Hotel']);

        $response = $this->getJson('/api/hotels/search?q=Test');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ]);
    }

    public function test_can_get_available_rooms()
    {
        $hotel = Hotel::factory()->create();
        $room = Room::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->getJson("/api/hotels/{$hotel->id}/available-rooms?check_in=2025-02-01&check_out=2025-02-03");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ]);
    }
}
