<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class rolesModel extends Model
{
    use HasFactory;

    public $table = 'roles';
    public $primaryKey = 'role_name';
    public $incrementing = false; // khoá 9 0 tự tăng
    protected $keyType = 'string'; //khoá 9 là chũi
    protected $fillable = [
        'role_name',
        'assigned_at',
    ];

    protected function casts(): array
    {
    return [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'assigned_at' => 'datetime',
    ];
    }

    public static function newFactory()
    {
        return \Database\Factories\RoleModelFactory::new();
    }

}