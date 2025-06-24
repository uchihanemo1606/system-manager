<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class routePermissionModel extends Model
{
    use HasFactory;
    protected $table = "route_permission";
    protected $fillable = [
        'route_name',
        'permissions_name'
    ];
    public function permission()
    {
        return $this->belongsTo(permissionModel::class, 'permissions_name', 'permissions_name');
    }

    public static function newFactory()
    {
        return \Database\Factories\routePermissionModelFactory::new();
    }

}
