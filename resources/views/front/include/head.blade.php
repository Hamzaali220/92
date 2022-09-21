<head>
    <title>92 Agents - @yield('title')</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/img/fav.png') }}">
    <!-- Google Fonts -->
 	@include('front.include.style')
   <script src="https://www.google.com/recaptcha/api.js" async defer></script>

   <script type="text/javascript" src="{{ URL::asset('front/js/pace.min.js') }}"></script>

</head>
