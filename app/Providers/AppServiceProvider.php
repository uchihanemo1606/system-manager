<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $permissions = $view->getData()['permissions'] ?? [];
            $permissionsRoute = $view->getData()['permissionsRoute'] ?? [];
            $permissionMap = [
                "user.edit" => "user.update",
                "software.edit" => "software.update",
            ];
            $permissionMapEnd = [
                "edit" => "update",
                "remove" => "delete",
            ];
            $userPermissionCodes = [];
            $userPermissionSource = $permissionsRoute;
            $normalizePermission = function ($code) use ($permissionMap, $permissionMapEnd) {
                // cụ thể
                if (isset($permissionMap[$code])) {
                    return $permissionMap[$code];
                }
                // theo hậu tố
                foreach ($permissionMapEnd as $suffix => $replaceWith) {
                    if (str_ends_with($code, '.' . $suffix)) {
                        return preg_replace('/\.' . preg_quote($suffix, '/') . '$/', '.' . $replaceWith, $code);
                    }
                }
                return $code;
            };
            // Áp dụng
            if (!empty($permissions) && !empty($permissionsRoute)) {
                foreach ($permissions as $permName) {
                    if (isset($permissionsRoute[$permName])) {
                        $routeCodeFromDB = $permissionsRoute[$permName];
                        $standardCode = $normalizePermission($routeCodeFromDB);
                        $userPermissionCodes[] = $standardCode;
                    }
                }
            }
            $view->with('userPermissionCodes', $userPermissionCodes);
            $view->with('userPermissionSource', $userPermissionSource);
            $view->with('permissionsRoute', $permissionsRoute);
            // Dùng được trong Blade directive
            app()->instance('userPermissionCodes', $userPermissionCodes);
        });
        Blade::if('hasPermission', function ($code) {
            $userPermissionCodes = app()->bound('userPermissionCodes') ? app('userPermissionCodes') : [];
            return in_array($code, $userPermissionCodes);
        }); 
    }
}
