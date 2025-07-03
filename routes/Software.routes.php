
<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\softwarefileController;


Route::post('/createsoftware',[SoftwareController::class, 'createSoftware'])
    ->middleware('check.permission')
    ->name('software.create');
Route::get('/getallsoftware',[SoftwareController::class, 'getAllSoftware'])
    ->middleware('check.permission')
    ->name('software.list');
Route::patch('/updatesoftware/{id}', [SoftwareController::class, 'updateSoftware'])
    ->middleware('check.permission')
    ->name('software.edit');
Route::delete('/deleteSoftware', [SoftwareController::class,'deleteSoftware'])
    ->middleware('check.permission')
    ->name('software.delete');
Route::get('/getsoftwarebyname', [SoftwareController::class, 'getSoftwareByName'])
    ->middleware('check.permission')
    ->name('software.list');

// =======================================================================================SOFTWARE FILE ROUTE============================================================================================================================

Route::post('/createsoftwarefile', [softwarefileController::class, 'createSoftwarefile'])
    ->middleware('check.permission')
    ->name('softwarefile.create');