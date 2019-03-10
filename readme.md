![Shongjukti - Laravel Package for Attachment Management by TechnoVista Limited](https://user-images.githubusercontent.com/4551598/54081078-af481380-4328-11e9-9c71-792d75f5867a.png)

# Shongjukti (সংযুক্তি)

[![GitHub release](https://img.shields.io/github/release/technovistalimited/shongjukti.svg?style=flat&color=green)](https://github.com/technovistalimited/shongjukti/releases)
[![GitHub license](https://img.shields.io/github/license/technovistalimited/shongjukti.svg?style=flat&color=blue)](https://github.com/technovistalimited/shongjukti/blob/master/LICENSE)
[![Laravel Package](https://img.shields.io/badge/laravel-yes-orange.svg?style=flat&logo=laravel&color=red&logoColor=white)](https://laravel.com/)

A reusable component for managing attachments in Laravel-based web application.

The repository was developed as a sub-project of an existing project, with a mission to re-use this code with less effort wherever necessary.

## Table of Contents
<!-- MarkdownTOC -->

- [Requirements](#user-content-requirements)
- [Features](#user-content-features)
- [Documentation](#user-content-documentation)
	- [Install & Configure](#user-content-install--configure)
	- [How to Use](#user-content-how-to-use)
	- [Utilities](#user-content-utilities)
	- [Error Handling](#user-content-error-handling)
- [UI \(User Interface\)](#user-content-ui-user-interface)
- [Known Issues \(When not to use\)](#user-content-known-issues-when-not-to-use)
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

## Documentation

### Install & Configure
- [Installation](https://github.com/technovistalimited/shongjukti/wiki/Installation)
- [Configuration](https://github.com/technovistalimited/shongjukti/wiki/Configuration)

### How to Use
- [Implementation Guide](https://github.com/technovistalimited/shongjukti/wiki/Implementation)
- [Implementation Checklist](https://github.com/technovistalimited/shongjukti/wiki/Implementation-Checklist) (guideline from other perspective)
- [Overriding Things](https://github.com/technovistalimited/shongjukti/wiki/Overriding-Things)

### Utilities
- [Necessary Methods (Functions)](https://github.com/technovistalimited/shongjukti/wiki/Necessary-Methods-(Functions))
- [Pluggable Portions (Things can be modified)](https://github.com/technovistalimited/shongjukti/wiki/Pluggable-Portions-(Things-can-be-modified))

### Error Handling
- [Error Handling](https://github.com/technovistalimited/shongjukti/wiki/Error-Handling)


## UI (User Interface)

The design is not the primary concern of the package and is not implemented as visible in the screenshots.

✔️ **_The basic functional UI with no blocking UX is implemented._**

But the screenshots are taken from the actual use case where we modified things to match with our custom layouts in Limitless admin framework with Bootstrap 3.3.7.

[📷 See Screenshots](https://github.com/technovistalimited/shongjukti/wiki/Screenshots)

## Known Issues (When not to use)
- **Variable number of Attachments not supported:**<br>
If you want to let the user add attachments on their choice, and there are no fixed attachments defined, this repository won't fit
- **No separate uploading (Larger files matter):**<br>
The module will store files (attachments) when the parent form will store data. If you are dealing with larger files and there are many types defined then the `max_input_vars` in `php.ini` needs to be revised, or altered using `.htaccess` with the resource [available here](https://stackoverflow.com/a/2364875/1743124). (**Solution:** A possible solution could be to use JavaScript-based file upload)
- **JavaScript-based upload will change file path:**<br>
If the file upload part is managed using JavaScript upload, then the `/scope_key/scope_id/file.ext` concept won't work, and the files will be stored in `/year/month/file.ext` path, unless the `scope_id` is managed by any way

## Roadmap
- [ ] Facilitate to employ multiple segments in the same scope to accept segmented attachments
- [x] Make it more robust to use like a Laravel package
- [x] If a Laravel package is been developed, publish it to packagist.org

## License
The code is licensed in [GPL3](https://opensource.org/licenses/GPL-3.0).

## Credits
Project initiated and lead by Mr. [Mayeenul Islam Mayeen](https://github.com/mayeenulislam). Ms. [Mowshana Farhana Mow](https://github.com/mowshana) implemented the idea.<br>
Heartiest thanks to Mr. Nazmul Hasan, Tanvir Rahman, Shakhawat Hossain Mollah, and Shipon Hossain for their valuable feedback and guidance.

----
<sup>[TechnoVista Limited](https://technovista.com.bd/)</sup>
