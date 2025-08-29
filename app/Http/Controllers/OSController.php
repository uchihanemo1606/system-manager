<?php

namespace App\Http\Controllers;

use App\Models\OSModel;
use App\Models\OSVersionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class OSController extends Controller
{

    public function createOS(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $data = $request->validate([
                'name' => 'required|string|max:100',
                'architecture' => 'required|string|max:50',
                'description' => 'nullable|string|max:255', 
            ]);
            $data['created_by'] = $user->username;
            $os = OSModel::create($data);

            if ($os->save()) {

                LogController::createLogAuto([
                    'username' => $user->username,
                    'os_name' => $os->name,
                    'message' => "{$user->fulllName} đã tạo hệ điều hành {$os->name}",
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Operating System created successfully.',
                    'data' => $os
                ], 201);
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

    public function updateOS(Request $request, $id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $os = OSModel::findOrFail($id);
            $data = $request->validate([
                'name' => 'required|string|max:100',
                'architecture' => 'required|string|max:50',
                'description' => 'nullable|string|max:255',
                'updated_by' => $user->username,
            ]);

            if ($os->update($data)) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'os_name' => $os->name,
                    'message' => "{$user->fulllName} đã cập nhật hệ điều hành {$os->name}",
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Operating System updated successfully.',
                    'data' => $os
                ], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Operating System not found.'
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
                'message' => 'Could not update Operating System. ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteOS($id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $os = OSModel::findOrFail($id);
            if (!$os) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Operating System not found.'
                ], 404);
            }
            $os->is_deleted = true;
            $os->deleted_by = $user->username;
            if ($os->save()) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'os_name' => $os->name,
                    'message' => "{$user->fulllName} đã xóa hệ điều hành {$os->name}",
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Operating System deleted successfully.',
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
                'message' => 'Could not update Operating System. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllOS(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);

            $os = OSModel::paginate($perPage, ['*'], 'page', $page);

            if ($os->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No Operating Systems found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Operating Systems retrieved successfully.',
                'total' => $os->total(),
                'current_page' => $os->currentPage(),
                'last_page' => $os->lastPage(),
                'per_page' => $os->perPage(),
                'data' => $os->items()
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
                'message' => 'Could not retrieve Operating Systems. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getOSActive(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $os = OSModel::where('is_deleted', false)->get();

            if ($os->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No active Operating Systems found.'
                ], 404);
            }

            $perPage = $request->input('per_page', 15);
            $page = $request->input('page', 1);

            $os = OSModel::where('is_deleted', false)->paginate($perPage, ['*'], 'page', $page);
            return response()->json([
                'status' => 'success',
                'message' => 'Active Operating Systems retrieved successfully.',
                'total' => $os->total(),
                'current_page' => $os->currentPage(),
                'last_page' => $os->lastPage(),
                'per_page' => $os->perPage(),
                'data' => $os->items()
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
                'message' => 'Could not retrieve active Operating Systems. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getOSDeleted()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
 

            $os = OSModel::where('is_deleted', true)->get();

            if ($os->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No deleted Operating Systems found.'
                ], 404);
            }

            $perPage = request()->input('per_page', 15);
            $page = request()->input('page', 1);

            $os = OSModel::where('is_deleted', true)->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'status' => 'success',
                'message' => 'Deleted Operating Systems retrieved successfully.',
                'total' => $os->total(),
                'current_page' => $os->currentPage(),
                'last_page' => $os->lastPage(),
                'per_page' => $os->perPage(),
                'data' => $os->items()
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
                'message' => 'Could not retrieve deleted Operating Systems. ' . $e->getMessage()
            ], 500);
        }

    }

    public function getOSByName($name)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $os = OSModel::where('name', 'like', '%' . $name . '%')->get();
            if ($os->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'oop!! operating System not found.'
                ], 404);
            }

            $page = request()->input('page', 1);
            $perPage = request()->input('per_page', 15);
            $os = OSModel::where('name', 'like', '%' . $name . '%')->paginate($perPage, ['*'], 'page', $page);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Operating System retrieved successfully.',
                'total' => $os->total(),
                'current_page' => $os->currentPage(),
                'last_page' => $os->lastPage(),
                'per_page' => $os->perPage(),
                'data' => $os->items()
            ])->setStatusCode(200, 'OK');

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
                'message' => 'Could not retrieve Operating System. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getOSById($id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $os = OSModel::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Operating System retrieved successfully.',
                'data' => $os
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Operating System not found.'
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
                'message' => 'Could not retrieve Operating System. ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================================================OS VERSION============================================================================================

    public function createOSVersion(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $data = $request->validate([
                'os_name' => 'required|string|max:100 |exists:os,name',
                'version' => 'required|string|max:50',
                'version_description' => 'nullable|string|max:255',
                // 'created_by' => $user->username,
            ]);
            $data['created_by'] = $user->username;
            $osVersion = OSVersionModel::create($data);
            if ($osVersion->save()) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'os_name' => $osVersion->os_name,
                    'message' => "{$user->fulllName} đã tạo phiên bản hệ điều hành {$osVersion->version} cho hệ điều hành {$osVersion->os_name}",
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Operating System Version created successfully.',
                    'data' => $osVersion
                ], 201);
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
                'message' => 'Could not create Operating System Version. ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateOSVersion(Request $request, $id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $osVersion = OSVersionModel::findOrFail($id);
            $data = $request->validate([
                'os_name' => 'required|string|max:100 |exists:os,name',
                'version' => 'required|string|max:50',
                'version_description' => 'nullable|string|max:255',
                'updated_by' => $user->username,
            ]);

            if ($osVersion->update($data)) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'os_name' => $osVersion->os_name,
                    'message' => "{$user->fulllName} đã cập nhật phiên bản hệ điều hành {$osVersion->version} cho hệ điều hành {$osVersion->os_name}",
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Operating System Version updated successfully.',
                    'data' => $osVersion
                ], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Operating System Version not found.'
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
                'message' => 'Could not update Operating System Version. ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteOSVersion($id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $osVersion = OSVersionModel::findOrFail($id);
            if (!$osVersion) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Operating System Version not found.'
                ], 404);
            }
            $osVersion->is_deleted = true;
            $osVersion->deleted_by = $user->username;
            if ($osVersion->save()) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'os_name' => $osVersion->os_name,
                    'message' => "{$user->fulllName} đã xóa phiên bản hệ điều hành {$osVersion->version} cho hệ điều hành {$osVersion->os_name}",
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Operating System Version deleted successfully.',
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
                'message' => 'Could not delete Operating System Version. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllOSVersions()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $osVersions = OSVersionModel::get();
            return response()->json([
                'status' => 'success',
                'message' => 'Operating System Versions retrieved successfully.',
                'data' => $osVersions
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
                'message' => 'Could not retrieve Operating System Versions. ' . $e->getMessage()
            ], 500);
        }
    }


    public function getAllVersionOfOS($name)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // $osVersion = OSVersionModel::where('os_name', 'like', '%' . $name . '%')->get();
            $osVersion = OSVersionModel::where('os_name', $name)->get();

            if ($osVersion->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'oop!! Operating System Version not found.'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Operating System Version retrieved successfully.',
                'data' => $osVersion
            ])->setStatusCode(200, 'OK');
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
                'message' => 'Could not retrieve Operating System Version. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllOSVersionByNameActive($name)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $osVersion = OSVersionModel::where('os_name', 'like', '%' . $name . '%')
                ->where('is_delete', false)
                ->get();
            if ($osVersion->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'oop!! Operating System Version not found.'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Operating System Version retrieved successfully.',
                'data' => $osVersion
            ])->setStatusCode(200, 'OK');
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
                'message' => 'Could not retrieve Operating System Version. ' . $e->getMessage()
            ], 500);
        }

    }



}
