<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\systemproject;




Route::post('/updateavatarsystem', [systemproject::class, 'updateAvatarSystem']);
Route::post('/updatefootersystem', [systemproject::class, 'updateFooterSystem']);
Route::get('/getavatarsystem', [systemproject::class, 'getAvatarSystem']);
Route::get('/getfootersystem', [systemproject::class, 'getFooterSystem']);