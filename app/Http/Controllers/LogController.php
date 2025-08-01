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
            'database_name',
            'os_name',

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
                'database_name' => 'nullable|string|max:255',
                'os_name' => 'nullable|string|max:255',

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
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not create log. ' . $e->getMessage()], 500);
        }
    }

    public function getAllLogs(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 404);
            }

            $query = logModel::query();
            $page = $request->query('page', 1);
            $perPage = $request->query('per_page', 10);

            // Lọc theo từ khoá nếu có
            $keyword = $request->query('keyword');
            $exact = $request->query('exact');
            if ($keyword) {
                if (!isset($exact) || $exact == 1) {
                    $query->where('message', 'like', '%' . $keyword . '%');
                } else {
                    $keywords = array_filter(explode(' ', trim($keyword)));
                    foreach ($keywords as $kw) {
                        $query->where('message', 'like', '%' . $kw . '%');
                    }
                }
            }

            // Lọc theo các trường liên quan nếu có truyền param
            $filterFields = [
                'software_id',
                'username',
                'software_file_id',
                'hardware_ip',
                'department',
                'permission_name',
                'rule_id',
                'role_id',
                'link_domain',
                'sw_permission_user',
                'hw_permission_user',
            ];

            foreach ($filterFields as $field) {
                if ($request->filled($field)) {
                    $query->where($field, $request->input($field));
                }
            }

            // Nếu chỉ muốn lấy log có trường nào đó khác null (ví dụ: chỉ log hardware)
            $notNullFields = [
                'hardware' => 'hardware_ip',
                'software' => 'software_id',
                'user' => 'username',
                'softwareFile' => 'software_file_id',
                'department' => 'department',
                'permission' => 'permission_name',
                'rule' => 'rule_id',
                'role' => 'role_id',
                'domain' => 'link_domain',
                'softwarePermission' => 'sw_permission_user',
                'hardwarePermission' => 'hw_permission_user',
            ];
            foreach ($notNullFields as $param => $column) {
                if ($request->has($param)) {
                    $query->whereNotNull($column);
                }
            }

            $logs = $query->with([
                'software',
                'user',
                'softwareFile',
                'hardware',
                'department',
                'permission',
                'rule',
                'role',
                'domain',
                'softwarePermission',
                'hardwarePermission',
            ])->paginate($perPage, ['*'], 'page', $page);

            $logsTransformed = $logs->getCollection()->map(function ($log) {
                $data = $log->toArray();
                $data['username'] = $log->user ? $log->user->fullName : $log->username;
                $data['software'] = $log->software ? $log->software->softwareName : $log->software_id;
                $data['software_file'] = $log->softwareFile ? $log->softwareFile->file_name : $log->software_file_id ?? null;
                $data['hardware'] = $log->hardware ? $log->hardware->ip : $log->hardware_ip ?? null;
                $data['department'] = $log->department ? $log->department->name : $log->department ?? null;
                $data['permission'] = $log->permission ? $log->permission->permissions_name : $log->permission_name ?? null;
                unset($data['software_id'], $data['hardware_ip'], $data['software_file_id'], $data['rule_id'], $data['role_id'], $data['permission_name']);
                return $data;
            });

            $logs->setCollection(collect($logsTransformed));

            return response()->json([
                'status' => 'success',
                'total' => $logs->total(),
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'per_page' => $logs->perPage(),
                'data' => $logs->items()
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
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

            $query = logModel::where('is_delete', false);

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

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve logs. ' . $e->getMessage()], 500);
        }

        return response()->json($logs);
    }

    public function getAllLog()
    {
        $logs = logModel::get();
        return response()->json($logs);
    }

    public function getLogById($id)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 404);
            }

            $log = logModel::with([
                'software',
                'user',
                'softwareFile',
                'hardware',
                'department',
                'permission',
                'rule',
                'role',
                'domain',
                'softwarePermission',
                'hardwarePermission',
            ])->find($id);

            if (!$log) {
                return response()->json(['message' => 'Log not found'], 404);
            }

            $data = $log->toArray();

            // Ghi đè các trường id bằng thông tin chi tiết
            $data['username'] = $log->user ? $log->user->fullName : $log->username;
            $data['software'] = $log->software ? $log->software->softwareName : $log->software_id;
            $data['software_file'] = $log->softwareFile ? $log->softwareFile->file_name : $log->software_file_id ?? null;
            $data['hardware'] = $log->hardware ? $log->hardware->ip : $log->hardware_ip ?? null;
            $data['department'] = $log->department ? $log->department->name : $log->department ?? null;
            $data['permission'] = $log->permission ? $log->permission->permissions_name : $log->permission_name ?? null;

            // Nếu muốn show thêm các trường khác, thêm vào đây

            unset($data['software_id']);
            unset($data['hardware_ip']);
            unset($data['software_file_id']);
            unset($data['rule_id']);
            unset($data['role_id']);
            unset($data['permission_name']);

            return response()->json($data);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve log. ' . $e->getMessage()], 500);
        }
    }


    public function getLogsInTime(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Nhận và chuyển đổi định dạng ngày từ d/m/Y sang Y-m-d
            $date = $request->query('date');
            $from = $request->query('from');
            $to = $request->query('to');

            // Hàm chuyển đổi d/m/Y sang Y-m-d
            $convertDate = function ($str) {
                if (!$str)
                    return null;
                $dt = \DateTime::createFromFormat('d/m/Y', $str);
                return $dt ? $dt->format('Y-m-d') : null;
            };

            $date = $convertDate($date);
            $from = $convertDate($from);
            $to = $convertDate($to);

            // $query = logModel::where('is_delete', false);
            $query = logModel::query(); // ✅ Đây là chỗ sửa
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
                ->get();

            if ($logs->isEmpty()) {
                return response()->json(['message' => 'No logs found for this user'], 404);
            }

            return response()->json($logs);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
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
                ->get();

            if ($logs->isEmpty()) {
                return response()->json(['message' => 'No logs found for this hardware IP'], 404);
            }

            return response()->json($logs);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve logs. ' . $e->getMessage()], 500);
        }
    }

    public function getLogBySoftware(Request $request, $softwareId)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 404);
            }

            $logs = logModel::where('software_id', $softwareId)
                ->get();

            if ($logs->isEmpty()) {
                return response()->json(['message' => 'No logs found for this software ID'], 404);
            }

            return response()->json($logs);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve logs. ' . $e->getMessage()], 500);
        }
    }




}
