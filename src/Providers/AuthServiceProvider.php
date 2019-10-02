<?php

namespace Agenciafmd\Leads\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        '\Agenciafmd\Leads\Lead' => '\Agenciafmd\Leads\Policies\LeadPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
