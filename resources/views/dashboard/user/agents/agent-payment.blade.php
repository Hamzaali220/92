@extends('dashboard.master')
@section('title', 'Pay pending invoices')
@section('style')
<style>
/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;

  height: 40px;

  padding: 10px 12px;

  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}

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

<?php

\Stripe\Stripe::setApiKey('sk_test_ok05SSIeli5JZkSUPZZV12LZ00wYz4H69v');

$intent = \Stripe\PaymentIntent::create([
  'amount' => 1099, # this amount not effecting anything on actual amount
  'currency' => 'inr',
  // Verify your integration in this guide by including this parameter
  'metadata' => ['integration_check' => 'accept_a_payment'],
]);

?>

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
						<h2 class="panel-title heading-sm pull-left"><i class="fa fa-newspaper-o"></i>Please provide your payment information</h2>

					</div>

					<div class="panel-body">
							<form class="text-center" action="{{ url('/downloadinvoice') }}" method="post" target="_blank">
								{{ @csrf_field() }}
								<input type="hidden" name="sell_ids" value="{{ implode(',',$sell_ids) }}">
								<button type="submit" class="btn btn-success"> <i class="fa fa-print" aria-hidden="true"></i> Download Unpaid Invoice
								</button>
							</form>
							<div class="clearfix"></div>
							<br>
						<div class="row">
							<!-- Payment form -->
								<div class="col-md-offset-1 col-md-9">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th colspan="6">
												<h1 class="text-center">92Agents.com</h1>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th>Agent Name</th>
											<td colspan="2">{{$userdetails['name']}}</td>
											<th>Agent Email</th>
											<td colspan="2">{{$userdetails['email']}}</td>
											{{-- <td colspan="2">rakesh.mishra@92agents.com</td> --}}
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

								<div class="col-md-offset-2 col-md-6">
									<form action="{{ url('/postAgentPayment') }}" method="post" id="agent-payment-form">

										  <div class="form-row">
										    <label for="card-element">
										      Credit or debit card
										    </label>
										    <div id="card-element">
										      <!-- A Stripe Element will be inserted here. -->
										    </div>

										    <!-- Used to display form errors. -->
										    <div id="card-errors" role="alert"></div>
										  </div>
										  {{ csrf_field() }}
										  <input type="hidden" name="sell_ids" value="{{ implode(',',$sell_ids) }}">
										  <input type="hidden" name="sale_amount" value="{{ $total_pay }}">
										  
										  <br>
										  <br>
										  <button class="btn-u payment-btn" data-secret="<?= $intent->client_secret ?>">
												    Pay Now
											</button>
										</form>
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

<script type="text/javascript">
	// Create a Stripe client.
var stripe = Stripe('pk_test_mQRUE55HT9hw1E3L8z5wDZvQ00YHYvJvHY');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('agent-payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();
debugger
  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
	debugger
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('agent-payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
</script>


@endsection

@section('scripts')

@stop