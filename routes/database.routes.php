<?php 

use App\Http\Controllers\databaseController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use app\Http\Middleware\CheckPermission;

Route::post('/createdatabase', [databaseController::class, 'createDatabase'])
    ->middleware('check.permission')
    ->name('hardware.create');

Route::patch('/updatedatabase/{id}', [databaseController::class, 'updateDatabase'])
    ->middleware('check.permission')
    ->name('hardware.edit');

Route::delete('/deletedatabase/{id}', [databaseController::class, 'deleteDatabase'])
    ->middleware('check.permission')
    ->name('hardware.delete');

Route::get('/getalldatabases', [databaseController::class, 'getAllDatabases'])
    ->middleware('check.permission')
    ->name('hardware.list');

Route::get('/getdatabaseactive', [databaseController::class, 'getDatabaseActive'])
    ->middleware('check.permission')
    ->name('hardware.active');

Route::get('/getalldatabasedeleted', [databaseController::class, 'getAllDatabaseDetele'])
    ->middleware('check.permission')
    ->name('database.list');

Route::get('/getdatabasebyid/{id}', [databaseController::class, 'getDatabaseById'])
    ->middleware('check.permission')
    ->name('hardware.detail');

// ====================hardware===================================================================================================================================================
// DATABASE VERSION CONTROLLER

Route::post('/createdatabaseversion', [databaseController::class, 'createDatabaseVersion'])
    ->middleware('check.permission')
    ->name('hardware.create');

Route::put('/updatedatabaseversion/{id}', [databaseController::class, 'updateDatabaseVersion'])
    ->middleware('check.permission')
    ->name('hardware.edit');

Route::delete('/deletedatabaseversion/{id}', [databaseController::class, 'deleteDatabaseVersion'])
    ->middleware('check.permission')
    ->name('hardware.delete');

Route::get('/getalldatabaseversions', [databaseController::class, 'getAllDatabaseVersions'])
    ->middleware('check.permission')
    ->name('hardware.list');

Route::get('/getdatabaseversionbyid/{id}', [databaseController::class, 'getDatabaseVersionById'])
    ->middleware('check.permission')
    ->name('hardware.detail');

Route::get('/getdatabaseversionbyname/{name}', [databaseController::class, 'getDatabaseVersionByName'])
    ->middleware('check.permission')
    ->name('hardware.list');