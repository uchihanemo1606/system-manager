<?php 

use App\Http\Controllers\departmentController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use app\Http\Middleware\CheckPermission;

Route::post('/createdepartment', [departmentController::class, 'createDepartment'])
    ->middleware('check.permission')
    ->name('department.create');

Route::get('/getalldepartment', [departmentController::class, 'getAllDepartments'])
    ->middleware('check.permission')
    ->name('department.list');

Route::patch('/updatedepartment/{department}', [departmentController::class, 'updateDepartment'])
    ->middleware('check.permission')
    ->name('department.edit');

Route::delete('/deletedepartment/{department}', [departmentController::class, 'deleteDepartment'])
    ->middleware('check.permission')
    ->name('department.delete');

Route::get('/getuserindepartment/{departmentName}', [departmentController::class, 'getUserInDepartment'])
    ->middleware('check.permission')
    ->name('department.list');

Route::patch('/adduserindepartment/{department}', [departmentController::class, 'addUserToDepartment'])
    ->middleware('check.permission')
    ->name('department.create');

Route::get('/getalldepartmentisactive', [departmentController::class, 'getAllDepartmentIsActive'])
    ->middleware('check.permission')
    ->name('department.list');

Route::get('/getalldepartmentisdelete', [departmentController::class, 'getAllDepartmentIsDelete'])
    ->middleware('check.permission')
    ->name('department.list');

Route::patch('/removeuserindepartment/{department}', [departmentController::class, 'removeUserFromDepartment'])
    ->middleware('check.permission')
    ->name('department.delete');
    
Route::get('/getdepartmentbyname/{departmentName}', [departmentController::class, 'getDepartmentByName'])
    ->middleware('check.permission')
    ->name('department.list');