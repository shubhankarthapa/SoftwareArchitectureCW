<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Hotel API Routes (Open routes - no authentication required)
Route::prefix('hotels')->group(function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::get('/{id}', [HotelController::class, 'show']);
    Route::get('/{hotelId}/rooms', [HotelController::class, 'getRooms']);
    Route::get('/{hotelId}/available-rooms', [HotelController::class, 'getAvailableRooms']);
    Route::get('/search', [HotelController::class, 'search']);
});
    