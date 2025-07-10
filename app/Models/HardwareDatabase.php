<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HardwareDatabase extends Model
{
    protected $table = 'hardware_database';

    protected $fillable = [
        'dbname', 'dbversion',
    ];
}
