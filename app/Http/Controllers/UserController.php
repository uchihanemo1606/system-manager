<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    // public function getUserById($id)
    // {
    //     try { 
    //         if(!$user = JWTAuth::parseToken()->authenticate()) {
    //             return response()->json(['please login to use the function'], 404);
    //         }
    //         $user = ModelsUser::findOrFail($id);
    //         return response()->json([
    //             'status' => 'success',
    //             'user' => $user,
    //         ]);
    //     } catch (TokenExpiredException $e) {
    //         return response()->json([
    //             'status'=> 'error',
    //             'message' => 'Token has expired.'
    //         ], 401);
    //     } catch (TokenExpiredException $e) {
    //         return response()->json([
    //             'status'=> 'error',
    //             'message' => 'Token is invalid.'
    //         ], 401);
    //     } catch (JWTException $e) {
    //         return response()->json([
    //             'status'=> 'error',
    //             'message' => 'Token is absent or could not be parsed.'
    //         ], 401);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Could not retrieve user. ' . $e->getMessage()
    //         ], 500);
            
    //     }
    // }


    public function getAllUsers()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['please login to use the function'], 404);
            }
            $users = UserModel::all();
            return response()->json([
                'status' => 'success',
                'count' => $users->count(),
                'users' => $users,
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Token has expired.'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Token is invalid.'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Token is absent or could not be parsed.'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not retrieve users. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUserByName(Request $request)
    {
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['please login to use the function'], 404);
        }
        $name = $request->query('fullName'); // Lấy từ query parameter
        if (!$name) {
            return response()->json([
                'status' => 'error',
                'message' => 'Name is required.',
            ], 400);
        }
        $users = UserModel::where('fullName', 'like', '%' . $name . '%')->get();
        if ($users->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'users' => $users,
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'User not found.'
        ], 404);
    } catch (TokenExpiredException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token has expired.'
        ], 401);
    } catch (TokenInvalidException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token is invalid.'
        ], 401);
    } catch (JWTException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token is absent or could not be parsed.'
        ], 401);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Could not retrieve user. ' . $e->getMessage()
        ], 500);
    }
}

public function getUserByUSerName(Request $request)
{
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['please login to use the function'], 404);
        }
        $username = $request->query('username'); // Lấy từ query parameter
        if (!$username) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username is required.',
            ], 400);
        }
        $user = UserModel::where('username', 'like', '%' . $username . '%')->get();
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'User not found.'
        ], 404);
    } catch (TokenExpiredException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token has expired.'
        ], 401);
    } catch (TokenInvalidException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token is invalid.'
        ], 401);
    } catch (JWTException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Token is absent or could not be parsed.'
        ], 401);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Could not retrieve user. ' . $e->getMessage()
        ], 500);
    }
  }
}