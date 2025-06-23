<?php

namespace App\Http\Controllers;

use App\Services\UserApiService;
use Illuminate\Http\Request;

class UserViewController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->attributes->get('token');
        $users = UserApiService::getAll($token);

        return view('pages.user_list', [
            'page' => 'user_list',
            'token' => $token,
            'users' => $users,
            'user' => $request->attributes->get('user'),
            'permissions' => $request->attributes->get('permissions'),
            'permissionsRoute' => $request->attributes->get('permissionsRoute'),
            'userPermissionCodes' => ['abc', 'xyz'], // nếu cần
        ]);
    }
}
