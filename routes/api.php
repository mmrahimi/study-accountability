<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
});
