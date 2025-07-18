<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class databaseVersionModel extends Model
{
    protected $table = "database_version";
    protected $fillable = [
        'dbname',
        'version',
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
    
    public function database()
    {
        return $this->belongsTo(databaseModel::class, 'dbname', 'dbname');
    }
    
}
