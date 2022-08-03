@extends('dashboard.master')
@section('title', 'home page')
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
<?php  $topmenu='Advertise'; ?>
<?php $activemenu = 'Advertise'; ?>
@include('dashboard.include.sidebar')

<?php

\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

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
						<div class="row">
							<!-- Payment form -->
								<div class="col-md-offset-2 col-md-6">
								<table class="table table-bordered">
									<tr>
										<th>Package Name</th>
										<td>{!! $package_details->title !!}</td>
										<th>Package Type</th>
										<td>{!! $package_details->package_type !!}</td>
									</tr>
									<tr>
										<th colspan="4">Package Details</th>
									</tr>
									<tr>
										<td colspan="4">{!! $package_details->details !!}</td>
									</tr>
									<tr>
										<th>Price</th>
										<td colspan="3">{!! $package_details->price !!}</td>
									</tr>
								</table>
							</div>

								<div class="col-md-offset-2 col-md-6">
									<form action="{{ url('/postPayment') }}" method="post" id="payment-form">

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
										  <input type="hidden" name="package_id" value="{!! $package_details->package_id !!}">
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


<script type="text/javascript">
	// Create a Stripe client.
var stripe = Stripe('{{env("STRIPE_KEY")}}');

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
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

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
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
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