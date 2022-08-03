<head>
	<title> 92Agents - @yield('title') </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{ @URL::asset('assets/img/fav.png') }}">
	@include('admin.includes.style')
 </head>
