<!DOCTYPE html>

 <html lang="en">

 @include('dashboard.include.head')

    <body class="header-fixed" style="padding:0 0 0 0 !important;">

        <div class="wrapper main-dashboard" id="appmykamlesh">

            @yield('content')

			@include('dashboard.include.footer')

			

		</div>

		    

    	<!--/wrapper-->

		@include('dashboard.include.script')

    </body>

	<script type="text/javascript">

		

	</script>

</html>