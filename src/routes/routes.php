<?php

/**
 * Shongjukti Routes
 *
 * @package    Laravel
 * @subpackage TechnoVistaLimited/Shongjukti
 */

Route::group(['namespace' => 'Technovistalimited\Shongjukti\Controllers'], function () {

    Route::group(['middleware' => ['web']], function () {

        // Note the plural 'attachment-types' with 's'.
        Route::get('attachment-types/{scope_key?}', 'AttachmentTypeController@index')
            ->name('attachment_type.index');

        // Note the singular 'attachment-type' without 's' from now,
        // to remove conflict with a parameter and a {scope_key}.
        Route::get('attachment-type/create', 'AttachmentTypeController@create')
            ->name('attachment_type.create');

        Route::post('attachment-type', 'AttachmentTypeController@store')
            ->name('attachment_type.store');

        Route::get('attachment-type/{id}/edit/', 'AttachmentTypeController@edit')
            ->name('attachment_type.edit');

        Route::patch('attachment-type/{id}', 'AttachmentTypeController@update')
            ->name('attachment_type.update');

        Route::delete('attachment-type/{id}', 'AttachmentTypeController@destroy')
            ->name('attachment_type.delete');
    });
});
