@extends('admin.clearpage')
@section('title', 'Ad Purchased invoice')
@section('style')


<style>


</style>
@stop
@section('content')
<?php  $topmenu='pendinginvoices'; ?>
<?php $activemenu = 'pendinginvoices'; ?>


<div class="container content" style="background-color: #fff;">
	<div class="row">
		<!--Left Sidebar-->
		<!-- @include('dashboard.user.agents.include.sidebar') -->
		<!-- @include('dashboard.user.agents.include.sidebar-dashbord') -->
		<!--End Left Sidebar-->
		<!-- Profile Content -->
		<div class="col-md-12">
			<!-- <h1 class="margin-bottom-40"></h1> -->
			<div class="box-shadow-profile homedata homedataposts ">
				<!-- Default Proposals -->
				<div class="panel-profile">
					<div class="panel-body">
						<div class="row">
							<!-- Payment form -->
								<div class="col-md-12">
								<a href="#" onclick="window.print()" class="hidden-print"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th colspan="6" class="text-center">
												<h1 class="text-center"><img id="logo-footer" class="footer-logo" src="{{ URL::asset('assets/img/logo1-default.png') }}" alt=""></h1>
												Address: Zippy Infotech inc30 N Gould st,<br/>
                                   Suite Rsheridn, WY, 82801 Sheridan<br />
						Phone: (615)594-3903 <br/><br>
						<!-- Fax: 000 000 0000 <br /> -->
						Email: <a href="mailto:Support@92agents.com" class="">Support@92agents.com</a>
											</th>
										</tr>
										
									</thead>
									<tbody>
										<tr>
											<th>Agent Name</th>
											<td>{{ $userdetails->name }}</td>
											<th>Agent Email</th>
											<td>{{ $user->email }}</td>
										</tr>
										<tr>
											<th>Contact No.</th>
											<td>{{ $userdetails->phone }}</td>
											<th>Address</th>
											<td>{{ $userdetails->adddress }}</td>
										</tr>
										<tr>
											<th>Invoice Date</th>
											<td>{{ est_std_date($ad_details->created_ts) }}</td>
											<th>Payment Gateway Receipt</th>
											<td><a target="_blank" href="{{ $ad_details->receipt_url }}">View Receipt</a></td>
										</tr>
										<tr>
											<th colspan="4">Ad Purchased Details</th>
										</tr>
										<tr>
											<th>Package Name</th>
											<td colspan="3">
												{{ $ad_details->title }}
											</td>
										</tr>
										<tr>
											<th>Package Type</th>
											<td colspan="3">
												{{ $ad_details->type }}
											</td>
										</tr>
										<tr>
											<th>Price</th>
											<td colspan="3">
												{{ $payment_details->amount }}
											</td>
										</tr>
										<tr>
											<th>Payment Mode</th>
											<td colspan="3">
												{{ $payment_details->payment }}
											</td>
										</tr>
										
									</tbody>
									
								</table>
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