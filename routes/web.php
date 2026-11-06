<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [FormController::class, 'show'])->name('register');
Route::post('/register', [FormController::class, 'handle'])->name('register.handle');
Route::get('/register/success', [FormController::class, 'success'])->name('register.success');

Route::get('/participants', [FormController::class, 'participants'])->name('participants');
