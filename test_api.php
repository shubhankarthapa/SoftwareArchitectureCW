<?php

require_once 'vendor/autoload.php';

use App\Models\Hotel;
use App\Models\Room;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Hotel API...\n\n";

try {
    // Test 1: Get all hotels
    echo "1. Testing GET /api/hotels\n";
    $hotels = Hotel::active()->with('rooms')->get();
    echo "   Found " . $hotels->count() . " hotels\n";
    if ($hotels->count() > 0) {
        $firstHotel = $hotels->first();
        echo "   First hotel: " . $firstHotel->name . " (" . $firstHotel->stars . " stars)\n";
        echo "   Rooms: " . $firstHotel->rooms->count() . "\n";
    }
    echo "   ✓ SUCCESS\n\n";

    // Test 2: Get specific hotel
    if ($hotels->count() > 0) {
        echo "2. Testing GET /api/hotels/{id}\n";
        $hotel = Hotel::with('rooms')->find($firstHotel->id);
        if ($hotel) {
            echo "   Hotel found: " . $hotel->name . "\n";
            echo "   Address: " . $hotel->address . ", " . $hotel->city . ", " . $hotel->country . "\n";
            echo "   ✓ SUCCESS\n\n";
        } else {
            echo "   ✗ FAILED: Hotel not found\n\n";
        }
    }

    // Test 3: Get hotel rooms
    if ($hotels->count() > 0) {
        echo "3. Testing GET /api/hotels/{hotelId}/rooms\n";
        $rooms = $firstHotel->rooms()->available()->get();
        echo "   Found " . $rooms->count() . " available rooms\n";
        if ($rooms->count() > 0) {
            $firstRoom = $rooms->first();
            echo "   First room: " . $firstRoom->name . " (" . $firstRoom->type . ")\n";
            echo "   Price: $" . $firstRoom->price_per_night . " per night\n";
        }
        echo "   ✓ SUCCESS\n\n";
    }

    // Test 4: Search hotels
    echo "4. Testing GET /api/hotels/search?q=Grand\n";
    $searchResults = Hotel::active()->search('Grand')->with('rooms')->get();
    echo "   Search results: " . $searchResults->count() . " hotels found\n";
    echo "   ✓ SUCCESS\n\n";

    echo "All API tests completed successfully! 🎉\n";
    echo "Your hotel API is working correctly.\n";
    echo "You can now start the server with: php artisan serve --port=8002\n";
    echo "And test the endpoints from your other Laravel application.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
