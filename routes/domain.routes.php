<?php

use App\Http\Controllers\domainController;;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use app\Http\Middleware\CheckPermission;


//function basic
Route::post('/createdomain', [domainController::class, 'createDomain'])
    ->middleware('check.permission')
    ->name('domain.create');

Route::get('/getalldomain', [domainController::class, 'getAllDomains'])
    ->middleware('check.permission')
    ->name('domain.list');

Route::patch('/updatedomain', [domainController::class,'updateDomain'])
    ->middleware('check.permission')
    ->name('domain.edit');


// hardware domain
Route::post('/createhardwaredomain', [domainController::class, 'createHardwareDomain'])
    ->middleware('check.permission')
    ->name('hardwaredomain.create');

Route::get('/gethardwaresoftwareindomain', [domainController::class, 'getHardwareAndSoftwareInDomain'])
    ->middleware('check.permission')
    ->name('hardwaredomain.list');

Route::get('/getdomainbyhardware', [domainController::class, 'getdomainbyhardware'])
    ->middleware('check.permission')
    ->name('hardwaredomain.list');