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
		@include('dashboard.user.agents.include.sidebar')
		@include('dashboard.user.agents.include.sidebar-dashbord')
		<!--End Left Sidebar-->
		<!-- Profile Content -->
		<div class="col-md-9">
			<!-- <h1 class="margin-bottom-40"></h1> -->
			<div class="box-shadow-profile homedata homedataposts ">
				<!-- Default Proposals -->
				<div class="panel-profile">
					<div class="panel-heading overflow-h air-card">
						<h2 class="panel-title heading-sm pull-left"><i class="fa fa-newspaper-o"></i>Payment Status</h2>
					</div>

					<div class="panel-body">
						<div class="row">
							<!-- Payment form -->
								<div class="col-md-offset-2 col-md-8 text-center">
									<?php
									if($status == 1){
										?>
										<i class="fa fa-check fa-5x" aria-hidden="true" style="color:green;"></i>
										<h2>{!! $message !!}</h2>
										<a href="{!! $receipt_url !!}" target="_blank" class="btn-u payment-btn">View Receipt</a>
										<?php
									} else {
										?>
										<i class="fa fa-times fa-5x" aria-hidden="true" style="color:red"></i>
										<h2>{!! $message !!}</h2>
										<a href="{{ url('/dashboard') }}" class="btn-u payment-btn">Go to Dashboard</a>
										<?php
									}

									?>
								</div>

								
						<!-- End of payment form -->
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