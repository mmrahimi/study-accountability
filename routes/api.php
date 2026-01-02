<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommitmentController;
use App\Http\Controllers\StreakController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->middleware('throttle:general')
    ->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('throttle:general', 'auth:sanctum');
    });

Route::apiResource('subjects', SubjectController::class)->middleware('throttle:general', 'auth:sanctum');

Route::prefix('commitments')
    ->middleware('throttle:general', 'auth:sanctum')
    ->group(function () {
        Route::get('/search', [CommitmentController::class, 'search']);
        Route::post('/{commitment}/cancel', [CommitmentController::class, 'cancel']);
        Route::post('/{commitment}/check', [CommitmentController::class, 'check']);
    });

Route::apiResource('commitments', CommitmentController::class)->except('destroy')->middleware('throttle:general', 'auth:sanctum');

Route::get('/streak', [StreakController::class, 'show'])->middleware('throttle:general', 'auth:sanctum');
