<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users'; // Đặt tên bảng là 'users'
    protected $primaryKey = 'username'; // Đặt username làm khóa chính
    public $incrementing = false; // Username không tự tăng (không phải số)
    protected $keyType = 'string'; // Khóa chính là kiểu chuỗi (string)
    
    protected $fillable = [
        'username',
        'password',
        'email',
        'fullName',
        'phone_number',
        'hidden',
        'is_delete',
        'department',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [
            'username' => $this->getKey(),
        ];
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->hasMany(userRoleModel::class, 'username', 'username');
    }

    public function getRole()
    {
    return $this->roles->pluck('role_name')->map(function($r) {
    return trim(mb_strtolower($r, 'UTF-8'));
    })->toArray();
    }
}
