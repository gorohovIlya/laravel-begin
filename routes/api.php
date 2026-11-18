<?php

use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ParticipantController;
use Illuminate\Support\Facades\Route;

Route::apiResource('events', EventController::class);
Route::apiResource('participants', ParticipantController::class);
