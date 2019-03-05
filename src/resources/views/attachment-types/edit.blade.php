@extends('shongjukti::layouts.layout')

@section('content')
	<form action="{{ route('attachment_type.update', $attachmentType->id) }}" method="POST">
		@include('shongjukti::attachment-types/form')
		@method('PATCH')
	</form>
@endsection
