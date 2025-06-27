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
use Illuminate\Support\Facades\Log;



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
            'dbname' => 'required|string|max:100',
            'dbversion' => 'required|string|max:100',
            'isVirtualServer' => 'required|boolean',
            'OS' => 'required|string|max:100',
            'OSver' => 'required|string|max:100',
            'hdd' => 'required|string|max:100',
            'ram'=> 'required|string|max:100',
            'services' => 'nullable|string|max:1000',
            'created_by'=> $user->username,
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
            LogController::createLogAuto([
                'username' => $user->username,
                'hardware_ip' => $hardware->ip,
                'message' => "User {$user->username} Created new hardware with IP {$hardware->ip}",
            ]);
            return response()->json(['message' => 'Hardware created successfully', 'data' => $hardware], 201);
        } else {
            return response()->json(['message' => 'Failed to create hardware'], 500);
        }
        
        }catch (TokenExpiredException $e) {
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

            // Sử dụng policy để kiểm tra người dùng có phải là quản lý phần cứng không
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
                    ->where('permissions_name', 'hardware.get') // Lấy quyền xem
                    ->pluck('hardware_ip');

                Log::info('Found allowed IPs for user', ['username' => $user->username, 'allowedIps' => $allowedIps->toArray()]);

                // Query sẽ chỉ lấy các hardware có IP nằm trong danh sách được phép.
                // Nếu $allowedIps rỗng, query sẽ không trả về kết quả nào (đây là hành vi đúng).
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
    public function updateHardware(Request $request)
    {
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            Log::warning('User not authenticated in updateHardware');
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

        $ip = $request->query('ip') ?? $request->input('ip');
        Log::info('Update hardware request received', [
            'username' => $user->username,
            'requested_ip' => $ip,
            'request_payload' => $request->all() // Log toàn bộ payload để debug
        ]);

        if (!$ip) {
            return response()->json(['status' => 'error', 'message' => 'IP is required'], 400);
        }

        $hardware = hardwareModel::where('ip', $ip)->first();
        if (!$hardware) {
            Log::warning('Hardware not found for update', ['ip' => $ip]);
            return response()->json(['status' => 'error', 'message' => 'No hardware found'], 404);
        }

        // --- THÊM LOG TRƯỚC KHI CHECK POLICY ---
        Log::info('Checking update permission for hardware', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip
        ]);
        // ----------------------------------------

        if ($user->cannot('update', $hardware)) {
            // --- THÊM LOG NẾU KHÔNG CÓ QUYỀN ---
            Log::warning('User denied update permission by policy', [
                'username' => $user->username,
                'hardware_ip' => $hardware->ip
            ]);
            // -----------------------------------
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


        // Cập nhật các trường nếu có truyền lên
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
            'message' => "User {$user->username} updated hardware with IP {$hardware->ip}. Changes: $changeString",
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

        // Lấy ip từ query hoặc body
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

        $hardware->delete();

        LogController::createLogAuto([
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'message' => "User {$user->username} deleted hardware with IP {$hardware->ip}",
        ]);

        return response()->json(['message' => 'Hardware deleted successfully']);
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
        try{
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

    
}

