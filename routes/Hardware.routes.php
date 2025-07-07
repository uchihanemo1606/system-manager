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
    ->name('hardware.list');

Route::patch('/updatehardware/{ip}', [HardwareController::class, 'updateHardware'])
    ->middleware('check.permission')
    ->name('hardware.edit');

Route::delete('/deletehardware', [HardwareController::class, 'deleteHardware']);
Route::get('/gethardwarebyip', [HardwareController::class, 'getHardwareByIP'])
    ->middleware('check.permission')
    ->name('hardware.list');


// ======================================================================================================================================================================================================================================================
// HARDWARE PERMISSION CONTROLLER

Route::post('/createharwarepermission', [HardwarePermissionController::class, 'createHardwarePermission'])
    ->middleware('check.permission')
    ->name('hardwarepermission.create');

Route::delete('/removeuserpermissioninhardware', [HardwarePermissionController::class, 'removeUserPermisionInHardware'])
    ->middleware('check.permission')
    ->name('hardwarepermission.delete');

Route::get('/getdetailuserpermissioninhardware', [HardwarePermissionController::class, 'getDetailUserPermissionInHardware'])
    ->middleware('check.permission')
    ->name('hardwarepermission.list');

Route::get('/getalluserpermissioninhardware/{hardwareIP}', [HardwarePermissionController::class, 'getUserInHardwarePermission'])
    ->middleware('check.permission')
    ->name('hardwarepermission.list');