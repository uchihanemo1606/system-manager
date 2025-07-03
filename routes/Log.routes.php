<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\LogController;


// get logs by type have(hardware, software, user, permission, role, etc.)
Route::get('/getLogByType', [LogController::class,'getLogByType']);
Route::post('/createlog', [LogController::class,'createLogManual']);
Route::get('/getAllLog', [LogController::class, 'getAllLogs']);
Route::get('/getlogintime', [LogController::class,'getLogsInTime']);
Route::get('/getlogcreatebyuser/{username}', [LogController::class,'getLogCreateByUser']);