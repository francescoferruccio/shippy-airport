<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\FlightController;

Route::get('/', [AirportController::class, 'index'])->name('home');
Route::post('/search', [FlightController::class, 'trovaVolo'])->name('trovaVolo');