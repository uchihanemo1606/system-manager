<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function getUserPermissions($username)
    {
        Cache::forget('user_permissions_' . $username);
        $cacheKey = 'user_permissions_' . $username;
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($username) {
            $userRoles = DB::table('user_role')->where('username', $username)->pluck('role_name')->all();
            if (empty($userRoles)) {
                return [];
            }
            return DB::table('role_permissions')
                ->whereIn('role_name', $userRoles)
                ->pluck('permission_name')
                ->unique()
                ->all();
        });
    }

    public function getRequiredPermission($routeName)
    {
        $routePermissions = config('permissions.route_permissions', []);
        $defaultActions = config('permissions.default_actions', []);

        // Ưu tiên override từ bảng route_permission
        $cacheKeyRouteOverride = 'route_override_permission_' . $routeName;
        $permissionOverride = Cache::remember($cacheKeyRouteOverride, now()->addHours(1), function () use ($routeName) {
            return DB::table('route_permission')
                ->where('route_name', $routeName)
                ->value('permissions_name');
        });

        $requiredPermission = $permissionOverride ?: ($routePermissions[$routeName] ?? null);

        if (!$requiredPermission) {
            $parts = explode('.', $routeName);
            if (count($parts) >= 2) {
                $resource = $parts[0];
                $action = $parts[1];
                $standardizedAction = $defaultActions[strtolower($action)] ?? null;
                if ($standardizedAction) {
                    $requiredPermission = "{$resource}.{$standardizedAction}";
                }
            }
        }

        return $requiredPermission;
    }
}