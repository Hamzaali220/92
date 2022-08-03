@extends('admin.clearpage')
@section('title', 'Print Unpaid Invoice')
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
											<td colspan="2">Rakesh Mishra</td>
											<th>Agent Email</th>
											<td colspan="2">rakesh.mishra@92agents.com</td>
										</tr>
										<tr>
											<th>Invoice Date</th>
											<td colspan="2">{{ est_std_date(date('d-m-Y')) }}</td>
											<th>Payment Status</th>
											<td colspan="2">Unpaid</td>
										</tr>
										<tr>
											<th colspan="6">Sell Details</th>
										</tr>
										<tr>
											<th>SL No.</th>
											<th>Seller Name</th>
											<th>Address</th>
											<th>Sale Date</th>
											<th>Sale Price</th>
											<th>Commision ($)</th>
										</tr>
										<?php 
										if(!empty($sell_details)){
											$i = 1;
											$total_pay = 0;
											foreach ($sell_details as $sell) {
												?>

												<tr>
													<td>{{ $i }}</td>
													<td>{{ $sell->sellers_name }}</td>
													<td>{{ $sell->address }}</td>
													<td>{{ est_std_date($sell->sale_date) }}</td>
													<td>{{ $sell->sale_price }}</td>
													<td>
														<?php 
															$per_10 = $sell->sale_price*10/100;
															$per_10_03 = $per_10*3/100;
															$total_pay += $per_10_03;
															echo number_format((float)$per_10_03, 2, '.', '');
														?>
													</td>
												</tr>
												<?php
												$i++;
											}
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5" class="text-right">You have to pay</td>
											<th>
												<?php 
												echo number_format((float)$total_pay, 2, '.', '');
											 	?>
											</th>
										</tr>
									</tfoot>
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