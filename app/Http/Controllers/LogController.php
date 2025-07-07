<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logModel; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LogController extends Controller
{
    public static function createLogAuto(array $data)
    {
        $fields = [
            'username',
            'software_id',
            'hardware_ip',
            'rule_id',
            'message',
            'software_file_id',
            'link_domain',
            'sw_permission_user',
            'hw_permission_user',
            'permission_name',
            'department',

        ];
         $logData = array_intersect_key($data, array_flip($fields));

    // Thiết lập mặc định cho is_delete nếu chưa có
    try {
        logModel::create($logData);
    } catch (\Exception $e) {
        // Ghi log lỗi vào laravel.log để dễ debug
        Log::error('Log ghi không thành công: ' . $e->getMessage(), $logData);
    }
    }

    public function createLogManual(Request $request)
    {

        try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['please login to use the function'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|max:255',
            'software_id' => 'nullable|integer',
            'hardware_ip' => 'nullable|string|max:255',
            'rule_id' => 'nullable|integer',
            'message' => 'nullable|string|max:1000',
            'software_file_id' => 'nullable|integer',
            'link_domain' => 'nullable|string|max:255',
            'sw_permission_user' => 'nullable|string|max:255',
            'hw_permission_user' => 'nullable|string|max:255',
            'permissions_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $logData = $validator->validated();
        try {
            logModel::create($logData);
            return response()->json(['message' => 'Log created successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Log creation failed: ' . $e->getMessage(), $logData);
            return response()->json(['error' => 'Log creation failed'], 500);
        } 
        } catch (TokenExpiredException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not create log. ' . $e->getMessage()], 500);
        }
    }

    public function getAllLogs(Request $request)
    {   try
        {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 404);
        }

        $logs = logModel::all();
        return response()->json($logs);

        } catch (TokenExpiredException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve logs. ' . $e->getMessage()], 500);
        }
    }

    public function getLogByType(Request $request)
    {
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 404);
        }

    $query = logModel::query();

    if ($request->has('hardware')) {
        $query->whereNotNull('hardware_ip');
    } elseif ($request->has('software')) {
        $query->whereNotNull('software_id');
    } elseif ($request->has('software_file')) {
        $query->whereNotNull('software_file_id');
    } else {
        // Log user: các trường hardware_ip, software_id, software_file_id đều null
        $query->whereNull('hardware_ip')
              ->whereNull('software_id')
              ->whereNull('software_file_id');
    }

    $logs = $query->get();

    if ($logs->isEmpty()) {
        return response()->json(['message' => 'No logs found for this type'], 404);
    }

    }catch (TokenExpiredException $e) {
        return response()->json(['status'=> 'error', 'message' => 'Token has expired.'], 401);
    } catch (TokenInvalidException $e) {
        return response()->json(['status'=> 'error', 'message' => 'Token is invalid.'], 401);
    } catch (JWTException $e) {
        return response()->json(['status'=> 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Could not retrieve logs. ' . $e->getMessage()], 500);
    }

    return response()->json($logs);
    }

    public function getAllLog()
    {
        $logs = logModel::all();
        return response()->json($logs);
    }

    public function getLogById($id)
    {
        $log = logModel::find($id);
        // if (!$log || $log->is_delete) {
        //     return response()->json(['message' => 'Log not found'], 404);
        // }
        return response()->json($log);
    }


    public function getLogsInTime(Request $request)
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

            $query = logModel::query();

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

            $logs = $query->get();

            return response()->json([
                'status' => 'success',
                'logs' => $logs,
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
                'message' => 'Could not retrieve logs. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getLogCreateByUser(Request $request, $username)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 404);
            }

            if (!$username) {
                return response()->json(['message' => 'Username is required'], 400);
            }

            $logs = logModel::where('username', $username)
                // ->where('is_delete', false)
                ->get();

            if ($logs->isEmpty()) {
                return response()->json(['message' => 'No logs found for this user'], 404);
            }

            return response()->json($logs);
        } catch (TokenExpiredException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve logs. ' . $e->getMessage()], 500);
        }
    }

    public function getLogByHardwarer(Request $request, $hardwareIP)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 404);
            }

            $logs = logModel::where('hardware_ip', $hardwareIP)
                ->where('is_delete', false)
                ->get();

            if ($logs->isEmpty()) {
                return response()->json(['message' => 'No logs found for this hardware IP'], 404);
            }

            return response()->json($logs);
        } catch (TokenExpiredException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve logs. ' . $e->getMessage()], 500);
        }
    }

    public function getLogBySoftware(Request $request, $softwareId)
    {
        try
        {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 404);
            }

            $logs = logModel::where('software_id', $softwareId)
                ->where('is_delete', false)
                ->get();

            if ($logs->isEmpty()) {
                return response()->json(['message' => 'No logs found for this software ID'], 404);
            }

            return response()->json($logs);
        } catch (TokenExpiredException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status'=> 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve logs. ' . $e->getMessage()], 500);
        }
    }



}
