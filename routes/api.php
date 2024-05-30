<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;

Route::post('/get-quote-as-pdf', [QuoteController::class, 'index'])->middleware('auth:sanctum');