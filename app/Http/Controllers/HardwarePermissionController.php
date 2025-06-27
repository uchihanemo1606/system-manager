<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hardwarePemisssionModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;




class HardwarePermissionController extends Controller
{
    public function createHardwarePermission(Request $request)
    {   
        try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

        $validated = $request->validate([
            'hardware_ip' => 'required|string|exists:hardware,ip|max:25',
            'user_name' => 'required|string|exists:users,username',
            'permissions_name' => 'required|string|max:255',
        ]);

        // Kiểm tra trùng lặp
        $exists = hardwarePemisssionModel::where([
            'hardware_ip' => $validated['hardware_ip'],
            'user_name' => $validated['user_name'],
            'permissions_name' => $validated['permissions_name'],
        ])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission already exists for this user and hardware.'
            ], 409);
        }

        // Lưu vào DB
        $permission = hardwarePemisssionModel::create([
            'hardware_ip' => $validated['hardware_ip'],
            'user_name' => $validated['user_name'],
            'permissions_name' => $validated['permissions_name'],
            'user_createby' => $user->username,
            'assigned_at' => now(),
        ]);

        return response()->json([
            'message' => 'Hardware permission created successfully.',
            'data' => $permission,
        ], 201);
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
                'message' => 'Could not create hardware permission. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllUserPermission()
    {
        try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }
        $permission = hardwarePemisssionModel::where('user_name', $user->username)
            ->with(['user', 'permissions', 'userCreatedby'])
            ->get();
        return response()->json([
            'message' => 'User permissions retrieved successfully.',
            'data' => $permission,
        ], 200);
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
                'message' => 'Could not create hardware permission. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDetailUserPermissionInHardware(Request $request)
    {
        try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

        // Lấy user_name và hardware_ip từ query hoặc body
        $username = $request->query('user_name') ?? $request->input('user_name');
        $hardwareIp = $request->query('hardware_ip') ?? $request->input('hardware_ip');

        if (!$username || !$hardwareIp) {
            return response()->json([
                'status' => 'error',
                'message' => 'user_name and hardware_ip are required.'
            ], 400);
        }

        // Kiểm tra user và hardware tồn tại
        $userExists = DB::table('users')->where('username', $username)->exists();
        $hardwareExists = DB::table('hardwares')->where('ip', $hardwareIp)->exists();
        if (!$userExists || !$hardwareExists) {
            return response()->json([
                'status' => 'error',
                'message' => 'User or hardware not found.'
            ], 404);
        }

        // Lấy toàn bộ permission của user trên hardware này
        $permissions = hardwarePemisssionModel::where([
                'hardware_ip' => $hardwareIp,
                'user_name' => $username,
            ])
            ->with(['user', 'permissions', 'userCreatedby'])
            ->get();

        if ($permissions->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No permissions found for this user on this hardware.'
            ], 404);
        }

        return response()->json([
            'message' => 'User permissions on hardware retrieved successfully.',
            'data' => $permissions,
        ], 200);
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
                'message' => 'Could not retrieve user permission details. ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeUserPermisionInHardware(Request $request)
    {
        try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

        // Lấy user_name và hardware_ip từ query hoặc body
        $username = $request->query('user_name') ?? $request->input('user_name');
        $hardwareIp = $request->query('hardware_ip') ?? $request->input('hardware_ip');

        if (!$username || !$hardwareIp) {
            return response()->json([
                'status' => 'error',
                'message' => 'user_name and hardware_ip are required.'
            ], 400);
        }

        // Kiểm tra user và hardware tồn tại
        $userExists = DB::table('users')->where('username', $username)->exists();
        $hardwareExists = DB::table('hardwares')->where('ip', $hardwareIp)->exists();
        if (!$userExists || !$hardwareExists) {
            return response()->json([
                'status' => 'error',
                'message' => 'User or hardware not found.'
            ], 404);
        }

        // Xóa permission của user trên hardware này
        $deletedRows = hardwarePemisssionModel::where([
                'hardware_ip' => $hardwareIp,
                'user_name' => $username,
            ])->delete();

        if ($deletedRows === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No permissions found to delete for this user on this hardware.'
            ], 404);
        }

        return response()->json([
            'message' => 'User permissions removed successfully.',
            'deleted_rows' => $deletedRows,
        ], 200);
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
                'message' => 'Could not retrieve user permission details. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllUserPermision(Request $request)
    {   try{
        if(!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }
        $username = $request->query('username') ?? $request->input('username');
        $hardwareIp = $request->query('hardware_ip') ?? $request->input('hardware_ip');
        if(!$username){
            return response()->json([
                'status'=> 'error',
                'message'=>'please input username'
            ],400);
        }
        $userExists = DB::table('users')->where('username', $username)->exists();
        $hardwareExists = DB::table('hardware')->where('ip', $hardwareIp)->exists();
        if (!$userExists || !$hardwareExists) {
            return response()->json([
                'status' => 'error',
                'message' => 'User or hardware not found.'
            ], 404);
        }
        $permissions = hardwarePemisssionModel::where([
                'hardware_ip' => $hardwareIp,
                'user_name' => $username,
            ])
            ->with(['user', 'permissions', 'userCreatedby'])
            ->get();

        if ($permissions->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No permissions found for this user on this hardware.'
            ], 404);
        }

        return response()->json([
            'message' => 'User permissions on hardware retrieved successfully.',
            'data' => $permissions,
        ], 200);
        }catch (TokenExpiredException $e) {
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
                'message' => 'Could not retrieve user permission details. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUserInHardwarePermission(Request $request)
    {
        try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

        // Lấy hardware_ip từ query hoặc body
        $hardwareIp = $request->query('hardware_ip') ?? $request->input('hardware_ip');

        if (!$hardwareIp) {
            return response()->json([
                'status' => 'error',
                'message' => 'hardware_ip is required.'
            ], 400);
        }

        // Kiểm tra hardware tồn tại
        $hardwareExists = DB::table('hardwares')->where('ip', $hardwareIp)->exists();
        if (!$hardwareExists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hardware not found.'
            ], 404);
        }

        // Lấy toàn bộ permission của user trên hardware này
        $permissions = hardwarePemisssionModel::where('hardware_ip', $hardwareIp)
            ->with(['user', 'permissions', 'userCreatedby'])
            ->get();

        if ($permissions->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No permissions found for this hardware.'
            ], 404);
        }

        return response()->json([
            'message' => 'User permissions on hardware retrieved successfully.',
            'data' => $permissions,
        ], 200);
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
                'message' => 'Could not retrieve user permission details. ' . $e->getMessage()
            ], 500);
        }
    }
}

