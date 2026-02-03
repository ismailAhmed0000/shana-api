<?php

use App\Http\Controllers\Api\AttachableController;
use App\Http\Controllers\DisatserController;
use App\Http\Controllers\SafePointController;
use App\Http\Controllers\SosController;
use Illuminate\Support\Facades\Route;

Route::apiResource('sos', SosController::class);
Route::apiResource('disaster', DisatserController::class);
Route::apiResource('safe-points', SafePointController::class);
Route::apiResource('attachable', AttachableController::class);
