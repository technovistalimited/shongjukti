## Implementation - Shongjukti

> A brief checklist for implementation is available<br>
> [<kbd>SEE CHECKLIST</kbd>](https://github.com/technovistalimited/laravel-attachments/blob/develop/docs/implementation-checklist.md)

During usage, change all the `demo-application` with your scope key. The variables are needed to mentioned exact. But only `$scope->ID` or `$id` should be replaced with _your_ scope id.

#### Step 1: Register the Scope
Register the `scope_key` at the `config/shongjukti.php` at the `'attachment_scopes'` (hyphenated please)
```php
'attachment_scopes' => [
	'demo-application' => 'Demo Application',
	'other-application' => 'Other Application'
]
```

#### Step 2: Scope Controller
In your Controller in which you want to implement the Attachment feature, use the package accordingly. Only the applicable lines are present here, the dependent lines are commented out for hints.
```php
use Shongjukti;

class MyController extends Controller
{
	public function index() {

	}

	public function create() {
		$attachmentTypes = Shongjukti::getAttachmentTypesByScopeKey('demo-application');
		return view('my-view.create', compact('attachmentTypes'));
	}

	public function store(Request $request) {
		//$scope = MyModel::create($request->all());

		Shongjukti::storeAttachments($request->all(), 'demo-application', $scope->id);
	}

	public function show($id) {
		$attachments = Shongjukti::getAttachments('demo-application', $id);

		return view('my-view.show', compact('attachments'));
	}

	public function edit($id) {
		$attachmentTypes = Shongjukti::getAttachmentTypesByScopeKey('demo-application');
		$attachments = Shongjukti::getAttachmentsForEdit('demo-application', $id);

		return view('my-view.edit', compact('attachmentTypes', 'attachments'));
	}

	public function update(Request $request, $id) {
		Shongjukti::storeAttachments($request->all(), 'demo-application', $id);
	}

	public function destroy($id) {

	}
}
```

#### Step 3: Scope Blades
**`create.blade.php`**
```html
<link rel="stylesheet" href="{{ asset('vendor/shongjukti/css/shongjukti.css') }}">
<form enctype="multipart/form-data">
	...
	@include('shongjukti::layouts.attachments')
</form>
{{-- <script src="path/to/jquery.js"></script> --}}
<script src="{{ asset('vendor/shongjukti/js/shongjukti.js') }}"></script>
```



**`edit.blade.php`**
```html
<link rel="stylesheet" href="{{ asset('vendor/shongjukti/css/shongjukti.css') }}">
<form enctype="multipart/form-data">
	...
	@include('shongjukti::layouts.attachments')
</form>
{{-- <script src="path/to/jquery.js"></script> --}}
<script src="{{ asset('vendor/shongjukti/js/shongjukti.js') }}"></script>
```


**`show.blade.php`**
```html
<link rel="stylesheet" href="{{ asset('vendor/shongjukti/css/shongjukti.css') }}">
@include('shongjukti::layouts.attachments')
```

----
<sup>[TechnoVista Limited](https://technovista.com.bd/)</sup>
