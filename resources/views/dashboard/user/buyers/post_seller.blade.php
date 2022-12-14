@section('content')
<?php  $topmenu='my_post'; ?>
<?php $activemenu = 'posts'; ?>
@include('dashboard.include.sidebar')

<!--=== Profile ===-->
    <div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@include('dashboard.user.buyers.include.sidebar')
			<!--End Left Sidebar-->

			<!-- Profile Content -->
			<div class="col-md-12">
				<h2><b>My Posts</b></h2>
				<div class="box-shadow-profile ">
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left"> Posts </h2>
							<a class="cursor pull-right btn btn-default" id="addnewpost"><i class="fa fa-plus"></i> Add</a>
						</div>

						<div class="" >	
							<div class="postappend"></div>
							<div id="loaduploadshare" class="col-md-12 center loder loaduploadshare"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
							<div class="text-center"><button type="button" id="loadpostmore" class="hide btn-u btn-u-default btn-u-sm ">Load More</button></div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Profile Content -->
		</div>
	</div>		

	<div class="modal fade" id="postaddeditmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>					
		<div class="modal-dialog modal-lg">
			<div class="modal-content not-top">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title post-modal-title">Enter Your Post Details</h4>
				</div>

				{!! Form::open(array('url' => '#','class'=>'sky-form','enctype'=>'multipart/form-data','id'=>'add-post-type')) !!}
				<div class="modal-body">
					<fieldset>
						<div class="row">
							<div class="hide post-msg"></div>
							<section title="Post Title">
								<label class="label weight">Post Title<span class="mandatory">*</span></label>
								<label class="input">
									<input type="text" name="post_title" class="post_title" placeholder="Post Title">
									<b class="error-text" id="post_title_error"></b>
								</label>
							</section>

							<section title="Details">
								<label class="label weight">Property Details<span class="mandatory">*</span></label>
								<label class="textarea">
									<textarea rows="3" name="details" class="details jqte-test" placeholder="Post Details"></textarea>
									<b class="error-text" id="details_error"></b>
								</label>
							</section>

							<section class="row">
								<div class="col col-6">
									<label class="label weight">Address Line 1<span class="mandatory">*</span> </label>
									<label class="input">
										<input type="text" class="address_first" name="address_Line_1" value=""  placeholder="Address ">
										<b class="error-text" id="address_Line_1_error"></b>
									</label>
								</div>

								<div class="col col-6">
									<label class="label weight">Address Line 2</label>
									<label class="input">
										<input type="text" class="address2" name="address2" value=""  placeholder="Address ">
										<b class="error-text" id="address2_error"></b>
									</label>
								</div>
							</section>



							<!-- <section class="row padding-bottom-10 border1-bottom">				
								<div class="col col-6">
									<label class="label weight">State <span class="mandatory">*</span>  </label>
									<label class="select">
										<select id="state" name="state" class="" placeholder="Select State">
											<option value="">Select State</option>						
										</select>
										<b class="error-text" id="state_error"></b>
									</label>
								</div>
								
								<div class="col col-6">
									<label class="label weight">City<span class="mandatory">*</span> </label>
									<label class="select">
										 <input type="text" id="city" name="city"  placeholder="Enter City"> 
										<select id="city" name="city" class="" placeholder="Select City">
											<option value="">Select City</option>
										</select>
										<b class="error-text" id="city_error"></b>
									</label>
								</div>							
							</section> -->

							<section class="row">
								<!-- <div class="col col-4">
									<label class="label weight">City<span class="mandatory">*</span> </label>
									<label class="input">
										<input type="text" id="city" name="city"  placeholder="Enter City">
										<b class="error-text" id="city_error"></b>
									</label>
								</div>

								<div class="col col-4">
									<label class="label weight">State <span class="mandatory">*</span>  </label>
									<label class="select">
										<select id="state" name="state" class="multipalselecte" placeholder="Select State">
											<option value="">Select State</option>					
										</select>
										<b class="error-text" id="state_error"></b>
									</label>
								</div> -->

								<div class="col col-4">
									<label class="label weight">State <span class="mandatory">*</span>  </label>
									<label class="select">
										<select id="state" name="state" class="" placeholder="Select State">
											<option value="">Select State</option>						
										</select>
										<b class="error-text" id="state_error"></b>
									</label>
								</div>

								
								<div class="col col-4">
									<label class="label weight">City<span class="mandatory">*</span> </label>
									<label class="select">
										<!-- <input type="text" id="city" name="city"  placeholder="Enter City"> -->
										<select id="city" name="city" class="" placeholder="Select City">
											<option value="">Select City</option>
										</select>
										<b class="error-text" id="city_error"></b>
									</label>
								</div>					

								<div class="col col-4">
									<label class="label weight">Zip Code<span class="mandatory">*</span> </label>
									<label class="input">
										<input type="number" id="zip" maxlength="5" name="zip" value=""  placeholder="Zip Code">
										<b class="error-text" id="zip_error"></b>
									</label>
								</div>
							</section>							

							<section  title="When Do You Want To Sell field Is required.">
								<label class="label weight">When Do You want To Sell<span class="mandatory">*</span> </label>
								<label class="select">
									<select id="when_do_you_want_to_sell" name="when_do_you_want_to_sell" placeholder="when do you want to sell">
										<option value="">When do you want to sell</option>
										<option value="now" > Now </option>
										<option value="within 30 days" > Within 30days </option>
										<option value="within 90 days" > Within 90 days </option>
										<option value="undecided" > Undecided </option>
									</select>
									<b class="error-text" id="when_do_you_want_to_sell_error"></b>
								</label>
							</section>							

							<section>
								<label class="label weight">Need Cash back/Negotiate Commision<span class="mandatory">*</span></label>
								<div class="inline-group">
									<div class="infopopup"><p > Some states don???t allow cash back </p></div>
									<label class="radio"><input type="radio" name="need_Cash_back" class="need_Cash_back_1" value="1" ><i class="rounded-x"></i>Yes</label>
									<label class="radio"><input type="radio" name="need_Cash_back" class="need_Cash_back_0" value="0" checked=""><i class="rounded-x"></i>No</label>
								</div>
									<b class="error-text" id="need_Cash_back_error"></b>
							</section>							

							<section class="row">
								<div class="col col-6">
									<label class="label weight">Interested in a Short Sale</label>
									<div class="inline-group">
										<label class="radio"><input type="radio" name="interested_short_sale" class="interested_short_sale_1" value="1" ><i class="rounded-x"></i>Yes</label>

										<label class="radio"><input type="radio" name="interested_short_sale" class="interested_short_sale_2" value="0" checked><i class="rounded-x"></i>No</label>
									</div>
								</div>

								<div class="col col-6 hide" id="got_lender_approval_for_short_sale">
									<label class="label weight">Got Lender Approval for Short Sale</label>
									<div class="inline-group">
										<label class="radio"><input type="radio" name="got_lender_approval_for_short_sale" class="got_lender_approval_for_short_sale_1" value="1" ><i class="rounded-x"></i>Yes</label>

										<label class="radio"><input type="radio" name="got_lender_approval_for_short_sale" class="got_lender_approval_for_short_sale_2" value="0" checked><i class="rounded-x"></i>No</label>
									</div>
								</div>
							</section>							

							<section title="Home type">
								<label class="label weight">Home Type </label>
								<label class="select">
									<select id="home_type" name="home_type" placeholder="Select home type">
										<option value="">Select Home type</option>
										<option value="single_family" > Single Family </option>
										<option value="condo_townhome" > Condo/Townhome </option>
										<option value="multi_family" > Multi Family </option>
										<option value="manufactured" > Manufactured </option>
										<option value="lots_land" > Lots/Land </option>
									</select>
									<b class="error-text" id="home_type_error"></b>
								</label>
							</section>							

							<section title="Best Features Of Your Home">
								<label class="label weight">Best Features Of Your Home</label>
								<label class="input">
									<input type="text" class="best_features_1" name="best_features[]" value="Secure Gated subdivision" placeholder="">
								</label><label class="input">
									<input type="text" class="best_features_2" name="best_features[]" value="New Kitchen" placeholder="">
								</label><label class="input">
									<input type="text" class="best_features_3" name="best_features[]" value="Huge flat backyard" placeholder="">
								</label><label class="input">
									<input type="text" class="best_features_4" name="best_features[]" value="Beautiful view from the home" placeholder="">
								</label><label class="input">
									<input type="text" class="best_features_5" name="best_features[]" value="" placeholder="">
								</label>
							</section>
						</div>
					</fieldset>
				</div>

				<div class="modal-footer">
					<input  type="hidden" value="" 	name="id" 		 id="post_id">
					<input  type="hidden" value="<?php echo $user->id; ?>"  name="agents_user_id" >
					<input  type="hidden" value="<?php echo $user->agents_users_role_id; ?>" name="agents_users_role_id" >
					<input  type="hidden" value="3"  name="post_type" >
					<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn-u btn-u-primary" name="add-proposal-submit" value="Save changes" title="Save changes">Save</button>
				</div>
				{!!Form::close()!!}
			</div>
		</div>
	</div>
