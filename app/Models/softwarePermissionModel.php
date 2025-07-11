<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class softwarePermissionModel extends Model
{
    protected $table = 'software_permissions';
    protected $fillable = [
        'software_id',
        'create_by',
        'user_name',
        'create_by',
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
    public function permission(){
        return $this->belongsTo('App\Models\PermissionModel', 'permissions_name', 'permissions_name');
    }
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
