<?php

use App\Http\Controllers\Api\AttachableController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisatserController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\SafePointController;
use App\Http\Controllers\SosController;
use Illuminate\Support\Facades\Route;

Route::apiResource('sos', SosController::class);
Route::apiResource('disaster', DisatserController::class);
Route::apiResource('points', PointsController::class);
Route::apiResource('safe-points', SafePointController::class);
Route::apiResource('attachable', AttachableController::class);
Route::get('/get-ngo', [AuthController::class, 'getNgos']);

Route::post('/ngo/register', [AuthController::class, 'register']);
Route::post('/ngo/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/overview', [PointsController::class, 'overView']);
    Route::post('/ngo/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/get-all-ngo', [AuthController::class, 'ngos']);
    Route::patch('/users/{user}/approve', [AuthController::class, 'approve']);
});
