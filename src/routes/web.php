<?php

/*
|--------------------------------------------------------------------------
| ADMIX Routes
|--------------------------------------------------------------------------
*/

Route::prefix(config('admix.url') . '/leads')
    ->name('admix.leads.')
    ->middleware(['auth:admix-web'])
    ->group(function () {
        Route::get('', 'LeadController@index')
            ->name('index')
            ->middleware('can:view,\Agenciafmd\Leads\Lead');
        Route::get('trash', 'LeadController@index')
            ->name('trash')
            ->middleware('can:restore,\Agenciafmd\Leads\Lead');
        Route::get('create', 'LeadController@create')
            ->name('create')
            ->middleware('can:create,\Agenciafmd\Leads\Lead');
        Route::post('', 'LeadController@store')
            ->name('store')
            ->middleware('can:create,\Agenciafmd\Leads\Lead');
        Route::get('{lead}', 'LeadController@show')
            ->name('show')
            ->middleware('can:view,\Agenciafmd\Leads\Lead');
        Route::get('{lead}/edit', 'LeadController@edit')
            ->name('edit')
            ->middleware('can:update,\Agenciafmd\Leads\Lead');
        Route::put('{lead}', 'LeadController@update')
            ->name('update')
            ->middleware('can:update,\Agenciafmd\Leads\Lead');
        Route::delete('destroy/{lead}', 'LeadController@destroy')
            ->name('destroy')
            ->middleware('can:delete,\Agenciafmd\Leads\Lead');
        Route::post('{id}/restore', 'LeadController@restore')
            ->name('restore')
            ->middleware('can:restore,\Agenciafmd\Leads\Lead');
        Route::post('batchDestroy', 'LeadController@batchDestroy')
            ->name('batchDestroy')
            ->middleware('can:delete,\Agenciafmd\Leads\Lead');
        Route::post('batchRestore', 'LeadController@batchRestore')
            ->name('batchRestore')
            ->middleware('can:restore,\Agenciafmd\Leads\Lead');
    });
