<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeminiController;

Route::get('/test', [GeminiController::class, 'index']);
