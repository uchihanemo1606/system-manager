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
    // Chỉ cho phép nếu user có quyền xem ít nhất 1 phần mềm
    return DB::table('software_permissions')
        ->where('user_name', $user->username)
        ->where('permissions_name', 'software.list')
        ->exists();
}

    public function view(UserModel $user, softwareModel $software): bool
    {
        return $this->checkSoftwarePermission($user, $software, 'software.list');
    }

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

    public function createPermission(UserModel $user, softwareModel $software): bool
    {
        Log::info('SoftwarePolicy@createPermission: Checking create permission', [
            'username' => $user->username,
            'software_id' => $software->id,
        ]);
        $result = $this->checkSoftwarePermission($user, $software, 'softwarepermission.create');
        Log::info('SoftwarePolicy@createPermission: Result', [
            'username' => $user->username,
            'software_id' => $software->id,
            'result' => $result,
        ]);
        return $result;
    }

    public function editPermission(UserModel $user, softwareModel $software): bool
    {
        Log::info('SoftwarePolicy@editPermission: Checking edit permission', [
            'username' => $user->username,
            'software_id' => $software->id,
        ]);
        $result = $this->checkSoftwarePermission($user, $software, 'softwarepermission.edit');
        Log::info('SoftwarePolicy@editPermission: Result', [
            'username' => $user->username,
            'software_id' => $software->id,
            'result' => $result,
        ]);
        return $result;
    }

    public function deletePermission(UserModel $user, softwareModel $software): bool
    {
        Log::info('SoftwarePolicy@deletePermission: Checking delete permission', [
            'username' => $user->username,
            'software_id' => $software->id,
        ]);
        $result = $this->checkSoftwarePermission($user, $software, 'softwarepermission.delete');
        Log::info('SoftwarePolicy@deletePermission: Result', [
            'username' => $user->username,
            'software_id' => $software->id,
            'result' => $result,
        ]);
        return $result;
    }
// =====================================================================CHECK PERMISSION==================================================================================================

    protected function checkSoftwarePermission(UserModel $user, softwareModel $software, string $routeName): bool
    {
        Log::info('SoftwarePolicy@checkSoftwarePermission: Start', [
            'username' => $user->username,
            'software_id' => $software->id,
            'route_name' => $routeName,
        ]);

        try {
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
        } catch (\Throwable $e) {
            Log::error('SoftwarePolicy@checkSoftwarePermission: Exception', [
                'username' => $user->username,
                'software_id' => $software->id,
                'route_name' => $routeName,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return false;
        }
    }

}