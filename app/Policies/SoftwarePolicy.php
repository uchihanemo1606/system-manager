<?php

namespace App\Policies;

use App\Models\softwareModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SoftwarePolicy
{
    /**
     * Hằng số cho tên role quản lý để tránh lỗi gõ sai và giúp code dễ bảo trì hơn.
     */
    private const SOFTWARE_MANAGER_ROLE = 'quản lý phần mềm';

    /**
     * Xác định xem người dùng có thể xem danh sách tất cả phần cứng không.
     *
     * @param  \App\Models\UserModel  $user
     * @return bool
     */
    public function viewAny(UserModel $user): bool
    {
        // === BẮT ĐẦU PHẦN GỠ LỖI QUAN TRỌNG ===
        // Lấy danh sách roles từ DB
        $rolesFromDb = DB::table('user_role')
            ->where('username', $user->username)
            ->pluck('role_name');

        // Chuẩn hóa roles: xóa khoảng trắng thừa và chuyển thành chữ thường
        $normalizedRoles = $rolesFromDb->map(function ($roleName) {
            // Quan trọng: Xử lý chuỗi để đảm bảo so sánh chính xác
            return trim(mb_strtolower($roleName, 'UTF-8'));
        });

        // Ghi log chi tiết để gỡ lỗi
        Log::info('softwarePolicy@viewAny: Checking roles', [
            'username' => $user->username,
            'original_roles' => $rolesFromDb->toArray(),      // Vai trò gốc từ DB
            'normalized_roles' => $normalizedRoles->toArray(),  // Vai trò đã được chuẩn hóa
            'role_to_check' => self::SOFTWARE_MANAGER_ROLE, // Vai trò cần kiểm tra
        ]);

        // Kiểm tra xem người dùng có role quản lý không
        $result = $normalizedRoles->contains(self::SOFTWARE_MANAGER_ROLE);

        Log::info('softwarePolicy@viewAny: Result', [
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
     * @param  \App\Models\softwareModel  $software
     * @return bool
     */
    public function view(UserModel $user, softwareModel $software): bool
    {
        // Người dùng có vai trò quản lý thì luôn có quyền xem
        if ($this->viewAny($user)) {
             Log::info('User is manager, allowed to view.', ['username' => $user->username, 'software id' => $software->id]);
             return true;
        }

        // Kiểm tra quyền cụ thể nếu không phải quản lý
        return $this->checkSoftwarePermission($user, $software, 'software.list');
    }

    /**
     * Xác định xem người dùng có thể cập nhật phần cứng không.
     *
     * @param  \App\Models\UserModel  $user
     * @param  \App\Models\softwareModel  $software
     * @return bool
     */
    public function update(UserModel $user, softwareModel $software): bool
{
    Log::info('softwarePolicy@update: Checking update permission', [
        'username' => $user->username,
        'software_id' => $software->id,
    ]);
    $result = $this->checkSoftwarePermission($user, $software, 'software.edit');
    Log::info('SoftwarePolicy@update: Result', [
        'username' => $user->username,
        'software_id' => $software->id,
        'result' => $result,
    ]);
    return $result;
}

public function delete(UserModel $user, softwareModel $software): bool
{
    Log::info('SoftwarePolicy@delete: Checking delete permission', [
        'username' => $user->username,
        'software_id' => $software->id,
    ]);
    $result = $this->checkSoftwarePermission($user, $software, 'software.delete');
    Log::info('SoftwarePolicy@delete: Result', [
        'username' => $user->username,
        'software_id' => $software->id,
        'result' => $result,
    ]);
    return $result;
}

// ...existing code...

    protected function checkSoftwarePermission(UserModel $user, softwareModel $software, string $routeName): bool
    {
        Log::info('SoftwarePolicy@checkSoftwarePermission: Start', [
            'username' => $user->username,
            'software_id' => $software->id,
            'route_name' => $routeName,
        ]);

        // Lấy permissions_name (tên quyền tiếng Việt) từ bảng route_permission
        $permissionName = Cache::remember("permission_name_for_{$routeName}", now()->addHours(1), function () use ($routeName) {
            return DB::table('route_permission')
                ->where('route_name', $routeName)
                ->value('permissions_name');
        });

        Log::info('SoftwarePolicy@checkSoftwarePermission: permissionName', [
            'route_name' => $routeName,
            'permission_name' => $permissionName,
        ]);

        if (!$permissionName) {
            Log::warning("SoftwarePolicy@checkSoftwarePermission: No permission_name found for route", [
                'user' => $user->username,
                'route_name' => $routeName,
            ]);
            return false;
        }

        $hasPermission = DB::table('software_permissions')
            ->where('user_name', $user->username)
            ->where('software_id', $software->id)
            ->where('permissions_name', $permissionName)
            ->exists();

        Log::info('SoftwarePolicy@checkSoftwarePermission: Result', [
            'username' => $user->username,
            'software_id' => $software->id,
            'permission_name' => $permissionName,
            'result' => $hasPermission,
        ]);

        return $hasPermission;
    }
}