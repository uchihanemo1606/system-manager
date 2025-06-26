<?php

namespace App\Providers;

use App\Models\hardwareModel;
use App\Models\softwareModel;
use App\Policies\HardwarePolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\softwwareModel;
use App\Policies\SoftwarePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        hardwareModel::class => HardwarePolicy::class,
        softwareModel::class => SoftwarePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}