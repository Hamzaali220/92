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
<?php  $topmenu='pendinginvoices'; ?>
<?php $activemenu = 'pendinginvoices'; ?>
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
						<h2 class="panel-title heading-sm pull-left"><i class="fa fa-newspaper-o"></i>Pending Invoices</h2>
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<form action="{{ url('/pay_pendinginvoices') }}" method="post" id="payment-form">
									{{ csrf_field() }}
								<table class="table">
								    <thead>
								      <tr>
								      	<th>#</th>
								        <th>Seller's Name</th>
								        <th>Address</th>
								        <th>Sale Date</th>
								        <th>Sale Price</th>
								        <th>Select</th>
								      </tr>
								    </thead>
								    <tbody>
							    		
								    	@if(!empty($invoice_details))
									    	@foreach($invoice_details as $i => $invoice)

									    		 <tr>
													<td>{{ (($invoice_details->currentPage() - 1 ) * $invoice_details->perPage() ) + $loop->iteration }}</td>
											        <td>{!! $invoice->sellers_name !!}</td>
											        <td>{!! $invoice->address !!}</td>
											        <td>{!! est_std_date($invoice->sale_date) !!}</td>
											        <td>{!! $invoice->sale_price !!}</td>
											        <td>
											        	<?php 
											        	if($invoice->payment_status == 1){
											        		?>
											        		<span style="color: green"><i class="fa fa-circle" aria-hidden="true"></i> Paid</span>

											        		<?php
											        	} else {
											        		?>
											        		<input type="checkbox" name="pending_invoices[]" value="{{ $invoice->id }}">
											        		<!-- <a href="{{ url('/pay_pendinginvoices/'.$invoice->id) }}" class="btn-u padding-6" style='color:#fff;'> -->
											        		<!-- Proceed to Pay -->
											        	</a>
											        		<?php
											        	}
											        	?>
											        	
											        </td>
											      </tr>
									    	@endforeach
								    	@endif
								    	
								    </tbody>
								    <tfoot>
								    	<tr>
								    		<td colspan="6">
								    			<input type="submit" name="pay_invoices" class="btn-u padding-6 pull-right" style='color:#fff;' value="Proceed to Pay">
								    		</td>
								    	</tr>
								    </tfoot>
								  </table>
								  </form>
								  <div class="col-md-12 pull-right">
					                {{ $invoice_details->links() }}    
					              </div>
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