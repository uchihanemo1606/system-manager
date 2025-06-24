<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class userRoleModel extends Model
{
    use HasFactory;
    protected $table = 'user_role';
    protected $fillable = [
        'username',
        'role_name',
        'assigned_at',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'username', 'username');
    }
    public function role()
    {
        return $this->belongsTo(rolesModel::class, 'role_name', 'role_name');
    }
    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

        public static function newFactory()
    {
        return \Database\Factories\userRoleModelFactory::new();
    }
}
