<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Services\PermissionService;
use App\Models\permissionModel; // Thêm lại để kiểm tra tồn tại
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not authenticated.'], 401);
            }

            $userPermissions = $this->permissionService->getUserPermissions($user->username);
            if (empty($userPermissions)) {
                return response()->json(['status' => 'error', 'message' => 'User has no roles assigned.'], 403);
            }

            $routeName = Route::currentRouteName();
            if (!$routeName) {
                $incidentId = uniqid('ROUTE_NAME_ERR_');
                Log::critical("Unnamed Route Accessed - Incident ID: {$incidentId}", [
                    'url' => $request->fullUrl(),
                    'user' => $user->username,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
                return response()->json([
                    'status' => 'config_error',
                    'message' => 'A critical configuration error occurred. Please contact support.',
                    'incident_id' => $incidentId,
                    'reference_note' => 'Route for this action is not properly named.'
                ], 500);
            }

            $requiredPermission = $permission ?: $this->permissionService->getRequiredPermission($routeName);

            if (!$requiredPermission) {
                Log::error("Permission for route '{$routeName}' could not be determined.", ['user' => $user->username]);
                return response()->json([
                    'status' => 'error',
                    'message' => "Access Denied: Permission for the requested action ('{$routeName}') is not configured or could not be inferred."
                ], 403);
            }

            // Kiểm tra tồn tại permission trong database
            if (!permissionModel::where('permissions_name', $requiredPermission)->exists()) {
                Log::warning("Inferred permission '{$requiredPermission}' for route '{$routeName}' does not exist in permissions table.");
                return response()->json([
                    'status' => 'error',
                    'message' => "Access Denied: The required permission ('{$requiredPermission}') is not configured."
                ], 403);
            }

            if (!in_array($requiredPermission, $userPermissions)) {
                Log::warning("User '{$user->username}' lacks permission '{$requiredPermission}' for route '{$routeName}'.", ['user_permissions' => $userPermissions]);
                return response()->json([
                    'status' => 'error',
                    'mypermission' => $userPermissions,
                    'message' => "Access Denied: You do not have the required permission ('{$requiredPermission}') to perform this action."
                ], 403);
            }

            return $next($request);

        } catch (TokenExpiredException $e) {
            Log::info('CheckPermission: Token has expired.', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'token_expired', 'message' => 'Token has expired. Please login again.'], 401);
        } catch (TokenInvalidException $e) {
            Log::info('CheckPermission: Token is invalid.', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'token_invalid', 'message' => 'Token is invalid. Please login again.'], 401);
        } catch (JWTException $e) {
            Log::warning('CheckPermission: JWT error.', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'token_absent_or_malformed', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Throwable $e) {
            Log::error('CheckPermission Middleware Unexpected Error: ' . $e->getMessage(), [
                'user' => isset($user) ? $user->username : 'N/A',
                'route' => isset($routeName) ? $routeName : $request->path(),
                'exception_trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected server error occurred. Please try again later.'
            ], 500);
        }
    }
}