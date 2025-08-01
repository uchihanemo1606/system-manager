<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class rolesController extends Controller
{
    public function createRole(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $validator = Validator::make($request->all(), [
                'role_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $roles = DB::table('roles')->insert([
                'role_name' => $request->role_name,
                'created_at' => now(),
                'updated_at' => now(),
                'assigned_at' => now(),
            ]);

            LogController::createLogAuto([
                'username' => $user->username,
                'role_name' => $request->role_name,
                'message' => " user {$user->fullName} đã tạo vai trò mới là {$request->role_name}.",
                'is_delete' => false
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Permission created successfully.',
                'role' => $request->role_name
            ]);
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
                'message' => 'Could not create permission. ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteRole(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $validator = Validator::make($request->all(), [
                'role_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $role = DB::table('roles')->where('role_name', $request->role_name)->first();
            if (!$role) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role not found.'
                ], 404);
            }

            DB::table('roles')->where('role_name', $request->role_name)->delete();
            
            LogController::createLogAuto([
                'username' => $user->username,
                'role_name' => $request->role_name,
                'message' => " user {$user->fullName} đã xóa vai trò {$request->role_name}.",
                'is_delete' => false
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully.'
            ]);
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
                'message' => 'Could not delete role. ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateRole(Request $request, string $rolename)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $validator = Validator::make($request->all(), [
                'role_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $role = DB::table('roles')->where('role_name', $rolename)->first();
            if (!$role) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role not found.'
                ], 404);
            }

            DB::table('roles')->where('role_name', $rolename)->update([
                'role_name' => $request->role_name,
                'assigned_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Role updated successfully.',
            ]);
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
                'message' => 'Could not update role. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRoleByName(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $role_name = $request->query('role_name');
            if (!$role_name) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'role_name is required.'
                ], 400);
            }

            $roles = DB::table('roles')
                ->where('role_name', 'LIKE', '%' . $role_name . '%')
                ->get();

            if ($roles->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role not found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $roles
            ]);
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
                'message' => 'Could not retrieve role. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllRoles(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $query = DB::table('roles');
            $role_name = $request->query('role_name');

            if ($role_name) {
                $query->where('role_name', 'LIKE', '%' . $role_name . '%');
            }

            $roles = $query->get();

            if ($roles->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No roles found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $roles
            ]);
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
                'message' => 'Could not retrieve roles. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRolesByUser(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $query = DB::table('roles');
            $role_name = $request->query('role_name');

            // Giả sử bảng roles có cột created_by (thay vì user_creately)
            $query->where('created_by', $user->username);

            if ($role_name) {
                $query->where('role_name', 'LIKE', '%' . $role_name . '%');
            }

            $roles = $query->get();

            if ($roles->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No roles found for this user.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $roles
            ]);
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
                'message' => 'Could not retrieve roles by user. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllUsersFromRole(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $role_name = $request->query('roleName');
            if (!$role_name) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'role_name is required.'
                ], 400);
            }

            $users = DB::table('users')
                ->join('user_role', 'users.username', '=', 'user_role.username')
                ->where('user_role.role_name', $role_name)
                ->select('users.username')
                ->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No users found for this role.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $users
            ]);
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
                'message' => 'Could not retrieve users from role. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllRolesByUser(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $roles = DB::table('roles')
                ->join('user_role', 'roles.role_name', '=', 'user_role.role_name')
                ->where('user_role.username', $user->username)
                ->select('roles.role_name')
                ->get();

            if ($roles->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No roles found for this user.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $roles
            ]);
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
                'message' => 'Could not retrieve roles by user. ' . $e->getMessage()
            ], 500);
        }
    }
}