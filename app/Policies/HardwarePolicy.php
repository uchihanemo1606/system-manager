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
        return $this->checkHardwarePermission($user, $hardware, 'hardware.get');
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
        return $this->checkHardwarePermission($user, $hardware, 'hardware.edit');
    }

    /**
     * Xác định xem người dùng có thể xóa phần cứng không.
     *
     * @param  \App\Models\UserModel  $user
     * @param  \App\Models\hardwareModel  $hardware
     * @return bool
     */
    public function delete(UserModel $user, hardwareModel $hardware): bool
    {
        return $this->checkHardwarePermission($user, $hardware, 'hardware.delete');
    }

    /**
     * Hàm kiểm tra quyền truy cập phần cứng dựa trên bảng hardware_permissions.
     *
     * @param  \App\Models\UserModel  $user
     * @param  \App\Models\hardwareModel  $hardware
     * @param  string  $permissionName
     * @return bool
     */
    protected function checkHardwarePermission(UserModel $user, hardwareModel $hardware, string $permissionName): bool
    {
        Log::info('Checking specific hardware permission', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'permission' => $permissionName,
        ]);

        $cacheKey = "route_permission_{$permissionName}";
        $routeName = Cache::remember($cacheKey, now()->addHours(1), function () use ($permissionName) {
            return DB::table('route_permission')
                ->where('permissions_name', $permissionName)
                ->value('route_name');
        });

        if (!$routeName) {
            Log::warning("No route_name found for permission: {$permissionName}", [
                'user' => $user->username,
            ]);
            return false;
        }

        $hasPermission = DB::table('hardware_permissions')
            ->where('user_name', $user->username)
            ->where('hardware_ip', $hardware->ip)
            ->where('permissions_name', $routeName)
            ->exists();

        Log::info('Specific hardware permission result', [
            'username' => $user->username,
            'hardware_ip' => $hardware->ip,
            'result' => $hasPermission,
        ]);

        return $hasPermission;
    }
}
