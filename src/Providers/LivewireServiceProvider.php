<?php

namespace Agenciafmd\Leads\Providers;

use Agenciafmd\Leads\Livewire\Pages;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('agenciafmd.leads.livewire.pages.lead.index', Pages\Lead\Index::class);
        Livewire::component('agenciafmd.leads.livewire.pages.lead.component', Pages\Lead\Component::class);
    }

    public function register(): void
    {
        //
    }
}
