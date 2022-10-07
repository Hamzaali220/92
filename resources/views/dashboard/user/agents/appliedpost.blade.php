@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
<style type="text/css">
	.mCustomScrollBox {
		overflow-y: scroll !important;
	}
</style>
@stop
{{-- {{dd($invoice_details);}} --}}
@section('title', 'Applied Post')
@section('content')
<?php  $topmenu='Home'; ?>
<?php $activemenu = 'appliedpost'; ?>
@include('dashboard.include.sidebar')

<!--=== Profile ===-->
    <div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@include('dashboard.user.agents.include.sidebar')
			<!--End Left Sidebar-->
				<!-- Profile Content -->
			<div class="col-md-12">
				<h2><b>All My Jobs</b></h2>
				<div class="box-shadow-profile ">
					<div class="panel-profile" style="padding: 10px;">
						<div class="table-responsive">
						    <table class="table table-bordered table-striped">
						        <thead>
						            <tr>
						                <th>Sl. No.</th>
						                <th>Project</th>
						                <th>Posted By</th>
						                <th>Address</th>
						                <th>Commition</th>
						                {{-- <th>Posted At</th> --}}
						                <th>Closing Date</th>
						                <th>Sale Price</th>
						                <th>Payment Status</th>
						                <th>Actions</th>
										
						            </tr>
						        </thead>
						        <tbody>
									<?php
									$n=1;	
									foreach($invoice_details as $in){
										?>
										<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
										<form class="sky-form <?php echo $in->id ?>" id="edit-personal-bio" name="<?php echo $in->id?>">
										@csrf
										<tr>
						                <td>{{$n}}</td>
						                <td>{{$in->posttitle}}</td>
						                <td>{{$in->sellers_name}}</td>	
						                <td>
						                    <div class="input-group">
                                                {{-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> --}}
                                                <input type="text" title="Add exact address" value="{{@$in->address}}" name="address" class="col-lg-10 form-control address <?php echo $in->id ?> address<?php echo $in->id ?>" />
                                            </div>
						                </td>
						                <td>
						                    <div class="input-group">
                                                {{-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> --}}
                                                <input type="number" title="Add charged comission" value="{{@$in->agent_comission}}" name="comission" class="col-lg-10 form-control comission <?php echo $in->id ?> comission<?php echo $in->id ?>" />
                                            </div>
						                </td>
						                <td>
						                    <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" title="Select Closing Date" value="{{@$in->sale_date}}" name="date" class="col-lg-10 form-control reservation proposaldate <?php echo $in->id ?> proposaldate<?php echo $in->id ?>" />
                                            </div>
						                </td>
						                <td>
						                    <input type="text" class="form-control price <?php echo $in->id ?> price<?php echo $in->id ?>" name="price" placeholder="Selling Price" value="{{@$in->sale_price}}" />
						                    <input type="hidden" class="form-control id <?php echo $in->id ?> id<?php echo $in->id ?>" name="id" value="{{@$in->id}}" />
						                </td>
						                
											<?php if(@$in->sale_date=='' || @$in->sale_price=='' ||  @$in->agent_comission=='' ||  @$in->address==''){?>
										<td>
												<span class="badge badge-blue">
						                        Closing Pending
						                    </span>
										</td>
										
											<td>
												<button class="btn btn-default submit-btn <?php echo $in->id?>" name="submit<?php echo $in->id?>" value="submit<?php echo $in->id?>" type="submit">Save</button>
											</td>
										
											<?php
											}elseif(@$in->payment_status==1){
											?>
										<td>
						                    <span class="badge badge-green">
						                        Paid
						                    </span>
						                </td>
						                <td>
						                    
						                </td>
										
											<?php
											}else{
											?>
										<td>
						                    <span class="badge badge-red">
						                        Payment Pending
						                    </span>
						                </td>
						                <td>
						                    <a class="btn-u padding-6" href="{{route('payitnow',$in->id)}}">Pay it now</a>
						                </td>
										
						                    
						                
						                <td>
											<input type="checkbox" value="" name="paycheck" class="col-lg-10 form-control reservation paycheck <?php echo $in->id ?> paycheck<?php echo $in->id ?>" />
						                </td>
										<?php
											}
										?>
						            </tr>	
									<?php
								$n=$n+1;	
								}
									?>
						            <tr>
						                {{-- <td>1</td>
						                <td>Need to sell my property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>06/06/2022</td>
						                <td>$40,000</td>
						                <td>
						                    <span class="badge badge-green">
						                        Paid
						                    </span>
						                </td>
						                <td>
						                    
						                </td>
						            </tr>
						            <tr>
						                <td>2</td>
						                <td>Req. to sell my home</td>
						                <td>Sanjeev</td>
						                <td>09/21/2022 01:01:00</td>
						                <td>01/06/2023</td>
						                <td>$4,000</td>
						                <td>
						                    <span class="badge badge-red">
						                        Payment Pending
						                    </span>
						                </td>
						                <td>
						                    <button class="btn-u padding-6">Pay it now</button>
						                </td>
						            </tr>
						            <tr>
						                <td>3</td>
						                <td>Need to sell a property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>
						                    <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" title="Select Closing Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" />
                                            </div>
						                </td>
						                <td>
						                    <input type="text" class="form-control" placeholder="Selling Price" />
						                </td>
						                <td>
						                    <span class="badge badge-blue">
						                        Closing Pending
						                    </span>
						                </td>

						                <td>
						                    <button class="btn btn-default">Save</button>
						                </td>
						            </tr>
						            <tr>
						                <td>4</td>
						                <td>Need to sell a property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>
						                    <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" title="Select Closing Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" />
                                            </div>
						                </td>
						                <td>
						                    <input type="text" class="form-control" placeholder="Selling Price" />
						                </td>
						                <td>
						                    <span class="badge badge-blue">
						                        Closing Pending
						                    </span>
						                </td>
						                <td>
						                    <button class="btn btn-default">Save</button>
						                </td>
						            </tr>
						            <tr>
						                <td>5</td>
						                <td>Need to sell a property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>
						                    <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" title="Select Closing Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" />
                                            </div>
						                </td>
						                <td>
						                    <input type="text" class="form-control" placeholder="Selling Price" />
						                </td>
						                <td>
						                    <span class="badge badge-blue">
						                        Closing Pending
						                    </span>
						                </td>
						                <td>
						                    <button class="btn btn-default">Save</button>
						                </td>
						            </tr>
						            <tr>
						                <td>6</td>
						                <td>Need to sell a property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>07/10/2022 01:01:00</td>
						                <td>$10,000</td>
						                <td>
						                    <span class="badge badge-orange">
						                        Ready for Closing
						                    </span>
						                </td>
						                <td>
						                    <button class="btn btn-default">Save</button>
						                </td>
						            </tr> --}}
										</form>
						        </tbody>
						    </table>
								<form class="checkform">
									@csrf
									<input type="hidden" name="pending_invoices" id="checkArr" value="">
									<button type='submit' class="btn-u padding-6 getselected">Pay it now</a>
								</form>
								{{-- <a class="btn-u padding-6" href="{{route('payitnow',$in->id)}}">Pay it now</a> --}}
							
						</div>
					</div>
				</div>
			</div>
			<!-- End Profile Content -->			
		</div>
	</div>	
	

