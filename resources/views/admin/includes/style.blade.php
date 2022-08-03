	<!-- CSS Global Compulsory -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/bootstrap/css/bootstrap.min.css') }}"> 
	<link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/dist/css/skins/_all-skins.min.css') }}"> 
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/morris/morris.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/datepicker/datepicker3.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
	<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}"> -->

	<!-- CSS Implementing Plugins -->
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/animate.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/line-icons-pro/styles.css') }}">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/line-icons/line-icons.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') }}">
	<!-- CSS Page Style -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/blocks.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/profile.css') }}">

	<!-- CSS Customization -->
	<link rel="stylesheet" href="{{ URL::asset('assets/css/custom.css') }}">
	<style type="text/css">
		.btn{
			padding: 1px 5px;
		    margin-bottom: 1px;
		    font-size: 12px;
		    color: #fff !important;
		}
		hr{
			margin: 5px 0 !important;
		}
		strong {
		    color: #565350;
		    font-weight: 700;
		}
		.content a.btn i {
			color: white !important;
		}		
	</style>
 @yield('style')