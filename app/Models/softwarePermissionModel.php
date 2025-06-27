<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class softwarePermissionModel extends Model
{
    protected $table = 'software_permissions';
    protected $fillable = [
        'software_id',
        'user_name',
        'user_createdby',
        'assigned_at',
        'permissions_name',
        
    ];
    public function software()
    {
        return $this->belongsTo(softwareModel::class, 'software_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_name', 'username');
    }
    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
