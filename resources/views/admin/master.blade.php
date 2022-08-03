<!DOCTYPE html>
 <html lang="en">
 @include('admin.includes.head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	@include('admin.includes.header')
	@include('admin.includes.sidebar')
	@yield('content')
	@include('admin.includes.footer')
	
	<div class="control-sidebar-bg"></div>
 </div>
  @include('admin.includes.script')
</body>
</html>