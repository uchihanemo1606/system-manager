<?php 


use App\Http\Controllers\rolesController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

route::post('/createrole', [rolesController::class, 'createRole'])
    ->middleware(middleware: 'check.permission')
    ->name('role.create');

route::delete('/deleterole',[rolesController::class,'deleteRole'])
    ->middleware('check.permission')
    ->name('role.delete');

route::patch('/updaterole/{rolename}', [rolesController::class, 'updateRole'])
    ->middleware('check.permission')
    ->name('role.edit');

route::get('/getrolebyname', [rolesController::class, 'getRoleByName'])
    ->middleware('check.permission')
    ->name('role.list');

route::get('/getallroles', [rolesController::class, 'getAllRoles'])
    ->middleware('check.permission')
    ->name('role.list');

route::get('/getrolesbyuser', [rolesController::class, 'getRolesByUser'])
    ->middleware('check.permission')
    ->name('role.list');

route::get('/getrolebyuserandname', [rolesController::class, 'getRoleByUserAndName'])
    ->middleware('check.permission')
    ->name('role.list');

route::get('/getalluserformrole', [rolesController::class, 'getAllUsersFromRole'])
    ->middleware('check.permission')
    ->name('role.list');

