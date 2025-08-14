<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\hardwareModel;
use App\Models\hardwarePemisssionModel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;



class HardwareController extends Controller
{
    public function createHardware(Request $request)
    {

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Validate the request data
            $request->validate([
                'ip' => 'required|string|max:255',
                'dbname' => 'required|string|max:100|exists:database,dbname',
                'dbversion' => 'required|string|max:100|exists:database_version,version',
                'isVirtualServer' => 'required|boolean',
                'OS' => 'required|string|max:100|exists:os,name',
                'OSver' => 'required|string|max:100|exists:os_version,version',
                'hdd' => 'required|string|max:100',
                'ram' => 'required|string|max:100',
                'services' => 'nullable|string|max:1000',
                'created_by' => $user->username,
            ]);

            // Create a new hardware record
            $hardware = new hardwareModel();
            $hardware->ip = $request->input('ip');
            $hardware->dbname = $request->input('dbname');
            $hardware->dbversion = $request->input('dbversion');
            $hardware->isVirtualServer = $request->input('isVirtualServer');
            $hardware->OS = $request->input('OS');
            $hardware->OSver = $request->input('OSver');
            $hardware->hdd = $request->input('hdd');
            $hardware->ram = $request->input('ram');
            $hardware->services = $request->input('services');
            $hardware->created_by = $user->username;

            // Save the hardware record
            if ($hardware->save()) {

                $fullPermissions = ['xem phần cứng', 'sửa phần cứng', 'xoá phần cứng', 'xem danh sách người dùng quản lý phần cứng', 'thêm người dùng quản lý phần cứng', 'sửa người dùng quản lý phần cứng', 'xoá người dùng quản lý phần cứng'];
                foreach ($fullPermissions as $permission) {
                    hardwarePemisssionModel::create([
                        'hardware_ip' => $hardware->ip,
                        'user_name' => $user->username,
                        'permissions_name' => $permission,
                        'user_createby' => $user->username,
                        'assigned_at' => now(),
                    ]);
                }
                LogController::createLogAuto([
                    'username' => $user->username,
                    'hardware_ip' => $hardware->ip,
                    'message' => "User {$user->fullName} Created new hardware with IP {$hardware->ip}",
                ]);
                return response()->json(['message' => 'Hardware created successfully', 'data' => $hardware], 201);
            } else {
                return response()->json(['message' => 'Failed to create hardware'], 500);
            }

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not create hardware. ' . $e->getMessage()], 500);
        }

    } ///áhdakjsdajkgsdjhavsd

    public function getAllHardware()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                Log::warning('User not authenticated in getAllHardware');
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // if ($user->cannot('list', hardwareModel::class)) {
            // return response()->json(['status' => 'error', 'message' => 'You do not have permission to view hardware'], 403);
            // }

            $isManager = $user->can('viewAny', hardwareModel::class);
            Log::info('Policy check result for viewAny', [
                'username' => $user->username,
                'isManager' => $isManager,
            ]);

            $hardwareQuery = hardwareModel::query();

            // Nếu người dùng không phải là quản lý, chỉ lấy những hardware họ được phép xem
            if (!$isManager) {
                Log::info('User is not a manager, applying specific permissions.', ['username' => $user->username]);

                $allowedIps = DB::table('hardware_permissions')
                    ->where('user_name', $user->username)
                    ->where('permissions_name', 'xem phần cứng')
                    ->pluck('hardware_ip');

                Log::info('Found allowed IPs for user', ['username' => $user->username, 'allowedIps' => $allowedIps->toArray()]);

                $hardwareQuery->whereIn('ip', $allowedIps);
            } else {
                Log::info('User is a manager, will fetch all hardware.', ['username' => $user->username]);
            }

            // Thực thi query và lấy kết quả
            $hardware = $hardwareQuery->get();
            $total = $hardware->count();

            if ($hardware->isEmpty()) {
                Log::warning('Final query returned no hardware for user', ['username' => $user->username, 'isManager' => $isManager]);
                // Trả về danh sách rỗng thay vì lỗi 404, vì đây không phải là một lỗi
                return response()->json(['status' => 'success', 'message' => 'No hardware found for your account', 'total' => 0, 'data' => []], 200);
            }

            Log::info('Successfully retrieved hardware', ['username' => $user->username, 'total' => $total]);

            return response()->json([
                'status' => 'success',
                'total' => $total,
                'data' => $hardware
            ]);

        } catch (TokenExpiredException $e) {
            Log::error('TokenExpiredException in getAllHardware', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            Log::error('TokenInvalidException in getAllHardware', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            Log::error('JWTException in getAllHardware', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            Log::critical('Exception in getAllHardware', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['status' => 'error', 'message' => 'An unexpected error occurred.'], 500);
        }
    }
    //update hardware
    public function updateHardware(Request $request, $ip)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                Log::warning('User not authenticated in updateHardware');
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            if (!$ip) {
                return response()->json(['status' => 'error', 'message' => 'IP (from URL) is required'], 400);
            }

            Log::info('Update hardware request received', [
                'username' => $user->username,
                'requested_ip' => $ip,
                'request_payload' => $request->all()
            ]);

            $hardware = hardwareModel::where('ip', $ip)->first();
            if (!$hardware) {
                Log::warning('Hardware not found for update', ['ip' => $ip]);
                return response()->json(['status' => 'error', 'message' => 'No hardware found'], 404);
            }

            if ($user->cannot('update', $hardware)) {
                Log::warning('User denied update permission by policy', [
                    'username' => $user->username,
                    'hardware_ip' => $hardware->ip
                ]);
                return response()->json(['status' => 'error', 'message' => 'You do not have permission to update this hardware.'], 403);
            }

            $oldData = $hardware->only([
                'ip',
                'dbname',
                'dbversion',
                'isVirtualServer',
                'OS',
                'OSver',
                'hdd',
                'ram',
                'services',
            ]);

            // Cập nhật các trường nếu có truyền lên (bao gồm cả ip mới nếu có)
            $hardware->ip = $request->input('ip', $hardware->ip);
            $hardware->OS = $request->input('OS', $hardware->OS);
            $hardware->OSver = $request->input('OSver', $hardware->OSver);
            $hardware->dbname = $request->input('dbname', $hardware->dbname);
            $hardware->dbversion = $request->input('dbversion', $hardware->dbversion);
            $hardware->isVirtualServer = $request->input('isVirtualServer', $hardware->isVirtualServer);
            $hardware->hdd = $request->input('hdd', $hardware->hdd);
            $hardware->ram = $request->input('ram', $hardware->ram);
            $hardware->services = $request->input('services', $hardware->services);

            $hardware->save();

            $newData = $hardware->only([
                'ip',
                'dbname',
                'dbversion',
                'isVirtualServer',
                'OS',
                'OSver',
                'hdd',
                'ram',
                'services',
            ]);


            // So sánh và tạo chuỗi thay đổi
            $changes = [];
            foreach ($oldData as $key => $oldValue) {
                $newValue = $newData[$key];
                if ($oldValue != $newValue) {
                    $changes[] = "$key: '$oldValue' => '$newValue'";
                }
            }
            $changeString = $changes ? implode(', ', $changes) : 'No changes';

            // Ghi log
            LogController::createLogAuto([
                'username' => $user->username,
                'hardware_ip' => $hardware->ip,
                'message' => "User {$user->fullName} updated hardware with IP {$hardware->ip}. Changes: $changeString",
            ]);

            return response()->json(['message' => 'Hardware updated successfully', 'data' => $hardware]);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not update hardware. ' . $e->getMessage()], 500);
        }
    }
    //delete hardware
    public function deleteHardware(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Lấy IP từ query hoặc body
            $ip = $request->query('ip') ?? $request->input('ip');
            if (!$ip) {
                return response()->json(['status' => 'error', 'message' => 'IP is required'], 400);
            }

            $hardware = hardwareModel::where('ip', $ip)->first();
            if (!$hardware) {
                return response()->json(['status' => 'error', 'message' => 'No hardware found'], 404);
            }

            if ($user->cannot('delete', $hardware)) {
                return response()->json(['status' => 'error', 'message' => 'You do not have permission to delete this hardware.'], 403);
            }

            // Cập nhật is_delete thay vì xóa
            $hardware->is_delete = true;
            $hardware->save();

            LogController::createLogAuto([
                'username' => $user->username,
                'hardware_ip' => $hardware->ip,
                'message' => "User {$user->fullName} marked hardware with IP {$hardware->ip} as deleted",
            ]);

            return response()->json(['message' => 'Hardware marked as deleted successfully']);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not delete hardware. ' . $e->getMessage()], 500);
        }
    }

    public function getHardwareByIP(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $ip = $request->query('ip');
            if (!$ip) {
                return response()->json(['status' => 'error', 'message' => 'IP is required'], 400);
            }

            $hardware = hardwareModel::where('ip', $ip)->first();
            if (!$hardware) {
                return response()->json(['status' => 'error', 'message' => 'No hardware found'], 404);
            }

            return response()->json($hardware);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve hardware. ' . $e->getMessage()], 500);
        }
    }

    public function statisticalHardware(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Chỉ lấy hardware chưa bị xóa
            $baseQuery = hardwareModel::where('is_delete', false);

            // 1. Thống kê máy thực, máy ảo
            $virtualStats = (clone $baseQuery)
                ->groupBy('isVirtualServer')
                ->selectRaw('isVirtualServer, COUNT(*) as total')
                ->get();

            // 2. Thống kê OS (Windows, Linux, ...)
            $osStats = (clone $baseQuery)
                ->groupBy('OS')
                ->selectRaw('OS, COUNT(*) as total')
                ->get();

            // 3. Thống kê database (theo dbname)
            $dbStats = (clone $baseQuery)
                ->groupBy('dbname')
                ->selectRaw('dbname, COUNT(*) as total')
                ->get();

            // 4. Thống kê số máy theo OS version (Windows 10, Windows 11, ...)
            $osVerStats = (clone $baseQuery)
                ->groupBy('OSver')
                ->selectRaw('OSver, COUNT(*) as total')
                ->get();

            // 5. Thống kê version của database
            $dbVerStats = (clone $baseQuery)
                ->groupBy('dbversion')
                ->selectRaw('dbversion, COUNT(*) as total')
                ->get();

            // 6. Thống kê dung lượng HDD
            $hddStats = (clone $baseQuery)
                ->groupBy('hdd')
                ->selectRaw('hdd, COUNT(*) as total')
                ->get();

            // 7. Thống kê RAM
            $ramStats = (clone $baseQuery)
                ->groupBy('ram')
                ->selectRaw('ram, COUNT(*) as total')
                ->get();

            return response()->json([
                'status' => 'success',
                'virtualStats' => $virtualStats,
                'osStats' => $osStats,
                'dbStats' => $dbStats,
                'osVerStats' => $osVerStats,
                'dbVerStats' => $dbVerStats,
                'hddStats' => $hddStats,
                'ramStats' => $ramStats,
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not get hardware statistics. ' . $e->getMessage()], 500);
        }
    }
    public function getHardwareAnalytics(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $from = $request->query('from');
            $to = $request->query('to');
            $fromDate = $from ? Carbon::parse($from)->startOfSecond() : null;
            $toDate = $to ? Carbon::parse($to)->endOfSecond() : null;

            $query = hardwareModel::where('is_delete', false);
            $deletedQuery = hardwareModel::where('is_delete', true);

            if ($fromDate && $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
                $deletedQuery->whereBetween('created_at', [$fromDate, $toDate]);
            }

            $hardware = $query->get();
            $deletedHardwareCount = $deletedQuery->count();

            if ($hardware->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No hardware found',
                    'data' => [],
                    'deletedCount' => $deletedHardwareCount
                ], 200);
            }

            $totalHardware = $hardware->count();
            $virtualHardware = $hardware->where('isVirtualServer', true);
            $physicalHardware = $hardware->where('isVirtualServer', false);

            $virtualCount = $virtualHardware->count();
            $physicalCount = $physicalHardware->count();

            $activeHardware = $hardware->where('is_active', true);
            $activeCount = $activeHardware->count();

            // Tổng HDD
            $totalActiveHddBytes = $activeHardware->reduce(function ($carry, $item) {
                return $carry + $this->convertToBytes($item->hdd);
            }, 0);

            // Tổng HDD máy ảo
            $virtualHddBytes = $virtualHardware->reduce(function ($carry, $item) {
                return $carry + $this->convertToBytes($item->hdd);
            }, 0);

            // Tổng HDD máy vật lý
            $physicalHddBytes = $physicalHardware->reduce(function ($carry, $item) {
                return $carry + $this->convertToBytes($item->hdd);
            }, 0);

            // Tổng RAM (dựa trên field `ram`, giả sử cũng lưu như hdd: "8 GB", "16 MB", etc.)
            $virtualRamBytes = $virtualHardware->reduce(function ($carry, $item) {
                return $carry + $this->convertToBytes($item->ram);
            }, 0);

            $physicalRamBytes = $physicalHardware->reduce(function ($carry, $item) {
                return $carry + $this->convertToBytes($item->ram);
            }, 0);

            $totalRamBytes = $virtualRamBytes + $physicalRamBytes;

            return response()->json([
                'status' => 'success',
                'totalHardware' => $totalHardware,
                'virtualCount' => $virtualCount,
                'physicalCount' => $physicalCount,
                'activeCount' => $activeCount,
                'totalActiveHdd' => $this->formatBytes($totalActiveHddBytes),

                'virtualHdd' => $this->formatBytes($virtualHddBytes),
                'physicalHdd' => $this->formatBytes($physicalHddBytes),

                'virtualRam' => $this->formatBytes($virtualRamBytes),
                'physicalRam' => $this->formatBytes($physicalRamBytes),
                'totalRam' => $this->formatBytes($totalRamBytes),

                'deletedCount' => $deletedHardwareCount,
            ]);

        } catch (TokenExpiredException | TokenInvalidException | JWTException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not get hardware analytics. ' . $e->getMessage()], 500);
        }
    }
    public function getAllHardwareConnectDomain()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                Log::warning('User not authenticated in getAllHardware');
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Truy vấn lấy danh sách phần cứng chưa bị xóa
            $hardwareList = hardwareModel::query()
                ->where('is_delete', false)
                ->select('ip', 'dbname', 'dbversion', 'OS', 'OSver','is_delete')
                ->get();


            if ($hardwareList->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No hardware found for your account',
                    'total' => 0,
                    'data' => []
                ], 200);
            } 

            Log::info('Successfully retrieved hardware', [
                'username' => $user->username,  
            ]);

            return response()->json([
                'status' => 'success', 
                'data' => $hardwareList
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            Log::critical('Exception in getAllHardware', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'An unexpected error occurred.'], 500);
        }
    }
















    private function convertToBytes($value)
    {
        if (!$value)
            return 0;

        $value = trim($value);
        if (preg_match('/^([\d.]+)\s*(KB|MB|GB|TB)$/i', $value, $matches)) {
            $number = (float) $matches[1];
            $unit = strtoupper($matches[2]);
            $multipliers = ['KB' => 1024, 'MB' => 1024 ** 2, 'GB' => 1024 ** 3, 'TB' => 1024 ** 4];
            return $number * ($multipliers[$unit] ?? 1);
        }

        return (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
    }


}