<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  
<html> 
@include('front.include.head')
	<body class="home">
		<div class="wrap">
	        
	        @yield('content')
			
			@include('front.include.footer')

	    </div>
		@include('front.include.script')
	</body><!-- rex -->
</html>