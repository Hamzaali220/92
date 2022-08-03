	<head>
        <title> 92 Agents - @yield('title') </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ @URL::asset('assets/img/fav.png') }}">
		<script src="https://js.stripe.com/v3/"></script>
		@include('dashboard.include.style')
    </head>