@extends('dashboard.master')
@section('title', 'home page')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/summernote/css/summernote.css') }}">

<style>

</style>
@stop
@section('content')
<?php  $topmenu='Advertise'; ?>
<?php $activemenu = 'Advertise'; ?>
@include('dashboard.include.sidebar')

    <div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->

			@include('dashboard.user.agents.include.sidebar')
			@include('dashboard.user.agents.include.sidebar-dashbord')
			<!--End Left Sidebar-->
			<!-- Profile Content -->
			<div class="col-md-9">
				<h1 class="margin-bottom-40">Ad Package List</h1>
				<div class="box-shadow-profile homedata homedataposts ">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="panel-title heading-sm pull-left"><i class="fa fa-newspaper-o"></i>Package. 
								<a href="{{ url('manageads') }}" class="btn btn-success">Manage Advertisment</a></h2>
						</div>
						
							<div class="panel-body">
								<div class="row">
									@foreach($package as $pack)
									<div class="col-md-4">
										<h2>{{ $pack->title }}</h2>
										<h3> Pricesss: $ {{ $pack->price }}</h3>
										<?php echo $pack->details ?>
										<br>
										@if($pack->price!=0)
										<a class="btn btn-success" href="{{ url('/paymentpage/'.$pack->package_id) }}">PAY $ {{ $pack->price }}</a>
										@endif
										
									</div>		
									@endforeach							
								</div>
								
							</div>
						
					</div>
					<!-- Default Proposals -->
				</div>
				
				

				
			</div>
			<!-- End Profile Content -->
		</div>
	</div>	
	<!-- survey popup -->
	<div class="modal fade" id="addblog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content not-top">
					<div class="modal-header">
						<h4>Add Blog</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title-text"></h4>
					</div>
					<div class="modal-body">
						{!! Form::open(array('method' => 'POST','url' => route('blog.addblog'),'class'=>'form-horizontal','role'=>'form')) !!}

		                <div class="row">
		                  <div class="col-md-12">
		                      <label>Title</label>
		                      <input type="text" name="title" class="form-control text-uppercase" placeholder="Blog Title" required>
		                  </div>
		                  
		                  <div class="col-md-12">
		                      <label>Description</label>
		                      <textarea id="summernote" class="form-control" name="description" required></textarea>
		                  </div>
		                </div>
		                <div class="col-md-12 text-center" style="margin-top: 15px;">
		                  <button class="btn-u btn-u-success">Submit</button>
		                </div>
		              {{ Form::close() }}
					</div>
					<div class="modal-footer foote-nb">
					
					</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')

@stop