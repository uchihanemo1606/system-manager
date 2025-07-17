<?php 

use App\Http\Controllers\OSController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use app\Http\Middleware\CheckPermission;


Route::post('/createos', [OSController::class, 'createOS'])
    ->middleware('check.permission')
    ->name('hardware.create');

Route::get('/getallos', [OSController::class, 'getAllOS'])
    ->middleware('check.permission')
    ->name('hardware.list');

Route::put('/updateos/{id}', [OSController::class, 'updateOS'])
    ->middleware('check.permission')
    ->name('hardware.edit');

Route::delete('/deleteos/{id}', [OSController::class, 'deleteOS'])
    ->middleware('check.permission')
    ->name('hardware.delete');

Route::get('/getosbyname/{name}', [OSController::class, 'getOSByName'])
    ->middleware('check.permission')
    ->name('hardware.list'); 

Route::get('/getosactive', [OSController::class, 'getOSActive'])
    ->middleware('check.permission')
    ->name('hardware.list');

Route::get('/getosdelete', [OSController::class, 'getOSDeleted'])
    ->middleware('check.permission')
    ->name('hardware.list');

Route::get('/getosbyid/{id}', [OSController::class, 'getOSById'])
    ->middleware('check.permission')
    ->name('hardware.list');


// =======================================================================================================================================================================
// OS VERSION CONTROLLER

Route::post('/createosversion', [OSController::class, 'createOSVersion'])
    ->middleware('check.permission')
    ->name('hardware.create');

Route::put('/updateosversion/{id}', [OSController::class, 'updateOSVersion'])
    ->middleware('check.permission')
    ->name('hardware.edit');

Route::delete('/deleteosversion/{id}', [OSController::class, 'deleteOSVersion'])
    ->middleware('check.permission')
    ->name('hardware.delete');

Route::get('/getallosversion', [OSController::class, 'getAllOSVersions'])
    ->middleware('check.permission')
    ->name('hardware.list');

Route::get('/getallversionofos/{osName}', [OSController::class, 'getAllVersionOfOS'])
    ->middleware('check.permission')
    ->name('hardware.list');

Route::get('/getallversionofosactive/{osName}', [OSController::class, 'getAllOSVersionByNameActive'])
    ->middleware('check.permission')
    ->name('hardware.list');
