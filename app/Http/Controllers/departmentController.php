<?php

namespace App\Http\Controllers;

use App\Models\departmentModel;
use App\Models\UserModel;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class departmentController extends Controller
{
    public function createDepartment(Request $request)
    {
       try{
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $request->validate( [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);
            $department = new departmentModel();
            $department->name = $request->input('name');
            $department->description = $request->input('description');
            $department->created_by = $user->id;
            $department->created_at = now();
            $department->updated_at = now();
            
            if($department->save()){
                LogController::createLogAuto([
                'username' => $user->username,
                'department' => $department->name,
                'message' => "{$user->fullName} ở phòng ban {$user->department} đã tạo một phòng ban mới {$department->name}",
            ]);
            return response()->json(['message' => 'Hardware created successfully', 'data' => $department], 201);
        } else {
            return response()->json(['message' => 'Failed to create hardware'], 500);
        }

       }  catch (TokenExpiredException $e) {
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
                'message' => 'Could not create user. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllDepartmentIsActive()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $departments = departmentModel::where('is_delete', false)->get();
            return response()->json([
                'count' => $departments->count(),
                'data' => $departments,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve departments. ' . $e->getMessage()], 500);
        }
    }

    public function getAllDepartmentIsDelete()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $departments = departmentModel::where('is_delete', true)->get();
            return response()->json([
                'count' => $departments->count(),
                'data' => $departments,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve departments. ' . $e->getMessage()], 500);
        }
    }

    public function getAllDepartments()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $departments = departmentModel::all();
            return response()->json([
                'count' => $departments->count(),
                'data' => $departments,
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
                'message' => 'Could not retrieve departments. ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateDepartment(Request $request, departmentModel $department)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
            ]);

            $department = departmentModel::findOrFail($department);
            $department->name = $request->input('name', $department->name);
            $department->description = $request->input('description', $department->description);
            $department->updated_at = now();
            
            if ($department->save()) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'department' => $department->name,
                    'message' => "{$user->fullName} đã cập nhật phòng ban {$department->name}",
                ]);
                return response()->json(['message' => 'Department updated successfully', 'data' => $department], 200);
            } else {
                return response()->json(['message' => 'Failed to update department'], 500);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not update department. ' . $e->getMessage()], 500);
        }
    }


    public function deleteDepartment($department)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $department = departmentModel::findOrFail($department);
            $department->is_delete = true;
            $department->save();
            
            LogController::createLogAuto([
                'username' => $user->username,
                'department' => $department->name,
                'message' => "{$user->fullName} đã xóa phòng ban {$department->name}",
            ]);
            
            return response()->json(['message' => 'Department deleted successfully'], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not delete department. ' . $e->getMessage()], 500);
        }
    }

    public function getUserInDepartment($departmentName)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $users = departmentModel::where('name', $departmentName)
                ->with(['users' => function ($query) {
                    $query->select('username', 'fullName', 'department');
                }])
                ->firstOrFail()
                ->users;
                
            return response()->json([
                'count' => $users->count(),
                'data' => $users,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve users in department. ' . $e->getMessage()], 500);
        }
    }


    public function addUserToDepartment(Request $request, $departmentName)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $request->validate([
                'usernames' => 'required|array',
                'usernames.*' => 'string|max:255',
            ]);
            $department = departmentModel::where('name', $departmentName)->firstOrFail();

            $usernames = $request->input('usernames');
            $updated = 0;
            foreach ($usernames as $username) {
                $userToAdd = UserModel::where('username', $username)->first();
                if ($userToAdd) {
                    $userToAdd->department = $departmentName;
                    $userToAdd->save();
                    $updated++;
                }
            }

            LogController::createLogAuto([
                'username' => $user->username,
                'department' => $departmentName,
                'message' => "{$user->fullName} đã thêm {$updated} người dùng vào phòng ban {$departmentName}",
            ]);

            return response()->json(['message' => "Added $updated users to department successfully"], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not add users to department. ' . $e->getMessage()], 500);
        }
    }

    public function removeUserFromDepartment(Request $request, $departmentName)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $request->validate([
                'usernames' => 'required|array',
                'usernames.*' => 'string|max:255',
            ]);
            $department = departmentModel::where('name', $departmentName)->firstOrFail();

            $usernames = $request->input('usernames');
            $updated = 0;
            foreach ($usernames as $username) {
                $userToRemove = UserModel::where('username', $username)->first();
                if ($userToRemove) {
                    $userToRemove->department = null;
                    $userToRemove->save();
                    $updated++;
                }
            }

            LogController::createLogAuto([
                'username' => $user->username,
                'department' => $departmentName,
                'message' => "{$user->fullName} đã xóa {$updated} người dùng khỏi phòng ban {$departmentName}",
            ]);

            return response()->json(['message' => "Removed $updated users from department successfully"], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not remove users from department. ' . $e->getMessage()], 500);
        }
    }

    public function getDepartmentByName($departmentName)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $departments = departmentModel::where('name', 'like', "%$departmentName%")->get();
                if ($departments->isEmpty()) {
                    return response()->json(['message' => 'Department not found'], 404);
                }
            return response()->json(['data' => $departments], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve department. ' . $e->getMessage()], 500);
        }
    }
}
