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
use App\Models\passwordResetModel;
use App\Http\Controllers\MailController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;




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

            $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8',
                'fullName' => 'required|string|max:100',
                'email' => [
                    'nullable',
                    'string',
                    'email',
                    'max:100',
                    Rule::unique('users')->ignore($request->username, 'username'),
                ],
                'phone_number' => 'nullable|string|max:12',
                'department' => 'nullable|string|exits:departments,name',
            ]);

            $usercreate = UserModel::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'fullName' => $request->fullName,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'department' => $request->department,
            ]);
            // Nếu là user đầu tiên thì $user sẽ không tồn tại
            LogController::createLogAuto([
                'username' => $userCount > 0 ? $user->username : $usercreate->username,
                'message' => ($userCount > 0
                    ? "{$user->fullName} đã tạo tài khoản có username là '{$usercreate->username}'"
                    : "Tài khoản đầu tiên '{$usercreate->username}' đã được tạo"),
            ]);

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
        $user = JWTAuth::setToken($token)->authenticate();
        //thêm kiểm tra tk bị khoá, xoá

        LogController::createLogAuto([
            'username' => $request->username,
            'message' => "{$user->fullName} đã đăng nhập vào hệ thống.",
        ]);

        return response()->json([
            'status' => 'success',
            'token' => $token,
        ])->withCookie(cookie('auth_token', $token, 60, '/', null, false, false));
    }
    public function refresh(Request $request)
    {
        try {
            $token = JWTAuth::getToken();

            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token không tồn tại',
                ], 401);
            }

            $newToken = JWTAuth::refresh($token);
            $user = JWTAuth::setToken($newToken)->authenticate();

            return response()->json([
                'status' => 'success',
                'token' => $newToken,
            ])->withCookie(cookie('auth_token', $newToken, 60, '/', null, false, false));
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token không hợp lệ hoặc đã hết hạn',
            ], 401);
        }
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
            'message' => "{$user->fullName} đã cập nhật thông tin tài khoản từ ($changeString)",
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

    public function sendOTPResetPassword(Request $request)
    {
        try {
            $mailController = new MailController();

            $request->validate(['email' => 'required|email']);
            $email = $request->input('email');
            $user = UserModel::where('email', $email)->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Email không tồn tại!'], 404);
            }

            $lastOtp = passwordResetModel::where('email', $email)->first();
            if ($lastOtp && $lastOtp->created_at) {
                $createdAtAdjusted = $lastOtp->created_at->setTimezone('Asia/Ho_Chi_Minh');
                $timeDiff =  $lastOtp->created_at->diffInSeconds(now());
                Log::info('Time difference check', [
                    'now' => now()->toDateTimeString(),
                    'created_at_original' => $lastOtp->created_at->toDateTimeString(),
                    'created_at_adjusted' => $createdAtAdjusted->toDateTimeString(),
                    'timeDiff' => $timeDiff
                ]);
                if ($timeDiff < 0) {
                    $timeDiff = 0;
                }
                if ($timeDiff < 60) {
                    $wait = 60 - $timeDiff;
                    Log::info('Wait time applied', ['wait' => $wait]);
                    return response()->json([
                        'success' => false,
                        'message' => "Bạn vừa yêu cầu OTP, vui lòng đợi {$wait} giây nữa để gửi lại.",
                        'time' => $wait,
                    ], 429);
                }
            }

            $otp = random_int(100000, 999999);
            $hashedOtp = bcrypt($otp);

            $subject = 'OTP đặt lại mật khẩu';
            $message = "
                <div style='max-width:400px;margin:0 auto;padding:24px 18px 18px 18px;border:1px solid #eee;border-radius:8px;font-family:sans-serif;'>
                    <p style='font-size:16px;'><b>Mã OTP của bạn là:</b></p>
                    <p style='font-size:24px;color:#d32f2f;font-weight:bold;letter-spacing:2px;margin:8px 0 16px 0;'>$otp</p>
                    <p style='margin-bottom:16px;'>(Có hiệu lực trong 2 phút)</p>
                    <p style='color:#555;margin-bottom:0;'>
                        Vui lòng không chia sẻ mã này với bất kỳ ai.<br>
                        Nếu OTP này không phải do bạn tạo ra, vui lòng liên hệ quản trị viên để được hỗ trợ.
                    </p>
                </div>
            ";
            $result = $mailController->sendEmailTo($email, $subject, $message);

            if ($result === true) {
                if ($lastOtp) {
                    $lastOtp->update([
                        'otp' => $hashedOtp,
                        'otp_expiration' => now()->addMinutes(2),
                        'otp_attempts' => 0,
                        'isVerified' => false,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    passwordResetModel::create([
                        'email' => $email,
                        'otp' => $hashedOtp,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'otp_expiration' => now()->addMinutes(2),
                        'otp_attempts' => 0,
                        'isVerified' => false
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'OTP đã được gửi về email!']);
            } else {
                Log::error('Gửi email thất bại: ' . $result);
                return response()->json(['success' => false, 'message' => 'Gửi email thất bại! Lý do: ' . $result], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi gửi OTP: ' . $e->getMessage()], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|string'
            ]);

            $record = passwordResetModel::where('email', $request->email)->first();

            if (!$record) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy yêu cầu đặt lại mật khẩu!'], 404);
            }

            // Kiểm tra hết hạn
            if (isset($record->otp_expiration) && now()->gt($record->otp_expiration)) {
                return response()->json(['success' => false, 'message' => 'OTP đã hết hạn!'], 400);
            }

            // Kiểm tra số lần nhập sai
            if (isset($record->otp_attempts) && $record->otp_attempts >= 5) {
                // Xóa OTP luôn cho chắc
                passwordResetModel::where('email', $request->email)->delete();
                return response()->json(['success' => false, 'message' => 'Bạn đã nhập sai OTP quá nhiều lần. Vui lòng yêu cầu OTP mới!'], 400);
            }

            // So sánh OTP (so sánh hash)
            if (!Hash::check($request->otp, $record->otp)) {
                // Tăng số lần nhập sai
                passwordResetModel::where('email', $request->email)->increment('otp_attempts');
                return response()->json(['success' => false, 'message' => 'OTP không đúng!'], 400);
            }

            // Đánh dấu đã xác thực OTP (có thể lưu thêm cột is_verified = true hoặc trả về token tạm)
            passwordResetModel::where('email', $request->email)->update(['isVerified' => true, 'otp_attempts' => 0]);

            return response()->json(['success' => true, 'message' => 'OTP hợp lệ, bạn có thể đổi mật khẩu.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi xác thực OTP: ' . $e->getMessage()], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed'
            ]);

            $record = passwordResetModel::where('email', $request->email)->first();

            if (!$record || empty($record->isVerified)) {
                return response()->json(['success' => false, 'message' => 'Bạn chưa xác thực OTP hoặc OTP không hợp lệ!'], 400);
            }

            // Đổi mật khẩu
            $user = UserModel::where('email', $request->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();

            // Xóa dòng reset để bảo mật
            passwordResetModel::where('email', $request->email)->delete();

            return response()->json(['success' => true, 'message' => 'Đổi mật khẩu thành công!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi tạo lại mật khẩu: ' . $e->getMessage()], 500);
        }
    }


}
