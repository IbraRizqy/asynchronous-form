<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::post('/woi', [App\Http\Controllers\HomeController::class, 'update']);
