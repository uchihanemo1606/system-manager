<?php

namespace App\Policies;

use App\Models\hardwareModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HardwarePolicy
{
    protected function checkHardwarePermission(UserModel $user, hardwareModel $hardware, string $permissionName): bool
    {
        $cacheKey = "route_permission_{$permissionName}";
        $routeName = Cache::remember($cacheKey, now()->addHours(1), fn() =>
            DB::table('route_permission')
                ->where('permissions_name', $permissionName)
                ->value('route_name')
        );

        if (!$routeName) {
            Log::warning("No route_name found for permission: {$permissionName} in route_permission table.", [
                'user' => $user->username,
                'hardware_ip' => $hardware->ip,
            ]);
            return $user->hasPermissionTo($permissionName);
        }

        $hasSpecificRules = DB::table('hardware_permissions')
            ->where('user_name', $user->username)
            ->where('hardware_ip', $hardware->ip)
            ->where('permissions_name', $routeName)
            ->exists();

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
        $hasPermission = DB::table('hardware_permissions')
            ->where('user_name', $user->username)
            ->where('permissions_name', 'hardware.list')
            ->exists();

        // níu trú là quản lý phầng kứng thì no one can't stop you
        $roles = DB::table('user_role')->where('username', $user->username)->pluck('role_name')->map(function($r) {
            return mb_strtolower($r, 'UTF-8');
        });
        if ($roles->contains('quản lý phần cứng')) {
            return true;
        }

        return $hasPermission;
    }

    public function view(UserModel $user, hardwareModel $hardware): bool
    {
        return $this->checkHardwarePermission($user, $hardware, 'hardware.get'| 'hardware.list');
    }

    public function update(UserModel $userModel, hardwareModel $hardware): bool
    {
        return $this->checkHardwarePermission($userModel, $hardware, 'hardware.edit');
    }

    public function delete(UserModel $userModel, hardwareModel $hardware): bool
    {
        return $this->checkHardwarePermission($userModel, $hardware, 'hardware.delete');
    }
}