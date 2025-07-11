<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HardwareOSVersion extends Model
{
    protected $table = 'hardware_os_version';

    protected $fillable = [
        'OS', 'OSver',
    ];
}
