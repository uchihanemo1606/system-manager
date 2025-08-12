<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SoftwareModel;
use App\Models\softwarePermissionModel;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class SoftwareController extends Controller
{
    public function createSoftware(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Validate the request data
            $request->validate([
                'softwareName' => 'required|string|max:255',
                'language' => 'required|string|max:100',
                'version' => 'nullable|string|max:255',
                'user_createby' => $user->username,
                'description' => 'nullable|string|max:1000',
            ]);

            // Create a new software record
            $software = new SoftwareModel();
            $software->softwareName = $request->input('softwareName');
            $software->language = $request->input('language');
            $software->version = $request->input('version');
            $software->description = $request->input('description');
            $software->user_createby = $user->username;
            $software->created_at = now();
            $software->updated_at = now();

            // Save the software record
            if ($software->save()) {

                $fullPermissions = [
                    'xem phần mềm',
                    'sửa phần mềm',
                    'xoá phần mềm',
                    'xem danh sách người dùng quản lý phần mềm',
                    'sửa người dùng quản lý phần mềm',
                    'thêm người dùng quản lý phần mềm',
                    'xoá người dùng quản lý phần mềm',
                ];
                foreach ($fullPermissions as $permission) {
                    softwarePermissionModel::create([
                        'software_id' => $software->id,
                        'user_name' => $user->username,
                        'permissions_name' => $permission,
                        'create_by' => $user->username,
                        'assigned_at' => now(),
                    ]);
                }

                LogController::createLogAuto([
                    'username' => $user->username,
                    'software_id' => $software->id,
                    'message' => " user {$user->fullName} created software '{$software->softwareName}'.",
                    'is_delete' => false
                ]);
                return response()->json(['message' => 'Software created successfully', 'data' => $software], 201);
            } else {
                return response()->json([
                    'message' => 'Failed to create software'
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not retrieve permission. ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSoftware(Request $request, $id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $id = $request->query('id');
            if (!$id) {
                return response()->json(['message' => 'Software id is required'], 400);
            }

            $software = SoftwareModel::findOrFail($id);

            $request->validate([
                'softwareName' => 'required|string|max:255',
                'language' => 'required|string|max:100',
                'version' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            if ($user->cannot('update', $software)) {
                return response()->json(['status' => 'error', 'message' => 'You do not have permission to update this software.'], 403);
            }

            $software->softwareName = $request->input('softwareName');
            $software->language = $request->input('language');
            $software->version = $request->input('version');
            $software->description = $request->input('description');
            $software->updated_at = now();

            if ($software->save()) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'software_id' => $software->id,
                    'message' => "user {$user->fullName} updated software '{$software->softwareName}'.",
                    'is_delete' => false
                ]);
                return response()->json(['message' => 'Software updated successfully', 'data' => $software], 200);
            } else {
                return response()->json(['message' => 'Failed to update software'], 500);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Software not found'], 404);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not update software. ' . $e->getMessage()], 500);
        }
    }

    public function getAllSoftware(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $isManager = $user->can('viewAny', SoftwareModel::class);

            $softwareQuery = SoftwareModel::query();

            // Nếu không phải quản lý, chỉ lấy những phần mềm user được phép xem
            if (!$isManager) {
                $allowedIds = softwarePermissionModel::where('user_name', $user->username)
                    ->where('permissions_name', 'xem phần mềm')
                    ->pluck('software_id');
                $softwareQuery->whereIn('id', $allowedIds);
            }

            $perPage = $request->input('per_page', 15);
            $page = $request->input('page', 1);

            $software = $softwareQuery->paginate($perPage, ['*'], 'page', $page);
            $total = $software->total();

            if ($software->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No software found for your account',
                    'total' => 0,
                    'data' => []
                ], 200);
            }

            return response()->json([
            'status' => 'success',
            'total' => $software->total(),
            'current_page' => $software->currentPage(),
            'last_page' => $software->lastPage(),
            'per_page' => $software->perPage(),
            'data' => $software->items()
        ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve software. ' . $e->getMessage()], 500);
        }
    }

    public function getSoftwareActive(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            if ($user->cannot('viewAny', softwareModel::class)) {
                return response()->json(['status' => 'error', 'message' => 'You do not have permission to view software'], 403);
            }

            $perPage = $request->input('per_page', 15);
            $page = $request->input('page', 1);

            $software = SoftwareModel::where('is_delete', false)
            ->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
            'status' => 'success',
            'total' => $software->total(),
            'current_page' => $software->currentPage(),
            'last_page' => $software->lastPage(),
            'per_page' => $software->perPage(),
            'data' => $software->items()
        ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve software. ' . $e->getMessage()], 500);
        }
    }

    public function getAllSoftwareIsDelte(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            if ($user->cannot('viewAny', softwareModel::class)) {
                return response()->json(['status' => 'error', 'message' => 'You do not have permission to view software'], 403);
            }
            $perPage = $request->input('per_page', 15);
            $page = $request->input('page', 1);

            $software = SoftwareModel::where('is_delete', true)
            ->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'status' => 'success',
                'total' => $software->total(),
                'current_page' => $software->currentPage(),
                'last_page' => $software->lastPage(),
                'per_page' => $software->perPage(),
                'data' => $software->items()
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve software. ' . $e->getMessage()], 500);
        }
    }


    public function getSoftwareByName(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $softwareName = $request->input('softwareName');
            if (!$softwareName) {
                return response()->json(['message' => 'Software name is required'], 400);
            }

            $software = SoftwareModel::where('softwareName', 'like', '%' . $softwareName . '%')->get();
            if ($software->isEmpty()) {
                return response()->json(['message' => 'No software found with that name'], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $software
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve software by name. ' . $e->getMessage()], 500);
        }
    }

    public function deleteSoftware(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $id = $request->query('id');
            if (!$id) {
                return response()->json(['message' => 'Software id is required'], 400);
            }

            $software = SoftwareModel::findOrFail($id);
            $software->is_delete = true; // Mark as deleted
            $software->save();

            // Log the deletion of the software
            LogController::createLogAuto([
                'username' => $user->username,
                'software_id' => $software->id,
                'message' => "User '{$user->fullName}' delete software'{$software->softwareName}.'",
                'is_delete' => false
            ]);

            return response()->json(['message' => 'Software deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Software not found'], 404);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not delete software. ' . $e->getMessage()], 500);
        }
    }
    public function getSoftwareById(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $id = $request->query('id');
            if (!$id) {
                return response()->json(['message' => 'Software id is required'], 400);
            }
            $software = SoftwareModel::where('id', 'like', '%' . $id . '%')->get();
            if ($software->isEmpty()) {
                return response()->json(['message' => 'No software found with that id'], 404);
            }
            return response()->json([
                'status' => 'success',
                'data' => $software[0]
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'ERRRR'], 401);
        }
    }
}
