<?php

use App\Http\Controllers\BinController;
use App\Http\Controllers\ProviderController;
use Illuminate\Support\Facades\Route;

Route::get('/bin/{bin}', [BinController::class, 'show']);
Route::get('/providers', [ProviderController::class, 'index']);
Route::post('/providers/{id}/toggle', [ProviderController::class, 'toggle']);
