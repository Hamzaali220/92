@extends('dashboard.master')
@section('title', 'Setting')
@section('content')
<?php  $topmenu='Profile'; ?>
<?php $activemenu = 'settings'; ?>
@include('dashboard.include.sidebar')
	<!--=== Profile ===-->
	<div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@include('dashboard.user.agents.include.sidebar')
			@include('dashboard.user.agents.include.sidebar-profile')

			<!-- Profile Content -->
			<div class="col-md-9">
				<h2 style="color:red;"><b>You have a new query from admin.</b></h2>
				<div class="box-shadow-profile ">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left"> Enter the closing date.</h2>
						</div>
							<div id="flash-message"></div>
						<div class="tab-v2">
							<div class="tab-content">
								<div id="settings" class="profile-edit">
									<div class="message-securty-question"> </div>
									<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
									{!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'edit-securty-question')) !!}
										<dl>
											<dt>Buyer or Seller Name:- </dt>
											<dd>
												<section>
													<label class="select">
														<input type="text" id="answer1" name="seller_name" value="{{$forPost['buyerorsellerdetails']['name']}}"  data-toggle="tooltip" data-placement="top" placeholder="Seller Name" class="form-control" readonly>
														<b class="error-text" id="question1_error"></b>
													</label>
												</section>
											</dd>

											<dt>Select Date:- </dt>
											<dd>
												<section>
													<label class="select">
														<input type="text" id="answer1" name="select_date" data-toggle="tooltip" data-placement="top" placeholder="Select Date" class="form-control" value="{{$forPost['post']['agent_select_date']}}" readonly>
														<b class="error-text" id="question1_error"></b>
													</label>

												</section>
											</dd>

											<dt>For Post:- </dt>
											<dd>
												<section>
													<label class="select">
														<input type="text" id="answer1" name="post_name" value="{{$forPost['post']['posttitle']}}"  data-toggle="tooltip" data-placement="top" placeholder="Seller Name" class="form-control" readonly>
														<b class="error-text" id="question1_error"></b>
													</label>
												</section>
											</dd>

											<dt>Closing Date:- </dt>
											<dd>
												<section>
													<label class="input">

														<input type="date" id="answer1" name="closing_date" value=""  data-toggle="tooltip" data-placement="top" placeholder="Closing Date" class="form-control">

														<b class="error-text" id="closing_date"></b>
													</label>
													<label class="select">
														<input type="checkbox" id="donthaveclosingdate" name="donthaveclosingdate" onclick="boxDisable( $(this));"> I dont' have closing date.
														<b class="error-text" id="question1_error"></b>
													</label>
												</section>
											</dd>
											<script type="text/javascript">
											function boxDisable(t) {
											if (t.is(':checked')) {
											$('#comment-dt').css('display', 'block');
											$('#comment-dd').css('display', 'block');
											} else {
											$('#comment-dt').css('display', 'none');
											$('#comment-dd').css('display', 'none');
											}
											}
											</script>

											<dt id="comment-dt" style="display:none;">Comment:- </dt>
											<dd id="comment-dd" style="display:none;">
												<section>
													<label class="select">
														<textarea class="form-control" name="comments" ></textarea>
														<b class="error-text" id="comments"></b>
													</label>

												</section>
											</dd>

										</dl>
										<input type="hidden" name="closingqueryid" value="{{$forPost['id']}}">
										<input type="hidden" name="postid" value="{{$forPost['post']['post_id']}}">
										<button class="btn-u" type="submit">Submit</button>
									{!!Form::close()!!}
								</div>
							</div>
						</div>
					</div>
					<!-- Default Proposals -->
				</div>


			</div>
			<!-- End Profile Content -->
		</div><!--/end row-->
	</div>
	<!--=== End Profile ===-->
	<script type="text/javascript">
		 /* Submit closing date query. */
	    $('#edit-securty-question').on('submit', function(e){
	    	 var $this = $(this); //alias form reference
			e.preventDefault();
			$.ajax({
				url: "{{url('/')}}/inputclosingdate",
				type: 'POST',
				data: $this.serialize(),
				beforeSend: function(){
					$(".body-overlay").show();
				},
	    	    processData:false,
				success: function(result) {
					if(typeof result.error !='undefined' && result.error !=null){
					 	$.each( result.error, function( key, value ) {
					 		alert(key);
						 	 $('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
							 $('#'+key).addClass('error-border');
							});
					 	esmsg.text('');

					}

					if(typeof result.msg !='undefined' && result.msg !=null){
						esmsg.addClass('alert alert-success text-center').html(result.msg);
						setInterval(function() { esmsg.removeClass('alert alert-success text-center').html(''); },10000);
						$('input[type="password"]').val('');
					}

					if(result.status == 2){
					$(".body-overlay").hide();
					$.each( result.errors, function( key, error) {
					$("#"+key+"").show().html('<strong>'+error[0]+'</strong>');
					});

					}

					if(result.status == 1){
					$(".body-overlay").hide();
					var msg = '<div class="alert alert-success"><strong>Success!</strong> Your comment has been submitted.</div>';
					$('#flash-message').html(msg);
					var route = '{{url("/")}}/dashboard';
					setTimeout(function(){
						window.location = route;
						 }, 3000);


					}
				},
			  	error: function(data)
		    	{
		    		if(data.status=='500'){
						esmsg.text(data.statusText).css({'color':'red'});
		    		}else if(data.status=='422'){
						esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
		    		}
		    		$(".body-overlay").hide();
		    	}

			});
		});
	    /* Submit closing date query. */
	</script>
@endsection
