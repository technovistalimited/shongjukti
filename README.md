# Laravel Attachments for TechnoVista Limited

A reusable component for attachments in Laravel-based web application. It's kind of static, and **not developed** in 100% modular concept.

The repository was developed as a sub-project of an existing project, with a mission to re-use this code with less effort wherever necessary. It will work like a plug&play module when implemented.

## Requirements
- Laravel 5.5+ (Tested up to 5.7.x)
- Bootstrap 3.3.7 CSS
- jQuery

## Features
- Defined attachments can be managed
- Attachments can be defined for any types of scopes
- Custom label can be accepted where necessary
- Mandatory and optional attachments can be defined
- Maximum upload size can be defined globally
- Default accepted file types can be defined globally
- Accepted file types can be defined for each of the type of attachment
- Translation-ready (English and Bengali are defined by default)

## Implementation Checklist

### Installation (One time)
- [ ] Command to symlink the storage in public `php artisan storage:link`
- [ ] Add `Http/Controllers/AttachmentsController`
- [ ] Add `AttachmentsController` as an _alias_ in `config/app.php`
- [ ] Add `Model/Settings/AttachmentTypes`
- [ ] Add `Model/Attachments`
- [ ] Add 'Attachment Types' CRUD directory (`attachment-types/`) including (add, edit, form, list) available at `resources/views/settings/`
- [ ] Add 'Attachment Types' routes in `routes/web.php`

```php
// --------------------
// Attachment Types
// --------------------
route::get('attachment-types/{scope_key?}', 'AttachmentsController@attachmentTypesIndex')->middleware('auth');

route::get('attachment-type/add', 'AttachmentsController@attachmentTypesAdd')->middleware('auth');

route::post('attachment-type/store', [
    'as'   => 'attachmenttype.store',
    'uses' => 'AttachmentsController@attachmentTypesStore'
])->middleware('auth');

route::get('attachment-type/edit/{id?}', 'AttachmentsController@attachmentTypesEdit')->middleware('auth');

route::put('attachment-type/update', [
    'as'   => 'attachmenttype.update',
    'uses' => 'AttachmentsController@attachmentTypesUpdate'
])->middleware('auth');

route::delete('attachment-type/delete/{id}', [
    'as'   => 'attachmenttype.delete',
    'uses' => 'AttachmentsController@attachmentTypesDelete'
])->middleware('auth');
```

- [ ] Copy the migration files in `database/migrations/`
	- `2018_12_31_162545_create_attachment_types_table.php`
	- `2018_12_31_162935_create_attachments_table.php`
- [ ] Run command: `php artisan migrate`
- [ ] place `attachments.blade.php` in `views/layouts/`
- [ ] place `_attachments.scss` in your repository
- [ ] include `_attachments.scss` to your master SCSS and compile
- [ ] place `_attachments.js` in your repository
- [ ] add simple JS in back end for conditional fields in attachment types (UX)

### Usage (Recurring Tasks)

During usage, change all the `your-scope-key` with your scope key. And don't forget the pass the appropriate `$scope_id` where we mentioned `$scopeId` or `$yourScope->ID` or `$inputs['scope_id']`.

- [ ] Register the `scope_key` at the `AttachmentController@attachmentScopes` (hyphenated please)
- [ ] Parent form: add `enctype="multipart/form-data"` to your parent `<form>` tag
- [ ] `Add()` Method
    - [ ] Controller: `$attachmentTypes = AttachmentTypesModel::getAttachmentTypesByScopeKey('your-scope-key');`
    - [ ] Controller: `compact('attachmentTypes')`
    - [ ] Add Mode (Blade): `@include('layouts.attachments')`
    - [ ] Add Mode (Blade): `<script src="{{ asset('js/_attachments.js') }}"></script>`
- [ ] `Store()` Method
    - [ ] Controller: `$attachmentInfo = AttachmentsModel::storeAttachments($inputs, 'your-scope-key', $yourScope->ID);`
- [ ] `Edit()` Method
    - [ ] Controller: `$attachmentTypes = AttachmentTypesModel::getAttachmentTypesByScopeKey('your-scope-key');`
    - [ ] Controller: `$attachments = AttachmentsModel::getAttachmentsForEdit('your-scope-key', $scopeId);`
    - [ ] Controller: `compact( 'attachmentTypes', 'attachments')`
    - [ ] Edit Mode (Blade): `@include('layouts.attachments')`
    - [ ] Edit Mode (Blade): `<script src="{{ asset('js/_attachments.js') }}"></script>`
- [ ] `Update()` Method
    - [ ] Controller: `$attachmentInfo = AttachmentsModel::storeAttachments($inputs, 'your-scope-key', $inputs['scope_id']);`
- [ ] `View()` Method
    - [ ] Controller: `$attachments = AttachmentsModel::getAttachments('your-scope-key', $scopeId);`
    - [ ] Controller: `compact('attachments')`
    - [ ] View Mode (Blade): `@include('layouts.attachments')` (If you want a custom view layout, you can include your chosen layout instead of ours)

## Pluggable portions (Things can be modified)
There are certain things developed as a variable, that can be modified according to the necessity:
- `$uploadMaxSize`: Maximum Upload Size. Default: 5mb.
- `$defaultExtensions`: Default accepted file extensions. Default: jpg, gif, png, pdf.
- `attachment_block_head_class`: `@section('attachment_block_head_class', 'your-custom-class')` can be passed to the attachments blade for your custom need. Default: 'section-head'.
- `attachment_block_head`: `@section('attachment_block_head', 'My Attachments')` can be passed to the attachments blade for your custom need. Default: 'Attachments'.

## Known Issues (When not to use)
- If you want to let user add attachments on their choice, and there's no fixed attachments are defined, this repository won't fit
- If the file upload part is managed using JavaScript upload, then the `/scope_key/scope_id/file.ext` concept won't work, and the files will be stored in `/year/month/file.ext` path

## License
The code is licensed in [GPL3](https://opensource.org/licenses/GPL-3.0).

## Credits
Project initiated and lead by Mr. Mayeenul Islam Mayeen ([`@mayeenulislam`](https://twitter.com/mayeenulislam)). Ms. Mowshana Farhana Mow implemented the idea. Thanks to Mr. Nazmul Hasan, Tanvir Rahman, Shakhawat Hossain Mollah, and Shipon Hossain for their valuable feedback and guidance.

----
<sup>2019 TechnoVista Limited</sup>
