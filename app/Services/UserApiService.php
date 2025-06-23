<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UserApiService
{
    public static function getAll(string $token)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('http://127.0.0.1:8000/api/getallusers');

        if ($response->successful()) {
            $json = $response->json();
            return $json['users'] ?? []; // ✅ Lấy riêng phần "users"
        }
        return [];
    }
}
