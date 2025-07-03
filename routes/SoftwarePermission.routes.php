<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\SoftwarePermissionController;

Route::post('createsoftwarepermission', [SoftwarePermissionController::class, 'createSoftwarePermission'])
    ->middleware('check.permission')
    ->name('softwarepermission.create');

Route::get('/getalluserpermission' , [SoftwarePermissionController::class, 'getAllUserPermission'])
    ->middleware('check.permission')
    ->name('softwarepermission.list');

Route::get('/getdetailuserpermissioninsoftware', [SoftwarePermissionController::class, 'getDetailUserPermissionInSoftware'])
    ->middleware('check.permission')
    ->name('softwarepermission.all');

Route::delete('/deletesoftwarepermission', [SoftwarePermissionController::class, 'removeUserPermissionInSoftware'])
    ->middleware('check.permission')
    ->name('softwarepermission.delete');

Route::get('/getalluserinsoftware/{softwareID}', [softwarePermissionController::class ,'getAllUserPermissionInSoftware'])
    ->middleware('check.permission')
    ->name('softwarepermission.list');

Route::patch('/updatepermissionuserinsoftware', [softwarePermissionController::class, 'updatePermissionUserInSoftware'])
    ->middleware('check.permission')
    ->name('softwarepermission.update');

Route::post('/addpermissionforuser', [softwarePermissionController::class, 'addPermissionForUser'])
    ->middleware('check.permission')
    ->name('softwarepermission.create');