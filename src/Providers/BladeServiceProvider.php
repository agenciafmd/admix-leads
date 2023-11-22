<?php

namespace Agenciafmd\Leads\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadBladeComponents();

        $this->loadBladeDirectives();

        $this->loadBladeComposers();

        $this->setMenu();

        $this->loadViews();

        $this->publish();
    }

    public function register(): void
    {
        //
    }

    private function loadBladeComponents(): void
    {
        Blade::componentNamespace('Agenciafmd\\Leads\\Http\\Components', 'admix-leads');
    }

    private function loadBladeComposers(): void
    {
        //
    }

    private function loadBladeDirectives(): void
    {
        //
    }

    private function setMenu(): void
    {
        $this->app->make('admix-menu')
            ->push((object)[
                'component' => 'admix-leads::aside.lead',
                'ord' => config('admix-leads.sort'),
            ]);
    }

    private function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'admix-leads');
    }

    private function publish(): void
    {
        // $this->publishes([
        //     __DIR__ . '/../resources/views' => base_path('resources/views/vendor/agenciafmd/leads'),
        // ], 'admix-leads:views');
    }
}
