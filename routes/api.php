<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplianceController;

Route::get('/appliance', [ApplianceController::class, 'index']);
Route::post('/appliance', [ApplianceController::class, 'store']);
Route::get('/appliance/{id}', [ApplianceController::class, 'show']);
Route::put('/appliance/{id}', [ApplianceController::class, 'update']);
Route::delete('/appliance/{id}', [ApplianceController::class, 'destroy']);