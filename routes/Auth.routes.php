<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;


Route::post('/createUser', [AuthController::class, 'CreateUser'])
    ->middleware('check.permission')
    ->name('user.create');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/getuser', [AuthController::class, 'getAuthenticatedUser']);
Route::patch('/updateuser', [AuthController::class, 'updateUser']);
Route::patch('/changepassword', [AuthController::class, 'changePassword']);
// Route::get('/getuserbyid/{id}', [UserController::class, 'getUserById']);
route::get('/getallusers', [UserController::class, 'getAllUsers'])->middleware('check.permission')->name('user.list');
route::get('/getuserbyname', [UserController::class, 'getUserByName']); 
route::get('/getuserbyusername', [UserController::class,'getUserByUsername']);

route::get('/sendmail', [MailController::class, 'sendEmail'])->name('mail.send');

Route::get('/getmypermissions', [PermissionController::class, 'getMyPermissions']); 
// route::get('/getuserbyusername', [UserController::class, 'getUserByUsername']); 
