<?php

namespace App\Policies;

use App\Models\hardwareModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HardwarePolicy
{
    /**
     * Hằng số cho tên role quản lý để tránh lỗi gõ sai và giúp code dễ bảo trì hơn.
     */
    private const HARDWARE_MANAGER_ROLE = 'quản lý phần cứng';

    /**
     * Xác định xem người dùng có thể xem danh sách tất cả phần cứng không.
     *
     * @param  \App\Models\UserModel  $user
     * @return bool
     */
    public function viewAny(UserModel $user): bool
    {
        // Chỉ cho phép nếu user có quyền xem ít nhất 1 phần cứng
        return DB::table('hardware_permissions')
            ->where('user_name', $user->username)
            ->where('permissions_name', 'hardware.list')
            ->exists();
    }
    public function isManager(UserModel $user): bool
    {
        return DB::table('user_roles')
            ->where('user_name', $user->username)
            ->where('role_permission', 'xem chi tiết hệ thống')
            ->exists();
    }
    public function view(UserModel $user, hardwareModel $hardware): bool
    {
        return $this->checkHardwarePermission($user, $hardware, 'hardware.list');
    }

    public function update(UserModel $user, hardwareModel $hardware): bool
    {
        Log::info('HardwarePolicy@update: Checking update permission', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
        ]);
        $result = $this->checkHardwarePermission($user, $hardware, 'hardware.edit');
        Log::info('HardwarePolicy@update: Result', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'result' => $result,
        ]);
        return $result;
    }

    public function delete(UserModel $user, hardwareModel $hardware): bool
    {
        Log::info('HardwarePolicy@delete: Checking delete permission', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
        ]);
        $result = $this->checkHardwarePermission($user, $hardware, 'hardware.delete');
        Log::info('HardwarePolicy@delete: Result', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'result' => $result,
        ]);
        return $result;
    }

    // ================= PERMISSION =================

    public function createPermission(UserModel $user, hardwareModel $hardware): bool
    {
        Log::info('HardwarePolicy@createPermission: Checking create permission', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
        ]);
        $result = $this->checkHardwarePermission($user, $hardware, 'hardwarepermission.create');
        Log::info('HardwarePolicy@createPermission: Result', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'result' => $result,
        ]);
        return $result;
    }

    public function editPermission(UserModel $user, hardwareModel $hardware): bool
    {
        Log::info('HardwarePolicy@editPermission: Checking edit permission', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
        ]);
        $result = $this->checkHardwarePermission($user, $hardware, 'hardwarepermission.edit');
        Log::info('HardwarePolicy@editPermission: Result', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'result' => $result,
        ]);
        return $result;
    }

    public function deletePermission(UserModel $user, hardwareModel $hardware): bool
    {
        Log::info('HardwarePolicy@deletePermission: Checking delete permission', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
        ]);
        $result = $this->checkHardwarePermission($user, $hardware, 'hardwarepermission.delete');
        Log::info('HardwarePolicy@deletePermission: Result', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'result' => $result,
        ]);
        return $result;
    }

// =========================================================CHECK PERMISSION==================================================

    protected function checkHardwarePermission(UserModel $user, hardwareModel $hardware, string $routeName): bool
    {
        Log::info('HardwarePolicy@checkHardwarePermission: Start', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'route_name' => $routeName,
        ]);

        // Lấy permissions_name (tên quyền tiếng Việt) từ bảng route_permission
        $permissionName = Cache::remember("permission_name_for_{$routeName}", now()->addHours(1), function () use ($routeName) {
            return DB::table('route_permission')
                ->where('route_name', $routeName)
                ->value('permissions_name');
        });

        Log::info('HardwarePolicy@checkHardwarePermission: permissionName', [
            'route_name' => $routeName,
            'permission_name' => $permissionName,
        ]);

        if (!$permissionName) {
            Log::warning("HardwarePolicy@checkHardwarePermission: No permission_name found for route", [
                'user' => $user->username,
                'route_name' => $routeName,
            ]);
            return false;
        }

        $hasPermission = DB::table('hardware_permissions')
            ->where('user_name', $user->username)
            ->where('hardware_ip', $hardware->ip)
            ->where('permissions_name', $permissionName)
            ->exists();

        Log::info('HardwarePolicy@checkHardwarePermission: Result', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'permission_name' => $permissionName,
            'result' => $hasPermission,
        ]);

        return $hasPermission;
    }
}