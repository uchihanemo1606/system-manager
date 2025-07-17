<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

require __DIR__.'/Auth.routes.php';
require __DIR__.'/Permission.routes.php';
require __DIR__.'/roles.routes.php';
require __DIR__.'/rolesPermission.routes.php';
require __DIR__.'/userRole.routes.php';
require __DIR__.'/Log.routes.php';
require __DIR__.'/rule.routes.php';
require __DIR__.'/Hardware.routes.php';
require __DIR__.'/Software.routes.php';
require __DIR__.'/domain.routes.php';
require __DIR__.'/SoftwarePermission.routes.php';
require __DIR__.'/HardwareData.routes.php';