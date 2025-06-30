<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class passwordResetModel extends Model
{
    protected $table = 'password_reset';
    protected $fillable = [
        'email',
        'otp',
        'created_at',
        'otp_expiration',
        'isVerified',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'email', 'email');
    }
}
