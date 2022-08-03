@extends('dashboard.master')
@section('title', 'home page')
@section('style')


<style>
.payment-btn {
    padding: 1.3rem 2rem;
    /* border-radius: 50px; */
    color: #fff;
    background-color: #4a4a4a;
}
</style>
@stop
@section('content')
<?php  $topmenu='Advertise'; ?>
<?php $activemenu = 'Advertise'; ?>
@include('dashboard.include.sidebar')


<div class="container content profile">
	<div class="row">
		<!--Left Sidebar-->
		@include('dashboard.user.buyers.include.sidebar')
		@include('dashboard.user.buyers.include.sidebar-dashbord')
		<!--End Left Sidebar-->
		<!-- Profile Content -->
		<div class="col-md-9">
			<!-- <h1 class="margin-bottom-40"></h1> -->
			<div class="box-shadow-profile homedata homedataposts ">
				<!-- Default Proposals -->
				<div class="panel-profile">
					<div class="panel-heading overflow-h air-card">
						<h2 class="panel-title heading-sm pull-left"><i class="fa fa-newspaper-o"></i>Configure Ad</h2>
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-md-offset-2 col-md-8">
								@if(!isset($status))
								<form action="{{ url('/configureads') }}" method="post" enctype="multipart/form-data">
									{{ csrf_field() }}
									<input type="hidden" name="ad_id" value="{!! $ad_id !!}">
									  <div class="form-group">
									    <span for="ad_title">Ad Title</span>
									    <input type="title" class="form-control" name="ad_title" id="ad_title">
									  </div>
									  <div class="form-group">
									    <span for="ad_link">Link</span>
									    <input type="text" class="form-control" name="ad_link" id="ad_link">
									  </div>

									  @if(isset($ad_details))
									  	@if($ad_details->image == 1)
									  		<input type="hidden" name="image_f" value="1">
									  		<div class="form-group">
											    <span for="Image_link">Image</span>
											    <input type="file" class="form-control" name="ad_banner" id="ad_photo">
										  	</div>
									  	@endif

								  		@if($ad_details->content == 1)
								  			<input type="hidden" name="content_f" value="1">
									  		<div class="form-group">
											    <span for="ad_content">Ad content</span>
											    <textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control jqte-test"  name="ad_content"></textarea>
										  	</div>
									  	@endif

									  @endif

									  
									  <button type="Submit" class="btn btn-default">Save</button>
									</form>
								@endif

								@if(isset($status))
									@if($status == 'success')
										<div class="alert alert-success alert-dismissible">
										  <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
										  <strong>Success!</strong> {!! $message !!}
										</div>
									@else
										<div class="alert alert-danger alert-dismissible">
										  <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
										  <strong>Failed!</strong> {!! $message !!}
										</div>
									@endif
								@endif
							</div>
						</div>
					</div>

			</div>
			<!-- Default Proposals -->
		</div>




	</div>
	<!-- End Profile Content -->
</div>
</div>	


@endsection

@section('scripts')

@stop