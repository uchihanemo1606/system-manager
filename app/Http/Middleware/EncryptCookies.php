<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Các cookie không cần mã hóa.
     *
     * @var array
     */
    protected $except = [
        'auth_token',
    ];
}
