# Laravel Attachments for TechnoVista Limited

A reusable component for attachments in Laravel-based web application. It's kind of static, and **not developed** in 100% modular concept.

The repository was developed as a sub-project of an existing project, with a mission to re-use this code with less effort wherever necessary. It will work like a plug&play module when implemented.

## Requirements
- Laravel 5.5+ (Tested up to 5.7.x)
- Bootstrap 3.3.7 styles (grids, panels, forms, alerts, buttons)
- jQuery

## Features
- Defined attachments can be managed
- Attachments can be defined for any types of scopes
- Custom label can be accepted where necessary
- Mandatory and optional attachments can be defined
- Maximum upload size can be defined globally
- Default accepted file types can be defined globally
- Accepted file types can be defined for each of the types of attachment
- Translation-ready (English and Bengali are defined by default)

## Screenshots
### Attachment Types (Add) Screen
![attachment-types-add](https://user-images.githubusercontent.com/4551598/51890676-daa11f80-23c6-11e9-8ab7-a58f04d56b12.png)

### Attachments (Add) Screen
![attachments-add](https://user-images.githubusercontent.com/4551598/51890527-826a1d80-23c6-11e9-8a64-8b2f411a2a4e.png)

### More Screenshots
- [Attachment Types (List)](https://user-images.githubusercontent.com/4551598/51890746-15a35300-23c7-11e9-9ea2-cf3174ce45c4.png)
- [Attachment Types (Edit)](https://user-images.githubusercontent.com/4551598/51890807-47b4b500-23c7-11e9-8d75-11d2892423c2.png)
- [Attachments (Edit)](https://user-images.githubusercontent.com/4551598/51890831-5ac78500-23c7-11e9-9e53-4d2955cb9f3b.png)
- [Attachments (View)](https://user-images.githubusercontent.com/4551598/51890843-6915a100-23c7-11e9-890a-f1fb1bef6390.png)

## Implementation Checklist

### Installation (One time)
- [ ] Command to symlink the storage in public `php artisan storage:link`
- [ ] Add `Http/Controllers/AttachmentController.php`
- [ ] Add `Model/Settings/AttachmentType.php`
- [ ] Add `Model/Attachment.php`
- [ ] Add 'Attachment Types' CRUD directory (`attachment-types/`) including (list, add, edit, form) available at `resources/views/settings/`
- [ ] Add 'Attachment Types' routes in `routes/web.php`:

```php
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
```

- [ ] Copy the migration files in `database/migrations/`
	- `2018_12_31_162545_create_attachment_types_table.php`
	- `2018_12_31_162935_create_attachments_table.php`
- [ ] Run command: `php artisan migrate`
- [ ] place `attachments.blade.php` in `views/layouts/`
- [ ] place `_attachments.scss` in your repository
- [ ] include `_attachments.scss` to your master SCSS and compile
- [ ] place `_attachments.js` in your repository

### Usage (Recurring Tasks)

During usage, change all the `your-scope-key` with your scope key. All the code mentioned are not supposed to be modified, even the variables are needed to mentioned exact. But only `$scopeId` or `$yourScope->ID` or `$inputs['scope_id']` should be replaced with _your_ `$scope_id`.

- [ ] Register the `scope_key` at the `AttachmentController@attachmentScopes` (hyphenated please)
- [ ] Parent form: add `enctype="multipart/form-data"` to your parent `<form>` tag
- [ ] `Add()` Method
    - [ ] Controller: `$attachmentTypes = AttachmentType::getAttachmentTypesByScopeKey('your-scope-key');`
    - [ ] Controller: `compact('attachmentTypes')`
    - [ ] Add Mode (Blade): `@include('layouts.attachments')`
    - [ ] Add Mode (Blade): `<script src="{{ asset('js/_attachments.js') }}"></script>`
- [ ] `Store()` Method
    - [ ] Controller: `$attachmentInfo = Attachment::storeAttachments($inputs, 'your-scope-key', $yourScope->ID);`
- [ ] `Edit()` Method
    - [ ] Controller: `$attachmentTypes = AttachmentType::getAttachmentTypesByScopeKey('your-scope-key');`
    - [ ] Controller: `$attachments = Attachment::getAttachmentsForEdit('your-scope-key', $scopeId);`
    - [ ] Controller: `compact( 'attachmentTypes', 'attachments')`
    - [ ] Edit Mode (Blade): `@include('layouts.attachments')`
    - [ ] Edit Mode (Blade): `<script src="{{ asset('js/_attachments.js') }}"></script>`
- [ ] `Update()` Method
    - [ ] Controller: `$attachmentInfo = Attachment::storeAttachments($inputs, 'your-scope-key', $inputs['scope_id']);`
- [ ] `View()` Method
    - [ ] Controller: `$attachments = Attachment::getAttachments('your-scope-key', $scopeId);`
    - [ ] Controller: `compact('attachments')`
    - [ ] View Mode (Blade): `@include('layouts.attachments')` (If you want a custom view layout, you can include your chosen layout instead of ours)

## Pluggable portions (Things can be modified)
There are certain things developed as a variable, that can be modified according to the necessity:
- `$uploadMaxSize`: Maximum Upload Size. Default: 5mb.
- `$defaultExtensions`: Default accepted file extensions. Default: jpg, gif, png, pdf.
- `attachment_block_head_class`: `@section('attachment_block_head_class', 'your-custom-class')` can be passed to the attachments blade for your custom need. Default: 'section-head'.
- `attachment_block_head`: `@section('attachment_block_head', 'My Attachments')` can be passed to the attachments blade for your custom need. Default: 'Attachments'.

## Error Handling
Most of the errors during handling the files upload are suppressed. But what we have checked during the add/edit process can be grabbed like below:

```php
// returns true, if all the attachments are uploaded duly;
// returns array of errors, if any one of the attachments failed to upload.
$attachmentInfo = Attachment::storeAttachments(...);
if( is_array($attachmentInfo) ) {
    return redirect()->back()->withErrors($attachmentInfo);
}
```

And you can display the errors in blade using the following code:

```html
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

## Known Issues/When not to use
- **Variable number of Attachments not supported:** If you want to let the user add attachments on their choice, and there are no fixed attachments are defined, this repository won't fit
- **No separate uploading (Larger files matter):** The module will store files (attachments) when the parent form will store data. If you are dealing with larger files and there are many types defined then the `max_input_vars` in `php.ini` needs to revised or altered using `.htaccess` with the resource [available here](https://stackoverflow.com/a/2364875/1743124). (**Solution:** A possible solution could be to use JavaScript-based file upload)
- **JavaScript-based upload will change file path:** If the file upload part is managed using JavaScript upload, then the `/scope_key/scope_id/file.ext` concept won't work, and the files will be stored in `/year/month/file.ext` path

## License
The code is licensed in [GPL3](https://opensource.org/licenses/GPL-3.0).

## Credits
Project initiated and lead by Mr. Mayeenul Islam Mayeen ([`@mayeenulislam`](https://twitter.com/mayeenulislam)). Ms. Mowshana Farhana Mow implemented the idea. Thanks to Mr. Nazmul Hasan, Tanvir Rahman, Shakhawat Hossain Mollah, and Shipon Hossain for their valuable feedback and guidance.

----
<sup>2019 [TechnoVista Limited](http://technovista.com.bd/)</sup>
