@extends('shongjukti::layouts.layout')

@section('page_header', __('shongjukti::messages.edit_attachment_type'))

@section('page_header_right')
	<a href="{{ Shongjukti::attachmentTypeIndexLink() }}" class="btn btn-primary">
		{{ __('List') }}
	</a>
	<a href="{{ Shongjukti::attachmentTypeCreateLink() }}" class="btn btn-primary">
		{{ __('shongjukti::messages.add_new') }}
	</a>
@endsection

@section('content')
	<form action="{{ route('attachment_type.update', $attachmentType->id) }}" method="POST">
		@include('shongjukti::attachment-types/form')
		@method('PATCH')
	</form>
@endsection
