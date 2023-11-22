<?php

namespace Agenciafmd\Leads\Providers;

use Agenciafmd\Leads\Http\Livewire\Pages;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('agenciafmd.leads.http.livewire.pages.lead.index', Pages\Lead\Index::class);
        Livewire::component('agenciafmd.leads.http.livewire.pages.lead.form', Pages\Lead\Form::class);
    }

    public function register(): void
    {
        //
    }
}
