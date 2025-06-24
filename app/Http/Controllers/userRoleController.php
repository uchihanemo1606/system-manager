<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class userRoleController extends Controller
{
    public function createUserRole(Request $request)
    {
        try 
        {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:255',
                'role_name' => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed', 'errors' => $validator->errors()
                ], 422);
            }

            $user_role = DB::table('user_role')->insert([
                'username' => $request->input('username'),
                'role_name' => $request->input('role_name'),
                'assigned_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            LogController::createLogAuto([
                'username' => $user->username,
                'message' => "User {$user->username} created a new user role: {$request->input('role_name')}.",
                'is_delete' => false
            ]);

            if ($user_role) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User role created successfully',
                    'user role' => [
                        'username' => $request->input('username'),
                        'role_name' => $request->input('role_name'),
                        'assigned_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create user role'
                ], 500);
            }

        }
        catch (TokenExpiredException $e) {
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not delete role. ' . $e->getMessage()
            ], 500);
        }    
    }

    public function updateUserRoles(Request $request)
    {
        try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

        // Nếu có id thì update theo id
        if ($request->has('id')) {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:user_role,id',
                'role_name' => 'required|string|exists:roles,role_name',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $affected = DB::table('user_role')
                ->where('id', $request->input('id'))
                ->update([
                    'role_name' => $request->input('role_name'),
                    'updated_at' => now()
                ]);
        } else {
            // Update theo username + old_role
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:255',
                'old_role' => 'required|string|max:50',
                'new_role' => 'required|string|max:50',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $affected = DB::table('user_role')
                ->where('username', $request->input('username'))
                ->where('role_name', $request->input('old_role'))
                ->update([
                    'role_name' => $request->input('new_role'),
                    'updated_at' => now()
                ]);
        }

        LogController::createLogAuto([
            'username' => $user->username,
            'message' => "User {$user->username} updated user role.",
            'is_delete' => false
        ]);

        if ($affected) {
            return response()->json([
                'status' => 'success',
                'message' => 'User role updated successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update user role'
            ], 500);
        }
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not update role. ' . $e->getMessage()
            ], 500);    
        }
    }

    public function removeUserRole(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:255',
                'role_name' => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $deleted = DB::table('user_role')
                ->where('username', $request->input('username'))
                ->where('role_name', $request->input('role_name'))
                ->delete();

            LogController::createLogAuto([
                'username' => $user->username,
                'message' => "User {$user->username} removed user role: {$request->input('role_name')}.",
                'is_delete' => true
            ]);

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User role removed successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to remove user role'
                ], 500);
            }
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not remove role. '.$e->getMessage()
            ], 500);
        }
    }

    public function getAllUserRole()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
        }
            $user_roles = DB::table('user_role')->get();

            if ($user_roles->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No user roles found',
                    'data' => []
                ], 200);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User roles retrieved successfully',
                    'data' => $user_roles
                ], 200);
            }
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
                'message' => 'Could not retrieve user roles. '.$e->getMessage()
            ], 500);
        }
    }

}