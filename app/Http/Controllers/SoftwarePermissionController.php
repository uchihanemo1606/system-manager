<?php


namespace App\Http\Controllers;

use App\Models\permissionModel;
use Illuminate\Http\Request;
use App\Models\softwarePermissionModel;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\LogController;
use App\Models\softwareModel;
use App\Models\UserModel;

class SoftwarePermissionController extends Controller
{
    //thêm 1 user mới vào đồng quản lý phần mềm
    public function createSoftwarePermission(Request $request)
    {
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

        $validated = $request->validate([
            'software_id' => 'required|integer|exists:software,id',
            'user_name' => 'required|string|exists:users,username',
            'permissions_name' => 'required|string|exists:permissions,permissions_name',
        ]);

        // Kiểm tra type của permission
        $permission = permissionModel::where('permissions_name', $validated['permissions_name'])->first();
        if (!$permission || $permission->type !== 'software') {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission type is not suitable for software.'
            ], 422);
        }

        // Kiểm tra trùng lặp
        $exists = softwarePermissionModel::where([
            'software_id' => $validated['software_id'],
            'user_name' => $validated['user_name'],
            'permissions_name' => $validated['permissions_name'],
        ])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Permission already exists for this user and software.'
            ], 409);
        }

        // Lưu vào DB
        $permission = softwarePermissionModel::create([
            'software_id' => $validated['software_id'],
            'user_name' => $validated['user_name'],
            'permissions_name' => $validated['permissions_name'],
            'user_createdby' => $user->username,
            'assigned_at' => now(),
        ]);
        logController::createLogAuto([
            'username' => $user->username,
            'software_id' => $validated['software_id'],
            'message' => "{$user->fullName} đã thêm quyền {$validated['permissions_name']} cho người dùng {$validated['user_name']} trong phần mềm.",
        ]);
        return response()->json([
            'message' => 'Software permission created successfully.',
            'data' => $permission,
        ], 201);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not create software permission. ' . $e->getMessage()], 500);
        }
    }

    public function getAllUserPermission(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $permissions = softwarePermissionModel::where('user_name', $user->username)
                ->with(['user', 'software'])
                ->get();
            return response()->json([
                'message' => 'User software permissions retrieved successfully.',
                'data' => $permissions,
            ], 200);
            } catch (TokenExpiredException $e) {
                return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
            } catch (TokenInvalidException $e) {
                return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
            } catch (JWTException $e) {
                return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Could not retrieve software permissions. ' . $e->getMessage()], 500);
            }
    }

    public function getDetailUserPermissionInSoftware(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $username = $request->query('user_name') ?? $request->input('user_name');
            $softwareId = $request->query('software_id') ?? $request->input('software_id');

            if (!$username || !$softwareId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'user_name and software_id are required.'
                ], 400);
            }

            $userExists = DB::table('users')->where('username', $username)->exists();
            $softwareExists = DB::table('software')->where('id', $softwareId)->exists();
            if (!$userExists || !$softwareExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User or software not found.'
                ], 404);
            }

            $permissions = softwarePermissionModel::where([
                    'software_id' => $softwareId,
                    'user_name' => $username,
                ])
                ->with(['user', 'software'])
                ->get();

            if ($permissions->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No permissions found for this user on this software.'
                ], 404);
            }

            return response()->json([
                'message' => 'User permissions on software retrieved successfully.',
                'data' => $permissions,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve user permission details. ' . $e->getMessage()], 500);
        }
    }

    //só 1 user ra khỏi phần quản lý phần mềm
    public function removeUserPermissionInSoftware(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $username = $request->query('user_name') ?? $request->input('user_name');
            $softwareId = $request->query('software_id') ?? $request->input('software_id');

            if (!$username || !$softwareId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'user_name and software_id are required.'
                ], 400);
            }

            $software = softwareModel::find($softwareId);
            if (!$software) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Software not found.'
                ], 404);
            }

            // Không cho phép xóa quyền của chủ phần mềm
            if ($username === $software->user_createby) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không thể xóa quyền của chủ phần mềm!'
                ], 403);
            }

            $userExists = UserModel::where('username', $username)->exists();
            if (!$userExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.'
                ], 404);
            }

            $deletedRows = softwarePermissionModel::where([
                    'software_id' => $softwareId,
                    'user_name' => $username,
                ])->delete();

            if ($deletedRows === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No permissions found to delete for this user on this software.'
                ], 404);
            }

            logController::createLogAuto([
                'username' => $user->username,
                'software_id' => $softwareId,
                'message' => "{$user->fullName} đã xóa quyền của người dùng {$username} trong phần mềm.",
            ]);

            return response()->json([
                'message' => 'User permissions removed successfully.',
                'deleted_rows' => $deletedRows,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not remove user permission. ' . $e->getMessage()], 500);
        }
    }

    public function removePermissionsForUsersInSoftware(Request $request, $softwareId)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            if (!$softwareId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'software_id is required.'
                ], 400);
            }

            $users = $request->input('users'); // array: [{user_name, permissions: []}, ...]
            if (!is_array($users) || empty($users)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'users is required and must be an array.'
                ], 400);
            }

            $software = softwareModel::find($softwareId);
            if (!$software) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Software not found.'
                ], 404);
            }

            $results = [];
            // Lấy danh sách user hiện đang giữ quyền sửa và xóa
            $currentEditUsers = softwarePermissionModel::where('software_id', $softwareId)
                ->where('permissions_name', 'sửa phần mềm')
                ->pluck('user_name')
                ->toArray();

            $currentDeleteUsers = softwarePermissionModel::where('software_id', $softwareId)
                ->where('permissions_name', 'xóa phần mềm')
                ->pluck('user_name')
                ->toArray();

            foreach ($users as $userData) {
                $username = $userData['user_name'] ?? null;
                $permissions = $userData['permissions'] ?? [];

                if (!$username || !is_array($permissions) || empty($permissions)) {
                    $results[] = [
                        'user_name' => $username,
                        'status' => 'error',
                        'message' => 'user_name and permissions are required.'
                    ];
                    continue;
                }

                // Không cho phép xóa quyền của chủ phần mềm
                if ($username === $software->user_createby) {
                    $results[] = [
                        'user_name' => $username,
                        'status' => 'forbidden',
                        'message' => 'Không thể xóa quyền của chủ phần mềm!'
                    ];
                    continue;
                }

                // Kiểm tra logic giữ lại ít nhất 1 quyền sửa và 1 quyền xóa
                $editWillRemove = in_array('sửa phần mềm', $permissions) && in_array($username, $currentEditUsers);
                $deleteWillRemove = in_array('xóa phần mềm', $permissions) && in_array($username, $currentDeleteUsers);

                if ($editWillRemove && count($currentEditUsers) == 1) {
                    $results[] = [
                        'user_name' => $username,
                        'status' => 'forbidden',
                        'message' => 'Phần mềm này cần ít nhất 1 người giữ quyền sửa phần mềm!'
                    ];
                    continue;
                }
                if ($deleteWillRemove && count($currentDeleteUsers) == 1) {
                    $results[] = [
                        'user_name' => $username,
                        'status' => 'forbidden',
                        'message' => 'Phần mềm này cần ít nhất 1 người giữ quyền xóa phần mềm!'
                    ];
                    continue;
                }

                // Thực hiện xóa các quyền chỉ định
                $deletedRows = softwarePermissionModel::where([
                        'software_id' => $softwareId,
                        'user_name' => $username,
                    ])
                    ->whereIn('permissions_name', $permissions)
                    ->delete();

                // Nếu xóa thành công thì cập nhật lại danh sách người giữ quyền sửa/xóa
                if ($deletedRows > 0) {
                    if ($editWillRemove) {
                        $currentEditUsers = array_diff($currentEditUsers, [$username]);
                    }
                    if ($deleteWillRemove) {
                        $currentDeleteUsers = array_diff($currentDeleteUsers, [$username]);
                    }
                }

                $results[] = [
                    'user_name' => $username,
                    'deleted_rows' => $deletedRows,
                    'status' => $deletedRows > 0 ? 'success' : 'error',
                    'message' => $deletedRows > 0 ? 'Permissions removed.' : 'No permissions found to delete.'
                ];
            }

            return response()->json([
                'message' => 'Bulk permission removal completed.',
                'results' => $results,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not remove permissions. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllUserPermissionInSoftware(Request $request, $softwareId)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            if (!$softwareId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vui lòng nhập software_id'
                ], 400);
            }

            $softwareExists = softwareModel::where('id', $softwareId)->exists();
            if (!$softwareExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Software not found.'
                ], 404);
            }

            // Lấy tất cả user và quyền của họ trong phần mềm này
            $permissions = softwarePermissionModel::where('software_id', $softwareId)
                ->with(['user'])
                ->get()
                ->groupBy('user_name')
                ->map(function ($items, $userName) {
                    return [
                        'user_name' => $userName,
                        'permissions' => $items->pluck('permissions_name'),
                        'user_info' => $items->first()->user ?? null,
                    ];
                })
                ->values();

            if ($permissions->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No users found for this software.'
                ], 404);
            }

            return response()->json([
                'message' => 'All users and their permissions in software retrieved successfully.',
                'data' => $permissions,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve users and permissions. ' . $e->getMessage()], 500);
        }
    }

    public function updatePermissionUserInSoftware(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $validated = $request->validate([
                'software_id' => 'required|integer|exists:software,id',
                'user_name' => 'required|string|exists:users,username',
                'permissions_name' => 'required|string|exists:permissions,permissions_name',
            ]);

            // Kiểm tra type của permission
            $permission = DB::table('permissions')->where('permissions_name', $validated['permissions_name'])->first();
            if (!$permission || $permission->type !== 'software') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission type is not suitable for software.'
                ], 422);
            }

            // Cập nhật quyền
            $softwarePermission = softwarePermissionModel::where([
                'software_id' => $validated['software_id'],
                'user_name' => $validated['user_name'],
            ])->first();

            if (!$softwarePermission) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission not found for this user and software.'
                ], 404);
            }

            $softwarePermission->permissions_name = $validated['permissions_name'];
            $softwarePermission->save();

            logController::createLogAuto([
                'username' => $user->username,
                'software_id' => $validated['software_id'],
                'message' => "{$user->fullName} đã cập nhật quyền {$validated['permissions_name']} cho người dùng {$validated['user_name']} trong phần mềm.",
            ]);

            return response()->json([
                'message' => 'Software permission updated successfully.',
                'data' => $softwarePermission,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not update software permission. ' . $e->getMessage()], 500);
        }
    }

    public function addPermissionForUser(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $validated = $request->validate([
                'software_id' => 'required|integer|exists:software,id',
                'user_name' => 'required|string|exists:users,username',
                'permissions_name' => 'required|string|exists:permissions,permissions_name',
            ]);

            // Kiểm tra type của permission
            $permission = DB::table('permissions')->where('permissions_name', $validated['permissions_name'])->first();
            if (!$permission || $permission->type !== 'software') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission type is not suitable for software.'
                ], 422);
            }

            // Kiểm tra trùng lặp
            $exists = softwarePermissionModel::where([
                'software_id' => $validated['software_id'],
                'user_name' => $validated['user_name'],
                'permissions_name' => $validated['permissions_name'],
            ])->exists();

            if ($exists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission already exists for this user and software.'
                ], 409);
            }

            // Lưu vào DB
            $permission = softwarePermissionModel::create([
                'software_id' => $validated['software_id'],
                'user_name' => $validated['user_name'],
                'permissions_name' => $validated['permissions_name'],
                'user_createdby' => $user->username,
                'assigned_at' => now(),
            ]);

            logController::createLogAuto([
                'username' => $user->username,
                'software_id' => $validated['software_id'],
                'message' => "{$user->fullName} đã thêm quyền {$validated['permissions_name']} cho người dùng {$validated['user_name']} trong phần mềm.",
            ]);

            return response()->json([
                'message' => 'Software permission created successfully.',
                'data' => $permission,
            ], 201);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not create software permission. ' . $e->getMessage()], 500);
        }
    }
}