@endsection


@section('scripts')
<script type="text/javascript">
	/* edit-personal-bio */
	

	$('.getselected').on('click',function(e){
		debugger
		e.preventDefault();
		// $(".body-overlay").show();
		let payArr=[];
		let check=$('.paycheck').get();
		for(let i=0;i<check.length;i++){
			if($(check[i]).is(':checked')){
				let payClass=$(check[i]).attr('class')
				payClass=payClass.split(" ");
				payArr.push(payClass[4]);
			}
		}
		$('#checkArr').val(payArr);
		$('.checkform').attr('action', '{{route('pay_pendinginvoices')}}');
		$('.checkform').attr('method', 'POST');
		$(".checkform").submit();
		// let rr ="http://127.0.0.1:8000/pending/pay/"+payArr;
		// $('.getselected').attr('href', rr);
		// $(".getselected").click();
		// $(this).unbind("click");
		// return false;
		console.log(payArr);

		// $.ajax({				
		// 		url: "{{url('/')}}/pay_pendinginvoices",
		// 		type: 'POST',
		// 		data:  new FormData(this),//$form.serialize(),
		// 		beforeSend: function(){$(".body-overlay").show();},
		// 		processData:false,
		// 		contentType: false,
		// 		success: function(result) {	
					
		// 			$(".body-overlay").hide();
		// 			// $('.error-text').text('');
		// 			// $('#edit-personal-bio input, #edit-personal-bio select, #edit-personal-bio textarea').removeClass('error-border');

		// 			if(typeof result.error !='undefined' && result.error !=null){
		// 				var i=0
		// 				$.each( result.error, function( key, value ) {
		// 					// if(i==0){
		// 					// 	scroleerr = $('#'+key+'_error');
		// 					// }
		// 					// i++;
		// 					// $('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
		// 					// var text = $('#'+key+'_error').text();
		// 					// text = text.replace("id", "");
		// 					// $('#'+key+'_error').text(text);
		// 					// $('#'+key).addClass('error-border');
		// 					alert('something went wrong');
		// 				});
		// 				// esmsg.text('');
		// 				// $('html, body').animate({
		// 				// 	scrollTop: scroleerr.offset().top
		// 				// },1000);
		// 				$(".body-overlay").hide();
		// 			}

		// 		},
		// 		error: function(data) 
		// 		{	
		// 			alert('something went wrong');
		// 		} 	
		// 	});

	});
	$('.submit-btn').on('click',function(e){
		debugger	
		// e.preventDedault();
		e.preventDefault()
		let cl=$(this).attr('class');
		cl=cl.split(" ");
$( ".proposaldate" ).prop( "disabled", true );
$( ".price" ).prop( "disabled", true );
$( ".comission" ).prop( "disabled", true );
$( ".address" ).prop( "disabled", true );
$( ".id" ).prop( "disabled", true );
$( ".id"+cl[3]).prop( "disabled", false );
$( ".proposaldate"+cl[3]).prop( "disabled", false );
$( ".price"+cl[3]).prop( "disabled", false );
$( ".comission"+cl[3]).prop( "disabled", false );
$( ".address"+cl[3]).prop( "disabled", false );

// 			var form = $('');
// var elements = form.elements;
// for (var i = 1, len = elements.length; i < len; ++i) {
//     elements[i].readOnly = true;
// }
// method="POST" action="{{route('update_sell')}}"
$('#edit-personal-bio').attr('action', '{{route('update_sell')}}');
$('#edit-personal-bio').attr('method', 'POST');
$("#edit-personal-bio").submit();
// 			let cl= $(this).attr("class");
// 			cl=cl.split(" ");		
// 			// var $form = $(e.target),esmsg = $('.message-Professional');
// 			$.ajax({				
// 				url: "{{url('/')}}/profile/agent/sellDetials",
// 				type: 'POST',
// 				data:  new FormData(this),//$form.serialize(),
// 				beforeSend: function(){$(".body-overlay").show();},
// 				processData:false,
// 				contentType: false,
// 				success: function(result) {	
					
// 					$(".body-overlay").hide();
// 					// $('.error-text').text('');
// 					// $('#edit-personal-bio input, #edit-personal-bio select, #edit-personal-bio textarea').removeClass('error-border');

// 					if(typeof result.error !='undefined' && result.error !=null){
// 						var i=0
// 						$.each( result.error, function( key, value ) {
// 							// if(i==0){
// 							// 	scroleerr = $('#'+key+'_error');
// 							// }
// 							// i++;
// 							// $('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
// 							// var text = $('#'+key+'_error').text();
// 							// text = text.replace("id", "");
// 							// $('#'+key+'_error').text(text);
// 							// $('#'+key).addClass('error-border');
// 							alert('something went wrong');
// 						});
// 						// esmsg.text('');
// 						// $('html, body').animate({
// 						// 	scrollTop: scroleerr.offset().top
// 						// },1000);
// 						$(".body-overlay").hide();
// 						$('html, body').animate({
// 							scrollTop: $('.message-Professional').offset().top
// 						},1000);
// 					}

// 					if(result.msg !='undefined' && result.msg !=null){
// 						$(".message-Personal").addClass('alert alert-success text-center').html(result.msg).css({'color':'green'});
// 						setInterval(function() { esmsg.removeClass('alert alert-success text-center').html(''); },20000);
// 						// $('input, select, textarea').val('');
// 						$('html, body').animate({
// 							scrollTop: $('body').offset().top
// 						},1000);
// 					}

// 					console.log(result);
// 				},
// 				error: function(data) 
// 				{	
// 					if(data.status=='500'){
// 						esmsg.text(data.statusText).css({'color':'red'});
// 					}else if(data.status=='422'){
// 						esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
// 					}
// 					$(".body-overlay").hide();
// 					$('html, body').animate({
// 						scrollTop: $('.message-Professional').offset().top
// 					},1000);
// 				} 	
// 			});
		});
		/* edit edit-prasnol-bio*/
</script>
@endsection