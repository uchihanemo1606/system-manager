<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logModel extends Model
{
    protected $table = 'log';
    protected $fillable = [
        'username',
        'software_id',
        'hardware_ip',
        'rule_id',
        'message',
        'role_id',
        'software_file_id',
        'link_domain',
        'sw_permission_user',
        'hw_permission_user',
        'permission_name',
        'os_name',
        'database_name',
        'department',
    ];
    public function software()
    {
        return $this->belongsTo(softwareModel::class, 'software_id', 'id');
    }
    public function hardware()
    {
        return $this->belongsTo(hardwareModel::class, 'hardware_ip', 'ip');
    }
    public function rule()
    {
        return $this->belongsTo(rulesModel::class, 'rule_id', 'id');
    }
    public function role()
    {
        return $this->belongsTo(rolesModel::class, 'role_id', 'id');
    }
    public function softwareFile()
    {
        return $this->belongsTo(softwareFileModel::class, 'software_file_id', 'id');
    }
    public function domain()
    {
        return $this->belongsTo(domainModel::class, 'link_domain', 'link');
    }
    public function softwarePermission()
    {
        return $this->belongsTo(softwarePermissionModel::class, 'sw_permission_user', 'user_name');
    }
    public function hardwarePermission()
    {
        return $this->belongsTo(hardwarePemisssionModel::class, 'hw_permission_user', 'user_name');
    }
    public function permission()
    {
        return $this->belongsTo(permissionModel::class, 'permission_name', 'permissions_name');
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'username', 'username');
    }
    public function department()
    {
        return $this->belongsTo(departmentModel::class, 'department', 'name');
    }
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'is_delete' => 'boolean',
            'assigned_at' => 'datetime',
        ];
    }
}
