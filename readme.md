![shongjukti-by-technovista-limited](https://user-images.githubusercontent.com/4551598/53943836-2d69a780-40e8-11e9-9aa8-8d7a66ae85d8.png)

# Shongjukti (সংযুক্তি)

[![GitHub release](https://img.shields.io/github/release-pre/technovistalimited/shongjukti.svg?style=flat&color=green)](https://github.com/technovistalimited/shongjukti/releases)
[![GitHub license](https://img.shields.io/github/license/technovistalimited/shongjukti.svg?style=flat&color=blue)](https://github.com/technovistalimited/shongjukti/blob/master/LICENSE)
[![Laravel Package](https://img.shields.io/badge/laravel-yes-orange.svg?style=flat&logo=laravel&color=red)](https://laravel.com/)

A reusable component for managing attachments in Laravel-based web application.

The repository was developed as a sub-project of an existing project, with a mission to re-use this code with less effort wherever necessary.

## Table of Contents
<!-- MarkdownTOC -->

- [Requirements](#user-content-requirements)
- [Features](#user-content-features)
- [Installation](#user-content-installation)
	- [Step 1: Download and Set in place](#user-content-step-1-download-and-set-in-place)
	- [Step 2: Add the repository to your app](#user-content-step-2-add-the-repository-to-your-app)
	- [Step 3: Let composer do the rest](#user-content-step-3-let-composer-do-the-rest)
	- [Step 4: Publish the Necessary files](#user-content-step-4-publish-the-necessary-files)
	- [Ready](#user-content-ready)
- [Configuration](#user-content-configuration)
- [How to Use \(Implementation\)](#user-content-how-to-use-implementation)
- [UI \(User Interface\)](#user-content-ui-user-interface)
- [Pluggable portions \(Things can be modified\)](#user-content-pluggable-portions-things-can-be-modified)
- [Error Handling](#user-content-error-handling)
- [Overriding Things](#user-content-overriding-things)
	- [Overriding Routes](#user-content-overriding-routes)
- [Known Issues/When not to use](#user-content-known-issueswhen-not-to-use)
- [Roadmap](#user-content-roadmap)
- [License](#user-content-license)
- [Credits](#user-content-credits)

<!-- /MarkdownTOC -->


## Requirements
- Laravel 5.6+ (Tested up to 5.8.x)
- Bootstrap 3.4.1 styles (grids, panels, forms, alerts, buttons) - non-breaking for Bootstrap 4
- jQuery 2.x+

## Features
- _Defined_ attachments can be managed
- Attachments can be defined for any types of scopes
- A custom label can be accepted where necessary
- Mandatory and optional attachments can be defined and managed accordingly
- Maximum upload size [per file] can be defined globally
- Accepted file types can be managed globally
- Accepted file types can be defined for each of the types of attachment
- Translation-ready (English and Bengali are defined by default)

Features that _not_ present can be found under "Known Issues" section.

## Installation

### Step 1: Download and Set in place

> **NOTICE**<br>
> The package is NOT AVAILABLE in Packagist yet, hence you have to download it from this repository.

**Option 1: Git clone (Faster)**
Open the command console in your application root, and type:
```
git clone https://github.com/technovistalimited/shongjukti.git packages/technovistalimited/shongjukti
```

This will download the package in: `packages\technovistalimited\shongjukti\...`

**Option 2: Download zip (Manual)**

For a cleaner version of the package proceed this way:

1. Create a directory in your app root with the name `packages`.
2. Create another directory named `technovistalimited` (vendor name) under `packages`.
3. [Download the latest release](https://github.com/technovistalimited/shongjukti/releases), extract the archive and put it under the `packages\technovistalimited` directory.

### Step 2: Add the repository to your app
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

Add the following string to the `config/app.php` under `providers` array:
```php
Technovistalimited\Shongjukti\ShongjuktiServiceProvider::class,
```

**Aliases array**

Add the following line to the `config/app.php` under `aliases` array:

```php
'Shongjukti' => Technovistalimited\Shongjukti\Facades\Shongjukti::class,
```

### Step 3: Let composer do the rest

Open up command console on the root of your app and run:
```
composer dump-autoload
```

### Step 4: Publish the Necessary files
Make the configuration, migration, and view files ready first:
```
php artisan vendor:publish --tag=shongjukti
```

Create the necessary tables:
```
php artisan migrate
```

### Ready
Open your browser to your app URL and get to `/attachment-types`. For example: `http://localhost:8000/attachment-types`

## Configuration
Change configuration in `config/shongjukti.php`.

> **Maximum Upload Size:**
>
> Set the maximum upload size (per file), under `'upload_max_size'`.<br>
> Accepts: _integer_ in bytes<br>
> _default_: `5000000` - 5mb in bytes
>
> **Default Extensions:**
>
> Set the default accepted extensions, if per-attachment accepted extensions are not set, under `'default_extensions'`.<br>
> Accepts: _string_ of comma-separated extensions (with or without dots)<br>
> _default_: `'jpg, gif, png, pdf'`
>
> **Attachment Scopes:**
>
> Set the maximum upload size (per file), under `'attachment_scopes'`.<br>
> Known issue: Config file cannot take translatable strings. :(<br>
> Accepts: _array_ of Scopes in key-value pair<br>
> _default_: `['demo-application' => 'Demo Application']`

## How to Use (Implementation)

- [**Implementation Guide**](https://github.com/technovistalimited/shongjukti/blob/master/docs/implementation.md)
- [Implementation Checklist](https://github.com/technovistalimited/shongjukti/blob/master/docs/implementation-checklist.md) (guideline from other perspective)

## UI (User Interface)

The design is not the primary concern of the package and is not implemented as visible in the screenshots.

✔️ **_The basic functional UI with no blocking UX is implemented._**

But the screenshots are taken from the actual use case where we modified things to match with our custom layouts in Limitless admin framework with Bootstrap 3.3.7.

[📌 See Screenshots](https://github.com/technovistalimited/shongjukti/blob/master/docs/screenshots.md)

## Pluggable portions (Things can be modified)
There are certain things developed like a variable, that can be modified according to the necessity:

> **`attachment_block_head_class`:**
>
> From your parent `create`, `edit` and `show` blade you can pass
> `@section('attachment_block_head_class', 'your-custom-class')` to the attachments blade.<br>
> Default: 'section-head'.
>
> **`attachment_block_head`:**
>
> From your parent `create`, `edit` and `show` blade you can pass
> `@section('attachment_block_head', 'My Attachments')` to the attachments blade.<br>
> Default: 'Attachments'.
>
> **`attachment_type_form_submit_btn`:**
>
> From the attachment type `create` and `edit` blade `@section('attachment_type_form_submit_btn', 'Update')` can be passed.<br>
> Default: 'Save'.

## Error Handling
Most of the errors during handling the files upload are suppressed. But what we have checked during the add/edit process can be grabbed like below:

```php
// returns true, if all the attachments are uploaded duly;
// returns an array of errors if any one of the attachments failed to upload.
$attachmentInfo = Shongjukti::storeAttachments(...);
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
- **Variable number of Attachments not supported:**<br>
If you want to let the user add attachments on their choice, and there are no fixed attachments defined, this repository won't fit
- **No separate uploading (Larger files matter):**<br>
The module will store files (attachments) when the parent form will store data. If you are dealing with larger files and there are many types defined then the `max_input_vars` in `php.ini` needs to be revised, or altered using `.htaccess` with the resource [available here](https://stackoverflow.com/a/2364875/1743124). (**Solution:** A possible solution could be to use JavaScript-based file upload)
- **JavaScript-based upload will change file path:**<br>
If the file upload part is managed using JavaScript upload, then the `/scope_key/scope_id/file.ext` concept won't work, and the files will be stored in `/year/month/file.ext` path, unless the `scope_id` is managed by any way

## Roadmap
- [ ] Facilitate to employ multiple segments in the same scope to accept segmented attachments
- [x] Make it more robust to use like a Laravel package
- [ ] If a Laravel package is been developed, publish it to packagist.org

## License
The code is licensed in [GPL3](https://opensource.org/licenses/GPL-3.0).

## Credits
Project initiated and lead by Mr. Mayeenul Islam Mayeen ([`@mayeenulislam`](https://twitter.com/mayeenulislam)). Ms. Mowshana Farhana Mow implemented the idea. Heartiest thanks to Mr. Nazmul Hasan, Tanvir Rahman, Shakhawat Hossain Mollah, and Shipon Hossain for their valuable feedback and guidance.

----
<sup>[TechnoVista Limited](https://technovista.com.bd/)</sup>
