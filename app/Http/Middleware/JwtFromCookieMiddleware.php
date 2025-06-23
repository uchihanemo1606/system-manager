<?php

namespace App\Http\Middleware;

use Closure;

class JwtFromCookieMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->cookie('token');
        if ($token) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }
}
