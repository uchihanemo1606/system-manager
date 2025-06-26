<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hardwareModel extends Model
{
    protected $table = "hardware";
    protected $primaryKey = 'ip';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'ip',
        'dbname',
        'dbversion',
        'isVirtualServer',
        'OS',
        'OSver',
        'hdd',
        'ram',
        'is_delete',
        'services',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'isVirtualServer' => 'boolean',
            'is_delete' => 'boolean',
            'is_active' => 'boolean',
            'services' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'created_by', 'username');
    }
}