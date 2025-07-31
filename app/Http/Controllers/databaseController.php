<?php

namespace App\Http\Controllers;

use App\Models\databaseModel;
use App\Models\databaseVersionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class databaseController extends Controller
{
    public function createDatabase(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            // $data = $request->validate([
            //     'dbname' => 'required|string|max:255',
            //     'description' => 'nullable|string|max:1000',
            //     'created_by' =>  $user->username,
            // ]);
            $data = $request->validate([
                'dbname' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            // Thêm created_by vào sau khi validate
            $data['created_by'] = $user->username;
            $database = databaseModel::create($data);

            if ($database->save()) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'database_name' => $database->dbname,
                    'message' => "$user->fullName đã thêm một cơ sở dữ liệu mới: $database->dbname",
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Operating System created successfully.',
                    'data' => $database
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


    public function updateDatabase(Request $request, $id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $database = databaseModel::findOrFail($id);
            $data = $request->validate([
                'dbname' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            if ($database->update($data)) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'database_name' => $database->dbname,
                    'message' => "$user->fullName đã cập nhật cơ sở dữ liệu: $database->dbname",
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Database updated successfully.',
                    'data' => $database
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
                'message' => 'Could not update permission. ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteDatabase($id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $database = databaseModel::findOrFail($id);
            $database->is_delete = true;

            if ($database->save()) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'database_name' => $database->dbname,
                    'message' => "$user->fullName đã xóa cơ sở dữ liệu: $database->dbname",
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Database deleted successfully.',
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

    public function getAllDatabases()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $databases = databaseModel::get();
            return response()->json([
                'status' => 'success',
                'data' => $databases
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
                'message' => 'Could not retrieve databases. ' . $e->getMessage()
            ], 500);
        }
    }


    public function getDatabaseActive()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $databases = databaseModel::where('is_delete', false)->get();
            return response()->json([
                'status' => 'success',
                'data' => $databases
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
                'message' => 'Could not retrieve active databases. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllDatabaseDetele()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $databases = databaseModel::where('is_delete', true)->get();
            return response()->json([
                'status' => 'success',
                'data' => $databases
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
                'message' => 'Could not retrieve deleted databases. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDatabaseById($id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $database = databaseModel::findOrFail($id);

            // Lấy toàn bộ phiên bản của database này
            $versions = databaseVersionModel::where('dbname', $database->dbname)
                ->where('is_delete', false)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'database' => $database,
                    'versions' => $versions
                ]
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
                'message' => 'Could not retrieve database and versions. ' . $e->getMessage()
            ], 500);
        }
    }

    public function createDatabaseVersion(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // $data = $request->validate([
            //     'dbname' => 'required|string|exits:database,dbname',
            //     'version' => 'required|string|max:100',
            //     'decription' => 'nullable|string|max:1000',
            //     'created_by' => $user->username,
            // ]);
            // $databaseVersion = databaseVersionModel::create($data);

            $data = $request->validate([
                'dbname' => 'required|string|exists:database,dbname',
                'version' => 'required|string|max:100',
                'description' => 'nullable|string|max:1000',
            ]);

            // Thêm created_by sau khi validate
            $data['created_by'] = $user->username;

            $databaseVersion = databaseVersionModel::create($data);
            if ($databaseVersion->save()) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'database_name' => $databaseVersion->dbname,
                    'message' => "$user->fullName đã thêm một phiên bản cơ sở dữ liệu mới: $databaseVersion->dbname - $databaseVersion->version",
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Database version created successfully.',
                    'data' => $databaseVersion
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
                'message' => 'Could not create database version. ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateDatabaseVersion(Request $request, $id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $databaseVersion = databaseVersionModel::findOrFail($id);
            $data = $request->validate([
                'version' => 'required|string|max:100',
                'decription' => 'nullable|string|max:1000',
            ]);

            $databaseVersion->update($data);

            LogController::createLogAuto([
                'username' => $user->username,
                'database_name' => $databaseVersion->dbname,
                'message' => "$user->fullName đã cập nhật một phiên bản cơ sở dữ liệu: $databaseVersion->dbname - $databaseVersion->version",
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Database version updated successfully.',
                'data' => $databaseVersion
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
                'message' => 'Could not update database version. ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteDatabaseVersion($id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $databaseVersion = databaseVersionModel::findOrFail($id);
            $databaseVersion->is_delete = true;

            if ($databaseVersion->save()) {
                LogController::createLogAuto([
                    'username' => $user->username,
                    'database_name' => $databaseVersion->dbname,
                    'message' => "$user->fullName đã xóa một phiên bản cơ sở dữ liệu: $databaseVersion->dbname - $databaseVersion->version",
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Database version deleted successfully.',
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
                'message' => 'Could not delete database version. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllDatabaseVersions()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $databaseVersions = databaseVersionModel::get();
            return response()->json([
                'status' => 'success',
                'data' => $databaseVersions
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
                'message' => 'Could not retrieve database versions. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDatabaseVersionById($id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $databaseVersion = databaseVersionModel::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $databaseVersion
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
                'message' => 'Could not retrieve database version. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllDatabaseVersionsByDatabaseName($dbname)
    {
        try
        {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            
            $databaseVersions = databaseVersionModel::where('dbname', $dbname)->get();
            return response()->json([
                'status' => 'success',
                'data' => $databaseVersions
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
                'message' => 'Could not retrieve database versions by name. ' . $e->getMessage()
            ], 500);
        }   
    }

}