@endsection
@section('scripts')

<script type="text/javascript">
	var postdata = [];
	(function() {
		$('input[name="interested_short_sale"]').on('change',function(e) {
			var interested_short_sale = $(this).val();
			if(interested_short_sale == 1){
				$('#got_lender_approval_for_short_sale').addClass('show').removeClass('hide');
			}else{
				$('#got_lender_approval_for_short_sale').addClass('hide').removeClass('show');
			}
		});

		$.ajax({
			url: "{{url('/')}}/state/get",
			type: 'get',
			success: function(result) {	
				$.each( result, function( key, val ) {
					$('#state').append('<option value="'+val.state_id+'" >'+val.state_name+'</option>');
				});
				/*
				$('#state').multiselect({
					nonSelectedText: 'Select State',
					columns: 1,
				    search: true,
				    onChange: function(option, checked) {				    	

		            },
		            buttonContainer: '<div class="btn-grouptest" />',
				});
				*/
			}
		});		
		
		$('#state').on('change',function(){			
			$('#city').children('option:not(:first)').remove();
			state_id= $(this).val();
			$.ajax({
				url: "{{url('/')}}/city/get/"+state_id,
				type: 'get',
				success: function(result) {	
					statearray = result;
					$.each( result, function( key, val ) {				
						$('#city').append('<option value="'+val.city_id+'" >'+val.city_name+'</option>');
					});
				}
			});	
		});
		
	 	/* post  */
		loadpostlimit(0);
	 	$('#loadpostmore').click(function(e){
			e.preventDefault();
			var limit = $(this).attr('title');
			loadpostlimit(limit);
		});

		/*add post */
		$('#addnewpost').click(function(e){
			e.preventDefault();
			$('#post_id').val('');
			$('.post_title').val('');
			$('.details').summernote('code','');		
		 	$('.address_first').val('');
		 	$('.address2').val('');
		 	// $('#state').multiselect('select', '');
	 		$('#city').val('');
		 	$("#when_do_you_want_to_sell").val( "" );
		 	$('#zip').val('');
		 	$("input[name=need_Cash_back]").removeAttr( "checked" );
		 	$("input[name=interested_short_sale]").removeAttr( "checked" );
		 	$('#got_lender_approval_for_short_sale').addClass('hide').removeClass('show');
		 	$("input[name=got_lender_approval_for_short_sale]").removeAttr( "checked" );
		 	$("#home_type").val( "" );
		 	$('.best_features_1').val('Secure Gated subdivision');
		 	$('.best_features_2').val('Secure Gated subdivision');
		 	$('.best_features_3').val('Huge flat backyard');
		 	$('.best_features_4').val('Beautiful view from the home');
		 	$('.best_features_5').val('');	 		
		 	$('#postaddeditmodal').modal('show');
		});

	    /* submit post data */
	    $('#add-post-type').submit(function(e){
			e.preventDefault();
			var $form = $(e.target);
			var esmsg = $('.post-msg');
			$.ajax({		
				url: "{{url('/')}}/profile/buyer/newpost",
				type: 'POST',
				data: $form.serialize(),
				beforeSend: function(){$(".body-overlay").show();},
	    	    processData:false,
				success: function(result) {	
					$(".body-overlay").hide();
					$('.error-text').text('');
					$('#add-post-type input, #add-post-type select, #add-post-type textarea').removeClass('error-border');
					if(typeof result.error !='undefined' && result.error !=null){			 	
					 	$.each( result.error, function( key, value ) {
					 	 	$('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
					 	 	var text = $('#'+key+'_error').text();
						    text = text.replace("id", "");
						    $('#'+key+'_error').text(text);
						 	$('#'+key).addClass('error-border');
						});	
					 	esmsg.text('').addClass('hide');
					 	$('.modal-content').animate({scrollTop: 0},400);			
					}

					if(typeof result.msg !='undefined' && result.msg !=null){
						esmsg.text('').css({'color':'green'});
						esmsg.removeClass('hide').addClass('show alert alert-success text-center').html(result.msg).css({'color':'green'});
						setInterval(function() { location.reload(); },5000);
						$('.modal-content').animate({scrollTop: 0},400);
						setTimeout(location.reload(),5000);
					}					
				},

			  	error: function(data) {	
		    		if(data.status=='500'){
						esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');
		    		}else if(data.status=='422'){
						esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');
		    		}
		    		$(".body-overlay").hide();
		    		$('.modal-content').animate({scrollTop: 0},400);			
		    	} 	
			});
		});
	    /* edit edit-prasnol-bio*/	 	
	})();

	/*load loadpostlimit */
	function loadpostlimit(limit) {
		$.ajax({
			url: "{{url('/')}}/profile/buyer/post/get/"+limit,
			type: 'POST',
			data: { agents_user_id : '{{ $user->id }}',agents_users_role_id : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
			beforeSend: function(){ $(".loaduploadshare").show(); },
			success: function(result) {	
				$(".loaduploadshare").hide();
				if(result.count !== 0){
					if(limit==0){
						$('.postappend').html('');
					}
					$.each( result.result, function( key, value ) {				
						postdata[value.post_id] = value;
						var date = "Some days ago";
						if(value.created_at != null){
							date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
						}
						var location_var = '<li><strong>  <i class="fa-fw fa fa-map-marker"></i>  </strong> No location provided yet !</li>';
						if(value.address1 !=null || value.city !=null || value.state_name !=null || value.zip!=null){
							location_var = '<li><strong>  <i class="fa-fw fa fa-map-marker"></i>  </strong> '+(value.address1 !=null ? value.address1 : '' )+' '+(value.city !=null ? value.city : '' )+' '+(value.state_name !=null ? value.state_name : '' )+' '+(value.zip!=null ? value.zip : '' )+' </li> - ';
						}
						var close_date = 'Not updated yet';
						
						if(value.closing_date != null) {
							close_date = new Date(Date.fromISO(value.closing_date)).toISOString().slice(0,10);
						}
						var htm = '<div class="border1-bottom">'+
										'<div class="funny-boxes acpost">'+
											'<h2 class="title margin-bottom-20"><a target="_blank" href="{{ URL("/") }}/profile/buyer/post/details/'+value.post_id+'">'+value.posttitle+'</a></h2>'+
											'<div class="funny-boxes-img">'+
												'<ul class="list-inline">'+
												location_var+
													'<li><strong> Posted <i class="fa fa-clock-o"></i>: </strong> '+date+' </li>'+
												'</ul>'+
											'</div>';

											if(value.details){
												htm +='<div onlick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'\')" class="limited-post-text hidetext2line margin-bottom-10" title="'+value.details+'">'+
															value.details
														+'</div>';
											}

									htm +='<ul class="list-inline margin-top-20 margin-bottom-0">';
											if(value.applied_post==2){
										htm +='	<li><a class="cursor" onclick="post_Edit('+value.post_id+');"> <b>Edit Post</b></a></li> , ';
											}

										htm +='	<li><a class="cursor" target="_blank" href="{{ URL("/") }}/profile/buyer/post/details/'+value.post_id+'"><b> Details </b></a></li> , '+
												'<li><a rel="popover" data-popover-content="#myPopover'+value.post_id+'">'+value.post_view_count+' Agents Applied </a></li>'+
												'<li> Closing date : '+close_date+'</li>'+
											'</ul>'+
										'</div>'+
										'<div id="myPopover'+value.post_id+'" class="hide">'+
									      '<div class="panel panel-profile">'+
											'<div class="panel-heading overflow-h border1-bottom">'+
												'<h2 class="panel-title heading-sm pull-left color-black"><i class="fa fa-users"></i> Active Agents</h2>'+
											'</div>'+			
											'<div id="postagentshowinpopup" class="panel-body no-padding mCustomScrollbar" data-mcs-theme="minimal-dark">';

									if(value.post_view_count != 0)	{
										$.each( value.connected_agent_list, function( key, agentdata ) {
											var adate = timeDifference(new Date(), new Date(Date.fromISO(agentdata.created_at)));
											if(agentdata.photo){

												var photo = '<img class="rounded-x" src="{{ URL::asset("assets/img/profile/") }}/'+agentdata.photo+'">';
											}else{
												var photo = '<img class="rounded-x" src="{{ URL::asset("assets/img/testimonials/user.jpg") }}" alt="">';
											}

											var selectedclass = '';
											var title='';
											if(value.applied_post == 1 && value.applied_user_id == agentdata.details_id){
												selectedclass = 'agents_selected';
												title = 'Selected this agents for post ( '+value.posttitle+' )';
											}

											htm +='	<div onclick="onclickagent('+agentdata.details_id+','+value.post_id+');" title="'+title+'" class="'+selectedclass+' cursor alert-blocks alert-dismissable">'+photo+
														'<div class="overflow-h" style="margin-top:10px;">'+
															'<strong class="color">'+agentdata.name+' <small class="pull-right" style="margin-left: 20px;"><em>'+adate+'</em></small></strong>'+
															'<div class="hidetext1line">'+(agentdata.description!=null ? agentdata.description : '&nbsp;' )+'</div>'+
														'</div>'+
													'</div>';
										});
									}else{
										htm +='	<div class="cursor alert-blocks alert-dismissable"> Not Applied Agents </div>';
									}
									htm += '</div>'+
										  '</div>'+
									    '</div>'+
									'</div>';
						$('.postappend').append(htm);
					});

				// $(function(){
				//      $('[rel="popover"]').popover({					   
				//         container: 'body',
				//         html: true,
				// 		title : '<a href="#" class="close" data-dismiss="alert">&times;</a>',
				//         // trigger: 'manual',
				//         animation:true,
				//         content: function () {
				//             var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
				//             return clone;
				//         }
				//     }).on('click', function(e) {  
				//         e.preventDefault();
				//         var $popover = $(this);				        
			 //        	// $popover.popover('show');

			 //        	// $("#close-popup").click(function() {
			 //        	// 	$popover.popover('hide');				        	
			 //        	// });			        	
				//     });
				//     $(document).on('click touch', function(event) {
				// 		  if (!$(event.target).parents().addBack().is('[rel="popover"]')) {
				// 		    $('.popover').hide();
				// 		  }
				// 		});
				// });	

				$(function(){ 
					     $('[rel="popover"]').popover({					   
					        container: 'body',
					        html: true,
							title : '<a href="#" class="close" data-dismiss="alert">&times;</a>',
					        //trigger: 'manual',
					        animation:true,
					        content: function () {
					            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
					            return clone;
					        }
					    }).on('click',function(e) {  
					        e.preventDefault();
					        var $popover = $(this);
					       $popover.popover('show');
					    });

					    $(document).on('click touch', function(event) {
						  if (!$(event.target).parents().addBack().is('[rel="popover"]')) {
						    $('.popover').hide();
						  }
						});
					});

				if(result.next != 0){
						$('#loadpostmore').attr('title',result.next).addClass('show').removeClass('hide');
					}else{
						$('#loadpostmore').addClass('hide').removeClass('show');
					}
				}else{
					$('.postappend').html('<h2 style="padding: 20px;text-align: center;"> No agent is connected to you. <a href="{{ URL("/agents") }}"> Find.</a> </h2>');
				}
			},

		  	error: function(data) {	
	    		if(data.status=='500'){
					$('.loaduploadshare').text(data.statusText).css({'color':'red'});
	    		}else if(data.status=='422'){
					$('.loaduploadshare').text(data.responseJSON.image[0]).css({'color':'red'});
	    		}
    				// setInterval(function() {$(".loaduploadshare").hide(); },5000);
	    	}
		});
	}

	function post_Edit(el) {
		var data = postdata[el];	
		console.log(data);
	 	$('#post_id').val(data.post_id);
	 	$('.post_title').val(data.posttitle);	
	 	$('.details').summernote('code',data.details);
	 	$('.address_first').val(data.address1);
	 	$('.address2').val(data.address2);
		 // $('#state').multiselect('select', data.state);
		$('#state').val(data.state).trigger('change');
		
	 	$('#zip').val(data.zip);
	 	$("#when_do_you_want_to_sell option:selected").removeAttr( "selected" );
	 	$('#when_do_you_want_to_sell').val(data.when_do_you_want_to_sell);
	 	$("input[name=need_Cash_back]").removeAttr( "checked" );
	 	$(".need_Cash_back_"+data.need_Cash_back).prop("checked", true);	
	 	$("input[name=interested_short_sale]").removeAttr( "checked" );
	 	$(".interested_short_sale_"+data.interested_short_sale).prop("checked", true); 	
	 	if(data.interested_short_sale == 1){
			$('#got_lender_approval_for_short_sale').addClass('show').removeClass('hide');
		}else{
			$('#got_lender_approval_for_short_sale').addClass('hide').removeClass('show');
		}
	 	$("input[name=got_lender_approval_for_short_sale]").removeAttr( "checked" );

	 	$(".got_lender_approval_for_short_sale_"+data.got_lender_approval_for_short_sale).prop("checked", true);	
	 	$("#home_type option:selected").removeAttr( "selected" );
	 	$('#home_type').val(data.home_type);
	 	if(data.best_features && data.best_features !=0 && data.best_features != null){
		 	var befu = JSON.parse(data.best_features);
		 	$('.best_features_1').val(befu.best_features_1);
		 	$('.best_features_2').val(befu.best_features_2);
		 	$('.best_features_3').val(befu.best_features_3);
		 	$('.best_features_4').val(befu.best_features_4);
		 	$('.best_features_5').val(befu.best_features_5);
	 	}else{
		 	$('.best_features_1').val('Secure Gated subdivision');
		 	$('.best_features_2').val('Secure Gated subdivision');
		 	$('.best_features_3').val('Huge flat backyard');
		 	$('.best_features_4').val('Beautiful view from the home');
		 	$('.best_features_5').val('');	 		
		 }
		setTimeout(()=>{
			console.log($('#city').val(data.city),data.city,typeof data.city); 
		},1000);
 		$('#postaddeditmodal').modal('show');
	}

	/* end */
	function onclickagent(d,p) {
		window.location.href = '{{ URL("/") }}/search/agents/details/'+d+'/'+p;
	}
</script> 
@stop