<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeminiController;

Route::post('/ask', [GeminiController::class, 'askGemini']);
