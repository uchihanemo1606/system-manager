<?php

namespace App\Http\Controllers;

use App\Models\hardwareModel;
use Illuminate\Http\Request;
use App\Models\hardwarePemisssionModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Policies\HardwarePolicy;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Log;



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
            'users' => 'required|array|min:1',
            'users.*.user_name' => 'required|string|exists:users,username',
            'users.*.permissions' => 'required|array|min:1',
            'users.*.permissions.*' => 'required|string|max:255',
        ]);
        $hardware = hardwareModel::where('ip', $validated['hardware_ip'])->first();

        if ($user->cannot('createPermission', $hardware)) {
            Log::warning('User denied create permission by policy', [
                'username' => $user->username,
                'hardware_ip' => $hardware->ip
            ]);
            return response()->json(['status' => 'error', 'message' => 'You do not have permission to create this hardware.'], 403);
        }

        $created = [];
        $skipped = [];

        // Kiểm tra trùng lặp
       foreach ($validated['users'] as $userData) {
            foreach ($userData['permissions'] as $permissionName) {
                $exists = hardwarePemisssionModel::where([
                    'hardware_ip' => $validated['hardware_ip'],
                    'user_name' => $userData['user_name'],
                    'permissions_name' => $permissionName,
                ])->exists();

                if ($exists) {
                    $skipped[] = [
                        'user_name' => $userData['user_name'],
                        'permissions_name' => $permissionName,
                    ];
                    continue;
                }

                $created[] = hardwarePemisssionModel::create([
                    'hardware_ip' => $validated['hardware_ip'],
                    'user_name' => $userData['user_name'],
                    'permissions_name' => $permissionName,
                    'user_createby' => $user->username,
                    'assigned_at' => now(),
                ]);
            }
        }

        LogController::createLogAuto([
            'username' => $user->username,
            'hardware_ip' => $validated['hardware_ip'],
            'message' => "User {$user->fullName} created hardware permissions for " . count($created) . " users.",
        ]);


       return response()->json([
            'message' => 'Bulk hardware permission creation completed.',
            'created' => $created,
            'skipped' => $skipped,
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
        $hardwareExists = DB::table('hardware')->where('ip', $hardwareIp)->exists();
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

    public function removePermissionsForUsersInHardware(Request $request, $hardwareIP)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            if (!$hardwareIP) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'hardware_ip is required.'
                ], 400);
            }

            $users = $request->input('users'); // array: [{user_name, permissions: []}, ...]
            if (!is_array($users) || empty($users)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'users is required and must be an array.'
                ], 400);
            }

            $hardware = hardwareModel::find($hardwareIP);
            if (!$hardware) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Hardware not found.'
                ], 404);
            }

            if ($user->cannot('deletePermission', $hardware)) {
                Log::warning('User denied delete permission by policy', [
                    'username' => $user->username,
                    'hardware_ip' => $hardware->ip,
                ]);
                return response()->json(['status' => 'error', 'message' => 'You do not have permission to delete this hardware.'], 403);
            }


            $results = [];
            // Lấy danh sách user hiện đang giữ quyền sửa và xóa
            $currentEditUsers = hardwarePemisssionModel::where('hardware_ip', $hardwareIP)
                ->where('permissions_name', 'sửa hardware')
                ->pluck('user_name')
                ->toArray();

            $currentDeleteUsers = hardwarePemisssionModel::where('hardware_ip', $hardwareIP)
                ->where('permissions_name', 'xóa hardware')
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

                // Không cho phép xóa quyền của chủ phần cứng
                if ($username === $hardware->created_by) {
                    $results[] = [
                        'user_name' => $username,
                        'status' => 'forbidden',
                        'message' => 'Không thể xóa quyền của chủ phần cứng!'
                    ];
                    continue;
                }

                // Kiểm tra logic giữ lại ít nhất 1 quyền sửa và 1 quyền xóa
                $editWillRemove = in_array('sửa hardware', $permissions) && in_array($username, $currentEditUsers);
                $deleteWillRemove = in_array('xóa hardware', $permissions) && in_array($username, $currentDeleteUsers);

                // Nếu xóa quyền sửa mà chỉ còn 1 người giữ quyền sửa (là user này) thì không cho xóa
                if ($editWillRemove && count($currentEditUsers) == 1) {
                    $results[] = [
                        'user_name' => $username,
                        'status' => 'forbidden',
                        'message' => 'Thiết bị này cần ít nhất 1 người giữ quyền sửa hardware!'
                    ];
                    continue;
                }
                // Nếu xóa quyền xóa mà chỉ còn 1 người giữ quyền xóa (là user này) thì không cho xóa
                if ($deleteWillRemove && count($currentDeleteUsers) == 1) {
                    $results[] = [
                        'user_name' => $username,
                        'status' => 'forbidden',
                        'message' => 'Thiết bị này cần ít nhất 1 người giữ quyền xóa hardware!'
                    ];
                    continue;
                }

                // Thực hiện xóa các quyền chỉ định
                $deletedRows = hardwarePemisssionModel::where([
                        'hardware_ip' => $hardwareIP,
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
        // note: gộp nhánh 
        // $userExists = DB::table('users')->where('username', $username)->exists();
        // $hardwareExists = DB::table('hardware')->where('ip', $hardwareIp)->exists();
        // if (!$userExists || !$hardwareExists) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'User or hardware not found.'
        //     ], 404);
        // } 
            // Lấy chủ phần cứng
            $hardware = hardwareModel::find($hardwareIp);
            if (!$hardware) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Hardware not found.'
                ], 404);
            }
            if($user->cannot('deletePermission', $hardware)) {
                Log::warning('User denied delete permission by policy', [
                    'username' => $user->username,
                    'hardware_ip' => $hardware->ip,
                ]);
                return response()->json(['status' => 'error', 'message' => 'You do not have permission to delete this hardware.'], 403);
            }

            // Không cho phép xóa quyền của chủ phần cứng
            if ($username === $hardware->created_by) {
                return response()->json([
                    'status' => 'forbidden',
                    'message' => 'Không thể xóa quyền của chủ phần cứng!'
                ], 403);
            }

            // Nếu user tự xóa quyền của mình
            if ($username === $user->username) {
                // Đếm số người còn quyền "sửa hardware" hoặc "xóa hardware" trên hardware này (trừ user hiện tại)
                $ownerCount = hardwarePemisssionModel::where('hardware_ip', $hardwareIp)
                    ->whereIn('permissions_name', ['sửa hardware', 'xóa hardware'])
                    ->where('user_name', '!=', $username)
                    ->distinct('user_name')
                    ->count('user_name');

                if ($ownerCount === 0) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Thiết bị này cần ít nhất 1 người có quyền sửa hoặc xóa. Vui lòng chuyển quyền chủ cho người khác trước khi xóa bản thân.'
                    ], 400);
                }
            }

            // Xóa tất cả quyền của user này trên hardware
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

    public function getUserInHardwarePermission(Request $request, $hardwareIP)
    {
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

        if (!$hardwareIP) {
            return response()->json([
                'status' => 'error',
                'message' => 'hardware_ip is required.'
            ], 400);
        }

        // Kiểm tra hardware tồn tại
        $hardwareExists = hardwareModel::where('ip', $hardwareIP)->exists();
        if (!$hardwareExists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hardware not found.'
            ], 404);
        }

        // Lấy tất cả user và quyền của họ trên hardware này
        $permissions = hardwarePemisssionModel::where('hardware_ip', $hardwareIP)
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
                'message' => 'No users found for this hardware.'
            ], 404);
        }

        return response()->json([
            'message' => 'All users and their permissions in hardware retrieved successfully.',
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
            'message' => 'Could not retrieve users and permissions. ' . $e->getMessage()
        ], 500);
    }
}


}

