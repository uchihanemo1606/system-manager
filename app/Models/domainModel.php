<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class domainModel extends Model
{   
    protected $table = "domain";
    protected $fillable = [
        'software_id',
        'name',
        'link',
        
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function software()
    {
        return $this->belongsTo(softwareModel::class, 'software_id', 'id');
    }

}
