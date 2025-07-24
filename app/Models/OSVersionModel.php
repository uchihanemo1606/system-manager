<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OSVersionModel extends Model
{
    protected $table = "_o_s_version";

    protected $fillable = [
        'os_name',
        'version',
        'version_description',
        'created_by',
        'description',
        'is_delete'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'created_by', 'username');
    }

    public function os()
    {
        return $this->belongsTo(OSModel::class, 'os_name', 'name');
    }

}
