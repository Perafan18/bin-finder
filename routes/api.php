<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BinController;
use App\Http\Controllers\ProviderController;

Route::get('/bin/{bin}', [BinController::class, 'show']);
Route::get('/providers', [ProviderController::class, 'index']);
Route::post('/providers/{id}/toggle', [ProviderController::class, 'toggle']);
