<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EcwidController;
use App\Http\Controllers\QuoteController;

Route::get('/get-orders-ecwid', [EcwidController::class, 'index']);
Route::post('/get-quote-as-pdf', [QuoteController::class, 'index'])->middleware('auth:sanctum');
Route::post('/generate', [QuoteController::class, 'store'])->middleware('auth:sanctum');
Route::post('/update-invoice', [QuoteController::class, 'updateInvoice'])->middleware('auth:sanctum');
Route::get('/get-invoice', [QuoteController::class, 'getInvoice'])->middleware('auth:sanctum');