<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class databaseModel extends Model
{
    protected $table = "database";
    protected $fillable = [
        'dbname',
        'created_by',
        'decription',
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
}
