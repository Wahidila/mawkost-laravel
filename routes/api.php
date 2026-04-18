<?php

use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// AI Chat API (public, rate-limited)
Route::middleware('chat.ratelimit')->group(function () {
    Route::post('/chat/send', [ChatController::class, 'send']);
    Route::get('/chat/stream/{messageId}', [ChatController::class, 'stream']);
});
Route::get('/chat/history/{sessionId}', [ChatController::class, 'history']);
