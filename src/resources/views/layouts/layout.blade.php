<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Shongjukti') }}</title>

		<!-- Styles -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<link href="{{ asset('vendor/shongjukti/css/shongjukti.css') }}" rel="stylesheet">

	</head>
	<body>

		<div class="container">
			@yield('content')
		</div>

		<!-- Scripts -->
		<script src="{{ asset('vendor/shongjukti/js/attachment-type.js') }}"></script>

	</body>

</html>
