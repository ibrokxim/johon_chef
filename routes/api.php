<?php

use App\Http\Controllers\Api\V1\TelegramController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\PaymeMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('telegram', [TelegramController::class, 'webhook'])
    ->middleware('authCheck');

Route::middleware(['payme'])->group(function() {
    Route::post('payme', [\App\Http\Controllers\PaymeController::class, 'index']);
});

//Route::post('/payme-profile', [ProfileController::class, 'index']);