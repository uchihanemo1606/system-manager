<?php 

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userRoleController;

route::post('createuserrole', [userRoleController::class, 'createUserRole'])
    ->middleware('check.permission')
    ->name('userrole.create');

route::patch('/updateuserrole', [userRoleController::class, 'updateUserRoles'])
    ->middleware('check.permission')
    ->name('userrole.edit');

route::delete('/deleteuserrole', [userRoleController::class, 'removeUserRole'])
    ->middleware('check.permission')
    ->name('userrole.delete');

route::get('/getalluserrole', [userRoleController::class, 'getAllUserRole'])
    ->middleware('check.permission')
    ->name('userrole.list');
