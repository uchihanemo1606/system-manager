<?php

namespace App\Providers;

use App\Models\hardwareModel;
use App\Policies\HardwarePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        hardwareModel::class => HardwarePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}