<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LogController;

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

// Log API Routes
Route::post('/logs', [LogController::class, 'store']);
Route::get('/logs', [LogController::class, 'index']);
Route::get('/logs/{id}', [LogController::class, 'show']);
Route::get('/logs/application/{applicationName}', [LogController::class, 'getByApplication']);
Route::get('/logs/level/{level}', [LogController::class, 'getByLevel']);
Route::get('/logs/user/{userId}', [LogController::class, 'getByUser']);