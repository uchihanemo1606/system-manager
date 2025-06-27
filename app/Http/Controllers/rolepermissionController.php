<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class rolepermissionController extends Controller
{
    public function createRolePermission(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $validator = Validator::make($request->all(), [
                'role_name' => 'required|string|max:100',
                'permission_name' => 'required|string|max:100',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed', 'errors' => $validator->errors()
                ], 422);
            }

            // Lấy type của permission
            $permission = DB::table('permissions')->where('permissions_name', $request->input('permission_name'))->first();
            if (!$permission) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission not found.'
                ], 404);
            }
            $permissionType = $permission->type;

            // Kiểm tra role có phù hợp với permission type không
            $roleName = mb_strtolower($request->input('role_name'), 'UTF-8');
            $roleType = null;
            if (str_contains($roleName, 'phần cứng') || str_contains($roleName, 'hardware')) {
                $roleType = 'hardware';
            } elseif (str_contains($roleName, 'phần mềm') || str_contains($roleName, 'software')) {
                $roleType = 'software';

            } elseif (str_contains($roleName, 'quản lý hệ thống') || str_contains($roleName, 'system')) {
                $roleType = 'system';
            }
            if ($roleType && $roleType !== $permissionType) {

                if (
                    in_array($roleType, ['admin', 'quản trị', 'quản trị viên'])
                    && in_array($permissionType, ['user', 'role', 'userrole'])
                ) {

                }
                // Cho phép system nhận permission type domain và hardwaredomain
                elseif (
                    $roleType === 'system'
                    && in_array($permissionType, ['domain', 'hardwaredomain'])
                ) {
   
                }

                elseif (
                    $roleType === 'hardware'
                    && in_array($permissionType, ['hardware', 'hardwarepermission'])
                ) {
   
                }

                else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Role '{$request->input('role_name')}' is not allowed to add permission of type '{$permissionType}'."
                    ], 422);
                }
            }
            

            // Kiểm tra trùng lặp
            $exists = DB::table('role_permissions')
                ->where('role_name', $request->input('role_name'))
                ->where('permission_name', $request->input('permission_name'))
                ->exists();
            if ($exists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This permission is already assigned to the role.'
                ], 409);
            }

            $rolePermission = DB::table('role_permissions')->insert([
                'role_name' => $request->input('role_name'),
                'permission_name' => $request->input('permission_name'),
                'assigned_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            if ($rolePermission) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'role_name' => $request->input('role_name'),
                    'permission_name' => $request->input('permission_name'),
                    'message' => "User {$user->username} created role permission '{$request->input('role_name')}' with permission '{$request->input('permission_name')}'.",
                    'is_delete' => false
                ]);

                $usernames = DB::table('user_role')->where('role_name', $request->input('role_name'))->pluck('username');
                foreach ($usernames as $username) {
                    Cache::forget('user_permissions_' . $username);
                }

                return response()->json(['message' => 'Role permission created successfully'], 201);
            } else {
                return response()->json(['message' => 'Failed to create role permission'], 500);
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
                'message' => 'Could not create permission. ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateRolePermission(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $validator = Validator::make($request->all(), [
                'role_name' => 'required|string|max:100',
                'permission_name' => 'required|string|max:100',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed', 'errors' => $validator->errors()
                ], 422);
            }

            // Lấy thông tin cũ
            $old = DB::table('role_permissions')
                ->where('role_name', $request->input('role_name'))
                ->first();

            if (!$old) {
                return response()->json(['message' => 'Role permission not found'], 404);
            }

            $oldPermission = $old->permission_name;
            $newPermission = $request->input('permission_name');

            // Cập nhật
            $updated = DB::table('role_permissions')
                ->where('role_name', $request->input('role_name'))
                ->update([
                    'permission_name' => $newPermission,
                    'updated_at' => now()
                ]);

            // So sánh thay đổi
            $changes = [];
            if ($oldPermission != $newPermission) {
                $changes[] = "permission_name: '$oldPermission' => '$newPermission'";
            }
            $changeString = $changes ? implode(', ', $changes) : 'No changes';

            // Log lại
            LogController::createLogAuto([
                'username' => $user->username,
                'role_name' => $request->input('role_name'),
                'permission_name' => $newPermission,
                'message' => "User {$user->username} updated role permission '{$request->input('role_name')}': $changeString",
                'is_delete' => false
            ]);

                $usernames = DB::table('user_role')->where('role_name', $request->input('role_name'))->pluck('username');
                foreach ($usernames as $username) {
                    Cache::forget('user_permissions_' . $username);
                }

            if ($updated) {
                return response()->json(['message' => 'Role permission updated successfully'], 200);
            } else {
                return response()->json(['message' => 'Failed to update role permission'], 500);
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
                    'message' => 'Could not update permission. ' . $e->getMessage()
                ], 500);
            }
    }

    public function deleteRolePermission(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $validator = Validator::make($request->all(), [
                'role_name' => 'required|string|max:100',
                'permission_name' => 'required|string|max:100',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed', 'errors' => $validator->errors()
                ], 422);
            }
            $rolePermission = DB::table('role_permissions')
                ->where('role_name', $request->input('role_name'))
                ->where('permission_name', $request->input('permission_name'))
                ->delete();
            if ($rolePermission) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'role_name' => $request->input('role_name'),
                    'permission_name' => $request->input('permission_name'),
                    'message' => "User {$user->username} deleted role permission '{$request->input('role_name')}' with permission '{$request->input('permission_name')}'.",
                    'is_delete' => true
                ]);

                $usernames = DB::table('user_role')->where('role_name', $request->input('role_name'))->pluck('username');
                foreach ($usernames as $username) {
                    Cache::forget('user_permissions_' . $username);
                }

                return response()->json(['message' => 'Role permission deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Failed to delete role permission'], 500);
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
                'message' => 'Could not delete permission. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllRolePermissions(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $query = DB::table('role_permissions');

            // Nếu có tham số role_name hoặc permission_name trong query, tìm kiếm gần đúng
            $role_name = $request->query('role_name');
            $permission_name = $request->query('permission_name');

            if ($role_name) {
                $query->where('role_name', 'LIKE', '%' . $role_name . '%');
            }
            if ($permission_name) {
                $query->where('permission_name', 'LIKE', '%' . $permission_name . '%');
            }

            $rolePermissions = $query->get();

            if ($rolePermissions->isEmpty()) {
                return response()->json(['message' => 'No role permissions found'], 404);
            }
            return response()->json($rolePermissions, 200);
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
                'message' => 'Could not retrieve role permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRolePermissionByName(Request $request)
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

            $rolePermissions = DB::table('role_permissions')
                ->where('role_name', 'LIKE', '%' . $role_name . '%')
                ->get();

            if ($rolePermissions->isEmpty()) {
                return response()->json(['message' => 'Role permission not found'], 404);
            }
            return response()->json($rolePermissions, 200);
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
                'message' => 'Could not retrieve role permission. ' . $e->getMessage()
            ], 500);
        }
    }

    
}