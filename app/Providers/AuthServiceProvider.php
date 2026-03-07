<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Apiario;
use App\Policies\ApiarioPolicy;
use App\Models\Colmeia;
use App\Policies\ColmeiaPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Apiario::class => ApiarioPolicy::class,
        Colmeia::class => ColmeiaPolicy::class,  // <- adiciona aqui
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
