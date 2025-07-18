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
            'check.permission' => CheckPermission::class, // <<<<<< THÊM ALIAS MỚI Ở ĐÂY
            'check.login' => CheckLogin::class,
            // 'jwt.cookie' => JwtFromCookieMiddleware::class,
            // Hoặc bạn có thể dùng Full Qualified Class Name (FQCN) nếu không muốn import:
            // 'check.permission' => \App\Http\Middleware\CheckPermission::class,
        ]);
        // Nếu bạn muốn CheckPermission cũng được áp dụng cho tất cả các route trong group 'api'
        // giống như 'json.exception', bạn có thể thêm nó vào đây:
        // $middleware->appendToGroup('api', [
        //     'json.exception',
        //     'check.permission' // <<<<<< THÊM VÀO GROUP 'api' NẾU CẦN
        // ]);
        // Tuy nhiên, từ file route bạn gửi trước, bạn đang áp dụng 'check.permission'
        // cho từng route cụ thể, nên việc thêm vào group 'api' ở đây có thể không cần thiết
        // trừ khi bạn muốn nó chạy cho MỌI route API.
        // Giữ lại cấu hình hiện tại của bạn cho 'json.exception' 
        $middleware->appendToGroup('api', ['json.exception']);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
