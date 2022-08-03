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
						<h2 class="panel-title heading-sm pull-left"><i class="fa fa-newspaper-o"></i>Manage Ads</h2>
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table">
								    <thead>
								      <tr>
								        <th>#</th>
								        <th>Package</th>
								        <th>Purchased Date</th>
								        <th>Clicks</th>
								        <th>Receipt URL</th>
								        <th>Status</th>
										<th>Configuration</th>
								      </tr>
								    </thead>
								    <tbody>
							    		
								    	@if(!empty($ad_list))
									    	@foreach($ad_list as $i => $ad)
									    		 <tr>
											        <td>{!! $i+1 !!}</td>
											        <td>{!! $ad->title !!}</td>
											        <td>{!! est_std_date($ad->created_ts) !!}</td>
											        <td>{!! $ad->clicks !!}</td>
											        <td>

											        	<a target="_blank" href="{{ url('/advertiseinvoice/'.$ad->id) }}"> 
											        		<i class="fa fa-file-text-o" aria-hidden="true"></i> View Receipt 
											        	</a>

											        	<!-- <a target="_blank" href ="{!! $ad->receipt_url !!}"> <i class="fa fa-file-text-o" aria-hidden="true"></i> View Receipt  </a> -->
											        </td>
											        <td>{!! ($ad->status == 1 ) ? 'Enabled' : 'Disabled' !!}</td>
											        <td><a href="{{ url('/configureads/'.$ad->id) }}"><i class="fa fa-2x fa-cog" aria-hidden="true"></i></a></td>
											      </tr>
									    	@endforeach
								    	@endif
								    </tbody>
								    <tfoot>
								    	<tr class="text-right">
								    		<th colspan="7" style="">{{ $ad_list->links() }}</th>
								    	</tr>
								    </tfoot>
								  </table>
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