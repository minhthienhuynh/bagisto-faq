<?php

Route::middleware('admin', 'bindings')
    ->namespace('DFM\FAQ\Http\Controllers\Admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('faqs', 'FaqController')->except(['show']);

        Route::prefix('faqs')->name('faqs.')->group(function () {

            Route::post('/massdelete', 'FaqController@massDelete')
                ->name('mass-delete');
        });
});
