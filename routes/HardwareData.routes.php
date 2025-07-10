<?php

use App\Http\Controllers\HardwareOSVersionController;
use App\Http\Controllers\HardwareDatabaseController;
use Illuminate\Support\Facades\Route;

Route::prefix('/hardwareOsData')->group(function () {
    Route::get('/', [HardwareOSVersionController::class, 'getAll']);
    Route::get('/versions', [HardwareOSVersionController::class, 'getVersionsByOS']); 
    Route::post('/', [HardwareOSVersionController::class, 'create']);
    Route::put('/{id}', [HardwareOSVersionController::class, 'update']);
    Route::delete('/{id}', [HardwareOSVersionController::class, 'destroy']);
});

Route::prefix('/hardwareDatabase')->group(function () {
    Route::get('/', [HardwareDatabaseController::class, 'getAll']);
    Route::get('/versions', [HardwareDatabaseController::class, 'getVersionsByDBName']); 
    Route::post('/', [HardwareDatabaseController::class, 'create']);
    Route::put('/{id}', [HardwareDatabaseController::class, 'update']);
    Route::delete('/{id}', [HardwareDatabaseController::class, 'destroy']);
});
