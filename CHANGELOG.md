# Changelog

> **CHANGES**<br>
> Use the following command for the commits in-between two releases:<br>
> `git log 'v2.0.0'..'v2.0.1' --oneline` # changes between v2.0.0-v2.0.1<br>
> `git log 'v2.0.0'..master --oneline` # changes between v2.0.0-master

## Unreleased

<details>
  <summary>
    Changes that have landed in master but are not yet released.
    <strong>Click to see more</strong>.
  </summary>

* Nothing for now :)

</details>

## `v2.0.1` - 2021-02-25 - Migration fix version

* Fix: Migration for the `attachments` table is fixed prior to `v1.1.1`

## `v2.0.0` - 2021-02-09 - Composer 2.0 Compatible Release

* Major Change: Controllers' and Models' Namespaces are changed
* Directory changed for Controllers and Models

### Migration Guide

Find whether you used these:

```php
Shongjukti\App\Controllers
Shongjukti\App\Models
```

If used, replace them with

```php
Shongjukti\Controllers
Shongjukti\Models
```

## `v1.1.2` - 2020-01-07 - Fix Release

* Config: Maximum upload size limit is now described in binary bytes
* Feature: Bootstrap-4 specific javascript validation

## `v1.1.1` - 2019-11-04 - Fix Release

* Add fields: `created_at` and `updated_at` data to db
* Fix: PHPCS ignore linelength warning

## `v1.1.0` - 2019-10-01 - Feature Release

* License changed from GPL-3 to MIT
* Feature: Support added for Shape files (`.shp`, `.shx`)
* Refactor: Return the ID of the attachment on successful upload instead of boolean
* Fix: Maximum Upload Size check, in PHP
* Fix: Attachment Type label not showing in Bengali mode (@props Mowshana Farhana)
* Fix: Prioritize `$_POST` value over database values in the form return values
* Changelog added
* General Fixes in Readme file
* Documentation: Update code documentation

### Resources changed

* `views/attachment-types/index.blade.php`
* `views/attachment-types/form.blade.php`
* `views/layouts/attachments.blade.php`
* `assets/css/shongjukti.css`

## `v1.0.4` - 2019-09-02 - Fixed Version

* Fix: Attachment Type Choice was lost in Edit mode due to Cookie storage
* Refactor: Remove 'optional' label from attachments when in view mode

## `v1.0.3` - 2019-08-04 - API Update

* New API for `deleteAttachment()` and `removeAttachment()`

## `v1.0.2` - 2019-08-01 - Bug Fixed and Code Refactored Version

* Fix: CSS declaration was like SCSS nested
* Fix: `storeAttachments()` is preventing storing parent form (Issue#5)
* Fix: `$attachments` causing 'undefined index' error while loading edit view (Issue#6)
* Documentation: Need more specific code snippet on how to override routes (Issue#7)
* Refactor: Added PHPCS Ruleset to PSR-2 Standard
* Refactor: Fixed .editorconfig for a better PHPCS Standard configuration
* Refactor: Fixed PHPCS Errors and Warnings

## `v1.0.1` - 2019-03-10 - Packagist version fixed

* Fixed a blocker bug in the `composer.json`

## `v1.0.0` - 2019-03-10 - Official Release in Packagist

* Packagist-compatible changes

## PRE-RELEASES

### `v0.1.2` - 2019-03-10 - Package Released in Packagist

* Fixed `composer.json` file for the Packagist parsing
* Minor fixes in Attachment Type model

### `v0.1.1` - 2019-03-10 - Bug Fixed Release

* Blocker bug fixed in Attachment Type Controller
* Documentation is completely moved to Github Wiki
* Fixed Translation Strings

### `v0.1.0` - 2019-03-07 - Laravel Package Release

* Initial Pre-Release

### `v0.0.1` - 2019-03-05 - Initial Release

* Functional Laravel Package
