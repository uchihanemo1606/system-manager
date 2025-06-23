<?php

namespace App\Http\Controllers;

use App\Models\UserModel as UserModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Controllers\LogController;

class AuthController extends Controller
{
    /**
     * Create a new user.
     *
     * @urlParam /api/createUser
     * @bodyParam username string required Username of the user. Example: nemo
     * @bodyParam password string required Password for the user (min: 8 characters). Example: password123
     * @response 201 {
     *   "status": "success",
     *   "message": "User created successfully",
     *   "user": {
     *     "id": 1,
     *     "username": "nemo",
     *     "password": "hashed_password"
     *   }
     * }
     * @response 400 {
     *   "status": "error",
     *   "message": "Validation failed",
     *   "errors": {
     *     "username": ["The username field is required."]
     *   }
     * }
     * @response 500 {
     *   "status": "error",
     *   "message": "Could not create user"
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function CreateUser(Request $request)
    {
        try { 
            // Nếu chưa có user nào thì cho phép tạo user đầu tiên mà không cần token
            $userCount = UserModel::count();
            if ($userCount > 0) {
                if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'User not found.'
                    ], 404);
                }
            }
 
            // if (!$user = JWTAuth::parseToken()->authenticate()) {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'User not found.'
            //     ], 404);
            // } 
            $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $usercreate = UserModel::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
 
            // Nếu là user đầu tiên thì không có $user để log
            if ($userCount > 0) {
                LogController::createLogAuto([
                    'username' => $user->username, 
                    'message' => "{$user->username} đã tạo tài khoản có username là '{$usercreate->username}'",
                ]);
            } 
            // LogController::createLogAuto([
            //     'username' => $user->username,
            //     'message' => "{$user->username} đã tạo tài khoản có username là '{$usercreate->username}'",
            // ]); 
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $usercreate,
            ], 201);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired.'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid.'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is absent or could not be parsed.'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create user. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log in a user.
     *
     * @group Authentication
     * @urlParam /api/login
     * @bodyParam username string required Username of the user. Example: nemo
     * @bodyParam password string required Password for the user. Example: password123
     * @response 200 {
     *   "status": "success",
     *   "token": "jwt-token-here"
     * }
     * @response 401 {
     *   "status": "error",
     *   "message": "username or password is incorrect"
     * }
     * @response 500 {
     *   "status": "error",
     *   "message": "Could not create token"
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'username or password is incorrect',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create token',
            ], 500);
        }
        //thêm kiểm tra tk bị khoá, xoá

        LogController::createLogAuto([
            'username' => $request->username,
            'message' => "{$request->username} đã đăng nhập vào hệ thống",
        ]);

        return response()->json([
            'status' => 'success',
            'token' => $token,
        ])->withCookie(cookie('auth_token', $token, 60, '/', null, false, false));
    }

    /**
     * Log out the authenticated user.
     *
     * @group Authentication
     * @urlParam /api/logout
     * @authenticated
     * @response 200 {
     *   "status": "success",
     *   "message": "Successfully logged out"
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        try {
            $token = $request->cookie('auth_token') ?? $request->bearerToken();
            if ($token) {
                JWTAuth::setToken($token)->invalidate(); // Hủy token
            } 
            $cookie = cookie()->forget('auth_token');

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out',
            ])->withCookie($cookie);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }

    /**
     * Get the authenticated user.
     *
     * @group Authentication
     * @urlParam /api/getAuthenticatedUser
     * @authenticated
     * @response 200 {
     *   "user": {
     *     "username": "demo",
     *     "email": "demo@example.com",
     *     "fullName": "Demo User",
     *     "phone_number": "0123456789"
     *   }
     * }
     * @response 401 {
     *   "token_absent"
     * }
     * @response 404 {
     *   "user_not_found"
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['token_absent'], 401);
        }

        return response()->json(compact('user'));
    }

    /**
     * Update the authenticated user's details.
     *
     * @group Authentication
     * @urlParam /api/updateUser
     * @authenticated
     * @bodyParam fullName string optional Full name of the user. Example: Uchiha Nemo
     * @bodyParam email string optional Email of the user. Example: uchihanemo@gmail.com
     * @bodyParam phone_number string optional Phone number of the user. Example: 0123456789
     * @response 200 {
     *   "status": "success",
     *   "message": "User updated successfully.",
     *   "users": {
     *     "username": "demo",
     *     "email": "uchihanemo@gmail.com",
     *     "fullName": "Uchiha Nemo",
     *     "phone_number": "0123456789"
     *   }
     * }
     * @response 400 {
     *   "status": "error",
     *   "message": "Validation failed.",
     *   "errors": {
     *     "email": ["The email has already been taken."]
     *   }
     * }
     * @response 401 {
     *   "status": "error",
     *   "message": "Token is absent or could not be parsed."
     * }
     * @response 422 {
     *   "status": "error",
     *   "message": "Validation failed.",
     *   "errors": {
     *     "fullName": ["The fullName field is invalid."]
     *   }
     * }
     * @response 500 {
     *   "status": "error",
     *   "message": "Failed to update user."
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.'
                ], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired.'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid.'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is absent or could not be parsed.'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not authenticate user. ' . $e->getMessage()
            ], 500);
        }

        $validator = Validator::make($request->all(), [
            'fullName' => 'sometimes|string|max:100',
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:100',
                $request->filled('email') ? 'unique:users,email,' . $user->username . ',username' : '',
            ],
            'phone_number' => 'sometimes|nullable|string|max:12',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        // Lưu thông tin cũ trước khi update
        $oldData = $user->only(['fullName', 'email', 'phone_number']);

        try {
            $user->update($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update user. ' . $e->getMessage(),
            ], 500);
        }

        // Lấy thông tin mới sau khi update
        $newData = $user->fresh()->only(['fullName', 'email', 'phone_number']);

        // Tạo chuỗi mô tả thay đổi
        $changes = [];
        foreach ($oldData as $key => $oldValue) {
            $newValue = $newData[$key];
            if ($oldValue != $newValue) {
                $changes[] = "$key: '$oldValue' → '$newValue'";
            }
        }
        $changeString = $changes ? implode(', ', $changes) : 'Không có thay đổi';

        // Ghi log
        LogController::createLogAuto([
            'username' => $user->username,
            'message' => "{$user->username} đã cập nhật thông tin tài khoản từ ($changeString)",
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
            'users' => $user->fresh(),
        ]);
    }
    /**
     * Change the authenticated user's password.
     *
     * @group Authentication
     * @urlParam /api/changePassword
     * @authenticated
     * @bodyParam current_password string required Current password of the user. Example: oldpassword123
     * @bodyParam new_password string required New password of the user (min: 8 characters). Example: newpassword123
     * @response 200 {
     *   "status": "success",
     *   "message": "Password changed successfully."
     * }
     * @response 400 {
     *   "status": "error",
     *   "message": "Current password is incorrect."
     * }
     * @response 401 {
     *   "token_absent"
     * }
     * @response 404 {
     *   "user_not_found"
     * }
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['token_absent'], 401);
        }

        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);

        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect.',
            ], 400);
        }
        $user->password = Hash::make($validatedData['new_password']);
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully.',
        ]);
    }
}
