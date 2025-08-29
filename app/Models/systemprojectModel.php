<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class systemprojectModel extends Model
{
    protected $table = 'systemproject';

    protected $fillable = [
        'avatar',
        'foodter',
        'namesystem',
    ];

    public $timestamps = true;

    /**
     * Get the avatar URL.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return asset('uploads/avatars/' . $this->avatar);
    }
}
