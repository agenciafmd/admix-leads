<?php

namespace Agenciafmd\Leads\Providers;

use Agenciafmd\Leads\Models\Lead;
use Illuminate\Support\ServiceProvider;

class LeadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->providers();
        
        $this->setSearch();

        $this->loadMigrations();

        $this->publish();
    }

    protected function providers()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(BladeServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    protected function setSearch()
    {
        $this->app->make('admix-search')
            ->registerModel(Lead::class, 'name', 'email');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        $this->loadConfigs();
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admix-leads.php', 'admix-leads');
        $this->mergeConfigFrom(__DIR__ . '/../config/gate.php', 'gate');
        $this->mergeConfigFrom(__DIR__ . '/../config/audit-alias.php', 'audit-alias');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../database/factories/LeadFactory.php.stub' => base_path('database/factories/LeadFactory.php'),
            __DIR__ . '/../database/seeders/LeadsTableSeeder.php.stub' => base_path('database/seeders/LeadsTableSeeder.php'),
        ], 'admix-leads:seeders');
    }
}
