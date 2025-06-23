<?php

use App\Http\Controllers\HardwareController;
use App\Http\Controllers\HardwarePermissionController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use app\Http\Middleware\CheckPermission;

Route::post('/createhardware',[HardwareController::class, 'createHardware'])
    ->middleware('check.permission')
    ->name('hardware.create');
Route::get('/getallhardware', [HardwareController::class, 'getAllHardware'])
    ->middleware('check.permission')
    ->name('hardware.getAll');
Route::patch('/updatehardware', [HardwareController::class, 'updateHardware']);
Route::delete('/deletehardware', [HardwareController::class, 'deleteHardware']);
Route::get('/gethardwarebyip', [HardwareController::class, 'getHardwareIp'])
    ->middleware('check.permission')
    ->name('hardware.get');

// harware perrmision controller

Route::post('/createharwarepermission', [HardwarePermissionController::class, 'createHardwarePermission'])
    ->middleware('check.permission')
    ->name('hardwarepermission.create');

