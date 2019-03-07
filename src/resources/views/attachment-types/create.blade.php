@extends('shongjukti::layouts.layout')

@section('page_header', __('shongjukti::messages.new_attachment_type'))

@section('page_header_right')
    <a href="{{ Shongjukti::attachmentTypeIndexLink() }}" class="btn btn-primary">
        {{ __('shongjukti::messages.list') }}
    </a>
@endsection

@section('content')
	<form action="{{ route('attachment_type.store') }}" method="POST">
		@include('shongjukti::attachment-types/form')
	</form>
@endsection
