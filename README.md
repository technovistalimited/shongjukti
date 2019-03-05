# Shongjukti (সংযুক্তি)

A reusable component for managing attachments in Laravel-based web application.

The repository was developed as a sub-project of an existing project, with a mission to re-use this code with less effort wherever necessary.

## Requirements
- Laravel 5.5+ (Tested up to 5.8.x)
- Bootstrap 3.3.7 styles (grids, panels, forms, alerts, buttons)
- jQuery

## Features
- _Defined_ attachments can be managed
- Attachments can be defined for any types of scopes
- Custom label can be accepted where necessary
- Mandatory and optional attachments can be defined and managed accordingly
- Maximum upload size [per file] can be defined globally
- Accepted file types can be managed globally
- Accepted file types can be defined for each of the types of attachment
- Translation-ready (English and Bengali are defined by default)

Features that _not_ present can be found below, under "Known Issues" section.

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

## Installation

The package is **NOT AVAILABLE in Packagist** yet, hence you have to download it from this repository.<br>
[<kbd>**DOWNLOAD v0.1.0**</kbd>](https://github.com/technovistalimited/shongjukti/releases/tag/v0.1.0)

#### Step 1: Put the package in place
- [ ] Create a directory in your app root with the name `packages`.
- [ ] Create another directory under `packages` named `technovistalimited`. (vendor name)
- [ ] Download the latest release, extract the archive and put it under the `packages\technovistalimited` directory.

Your directory structure would be: `packages\technovistalimited\shongjukti\...`

#### Step 2: Add the repository to your app
**composer.json**

Open up the `composer.json` of your app root and add the following line under `psr-4` `autoload` array:
```
"Technovistalimited\\Shongjukti\\": "packages/technovistalimited/shongjukti/src/"
```

So it would look similar to _this_:
```
"autoload": {
    "psr-4": {
        "Technovistalimited\\Shongjukti\\": "packages/technovistalimited/shongjukti"
    }
}
```

**Providers array**

Add the following string to `config/app.php` under `providers` array:
```php
Technovistalimited\Shongjukti\ShongjuktiServiceProvider::class,
```

#### Step 3: Let composer do the rest

Open up command console on the root of your app and run:
```
composer dump-autoload
```

#### Step 4: Publish the Necessary files
Make the configuration, migration, view files ready first:
```
php artisan vendor:publish --tag=shongjukti
```

Create the necessary tables:
```
php artisan migrate
```

And the final step is to add the following line to the `aliases` section in file `config/app.php`:

<!-- ```php
'Shongjukti' => 'Technovistalimited\Shongjukti\App\Controllers\AttachmentController',
``` -->

## Configuration
Change configuration in `config/shongjukti.php`.

### Maximum Upload Size:
Set the maximum upload size (per file), under `'upload_max_size'`.<br>
Accepts: _integer_ in bytes<br>
_default_: `5000000` - 5mb in bytes

### Default Extensions:
Set the default accepted extensions, if per-attachment accepted extensions are not set, under `'default_extensions'`.<br>
Accepts: _string_ of comma-separated extensions (with or without dots)<br>
_default_: `'jpg, gif, png, pdf'`

### Attachment Scopes:
Set the maximum upload size (per file), under `'attachment_scopes'`.<br>
Known issue: Config file cannot take translatable strings. :(<br>
Accepts: _array_ of Scopes in key-value pair<br>
_default_: `['demo-application' => 'Demo Application']`


### API: How to use

During usage, change all the `demo-application` with your scope key. All the code mentioned are not supposed to be modified, even the variables are needed to mentioned exact. But only `$scopeId` or `$yourScope->ID` or `$id` should be replaced with _your_ scope id.

- [ ] **Register:** Register the `scope_key` at the `config/shongjukti.php` at the `'attachment_scopes'` (hyphenated please)

- [ ] Controller: `use Technovistalimited\Shongjukti\App\Models\AttachmentType;`
- [ ] Controller: `use Technovistalimited\Shongjukti\App\Models\Attachment;`

- [ ] **`Create()` Method** - _responsible for displaying the add page_
    - [ ] Controller: `$attachmentTypes = AttachmentType::getAttachmentTypesByScopeKey('demo-application');`
    - [ ] Controller: `compact('attachmentTypes')`
    - [ ] Add Mode (Blade): add `enctype="multipart/form-data"` to your parent `<form>` tag
    - [ ] Add Mode (Blade): `@include('shongjukti::layouts.attachments')` inside the `<form></form>` tag
    - [ ] Add Mode (Blade): `<link rel="stylesheet" href="{{ asset('vendor/shongjukti/css/shongjukti.css') }}">`
    - [ ] Add Mode (Blade): `<script src="{{ asset('vendor/shongjukti/js/shongjukti.js') }}"></script>` (depends on jQuery)

- [ ] **`Store()` Method** - _responsible for storing new data_
    - [ ] Controller: `Attachment::storeAttachments($request->all(), 'demo-application', $yourScope->id);` - after saving your scope, pass the scope id here

- [ ] **`Edit()` Method** - _responsible for displaying the edit page_
    - [ ] Controller: `$attachmentTypes = AttachmentType::getAttachmentTypesByScopeKey('demo-application');`
    - [ ] Controller: `$attachments = Attachment::getAttachmentsForEdit('demo-application', $id);`
    - [ ] Controller: `compact( 'attachmentTypes', 'attachments')`
    - [ ] Edit Mode (Blade): add `enctype="multipart/form-data"` to your parent `<form>` tag
    - [ ] Edit Mode (Blade): `@include('shongjukti::layouts.attachments')` inside the `<form></form>` tag
    - [ ] Edit Mode (Blade): `<link rel="stylesheet" href="{{ asset('vendor/shongjukti/css/shongjukti.css') }}">`
    - [ ] Edit Mode (Blade): `<script src="{{ asset('vendor/shongjukti/js/shongjukti.js') }}"></script>` (depends on jQuery)

- [ ] **`Update()` Method** - _responsible for storing edited data_
    - [ ] Controller: `Attachment::storeAttachments($request->all(), 'demo-application', $id);`

- [ ] **`Show()` Method** - _responsible for displaying the view page_
    - [ ] Controller: `$attachments = Attachment::getAttachments('demo-application', $id);`
    - [ ] Controller: `compact('attachments')`
    - [ ] View Mode (Blade): `@include('shongjukti::layouts.attachments')` (If you want a custom view layout, you can include your chosen layout instead of ours)


## Pluggable portions (Things can be modified)
There are certain things developed as a variable, that can be modified according to the necessity:
- **`attachment_block_head_class`:** `@section('attachment_block_head_class', 'your-custom-class')` can be passed to the attachments blade for your custom need. Default: 'section-head'.
- **`attachment_block_head`:** `@section('attachment_block_head', 'My Attachments')` can be passed to the attachments blade for your custom need. Default: 'Attachments'.

## Error Handling
Most of the errors during handling the files upload are suppressed. But what we have checked during the add/edit process can be grabbed like below:

```php
// returns true, if all the attachments are uploaded duly;
// returns array of errors, if any one of the attachments failed to upload.
$attachmentInfo = Attachment::storeAttachments(...);
if( is_array($attachmentInfo) ) {
    return back()->withErrors($attachmentInfo);
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

## Overriding Things

### Overriding Routes
If you want to override the routes defined by the package, you will need to follow the [this StackOverflow thread on how to override package routes in the application](https://stackoverflow.com/a/44724330/1743124).


## Known Issues/When not to use
- **Variable number of Attachments not supported:** If you want to let the user add attachments on their choice, and there are no fixed attachments are defined, this repository won't fit
- **No separate uploading (Larger files matter):** The module will store files (attachments) when the parent form will store data. If you are dealing with larger files and there are many types defined then the `max_input_vars` in `php.ini` needs to revised or altered using `.htaccess` with the resource [available here](https://stackoverflow.com/a/2364875/1743124). (**Solution:** A possible solution could be to use JavaScript-based file upload)
- **JavaScript-based upload will change file path:** If the file upload part is managed using JavaScript upload, then the `/scope_key/scope_id/file.ext` concept won't work, and the files will be stored in `/year/month/file.ext` path

## Roadmap
- [ ] Facilitate to employ multiple segments in the same scope to accept segmented attachments
- [x] Make it more robust to use like a Laravel package
- [ ] If a Laravel package is been developed, publish it to packagist.org

## License
The code is licensed in [GPL3](https://opensource.org/licenses/GPL-3.0).

## Credits
Project initiated and lead by Mr. Mayeenul Islam Mayeen ([`@mayeenulislam`](https://twitter.com/mayeenulislam)). Ms. Mowshana Farhana Mow implemented the idea. Heartiest thanks to Mr. Nazmul Hasan, Tanvir Rahman, Shakhawat Hossain Mollah, and Shipon Hossain for their valuable feedback and guidance.

----
<sup>2019 [TechnoVista Limited](http://technovista.com.bd/)</sup>
