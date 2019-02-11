<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --------------------
// Attachment Types
// --------------------
route::get('attachment-types/{scope_key?}', 'AttachmentController@attachmentTypesIndex')->middleware('auth');

route::get('attachment-type/add', 'AttachmentController@attachmentTypesAdd')->middleware('auth');

route::post('attachment-type/store', [
    'as'   => 'attachmenttype.store',
    'uses' => 'AttachmentController@attachmentTypesStore'
])->middleware('auth');

route::get('attachment-type/edit/{id?}', 'AttachmentController@attachmentTypesEdit')->middleware('auth');

route::put('attachment-type/update', [
    'as'   => 'attachmenttype.update',
    'uses' => 'AttachmentController@attachmentTypesUpdate'
])->middleware('auth');

route::delete('attachment-type/delete/{id}', [
    'as'   => 'attachmenttype.delete',
    'uses' => 'AttachmentController@attachmentTypesDelete'
])->middleware('auth');
