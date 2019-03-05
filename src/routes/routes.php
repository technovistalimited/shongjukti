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

		/**
		 * Note the plural 'attachment-types' with 's'.
		 */
		route::get('attachment-types/{scope_key?}', 'AttachmentTypeController@index');


		/**
		 * Note the singular 'attachment-type' without 's' from now.
		 * It is to remove conflict with {id} and {scope_key}.
		 */
		route::get('attachment-type/create', 'AttachmentTypeController@create');
		route::post('attachment-type', [
			'as'   => 'attachment_type.store',
			'uses' => 'AttachmentTypeController@store'
		]);

		route::get('attachment-type/{id}/edit/', 'AttachmentTypeController@edit');
		route::patch('attachment-type/{id}', [
			'as'   => 'attachment_type.update',
			'uses' => 'AttachmentTypeController@update'
		]);

		route::delete('attachment-type/{id}', [
			'as'   => 'attachment_type.delete',
			'uses' => 'AttachmentTypeController@destroy'
		]);

	});

});
