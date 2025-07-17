<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OSModel extends Model
{
    protected $table = "os";

    protected $fillable = [
        'name',
        'architecture',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by',
        'deleted_by',
        'description',
    ];
    
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function userCreated()
    {
        return $this->belongsTo(UserModel::class, 'created_by', 'username');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo(UserModel::class, 'updated_by', 'username');
    }

    public function userDeleted()
    {
        return $this->belongsTo(UserModel::class, 'deleted_by', 'username');
    }

}
