@extends('shongjukti::layouts.layout')

@section('content')
	<form action="{{ route('attachment_type.store') }}" method="POST">
		@include('shongjukti::attachment-types/form')
	</form>
@endsection
