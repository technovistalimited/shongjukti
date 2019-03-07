## Implementation Checklist - Shongjukti

During usage, change all the `demo-application` with your scope key. The variables are needed to mentioned exact. But only `$scope->ID` or `$id` should be replaced with _your_ scope id.

### Onetime
- [ ] **gitignore:** add `public/attachments/` in project `.gitignore` if you don't want to track uploaded attachment files in Git

### Recurring (per use case)
- [ ] **Register:** Register the `scope_key` at the `config/shongjukti.php` at the `'attachment_scopes'` (hyphenated please)

- [ ] **Controller:** `use Shongjukti;`

- [ ] **`Create()` Method** - _responsible for displaying the add page_
	- [ ] Controller: `$attachmentTypes = Shongjukti::getAttachmentTypesByScopeKey('demo-application');`
	- [ ] Controller: `compact('attachmentTypes')`
	- [ ] Add Mode (Blade): add `enctype="multipart/form-data"` to your parent `<form>` tag
	- [ ] Add Mode (Blade): `@include('shongjukti::layouts.attachments')` inside the `<form></form>` tag
	- [ ] Add Mode (Blade): `<link rel="stylesheet" href="{{ asset('vendor/shongjukti/css/shongjukti.css') }}">`
	- [ ] Add Mode (Blade): `<script src="{{ asset('vendor/shongjukti/js/shongjukti.js') }}"></script>` (depends on jQuery)

- [ ] **`Store()` Method** - _responsible for storing new data_
	- [ ] Controller: `Shongjukti::storeAttachments($request->all(), 'demo-application', $yourScope->id);` - after saving your scope, pass the scope id here

- [ ] **`Edit()` Method** - _responsible for displaying the edit page_
	- [ ] Controller: `$attachmentTypes = Shongjukti::getAttachmentTypesByScopeKey('demo-application');`
	- [ ] Controller: `$attachments = Shongjukti::getAttachmentsForEdit('demo-application', $id);`
	- [ ] Controller: `compact( 'attachmentTypes', 'attachments')`
	- [ ] Edit Mode (Blade): add `enctype="multipart/form-data"` to your parent `<form>` tag
	- [ ] Edit Mode (Blade): `@include('shongjukti::layouts.attachments')` inside the `<form></form>` tag
	- [ ] Edit Mode (Blade): `<link rel="stylesheet" href="{{ asset('vendor/shongjukti/css/shongjukti.css') }}">`
	- [ ] Edit Mode (Blade): `<script src="{{ asset('vendor/shongjukti/js/shongjukti.js') }}"></script>` (depends on jQuery)

- [ ] **`Update()` Method** - _responsible for storing edited data_
	- [ ] Controller: `Shongjukti::storeAttachments($request->all(), 'demo-application', $id);`

- [ ] **`Show()` Method** - _responsible for displaying the view page_
	- [ ] Controller: `$attachments = Shongjukti::getAttachments('demo-application', $id);`
	- [ ] Controller: `compact('attachments')`
	- [ ] View Mode (Blade): `@include('shongjukti::layouts.attachments')` (If you want a custom view layout, you can include your chosen layout instead of ours)

----
<sup>[TechnoVista Limited](https://technovista.com.bd/)</sup>
