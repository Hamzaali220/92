<?php
$statusTextArr = array();
$statusTextArr[0] = "Pending";
$statusTextArr[1] = "in-progress";
$statusTextArr[2] = "closed";
?>
@extends('dashboard.master')
@section('style')
<script src="https://checkout.stripe.com/checkout.js"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
<style type="text/css">
	.mCustomScrollBox {
		overflow-y: scroll !important;
    }
    #selectedJobsPanel >.nav-pills >li.active>a 
    {
        background-color:#37a000;
    }
    .btn-theme-green
    {
        background-color: #37a000 !important; 
    }
</style>
@stop
@section('title', 'My selected jobs')
@section('content')
<?php  $topmenu='Home'; ?>
<?php $activemenu = 'selected_post'; ?>
@include('dashboard.include.sidebar')
<!--=== Profile ===-->
    <div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@include('dashboard.user.agents.include.sidebar')
			<!--End Left Sidebar-->
				<!-- Profile Content -->
			<div class="col-md-12">
				<h2><b>My selected jobs</b></h2>
				<div class="box-shadow-profile ">
					<div class="panel-profile" style="padding:20px;">
                        <div id="selectedJobsPanel">	
                            <ul  class="nav nav-pills">
                                <li class="active"><a  href="#1a" data-toggle="tab">Payment Pending</a></li>
                                <li><a href="#2a" data-toggle="tab">Payment Completed</a></li>
                            </ul>

                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1a">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <a target="_blank" style="color:white !important" class="btn btn-primary btn-sm btn-theme-green pull-right" id="btn_paynow"> <i style="color:white !important" class="fa fa-credit-card" ></i> Pay All</a>
                                        </div>
                                    </div>
                                    <table class="table table-stripped">
                                        <thead>
                                            <tr>
                                                <td>Post Name</td>
                                                <td>Select Date</td>
                                                <td>Closing Date</td>
                                                <td>Amount</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $isAnyPending = false;
                                        ?>
                                        
                                            @foreach($all_posts as $post)
                                                @if($post->agent_payment !== "completed" OR $post->agent_payment == null)
                                                <?php
                                                    $our_commision = 0;
                                                    if($post->sell_details != ""){
                                                        $agent_comission = $post->sell_details->agent_comission;
                                                        $commission_rate = $post->sell_details->comission_92agent;
                                                        $agent_commission_amount = (( $agent_comission / 100 ) * $post->sell_details->sale_price);
                                                        $our_commision = (( $commission_rate / 100 ) * $agent_commission_amount);
                                                        $our_commision = number_format((float)$our_commision, 2, '.', '');
                                                    }
                                                ?>
                                                <tr>
                                                    <td>{{ $post->posttitle }}</td>
                                                    <td>{{ date("d/m/Y", strtotime($post->agent_select_date)) }}</td>
                                                    <td>{{ date("d/m/Y", strtotime($post->closing_date)) }}</td>
                                                    <td>
                                                    {{ $our_commision }}
                                                    @if($post->sell_details == "")
                                                        <span class="badge badge-danger">No sale details</span>
                                                    @endif
                                                    </td>
                                                    <td> <a target="_blank" style="color:white !important" href="{{ url('/search/post/details') }}/{{ $post->post_id }}" class="btn btn-info btn-theme-green btn-sm"> <i style="color:white !important" class="fa fa-eye"></i> &nbsp; View</a>
                                                    @if($post->sell_details !== "")
                                                    <a style="display:none" target="_blank" data-job="{{ $post->post_id }}" data-commission="{{ $post->commission_price }}" style="color:white !important" class="btn btn-primary btn-sm btn-theme-green btn_paynow"> <i style="color:white !important" class="fa fa-credit-card" ></i> Pay Now</a>

                                                    <input type="hidden" value="{{ $post->post_id }}" class="post_id_val">
                                                    <input type="hidden" value="{{ $our_commision }}" class="commission_price_val">
                                                
                                                    @endif
                                                    </td>
                                                </tr>
                                                <?php 
                                                $isAnyPending = true; 
                                                ?>
                                                @endif
                                            @endforeach
                                            @if($isAnyPending == false)
                                            <tr>
                                                <td colspan="5">No pending posts</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="2a">
                                    <table class="table table-stripped">
                                        <thead>
                                            <tr>
                                                <td>Post Name</td>
                                                <td>Select Date</td>
                                                <td>Closing Date</td>
                                                <td>Amount</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $isAnyCompleted = false;
                                        ?>
                                            @foreach($all_posts as $post)
                                                @if($post->agent_payment == "completed" AND $post->agent_payment !== null)
                                                <?php
                                                    $our_commision = 0;
                                                    if($post->sell_details != ""){
                                                        $agent_comission = $post->sell_details->agent_comission;
                                                        $commission_rate = $post->sell_details->comission_92agent;
                                                        $agent_commission_amount = (( $agent_comission / 100 ) * $post->sell_details->sale_price);
                                                        $our_commision = (( $commission_rate / 100 ) * $agent_commission_amount);
                                                        $our_commision = number_format((float)$our_commision, 2, '.', '');
                                                    }
                                                ?>
                                                <tr>
                                                    <td>{{ $post->posttitle }}</td>
                                                    <td>{{ date("d/m/Y", strtotime($post->closing_date)) }}</td>
                                                    <td>{{ date("d/m/Y", strtotime($post->closing_date)) }}</td>
                                                    <td>{{ $our_commision }}</td>
                                                    <td> <a target="_blank" style="color:white !important" href="{{ url('/search/post/details') }}/{{ $post->post_id }}" class="btn btn-info btn-sm btn-theme-green"> <i style="color:white !important" class="fa fa-eye"></i> &nbsp; View</a></td>
                                                </tr>
                                                <?php 
                                                $isAnyCompleted = true; 
                                                ?>
                                                @endif
                                            @endforeach
                                            @if($isAnyCompleted == false)
                                            <tr>
                                                <td colspan="5">No completed posts</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>      
                            </div>
                        </div>
					</div>
				</div>
			</div>
			<!-- End Profile Content -->			
		</div>
	</div>	
	
    <div class="modal fade " id="make_payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog " style="display: grid;">
			<div class="modal-content not-top sky-form">
				
				<div id="set-agent-review-loader" class="body-overlay col-md-12 center loder set-agent-review-loader"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
				
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title set-agent-review-title">Make Payment To 92agents.com </h4>
				</div>
				{!! Form::open(array('id'=>'make_payment_for_agents' ,'class'=>'sky-form')) !!}
				<div class="modal-body">
					<div id="paymentResponse"></div>
					<fieldset style="padding: 0px 15px;">
						<p class="review-msg-text hide"></p>
						
						
						<section class="margin-0">
							<label class="label margin-0"> 92agents.com Charges</label>
							<label class="textarea margin-0">
								<input type="text" id="amount" name="amount" class="form-control" readonly />
								<b class="error-text" id="amount_error"></b>
							</label>
						</section>					
					</fieldset>
				</div>
				<div class="modal-footer" >
					<input type="hidden" name="post_id" id="post_id" value="">
					<input type="hidden" name="agent_id" value="{{ isset($user->id)?$user->id:'' }}">

					<button type="button" class="btn btn-link" data-dismiss="modal" aria-hidden="true">Close</button>
					<button type="submit" class="btn-u">Make Payment</button>
				</div>
				{!!Form::close()!!}
			</div>
		</div>
	</div>



