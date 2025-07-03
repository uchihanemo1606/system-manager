<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/login', fn() => view('pages/login'));
Route::get('/apis', fn() => view('scribe/index'));
// Route::get('/modal/{modal}', function ($modal, Request $request) {
//     $view = 'modals.' . str_replace('/', '.', $modal);
//     return View::exists($view) ? view($view) : view('modal_not_found');
// })->where('modal', '.*');

Route::middleware(['check.login'])->group(function () {
    $getCommonData = fn(Request $request) => [
        'token' => $request->attributes->get('token'),
        'user' => $request->attributes->get('user'),
        'permissions' => $request->attributes->get('permissions'),
        'permissionsRoute' => $request->attributes->get('permissionsRoute'),
    ];
    Route::get('/modal/{modal}', function ($modal, Request $request) use ($getCommonData) {
        $view = 'modals.' . str_replace('/', '.', $modal);
        if (View::exists($view)) {
            return view($view, $getCommonData($request));
        }
        return view('modal_not_found', $getCommonData($request));
    })->where('modal', '.*');
    Route::get('/', function (Request $request) use ($getCommonData) {
        return view('pages/dashboard', $getCommonData($request));
    });
    Route::get('/{page}', function ($page, Request $request) use ($getCommonData) {
        $view = 'pages.' . str_replace('/', '.', $page);
        if (View::exists($view)) {
            return view($view, array_merge(['page' => $page], $getCommonData($request)));
        }
        return view('pages_not_found');
    })->where('page', '.*');
});
