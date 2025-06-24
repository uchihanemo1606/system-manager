<?php // bootstrap/app.php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\JsonExceptionHandler;
use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\JwtFromCookieMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'json.exception' => JsonExceptionHandler::class,
            'check.permission' => CheckPermission::class, 
        ]);

        $middleware->appendToGroup('api', ['json.exception']);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
