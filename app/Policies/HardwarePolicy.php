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
        $rolesFromDb = DB::table('user_role')
            ->where('username', $user->username)
            ->pluck('role_name');

        // Chuẩn hóa roles: xóa khoảng trắng thừa và chuyển thành chữ thường
        $normalizedRoles = $rolesFromDb->map(function ($roleName) {
            // Quan trọng: Xử lý chuỗi để đảm bảo so sánh chính xác
            return trim(mb_strtolower($roleName, 'UTF-8'));
        });

        // Ghi log chi tiết để gỡ lỗi
        Log::info('HardwarePolicy@viewAny: Checking roles', [
            'username' => $user->username,
            'original_roles' => $rolesFromDb->toArray(),      // Vai trò gốc từ DB
            'normalized_roles' => $normalizedRoles->toArray(),  // Vai trò đã được chuẩn hóa
            'role_to_check' => self::HARDWARE_MANAGER_ROLE, // Vai trò cần kiểm tra
        ]);

        // Kiểm tra xem người dùng có role quản lý không
        $result = $normalizedRoles->contains(self::HARDWARE_MANAGER_ROLE);

        Log::info('HardwarePolicy@viewAny: Result', [
            'username' => $user->username,
            'has_manager_role' => $result,
        ]);
        // === KẾT THÚC PHẦN GỠ LỖI QUAN TRỌNG ===

        return $result;
    }

    /**
     * Xác định xem người dùng có thể xem một phần cứng cụ thể không.
     *
     * @param  \App\Models\UserModel  $user
     * @param  \App\Models\hardwareModel  $hardware
     * @return bool
     */
    public function view(UserModel $user, hardwareModel $hardware): bool
    {
        // Người dùng có vai trò quản lý thì luôn có quyền xem
        if ($this->viewAny($user)) {
             Log::info('User is manager, allowed to view.', ['username' => $user->username, 'hardware_ip' => $hardware->ip]);
             return true;
        }

        // Kiểm tra quyền cụ thể nếu không phải quản lý
        return $this->checkHardwarePermission($user, $hardware, 'hardware.list');
    }

    /**
     * Xác định xem người dùng có thể cập nhật phần cứng không.
     *
     * @param  \App\Models\UserModel  $user
     * @param  \App\Models\hardwareModel  $hardware
     * @return bool
     */
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

// =================================================PERMISSION==================================================
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