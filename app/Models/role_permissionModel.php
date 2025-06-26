<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class role_permissionModel extends Model
{
    use HasFactory;
    protected $table = "role_permissions";
    protected $fillable = [
        'role_name',
        'permission_name',
        'assigned_at',
        'created_at',
        'updated_at'

    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function permissions()
    {
        return $this->belongsTo(permissionModel::class, 'permission_name', 'permissions_name');
    }

    public static function newFactory()
    {
        return \Database\Factories\role_PermissionModelFactory::new();
    }

    
}
