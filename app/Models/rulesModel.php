<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rulesModel extends Model
{
    protected $table = 'rules';

    protected $fillable = [
        'name',
        'description',
        'category_rule_id',
        'file_url',
        'username',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function category()
    {
        return $this->belongsTo(categoryRulesModel::class, 'category_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'username', 'username');
    }

}
