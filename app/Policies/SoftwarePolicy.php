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
     * Kiểm tra quyền trên phần cứng dựa trên route_name trong bảng route_permission.
     */
    protected function checkSoftwarePermission(UserModel $user, softwareModel $software, string $permissionName): bool
    {
        // 1. Tìm route_name tương ứng với permissions_name từ bảng route_permission
        // Sử dụng cache để tối ưu hóa truy vấn
        $cacheKey = "route_permission_{$permissionName}";
        $routeName = Cache::remember($cacheKey, now()->addHours(1), function () use ($permissionName) {
            return DB::table('route_permission')
                ->where('permissions_name', $permissionName)
                ->value('route_name');
        });

        // 2. Nếu không tìm thấy route_name, ghi log và fallback
        if (!$routeName) {
            Log::warning("No route_name found for permission: {$permissionName} in route_permission table.", [
                'user' => $user->username,
                'software_id' => $software->ip,
            ]);
            return $user->hasPermissionTo($permissionName); // Fallback về quyền chung
        }

        // 3. Kiểm tra xem có quy tắc cụ thể trong bảng software_permissions
        // với route_name thay vì permissions_name
        $hasSpecificRules = DB::table('software_permissions')
            ->where('user_name', $user->username)
            ->where('software_id', $software->ip)
            ->where('permissions_name', $routeName) // Kiểm tra route_name
            ->exists();

        // 4. Nếu có quy tắc cụ thể, trả về true
        if ($hasSpecificRules) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserModel $user): bool
    {
        $hasPermission = DB::table('software_permissions')
            ->where('user_name', $user->username)
            ->where('permissions_name', 'software.list')
            ->exists();

        // níu trú là quản lý phầng kứng thì no one can't stop you
        $roles = DB::table('user_role')->where('username', $user->username)->pluck('role_name')->map(function($r) {
            return mb_strtolower($r, 'UTF-8');
        });
        if ($roles->contains('quản lý phần mềm' | 'software manager')) {
            return true;
        }

        return $hasPermission;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserModel $user, softwareModel $software): bool
    {
        return $this->checkSoftwarePermission($user, $software, 'software.view');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserModel $userModel, softwareModel $software): bool
    {
        return $this->checkSoftwarePermission($userModel, $software, 'software.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserModel $userModel, softwareModel $software): bool
    {
        return $this->checkSoftwarePermission($userModel, $software, 'software.delete');
    }
}