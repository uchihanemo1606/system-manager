<?php

namespace App\Http\Controllers;

use Google_Client;
use Google\Service\Gmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserModel;
use App\Http\Controllers\LogController;
use App\Models\passwordResetModel;




class MailController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Laravel Gmail Integration');
        $this->client->setScopes([Gmail::GMAIL_SEND]);
        $this->client->setAuthConfig(env('PATH_CREDENTIALS'));
        $this->client->setAccessType('offline');
        $this->client->setApprovalPrompt('force');

        // Sử dụng Refresh Token
        if (Session::has('access_token') && isset(Session::get('access_token')['refresh_token'])) {
            $this->client->setAccessToken(Session::get('access_token'));
            if ($this->client->isAccessTokenExpired()) {
                $this->client->fetchAccessTokenWithRefreshToken(Session::get('access_token')['refresh_token']);
                Session::put('access_token', $this->client->getAccessToken());
            }
        } else {
            $refreshToken = env('REFRESH_TOKEN');
            if (empty($refreshToken)) {
                throw new \Exception('REFRESH_TOKEN chưa được cấu hình trong file .env');
            }
            $token = [
                'refresh_token' => $refreshToken,
                'access_token' => '',
                'expires_in' => 3600,
            ];
            $this->client->setAccessToken($token);
            if ($this->client->isAccessTokenExpired()) {
                $this->client->fetchAccessTokenWithRefreshToken($token['refresh_token']);
                Session::put('access_token', $this->client->getAccessToken());
            }
        }
    }

    

    public function sendEmail(Request $request)
    {
        $to = $request->input('to', 'recipient@example.com');
        $subject = $request->input('subject', 'Test Email từ Laravel');
        $message = $request->input('message', 'Đây là nội dung email test từ Laravel với Google API.');
        $from = 'tienyeuai2200@gmail.com';

        $result = $this->sendEmailTo($to, $subject, $message, $from);

        if ($result === true) {
            return response()->json(['success' => true, 'message' => 'Email đã được gửi thành công!'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Lỗi khi gửi email!'], 500);
        }
    }

    private function createRawMessage($to, $from, $subject, $message)
    {
        $mime = "MIME-Version: 1.0\r\n";
        $mime .= "Content-Type: text/html; charset=UTF-8\r\n"; // Sửa dòng này
        $mime .= "To: " . $this->sanitizeEmail($to) . "\r\n";
        $mime .= "From: " . $this->sanitizeEmail($from) . "\r\n";
        $mime .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n\r\n";
        $mime .= $message . "\r\n";

        return rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
    }

    public function sendEmailTo($to, $subject, $message, $from = 'tienyeuai2200@gmail.com')
    {
        if (!$this->client->getAccessToken()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng cấu hình token trước!'], 401);
        }

        $service = new Gmail($this->client);
        $user = 'me';

        $rawMessage = $this->createRawMessage(
            $to,
            $from,
            $subject,
            $message
        );

        try {
            $gmailMessage = new \Google\Service\Gmail\Message();
            $gmailMessage->setRaw($rawMessage);
            $service->users_messages->send($user, $gmailMessage);
            return true;
        } catch (\Exception $e) {
             return $e->getMessage();
        }
    }

    private function sanitizeEmail($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }



}