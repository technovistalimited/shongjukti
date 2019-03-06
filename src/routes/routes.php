<?php
/**
 * Shongjukti Routes
 *
 * @package    laravel
 * @subpackage shongjukti
 */

Route::group(['namespace' => 'Technovistalimited\Shongjukti\App\Controllers'], function()
{

	Route::group(['middleware' => ['web']], function ()
	{

		// Note the plural 'attachment-types' with 's'.
		route::get('attachment-types/{scope_key?}', 'AttachmentTypeController@index')
			->name('attachment_type.index');

		// Note the singular 'attachment-type' without 's' from now,
		// to remove conflict with a parameter and a {scope_key}.
		route::get('attachment-type/create', 'AttachmentTypeController@create')
			->name('attachment_type.create');

		route::post('attachment-type', 'AttachmentTypeController@store')
			->name('attachment_type.store');

		route::get('attachment-type/{id}/edit/', 'AttachmentTypeController@edit')
			->name('attachment_type.edit');

		route::patch('attachment-type/{id}', 'AttachmentTypeController@update')
			->name('attachment_type.update');

		route::delete('attachment-type/{id}', 'AttachmentTypeController@destroy')
			->name('attachment_type.delete');

	});

});
