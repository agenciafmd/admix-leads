<?php

use Agenciafmd\Leads\Http\Controllers\LeadController;
use Agenciafmd\Leads\Models\Lead;

Route::get('leads', [LeadController::class, 'index'])
    ->name('admix.leads.index')
    ->middleware('can:view,' . Lead::class);
Route::get('leads/trash', [LeadController::class, 'index'])
    ->name('admix.leads.trash')
    ->middleware('can:restore,' . Lead::class);
Route::get('leads/create', [LeadController::class, 'create'])
    ->name('admix.leads.create')
    ->middleware('can:create,' . Lead::class);
Route::post('leads', [LeadController::class, 'store'])
    ->name('admix.leads.store')
    ->middleware('can:create,' . Lead::class);
Route::get('leads/{lead}', [LeadController::class, 'show'])
    ->name('admix.leads.show')
    ->middleware('can:view,' . Lead::class);
Route::get('leads/{lead}/edit', [LeadController::class, 'edit'])
    ->name('admix.leads.edit')
    ->middleware('can:update,' . Lead::class);
Route::put('leads/{lead}', [LeadController::class, 'update'])
    ->name('admix.leads.update')
    ->middleware('can:update,' . Lead::class);
Route::delete('leads/destroy/{lead}', [LeadController::class, 'destroy'])
    ->name('admix.leads.destroy')
    ->middleware('can:delete,' . Lead::class);
Route::post('leads/{id}/restore', [LeadController::class, 'restore'])
    ->name('admix.leads.restore')
    ->middleware('can:restore,' . Lead::class);
Route::post('leads/batchDestroy', [LeadController::class, 'batchDestroy'])
    ->name('admix.leads.batchDestroy')
    ->middleware('can:delete,' . Lead::class);
Route::post('leads/batchRestore', [LeadController::class, 'batchRestore'])
    ->name('admix.leads.batchRestore')
    ->middleware('can:restore,' . Lead::class);
Route::post('leads/batchExport/{all?}', [LeadController::class, 'batchExport'])
    ->name('admix.leads.batchExport');

//Route::post('leads', 'FrontendController@store')
//    ->name('frontend.leads.store');
