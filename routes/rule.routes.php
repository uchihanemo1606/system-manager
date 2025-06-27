<?php

use App\Http\Controllers\RuleController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use app\Http\Middleware\CheckPermission;


// CATEGORY RULES ROUTES
//tạo 1 lọi rule 
Route::post('/createcateogryrule', [RuleController::class, 'createCategoryRule'])
    ->middleware('check.permission')
    ->name('legal.create');
//só 1 lội rule
Route::delete('/deletecategoryrule', [RuleController::class, 'deleteCategoryRule'])
    ->middleware('check.permission')
    ->name('legal.delete');
//cập nhật 1 lội rule
Route::patch('/updatecategoryrule', [RuleController::class, 'updateCategoryRule'])
    ->middleware('check.permission')
    ->name('legal.edit');

//get full category rule
Route::get('/getallcategoryrule', [RuleController::class, 'getAllCategoryRules'])
    ->middleware('check.permission')
    ->name('legal.list');

Route::get('/getcategoryrulebyid', [RuleController::class, 'getCategoryRuleById'])
    ->middleware('check.permission')
    ->name('legal.getbyid');

//get category rule by name
Route::get('/getcategoryrulebyname',[RuleController::class, 'getCategoryRuleByName'])
    ->middleware('check.permission')
    ->name('legal.list');


//==============================================================================================================================================================

// RULES ROUTES
//tạo 1 lội rule
Route::post('/createrule', [RuleController::class,'createRule'])
    ->middleware('check.permission')
    ->name('legal.create');

//só 1 lội rule
Route::delete('/deleterule', [RuleController::class, 'deleteRule'])
    ->middleware('check.permission')
    ->name('legal.delete');

//cập nhật 1 lội rule
Route::patch('/updaterule', [RuleController::class, 'updateRule'])
    ->middleware('check.permission')
    ->name('legal.edit');

//get all rules
Route::get('/getallrules', [RuleController::class, 'getAllRules'])
    ->middleware('check.permission')
    ->name('legal.list');

//get rule by id
Route::get('/getrulebyid', [RuleController::class, 'getRuleById'])
    ->middleware('check.permission')
    ->name('legal.list');

Route::get('/getrulebycategoryid', [RuleController::class, 'getRuleBycategoryId'])
    ->middleware('check.permission')
    ->name('legal.list');


//get rule by name
Route::get('/getrulebyname', [RuleController::class, 'getRuleByName'])
    ->middleware('check.permission')
    ->name('legal.list');

//===============================================================================================================================================================
// SOFTWARE RULES ROUTES

//thim 1 rule dào phằng mìm
Route::post('/createsoftware', [RuleController::class, 'createSoftwareRule'])
    ->middleware('check.permission')
    ->name('software.create');

//só 1 rule khổi phằng mìm
Route::delete(('/deletesoftwarerule'), [RuleController::class, 'deleteSoftwareRule'])
    ->middleware('check.permission')
    ->name('software.delete');

//cặp nhặc 1 rule trong phằng mìm
Route::patch('/updatesoftwarerule', [RuleController::class, 'updateSoftwareRule'])
    ->middleware('check.permission')
    ->name('software.edit');

