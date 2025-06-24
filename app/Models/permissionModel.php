<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class permissionModel extends Model
{
    use HasFactory;
    
    protected $table = 'permissions';
    protected $primaryKey = 'permissions_name'; // Khóa chính của bảng permissions
    public $incrementing = false; // dì khoá 9 là chũi nêng nó 0 tự tânk
    protected $keyType = 'string';
        protected $fillable = [
            'user_creately',
            'permissions_name',
            'type',
    ];


    protected function casts(): array
    {
    return [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    }

    public static function newFactory()
    {
        return \Database\Factories\PermissionModelFactory::new();
    }
}
