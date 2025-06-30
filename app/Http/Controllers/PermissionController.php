<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;



/**
 * @OA\Info(
 *     title="Permission API",
 *     version="1.0.0",
 *     description="API for managing permissions in the system"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class PermissionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/getAllPermissions",
     *     summary="Retrieve all permissions",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                     @OA\Property(property="type", type="string", example="user"),
     *                     @OA\Property(property="user_creately", type="string", example="admin"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not retrieve permissions. {error_message}")
     *         )
     *     )
     * )
     */
    public function getAllPermissions()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $permissions = DB::table('permissions')->get();

            return response()->json([
                'status' => 'success',
                'permissions' => $permissions,
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
                'message' => 'Could not retrieve permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/getPermissionByName",
     *     summary="Retrieve permissions by name (partial match)",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name to search for (partial match)",
     *         required=true,
     *         @OA\Schema(type="string", example="phân quyền")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="permission", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                     @OA\Property(property="type", type="string", example="user"),
     *                     @OA\Property(property="user_creately", type="string", example="admin"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="name is required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Permission not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not retrieve permission. {error_message}")
     *         )
     *     )
     * )
     */
    public function getPermissionByName(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $name = $request->query('name');
            if (!$name) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'name is required.'
                ], 400);
            }

            $permission = DB::table('permissions')->where('permissions_name', 'like', '%' . $name . '%')->get();

            if (!$permission) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission not found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'permission' => $permission,
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
                'message' => 'Could not retrieve permission. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/createPermission",
     *     summary="Create a new permission",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng", description="Name of the permission"),
     *             @OA\Property(property="type", type="string", example="user", description="Type of the permission")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Permission và route_permission đã được tạo thành công."),
     *             @OA\Property(property="permission", type="object",
     *                 @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                 @OA\Property(property="type", type="string", example="user"),
     *                 @OA\Property(property="user_creately", type="string", example="admin"),
     *                 @OA\Property(property="route_permission", type="string", example="user.create"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Route name '{permissions_name}' đã tồn tại trong hệ thống. Permission này có thể đã được thêm trước đó với tên khác.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="object", example={"permissions_name": {"The permissions name field is required."}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not create permission. {error_message}")
     *         )
     *     )
     * )
     */
    public function createPermission(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $validator = Validator::make($request->all(), [
                'permissions_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }
            // quản lý hệ thông sẽ có thể thêm luông domain và gép:[cứng, mềm, doamin, hardwaredomain]
            $input = mb_strtolower($request->permissions_name, 'UTF-8');
            $defaultPermission = $request->permissions_name;

            // Map resource và action như cũ...
            $resourceMap = [
                'phần cứng' => 'hardware',
                'hardware' => 'hardware',
                'phần mềm' => 'software',
                'software' => 'software',
                'người dùng' => 'user',
                'user' => 'user',
                'quyền hạn' => 'permission',
                'quyền' => 'permission',
                'permission' => 'permission',
                'pháp lý' => 'legal',
                'legal' => 'legal',
                'hệ thống' => 'system',
                'system' => 'system',
                'danh mục' => 'category',
                'category' => 'category',
                'vai trò' => 'role',
                'role' => 'role',
                'người dùng quản lý phần cứng' => 'hardwarepermission',
                'hardware Permission' => 'hardwarepermission',
                'người dùng quản lý phần mềm' => 'softwarepermission',
                'software permisison' => 'softwarepermission',
                'quyền người dùng' => 'userrole',
                'user role' => 'userrole',
                'quyền hệ thống' => 'systempermission',
                'system permission' => 'systempermission',
                'tên miền' => 'domain',
                'domain' => 'domain',
                'phần cứng vào domain' => 'hardwaredomain',
                'hardware domain' => 'hardwaredomain',
                'phần cứng khỏi domain' => 'hardwaredomain',
                'hardware khỏi domain' => 'hardwaredomain',
                'phần cứng trong domain' => 'hardwaredomain',
                'phòng ban' => 'department',
                'department' => 'department',

            ];

            $actionMap = [
                'thêm' => 'create', 'tạo' => 'create', 'add' => 'create', 'create' => 'create', 'cấp' => 'create',
                'cập nhật' => 'edit', 'sửa' => 'edit', 'update' => 'edit', 'edit' => 'edit', 'sửa thông tin' => 'edit', 'update thông tin' => 'edit', 'thay đổi' => 'edit', 'thay đổi thông tin' => 'edit',
                'xoá' => 'delete', 'thu hồi' => 'delete', 'delete' => 'delete', 'remove' => 'delete',
                'xem danh sách' => 'list', 'lấy danh sách'=> 'list', 'list' => 'list', 'view' => 'list', 'lấy toàn bộ' => 'list', 'xem tất cả' => 'list', 'lấy tất cả' => 'list', 'danh sách' => 'list',
                'xem chi tiết' => 'detail', 'chi tiết' => 'detail', 'detail' => 'detail', 'xem thông tin' => 'detail', 'getdetail' => 'detail', 'get detail'=> 'detail',
                'tìm kiếm' => 'get', 'search' => 'get', 'lấy' => 'get', 'get' => 'get', 'xem' => 'get', 
            ];

            $input = mb_strtolower($request->permissions_name, 'UTF-8');
            $defaultPermission = $request->permissions_name;

            
            uksort($resourceMap, fn($a, $b) => strlen($b) - strlen($a));
            uksort($actionMap, fn($a, $b) => strlen($b) - strlen($a));

            $resource = '';
            $action = '';

            foreach ($resourceMap as $vi => $en) {
                if (str_contains($input, $vi)) {
                    $resource = $en;
                    $input = str_replace($vi, '', $input);
                    break;
                }
            }

            foreach ($actionMap as $vi => $en) {
                if (str_contains($input, $vi)) {
                    $action = $en;
                    break;
                }
            }

            if (!$resource) $resource = 'other';
            if (!$action) $action = 'other';

            $permissions_name = $resource . '.' . $action;

            $type = $resource;

            // Kiểm tra route_permission đã tồn tại chưa
            $routeExists = DB::table('route_permission')->where('route_name', $permissions_name)->exists();
            if ($routeExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Route name '{$permissions_name}' đã tồn tại trong hệ thống. Permission này có thể đã được thêm trước đó với tên khác."
                ], 409);
            }

            $now = now();
            DB::table('permissions')->insert([
                'user_creately' => $user->username,
                'permissions_name' => $defaultPermission,
                'type' => $type,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('route_permission')->insert([
                'route_name' => $permissions_name,
                'permissions_name' => $defaultPermission,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            LogController::createLogAuto([
                'username' => $user->username,
                'permission_name' => $defaultPermission,
                'message' => "user $user->fullName has been create new permission: ' . $defaultPermission",
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Permission và route_permission đã được tạo thành công.',
                'permission' => [
                    'permissions_name' => $defaultPermission,
                    'type' => $type,
                    'user_creately' => $user->username,
                    'route_permission' => $permissions_name,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
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

    /**
     * @OA\Patch(
     *     path="/api/updatePermission/{name}",
     *     summary="Update an existing permission",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="Name of the permission to update",
     *         required=true,
     *         @OA\Schema(type="string", example="phân quyền người dùng")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="permission_name", type="string", example="phân quyền người dùng mới", description="New name of the permission"),
     *             @OA\Property(property="type", type="string", example="user", description="New type of the permission")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Permission updated successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Permission not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="object", example={"permission_name": {"The permission name field is required."}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not update permission. {error_message}")
     *         )
     *     )
     * )
     */
    public function updatePermission(Request $request, $name)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $validator = Validator::make($request->all(), [
                'permission_name' => 'sometimes|required|string|max:255',
                // 'type' => 'sometimes|required|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 422);
            }

            $permission = DB::table('permissions')->where('permissions_name', $name)->first();

            if (!$permission) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission not found.'
                ], 404);
            }

            $oldName = $permission->permissions_name;
            $newName = $request->input('permission_name', $oldName);

            DB::table('permissions')->where('permissions_name', $name)->update(array_filter($request->only(['permission_name', 'type'])));

            LogController::createLogAuto([
                'username' => $user->username,
                'permission_name' => $name,
                'message' => "User $user->fullName updated permission from '{$oldName}' => '{$newName}'",
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Permission updated successfully.',
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
                'message' => 'Could not update permission. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/deletePermission",
     *     summary="Delete a permission",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng", description="Name of the permission to delete")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Permission deleted successfully."),
     *             @OA\Property(property="permissions", type="string", example="phân quyền người dùng")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="permissions_name is required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Permission not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not delete permission. {error_message}")
     *         )
     *     )
     * )
     */
    public function deletePermission(Request $request)
    {
        try {
            // Xác thực JWT
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Validation dữ liệu từ body
            $validator = Validator::make($request->all(), [
                'permissions_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            // Lấy permissions_name từ body
            $permissionName = $request->input('permissions_name');

            if (!$permissionName) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'permissions_name is required.'
                ], 400);
            }

            // Kiểm tra tồn tại trong permissions
            $permission = DB::table('permissions')->where('permissions_name', $permissionName)->first();
            
            if (!$permission) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission not found.'
                ], 404);
            }

            // Xóa trong route_permission
            DB::table('route_permission')->where('permissions_name', $permissionName)->delete();

            // Xóa trong permissions
            DB::table('permissions')->where('permissions_name', $permissionName)->delete();

            LogController::createLogAuto([
                'username' => $user->username,
                'permission_name' => $permissionName,
                'message' => "User $user->fullName deleted permission: {$permissionName}",
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Permission deleted successfully.',
                'permissions:' => $permissionName,
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
                'message' => 'Could not delete permission. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/getUserCreatePermissions",
     *     summary="Retrieve permissions created by a user",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="Username of the creator (defaults to authenticated user)",
     *         required=false,
     *         @OA\Schema(type="string", example="admin")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                     @OA\Property(property="type", type="string", example="user"),
     *                     @OA\Property(property="user_creately", type="string", example="admin"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not retrieve permissions. {error_message}")
     *         )
     *     )
     * )
     */

    public function getUserCreatePermissions(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Lấy username từ query, nếu không có thì lấy từ token
            $username = $request->query('username', $user->username);

            $permissions = DB::table('permissions')->where('user_creately', $username)->get();

            return response()->json([
                'status' => 'success',
                'permissions' => $permissions,
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
                'message' => 'Could not retrieve permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/getPermissionsByType",
     *     summary="Retrieve permissions by type (partial match)",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Type to search for (partial match)",
     *         required=true,
     *         @OA\Schema(type="string", example="user")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                     @OA\Property(property="type", type="string", example="user"),
     *                     @OA\Property(property="user_creately", type="string", example="admin"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not retrieve permissions. {error_message}")
     *         )
     *     )
     * )
     */
    public function getPermissionsByType(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $type = $request->query('type');

            $permissions = DB::table('permissions')->where('type', 'like', '%' . $type . '%')->get();

            return response()->json([
                'status' => 'success',
                'permissions' => $permissions,
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
                'message' => 'Could not retrieve permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/getPermissionsByUserAndType/{username}/{type}",
     *     summary="Retrieve permissions by user and type",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         description="Username of the creator",
     *         required=true,
     *         @OA\Schema(type="string", example="admin")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description="Type of the permission",
     *         required=true,
     *         @OA\Schema(type="string", example="user")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                     @OA\Property(property="type", type="string", example="user"),
     *                     @OA\Property(property="user_creately", type="string", example="admin"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not retrieve permissions. {error_message}")
     *         )
     *     )
     * )
     */
    public function getPermissionsByUserAndType($username, $type)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $permissions = DB::table('permissions')
                ->where('user_creately', $username)
                ->where('type', $type)
                ->get();

            return response()->json([
                'status' => 'success',
                'permissions' => $permissions,
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
                'message' => 'Could not retrieve permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/getPermissionsByUserAndName/{username}/{name}",
     *     summary="Retrieve permissions by user and name (partial match)",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         description="Username of the creator",
     *         required=true,
     *         @OA\Schema(type="string", example="admin")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="Name to search for (partial match)",
     *         required=true,
     *         @OA\Schema(type="string", example="phân quyền")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                     @OA\Property(property="type", type="string", example="user"),
     *                     @OA\Property(property="user_creately", type="string", example="admin"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not retrieve permissions. {error_message}")
     *         )
     *     )
     * )
     */
    public function getPermissionsByUserAndName($username, $name)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $permissions = DB::table('permissions')
                ->where('user_creately', $username)
                ->where('permissions_name', 'like', '%' . $name . '%')
                ->get();

            return response()->json([
                'status' => 'success',
                'permissions' => $permissions,
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
                'message' => 'Could not retrieve permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/getPermissionsByTypeAndName/{type}/{name}",
     *     summary="Retrieve permissions by type and name (partial match)",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description="Type of the permission",
     *         required=true,
     *         @OA\Schema(type="string", example="user")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="Name to search for (partial match)",
     *         required=true,
     *         @OA\Schema(type="string", example="phân quyền")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                     @OA\Property(property="type", type="string", example="user"),
     *                     @OA\Property(property="user_creately", type="string", example="admin"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not retrieve permissions. {error_message}")
     *         )
     *     )
     * )
     */
    public function getPermissionsByTypeAndName($type, $name)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $permissions = DB::table('permissions')
                ->where('type', $type)
                ->where('permission_name', 'like', '%' . $name . '%')
                ->get();

            return response()->json([
                'status' => 'success',
                'permissions' => $permissions,
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
                'message' => 'Could not retrieve permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/getPermissionsByUserTypeAndName/{username}/{type}/{name}",
     *     summary="Retrieve permissions by user, type, and name (partial match)",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         description="Username of the creator",
     *         required=true,
     *         @OA\Schema(type="string", example="admin")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description="Type of the permission",
     *         required=true,
     *         @OA\Schema(type="string", example="user")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="Name to search for (partial match)",
     *         required=true,
     *         @OA\Schema(type="string", example="phân quyền")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                     @OA\Property(property="type", type="string", example="user"),
     *                     @OA\Property(property="user_creately", type="string", example="admin"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not retrieve permissions. {error_message}")
     *         )
     *     )
     * )
     */
    public function getPermissionsByUserTypeAndName($username, $type, $name)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $permissions = DB::table('permissions')
                ->where('user_creately', $username)
                ->where('type', $type)
                ->where('permission_name', 'like', '%' . $name . '%')
                ->get();

            return response()->json([
                'status' => 'success',
                'permissions' => $permissions,
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
                'message' => 'Could not retrieve permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/getPermisionByTime",
     *     summary="Retrieve permissions by date or date range",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Specific date to filter (format: dd/mm/yyyy)",
     *         required=false,
     *         @OA\Schema(type="string", example="01/06/2025")
     *     ),
     *     @OA\Parameter(
     *         name="from",
     *         in="query",
     *         description="Start date of range (format: dd/mm/yyyy)",
     *         required=false,
     *         @OA\Schema(type="string", example="01/06/2025")
     *     ),
     *     @OA\Parameter(
     *         name="to",
     *         in="query",
     *         description="End date of range (format: dd/mm/yyyy)",
     *         required=false,
     *         @OA\Schema(type="string", example="05/06/2025")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="permissions_name", type="string", example="phân quyền người dùng"),
     *                     @OA\Property(property="type", type="string", example="user"),
     *                     @OA\Property(property="user_creately", type="string", example="admin"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-04 10:24:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-04 10:24:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Bạn phải nhập ngày (date) hoặc khoảng ngày (from, to) theo định dạng ngày/tháng/năm.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Token has expired.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Could not retrieve permissions. {error_message}")
     *         )
     *     )
     * )
     */
    public function getPermisionByTime(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Nhận và chuyển đổi định dạng ngày từ d/m/Y sang Y-m-d
            $date = $request->query('date'); // dạng: 01/06/2024
            $from = $request->query('from'); // dạng: 01/06/2024
            $to = $request->query('to');     // dạng: 05/06/2024

            // Hàm chuyển đổi d/m/Y sang Y-m-d
            $convertDate = function($str) {
                if (!$str) return null;
                $dt = \DateTime::createFromFormat('d/m/Y', $str);
                return $dt ? $dt->format('Y-m-d') : null;
            };

            $date = $convertDate($date);
            $from = $convertDate($from);
            $to = $convertDate($to);

            $query = DB::table('permissions');

            if ($date) {
                $query->whereDate('created_at', $date);
            } elseif ($from && $to) {
                $query->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);
            } elseif ($from) {
                $query->whereDate('created_at', '>=', $from);
            } elseif ($to) {
                $query->whereDate('created_at', '<=', $to);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn phải nhập ngày (date) hoặc khoảng ngày (from, to) theo định dạng ngày/tháng/năm.'
                ], 400);
            }

            $permissions = $query->get();

            return response()->json([
                'status' => 'success',
                'permissions' => $permissions,
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
                'message' => 'Could not retrieve permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllTypePermission(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $types = DB::table('permissions')->distinct()->pluck('type');

            return response()->json([
                'status' => 'success',
                'types' => $types,
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
                'message' => 'Could not retrieve types. ' . $e->getMessage()
            ], 500);
        }
   }

    public function getMyPermissions(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Lấy tất cả role của user
            $roles = DB::table('user_role')
                ->where('username', $user->username)
                ->pluck('role_name');

            if ($roles->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'role' => [],
                    'message' => 'User has no roles.'
                ]);
            }

            $result = [];
            foreach ($roles as $roleName) {
                // Lấy tất cả permission_name từ role_permission cho từng role
                $permissionNames = DB::table('role_permissions')
                    ->where('role_name', $roleName)
                    ->pluck('permission_name');

                // Lấy đầy đủ thông tin permission
                $permissions = DB::table('permissions')
                    ->whereIn('permissions_name', $permissionNames)
                    ->get();

                $result[] = [
                    'rolename' => $roleName,
                    'permission' => $permissions
                ];
            }

            return response()->json([
                'status' => 'success',
                'role' => $result,
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
                'message' => 'Could not retrieve permissions. ' . $e->getMessage()
            ], 500);
        }
    }
}

