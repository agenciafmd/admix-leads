<?php

use Agenciafmd\Leads\Livewire\Pages;

Route::get('/leads', Pages\Lead\Index::class)
    ->name('admix.leads.index');
Route::get('/leads/trash', Pages\Lead\Index::class)
    ->name('admix.leads.trash');
Route::get('/leads/create', Pages\Lead\Component::class)
    ->name('admix.leads.create');
Route::get('/leads/{lead}/edit', Pages\Lead\Component::class)
    ->name('admix.leads.edit');