@endsection

@section('scripts')

<script>
/* Make 3% of payment to Agent*/
        var handler = StripeCheckout.configure({
            key: 'pk_test_51Hso8eG631bdjDJFxxjr69uA3X7qVzFKcGZaCHgORUlQuJ2Cwi5QbUOU9HtMdtsmIl2pTn4dXB2N290L1pZHWBsi00Bj3YoYeB',
            image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
            locale: 'auto',
            token: function(token) {
            // You can access the token ID with `token.id`.
            // Get the token ID to your server-side code for use.
            }
		});
		function handleToken(token) {
            fetch("{{url('/')}}/validatepaymentamount", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(token)
		})
		.then(response => {
            if (!response.ok)
            throw response;
            return response.json();
		})
		.then(output => {
            if(output.status == 1){
                var alert = '<div class="alert alert-success"><strong>Success!</strong> '+output.msg+'</div>';
                $("#paymentResponse").html(alert);
                setTimeout(function(){ location.reload(); }, 1000);
            }else{
                var alert = '<div class="alert alert-danger"><strong>Info!</strong> '+output.msg+'</div>';
                $("#paymentResponse").html(alert);
            }
        })
		.catch(err => {
		    console.log("Purchase failed:", err);
		})
		}
	  $('#make_payment_for_agents').submit(function(e){
			e.preventDefault();
			var $form = $(e.target),esmsg = $('.review-msg-text');
			
			$.ajax({
				url: "{{url('/')}}/validatepaymentamount",
				type: 'POST',
				data: $form.serialize(),
				beforeSend: function(){$(".set-agent-review-loader").show();},
	    	    processData:false,
				success: function(result) {	
					$(".set-agent-review-loader").hide();
					$('.error-text').text('').removeClass('show').addClass('hide');
				 	esmsg.text('').removeClass('show').addClass('hide');
                     
                    if(result.status == 2){
                        let originalAmount = (parseFloat($('#amount').val()).toPrecision(16));
                        let amount = originalAmount*100;
                        amount = amount.toFixed(2);
                        
                        // var amount = $('#amount').val();
                        handler.open({
                        name: 'Agent Charges',
                        description: 'Agent Charges paying to agent.',
                        amount: amount,
                        currency: 'usd',
                        token: handleToken,
                        email : '{{$user->email}}'
                        });
                        e.preventDefault();
					}

					if(typeof result.error !='undefined' && result.error !=null){
					 	$.each( result.error, function( key, value ) {
					 	 	$('#'+key+'_error').removeClass('success-text hide').addClass('error-text show').text(value);
						});
					}

					if(typeof result.data !='undefined' && result.data !=null){
						$('#set-agent-review').modal('hide');
						msgshowfewsecond('Payment done succeed.');
						location.reload();
					}

				},
			  	error: function(data) 
		    	{	
		    		$(".set-agent-review-loader").hide();
		    		if(data.status=='500'){
						esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');
		    		}else if(data.status=='422'){
						esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');
		    		}
		    	} 	

			});

		});
    

    $(document).on('click',".btn_paynow",function(){
        let ele = $(this);
        let post_id = ele.attr("data-job");
        let commission = ele.attr("data-commission");
        $("#make_payment").find("#post_id").val(post_id);
        $("#make_payment").find("#amount").val(commission);
        $("#make_payment").modal("show");
    });

    $(document).ready(function(){
        let commission = 0;
        $(".commission_price_val").each(function(){
            let ele = $(this);
            commission += parseFloat(ele.val());
        });
        if(commission == 0 ){
            $("#btn_paynow").addClass("disabled");
        }else{
            $("#btn_paynow").removeClass("disabled");
        }
    })

    $(document).on('click',"#btn_paynow",function(){
        let ele = $(this);
        let post_id = "";
        $(".post_id_val").each(function(){
            let ele = $(this);
            let post_id_val = ele.val();
            if(post_id == ""){
                post_id = post_id_val;
            }else{
                post_id += ","+post_id_val;
            }
        });

        let commission = 0;
        $(".commission_price_val").each(function(){
            let ele = $(this);
            commission += parseFloat(ele.val());
        });

        commission = commission.toFixed(2);
        
        $("#make_payment").find("#post_id").val(post_id);
        $("#make_payment").find("#amount").val(commission);
        $("#make_payment").modal("show");
    });

    
    

    $('#make_payment').on('hidden.bs.modal', function () {
        $(this).find("#post_id").val("");
        $(this).find("#amount").val("");
        $(this).find("#paymentResponse").html("");
        $(this).find("#amount_error").html("");
    });
</script>
@stop