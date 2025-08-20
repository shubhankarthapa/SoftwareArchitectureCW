<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HotelController extends Controller
{
    /**
     * Get all hotels
     */
    public function index(): JsonResponse
    {
        $hotels = Hotel::active()->with('rooms')->get();
        
        return response()->json([
            'success' => true,
            'data' => $hotels
        ]);
    }

    /**
     * Get a specific hotel
     */
    public function show($id): JsonResponse
    {
        $hotel = Hotel::with('rooms')->find($id);
        
        if (!$hotel) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $hotel
        ]);
    }

    /**
     * Get hotel rooms
     */
    public function getRooms($hotelId): JsonResponse
    {
        $hotel = Hotel::find($hotelId);
        
        if (!$hotel) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel not found'
            ], 404);
        }
        
        $rooms = $hotel->rooms()->available()->get();
        
        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    /**
     * Get available rooms for specific dates
     */
    public function getAvailableRooms(Request $request, $hotelId): JsonResponse
    {
        $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in'
        ]);
        
        $hotel = Hotel::find($hotelId);
        
        if (!$hotel) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel not found'
            ], 404);
        }
        
        $rooms = $hotel->rooms()
            ->available()
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    /**
     * Search hotels
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:2'
        ]);
        
        $query = $request->get('q');
        $hotels = Hotel::active()
            ->search($query)
            ->with('rooms')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $hotels
        ]);
    }
}
