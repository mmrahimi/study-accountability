<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommitmentController;
use App\Http\Controllers\StreakController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

Route::apiResource('subjects', SubjectController::class)->middleware('auth:sanctum');

Route::prefix('commitments')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('', CommitmentController::class)->except('destroy');
        Route::post('/{commitment}/cancel', [CommitmentController::class, 'cancel']);
        Route::post('/{commitment}/check', [CommitmentController::class, 'check']);
    });

Route::get('streak', [StreakController::class, 'show'])->middleware('auth:sanctum');
