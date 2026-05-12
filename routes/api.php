<?php

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

Route::post('/chatbot', [\App\Http\Controllers\Api\ChatbotController::class, 'reply']);

// مسارات API لنظام تحليل الزيارات
Route::prefix('analytics')->group(function () {
    Route::post('/record', [\App\Http\Controllers\Api\AnalyticsApiController::class, 'recordVisit']);
    Route::post('/duration', [\App\Http\Controllers\Api\AnalyticsApiController::class, 'updateDuration']);
});
