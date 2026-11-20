<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeteksiController;

Route::get('/', [DeteksiController::class, 'index']);
Route::get('/parkir-in', [DeteksiController::class, 'parkirin'])
    ->name('parkir.in');