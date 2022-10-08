@extends('dashboard.master')
@section('style')
	<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@stop
@section('title', 'Question')
@section('content')
<?php
	$topmenu='Other_Resources';
 	$activemenu = 'Questions';
 ?>
@include('dashboard.include.sidebar')

	<!--=== Profile ===-->
	<div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@include('dashboard.user.agents.include.sidebar')
			@if($segment[2] == "tests")
			@include('dashboard.user.agents.include.sidebar-dashbord')
			@else
			@include('dashboard.user.agents.include.sidebar-files')
			@endif
			<!--End Left Sidebar-->

			<!-- Profile Content -->
			<div class="col-md-9">
				@if($segment[2] == "questions")
				<h2><b>Questions To Ask For Buyer/Seller</b></h2>
				<div class="box-shadow-profile ">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<!--<h2 class="heading-sm pull-left"> Questions to ask </h2>-->
							<a class="cursor pull-right btn btn-default new-ask-question" data-toggle="tab"><i class="fa fa-plus"></i> Add </a>
						</div>

						<div class="panel-body whaite-bg" >
							<div class="">
								<div id="enters-questions-to-ask" class="sky-form">
									<div class="tab-v1">
										<ul class="nav nav-tabs">
											<li class="active"><a data-target="#Buyer" aria-expanded="true" aria-controls="collapseOne" data-toggle="tab">Buyer</a></li>

											<li><a data-target="#Seller" aria-expanded="true" aria-controls="collapseOne" data-toggle="tab">Seller</a></li>
										</ul>

										<div class="tab-content">
											<!-- Buyer -->
											<div class="tab-pane fade in active" id="Buyer">
												<div id="BuyerQuestions" class="sky-form">
													<h2><b>Buyer Questions </b></h2>
												</div>
											</div>

											<!-- Seller -->
											<div class="tab-pane fade" id="Seller">
												<div id="SellerQuestions" class="sky-form">
													<h2><b>Seller Questions</b></h2>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="body-overlay_questions body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
							</div>
						</div>
						<!--/end row-->
					</div>
					<!-- Default Proposals -->
				</div>
				@endif

				@if($segment[2] == "tests")

				<h2><b>Skill Tests</b></h2>
				<p>Prove your skills and impress potential Buyer and Seller by taking a 92Agents tests! The more relevant tests you pass, the more professional you look. Read the test policies & rules before starting any tests.</p>

				<div class="box-shadow-profile ">

					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left">Test Questions  </h2>
						</div>
						<div class="" >
							<div id="enters-default-answers" class="sky-form">
							</div>
							<div class="body-overlay_default body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
						</div>
						<!--/end row-->
					</div>
					<!-- Default Proposals -->
				</div>
				@endif
			</div>
			<!-- End Profile Content -->
		</div><!--/end row-->
	</div>
	<!--=== End Profile ===-->

	<!-- <button class="btn-u" data-toggle="modal" data-target="#profilemodel">Modal Form Sample</button> -->
	<div class="modal fade" id="new-ask-question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				{!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'add-new-question')) !!}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel4">{{ucfirst($userdetails->name)}}</h4>
					</div>
					<div class="modal-body">
						<fieldset>
							<div class="body-overlay-popup body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
							<div class="hide Question-add-msg"></div>
							<section>
								<label class="label">Ask Question</label>
								<label class="textarea ">
									<textarea rows="2" class="field-border" name="question" id="Question_id" placeholder="Enter Question"></textarea>
									<b class="error-text" id="question_error"></b>
								</label>
							</section>
							<section>
								<label class="label">Select Question Type</label>
								<label class="select">
									<select  class="field-border" name="question_type" id="question_type">
										<option value=" ">Select Question Type</option>
										<option value="2">Buyer</option>
										<option value="3">Seller</option>
									</select>
									<i></i>
									<b class="error-text" id="question_type_error"></b>
								</label>
							</section>
							<section class="row">
								<div class="col col-12">
									<label class="label weight">Add question to Survey list</label>
									<div class="inline-group">
										<label class="radio"><input type="radio" name="survey" class="survey_1" value="1" ><i class="rounded-x"></i>Yes</label>
										<label class="radio"><input type="radio" name="survey" class="survey_2" value="0" checked><i class="rounded-x"></i>No</label>
									</div>
								</div>
							</section>
						</fieldset>
					</div>

					<div class="modal-footer">
						<input type="hidden" value="0" name="importance1" >
						<input type="hidden" value="{{ $user->id }}" name="add_by" >
						<input type="hidden" value="{{ $user->agents_users_role_id }}" name="add_by_role" >
						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn-u btn-u-primary" name="edit-profile-submit" value="Save changes" title="Save changes">Save</button>
					</div>
				{!!Form::close()!!}
			</div>
		</div>
	</div>

	<!-- survey popup -->
	<div class="modal fade" id="surveyconfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content not-top">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Survey</h4>
					</div>

					<div class="modal-body">
						<br>
						<div class="body-overlay body-overlay-survey"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
						<div id="surveyerrormsgshow"> </div>
						<p class="sure">Are you sure that you need to add question from the Survey’.</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn-u btn-u-primary delete" id="delete">Sure</button>
						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
					</div>
			</div>
		</div>
	</div>

	<!-- praposal -->
	<div class="modal fade" id="open-proposal-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content not-top">
				<div id="loadproposalshare"  class="loadproposalshare body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Share Question</h4>
				</div>

				<div class="row margin-10">
					{!! Form::open(array('url' => '#','id'=>'searchproposalshareuser')) !!}
						<div class="col-sm-6 md-margin-bottom-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-tag"></i></span>
								<input type="text" autofocus placeholder="Search With Seller/Buyer" value="" name="proposalkeyword" id="proposalkeyword" class="keyword form-control">
							</div>
						</div>

						<div class="col-sm-6 md-margin-bottom-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
								<input type="text" autofocus placeholder="Search With Address & Zipcode" name="proposaladdress" value="" id="proposaladdress" class="address form-control">
							</div>
						</div>

						<div class="col-sm-6 ">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" id="proposaldate" title="Select Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" placeholder="Search With Connected date">
							</div>
						</div>

						<div class="col-sm-6 ">
							<button type="submit" class="btn-u btn-block btn-u-dark"  name="searchproposal"> Search </button>
						</div>
						<input type="hidden" name="praposalid" id="praposalid" value="">
						<input type="hidden" name="praposalidrole" id="praposalidrole" value="">
					{!!Form::close()!!}
				</div>

				<div class="modal-body sky-form" id="append-proposal-share-user-list">
				</div>

				<div class="modal-footer">
					<!-- <button type="button" class="btn-u" data-dismiss="modal">Share</button> -->
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- share option  end-->
@endsection

@section('scripts')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script>
	$(function() {
		var start = moment().subtract(60, 'days');
    	var end = moment();
        $('#proposaldate,#documentsdate').daterangepicker({
         	 format: 'MM/DD/YYYY',
         	"opens": "left",
     	 	startDate: start,
        	endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
	             format: 'MM/DD/YYYY',
	          }
        });
    });
</script>

<script>
	var important_data = [];

	var shared_proposal_connected_user_list  = [];

	$( document ).ready(function() {

	    /* question and ans  */

		$.ajax({

			url: "{{url('/')}}/question/get",

			type: 'POST',

			data: {question_type:'{{ $user->agents_users_role_id }}',add_by:1,add_by_role:1,_token : '{{ csrf_token() }}',from_id: '{{ $user->id }}',from_role : '{{ $user->agents_users_role_id }}'},

			beforeSend: function(){$(".body-overlay_default").show();},

			success: function(result) {
                console.log(result);
				$(".body-overlay_default").hide();
				$.each( result[0], function( key, val ) {
					var htm =

								'<div class="panel-heading border1-bottom col-md-12">'+



									'<h4 class="panel-title question-title"><span>'+

										(key+1)+') </span><a class="question-question q-s-'+val.question_id+'" >'+

												 val.question+

										 	'</a>'+

									 	'<span href="#"  data-toggle="collapse" data-toggle="collapse" data-target="#collapse-answer-'+key+'" class="margin cursor sitegreen pull-right accordion-toggle collapsed" > <i class="fa fa-reply"> </i> <small> Answer </small> </span>'+

								 	'</h4>'+



								 	'<div id="collapse-answer-'+key+'" class="panel-collapse collapse panel-body padding-0 margin-top-10">'+



										'{!! Form::open(array("url" => "#","class"=>"sky-form enters-default-answers")) !!}'+

											'<div class="hide question-msg-'+val.question_id+'"></div>'+

											'<div class="col-md-10">'+

												'<label class="textarea ">'+

													'<textarea data-original-title="Enter your interesting answer" rows="2" class="field-border tooltips" name="question_default_'+key+'" id="question_default_'+key+'" placeholder="Enter your interesting answer">'+result[1][val.question_id]+'</textarea>'+

													'<b class="error-text" id="question_default_'+key+'_error"></b>'+

												'</label>'+

											'</div>'+

											'<input type="hidden" name="question_id" value="'+val.question_id+'">'+

											'<div class="col-md-2 margin-top-5"> <button type="submit" class="btn-u ladda-button pull-right">Save</button></div>'+



										'{!! Form::close() !!}'+

									'</div>'+



								'</div>';

                    console.log(htm);

					$('#enters-default-answers').append(htm);
						$('.collapse').on('show.bs.collapse', function () {
							$('.collapse.in').each(function(){
								$(this).collapse('hide');
							});
							$(this).collapse('toggle');
						});
				});

			}

		});

/*$( document ).ajaxComplete(function( event, request, settings ) {
	$('.collapse').on('show.bs.collapse', function () {
		$('.collapse.in').each(function(){
			$(this).collapse('hide');
		});
		$(this).collapse('toggle');
	});
});*/

		$('#enters-default-answers').submit(function(e){

			e.preventDefault();

			var answers = e.target[1].value;

			var question_id = e.target[2].value;

			var fieldname = e.target[1].name;

			var $form = $(e.target),esmsg = $(".question-msg-"+question_id);

			$.ajax({

				url: "{{url('/')}}/questiontoanswer",

				type: 'POST',

				data: {question_id:question_id,answers:answers,_token : '{{ csrf_token() }}',from_id : '{{ $user->id }}',from_role : '{{ $user->agents_users_role_id }}'},



				success: function(result) {

					$('.error-text').text('');

					$('.field-border').removeClass('error-border');

					if(typeof result.error !='undefined' && result.error !=null){

					 	$.each( result.error, function( key, value ) {

						 	$('#'+fieldname+'_error').removeClass('success-text').addClass('error-text').text(value);

							$('#'+fieldname).addClass('error-border');

						});

					 	esmsg.text('').addClass('hide');

					}

					if(typeof result.msg !='undefined' && result.msg !=null){

						esmsg.text('').addClass('hide');

						msgshowfewsecond(result.msg);

						// esmsg.text('').css({'color':'green'});

						// esmsg.removeClass('hide').addClass('show alert alert-success text-center').text(result.msg);

						// setTimeout(location.reload(),5000);

		    			// setInterval(function() { esmsg.text('').addClass('hide').removeClass('show alert-success'); },5000);

					}

				},

			  	error: function(data)

		    	{

		    		if(data.status=='500'){

						esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');

		    		}else if(data.status=='422'){

						esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');

		    		}

		    		setInterval(function() { esmsg.text('').addClass('hide').removeClass('show'); },5000);

		    	}

			});

		});



		/* question and ans  */

		$.ajax({

			url: "{{url('/')}}/question/get/only/user",

			type: 'POST',

			data: {_token : '{{ csrf_token() }}',add_by : '{{ $user->id }}',add_by_role : '{{ $user->agents_users_role_id }}'},

			beforeSend: function(){$(".body-overlay_questions").show();},

			success: function(result) {

				$(".body-overlay_questions").hide();

				var by =1,sel=1;

				$.each( result, function( key, val ) {

					important_data[val.question_id] = val;

					if(val.question_type==2){

						key = by;

						by = 1+by;

						var utyp = 'buyer';

					var apen = $('#BuyerQuestions');

					}

					if(val.question_type==3){

						key = sel;

						sel = 1+sel;

						var utyp = 'seller';

					var apen = $('#SellerQuestions');

					}

					var htm = '<div class="askquestioncount_'+utyp+'">'+

								'<div class="panel-group margin-0" id="accordion-'+utyp+'-'+key+'">'+



										'<div class="panel-heading border1-bottom">'+



											'<h4 class="panel-title question-title"><span>'+



											key+') </span><a class="question-question q-s-'+val.question_id+'" >'+

													 val.question+

											 	'</a>'+



												'<span href="#" data-toggle="collapse" class="margin cursor sitegreen pull-right accordion-toggle collapsed" data-target="#collapse-'+utyp+'-'+key+'"> <i class="fa fa-edit  marginediticon"> </i> <small> Edit </small> </span>'+

												'<span class="sitegreen margin cursor pull-right share_'+val.question_id+'"  Title="Share" onclick="shareproposalpopup('+val.question_id+','+val.question_type+')" id="share_'+val.question_id+'"> <i class="rounded-x fa fa-share-alt"></i> <small> Share </small></span>'+

												'';





										htm +=' '+

												'<span class="clicksurvey_'+val.question_id+'">';

													if(val.survey==0){

														htm +='<span href="#" class="cursor margin green pull-right" onclick="survey('+val.question_id+');"> <i class="fa fa-check-circle-o"> </i> <small>Survey</small> </span>';

													}else{

														htm +='<span href="#" class="cursor margin red pull-right" onclick="surveyremove('+val.question_id+');"> <i class="fa fa-times-circle-o"> </i> <small>Survey</small> </span>';

													}

										htm +=' </span>'+



											'</h4>'+



											'<div id="collapse-'+utyp+'-'+key+'" class="panel-collapse collapse">'+

												'<div class="panel-body padding-0 margin-top-10">'+

													'{!! Form::open(array("url" => "#","class"=>"sky-form enters-questions-to-ask")) !!}'+



														'<div class="hide question-ask-msg-'+val.question_id+'"></div>'+

													 	'<div class="col-md-10">'+

															'<label class="textarea ">'+

																'<textarea rows="1" class="field-border" name="questions_to_ask_'+key+'" id="question_default_'+key+'" placeholder="Enter Question">'+val.question+'</textarea>'+

																'<b class="error-text" id="questions_to_ask_'+key+'_error"></b>'+

															'</label>'+

														'</div>'+

														'<input type="hidden" name="question_id" value="'+val.question_id+'">'+

														'<button type="submit" class="margin-top-5 col-md-2 btn-u pull-right">Change</button>'+



													'{!!Form::close()!!}'+

												'</div>'+

											'</div>'+



										'</div>'+



								'</div>'+

							'</div>';



					apen.append(htm);

				});

			}

		});



		$('#enters-questions-to-ask').submit(function(e){

			e.preventDefault();



			//var question_id = e.srcElement[2].value;

			//var fieldname = e.srcElement[1].name;
			var question = e.target[1].value;

			var question_id = e.target[2].value;

			var fieldname = e.target[1].name;

			//return false;
			var $form = $(e.target),esmsg = $(".question-ask-msg-"+question_id);

			$.ajax({

				url: "{{url('/')}}/updatequestion",

				type: 'POST',

				data: {question_id:question_id,question:question,_token : '{{ csrf_token() }}',add_by : '{{ $user->id }}',add_by_role : '{{ $user->agents_users_role_id }}'},

				success: function(result) {

					$('.error-text').text('');

					$('.field-border').removeClass('error-border');

					if(typeof result.error !='undefined' && result.error !=null){

					 	$.each( result.error, function( key, value ) {

						 	$('#'+fieldname+'_error').removeClass('success-text').addClass('error-text').text(value);

							$('#'+fieldname).addClass('error-border');

						});

					 	esmsg.text('').addClass('hide');

					}

					if(typeof result.msg !='undefined' && result.msg !=null){



						esmsg.text('').css({'color':'green'});

						esmsg.removeClass('hide').addClass('show alert alert-success text-center').text(result.msg);

						// setTimeout(location.reload(),5000);

						$('.q-s-'+question_id).text(question);

		    			setInterval(function() { esmsg.text('').addClass('hide').removeClass('show alert-success'); },5000);

					}

				},

			  	error: function(data)

		    	{

		    		if(data.status=='500'){

						esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');

		    		}else if(data.status=='422'){

						esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');

		    		}

		    		setInterval(function() { esmsg.text('').addClass('hide').removeClass('show'); },5000);

		    	}

			});

		});

		$('#add-new-question').submit(function(e){

			e.preventDefault();

			var $form = $(e.target),esmsg = $(".Question-add-msg");

			$.ajax({

				url: "{{url('/')}}/insertquestion",

				type: 'POST',

				data: $form.serialize(),

				beforeSend: function(){$(".body-overlay-popup").show();},

	    	    processData:false,

				success: function(result) {

					$('#Question_id').val('');

					$('#question_type').val('');

					$(".body-overlay-popup").hide();

					$('.error-text').text('');

					$('.field-border').removeClass('error-border');

					if(typeof result.error !='undefined' && result.error !=null){

					 	$.each( result.error, function( key, value ) {

						 	$('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);

							$('#'+key).addClass('error-border');

						});

					 	esmsg.text('').addClass('hide');

					}

					if(typeof result.msg !='undefined' && result.msg !=null){



						esmsg.text('').css({'color':'green'});

						esmsg.removeClass('hide').addClass('show alert alert-success text-center').text(result.msg);

		    			setInterval(function() { esmsg.text('').addClass('hide').removeClass('show alert-success'); },5000);

		    			anymodelhideinfewsecond('#new-ask-question');

						var val = result.data;

						important_data[val.question_id] = val;

						if(val.question_type==2){

							key = $('.askquestioncount_buyer').length+1;

							var utyp = 'buyer';

							var apen = $('#BuyerQuestions');

						}



						if(val.question_type==3){

							key = $('.askquestioncount_seller').length+1;

							var utyp = 'seller';

							var apen = $('#SellerQuestions');

						}



						var htm = '<div class="askquestioncount_'+utyp+'">'+

									'<div class="panel-group margin-0" id="accordion-'+utyp+'-'+key+'">'+



											'<div class="panel-heading border1-bottom">'+



												'<h4 class="panel-title"><span>'+



												key+') </span><a class=" q-s-'+val.question_id+'" >'+

														 val.question+

												 	'</a>'+



													'<span href="#" class="margin cursor sitegreen pull-right accordion-toggle collapsed" data-href="#collapse-'+utyp+'-'+key+'"> <i class="fa fa-edit  marginediticon"> </i> <small> Edit </small> </span>'+

													'<span class="sitegreen margin cursor pull-right share_'+val.question_id+'"  Title="Share" onclick="shareproposalpopup('+val.question_id+','+val.question_type+')" id="share_'+val.question_id+'"> <i class="rounded-x fa fa-share-alt"></i> <small> Share </small></span>'+

													'';





											htm +=' '+

													'<span class="clicksurvey_'+val.question_id+'">';

														if(val.survey==0){

															htm +='<span href="#" class="cursor margin green pull-right" onclick="survey('+val.question_id+');"> <i class="fa fa-check-circle-o"> </i> <small>Survey</small> </span>';

														}else{

															htm +='<span href="#" class="cursor margin red pull-right" onclick="surveyremove('+val.question_id+');"> <i class="fa fa-times-circle-o"> </i> <small>Survey</small> </span>';

														}

											htm +=' </span>'+



												'</h4>'+



												'<div id="collapse-'+utyp+'-'+key+'" class="panel-collapse collapse">'+

													'<div class="panel-body padding-0 margin-top-10">'+

														'{!! Form::open(array("url" => "#","class"=>"sky-form enters-questions-to-ask")) !!}'+



															'<div class="hide question-ask-msg-'+val.question_id+'"></div>'+

														 	'<div class="col-md-10">'+

																'<label class="textarea ">'+

																	'<textarea rows="1" class="field-border" name="questions_to_ask_'+key+'" id="question_default_'+key+'" placeholder="Enter Question">'+val.question+'</textarea>'+

																	'<b class="error-text" id="questions_to_ask_'+key+'_error"></b>'+

																'</label>'+

															'</div>'+

															'<input type="hidden" name="question_id" value="'+val.question_id+'">'+

															'<button type="submit" class="margin-top-5 col-md-2 btn-u pull-right">Change</button>'+



														'{!!Form::close()!!}'+

													'</div>'+

												'</div>'+



											'</div>'+



									'</div>'+

								'</div>';

						apen.append(htm);

					}

				},

			  	error: function(data)

		    	{

		    		if(data.status=='500'){

						esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');

		    		}else if(data.status=='422'){

						esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');

		    		}

		    		$(".body-overlay").hide();

		    		setInterval(function() { esmsg.text('').addClass('hide').removeClass('show'); },5000);

		    	}

			});

		});

	    /* question answear */
	    $('.new-ask-question').click(function(e){
			e.preventDefault();
			$('#Question_id').val('');
		 	$('#new-ask-question').modal('show');
		});

		$('#searchproposalshareuser').submit(function(e){
			e.preventDefault();
			shareproposalpopup($('#praposalid').val(),$('#praposalidrole').val());
		});
    });

	/*survey*/
	function survey(id) {
		var qdata = important_data[id];
		$('.sure').show().text('Are you sure that you need to add  question ('+qdata.question+') from the Survey’.');
		$('#surveyerrormsgshow').removeClass('alert alert-success alert-danger text-center').text('');
		$('#surveyconfirm')
	        .modal({ backdrop: 'static', keyboard: false })
	        .one('click', '.delete', function (e) {
	           	$.ajax({
					url: "{{url('/')}}/survey",

					type: 'post',

					data: {question_id:id,_token : '{{ csrf_token() }}',agents_user_id: '{{ $user->id }}',agents_users_role_id : '{{ $user->agents_users_role_id }}'},

					beforeSend: function(){$(".body-overlay-survey").show();},

					success: function(result) {

						// console.log(result);

						$(".body-overlay-survey").hide();

						if(result.status=='error'){

							$('#surveyerrormsgshow').addClass('alert alert-danger text-center').text(result.msg);

						}else{

							$('#surveyerrormsgshow').addClass('alert alert-success text-center').text(result.msg);

							$('.clicksurvey_'+id).html('<span href="#" class="cursor margin red pull-right" onclick="surveyremove('+id+');"> <i class="fa fa-times-circle-o"> </i> <small>Survey</small> </span>');

							$('.sure').hide();

						}anymodelhideinfewsecond('#surveyconfirm');

						// setTimeout($('#imprterrormsgshow').removeClass('alert alert-success alert-danger text-center').text(''),7000);

					},error: function(result) {

						$(".body-overlay-survey").hide();

					}

				});

        });

	}

	function surveyremove(id) {

		var qdata = important_data[id];

		$('.sure').show().text('Are you sure that you need to remove  question ('+qdata.question+') from the Survey.');

		$('#surveyerrormsgshow').removeClass('alert alert-success alert-danger text-center').text('');

		$('#surveyconfirm')

	        .modal({ backdrop: 'static', keyboard: false })

	        .one('click', '.delete', function (e) {

	           	$.ajax({

					url: "{{url('/')}}/survey/delete",

					type: 'POST',

					data: {question_id:id, _token : '{{ csrf_token() }}',add_by : '{{ $user->id }}',add_by_role : '{{ $user->agents_users_role_id }}'},

					// processData:false,

					beforeSend: function(){$(".body-overlay-survey").show();},

					success: function(result) {


						$(".body-overlay-survey").hide();

						if(result.status=='error'){

							$('#surveyerrormsgshow').addClass('alert alert-danger text-center').text(result.msg);

						}else{

							$('#surveyerrormsgshow').addClass('alert alert-success text-center').text(result.msg);

							$('.sure').hide();

							$('.clicksurvey_'+id).html('<span href="#" class="cursor margin green pull-right"" onclick="survey('+id+');"> <i class="fa fa-check-circle-o"> </i> <small>Survey</small> </span>');

						}anymodelhideinfewsecond('#surveyconfirm');

						// setTimeout(location.reload(),5000);

					},error: function(data) {	$(".body-overlay-survey").hide(); 	}

				});

        });

	}

	/*share question all agents shellers buyers*/
	function shareproposalpopup(id,type) {
		// var praposaldata = proposale_data[id];
		$('#append-proposal-share-user-list').html('');
		$('#open-proposal-share').modal('show');
		$('#praposalid').val(id);
		$('#praposalidrole').val(type);
		var keyword = $('#proposalkeyword').val();
		var address = $('#proposaladdress').val();
		var date = $('#proposaldate').val();

		$.ajax({
			url: "{{url('/')}}/shared/question/with/connected/users/by/"+id+"/"+type+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",
			type: 'post',
			data: {date :date,keyword : keyword,address : address,_token : '{{ csrf_token() }}'},
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			beforeSend: function(){$(".loadproposalshare").show();},
			success: function(result) {
				console.log(result);
				$(".loadproposalshare").hide();
				if(result.count !== 0){
					$.each( result.result, function( index, value ) {
						shared_proposal_connected_user_list[value.details_id] = value;
						if(value.share_file.result != '' && value.share_file.result != null){
							var asrvfun ='<input type="checkbox" checked onclick="shareproposalremove('+value.details_id+','+id+','+value.share_file.result.shared_id+')" name="proposale-checkox-'+value.details_id+'"><i class="o-p-a"></i>';
						}else{
							var asrvfun ='<input type="checkbox" onclick="shareproposal('+value.details_id+','+id+')"  name="proposale-checkox-'+value.details_id+'"><i class="n-p-a"></i>';
						}
						var htmll = '<section><label class="checkbox" style="border-bottom: 1px solid #e6e6e6;">'+
										'<span class="proposal_share_'+value.details_id+'_'+value.details_id_role_id+'">'+asrvfun+'</span>'+
										'<strong>'+value.name+'</strong>'+
										'<p>(<small>'+
										value.posttitle+
										'<small>)</p>'+
									'</label></section>';
				 		$('#append-proposal-share-user-list').append(htmll);
					});
				}else{
					let no_records = `No Records Found`;
					$('#append-proposal-share-user-list').html(no_records);
				}
			},
		  	error: function(data) {

	    		$(".loadproposalshare").hide();
	    		if(data.status=='500'){
					$('#append-proposal-share-user-list').text(data.statusText).css({'color':'red'});
	    		}else if(data.status=='422'){
					$('#append-proposal-share-user-list').text(data.responseJSON.image[0]).css({'color':'red'});
	    		}
	    	}
		});
	}

	function shareproposal(userid,id) {

		var userdata = shared_proposal_connected_user_list[userid];

       	$.ajax({

			url: "{{url('/shared/data/insert')}}",

			type: 'post',

			data: {notification_type : 1,notification_message : '{{ $userdetails->name }} asked questions related to your post `'+userdata.posttitle+'`' ,shared_type:1 ,shared_item_id:id,shared_item_type : 1,shared_item_type_id : userdata.post_id,receiver_id : userdata.details_id,receiver_role: userdata.details_id_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},

			success: function(result) {

				$('.proposal_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" checked onclick="shareproposalremove('+userid+','+id+','+result.data+')"  name="proposale-checkox-'+userdata.details_id+'"><i class="o-p-a"></i>');
				msgshowfewsecond('Question shared successfully');
			},error: function(result) {

			}

		});



	}

	function shareproposalremove(userid,id,shared_id) {

		var userdata = shared_proposal_connected_user_list[userid];

       	$.ajax({

			url: "{{url('/shared/data/delete')}}",

			type: 'post',

			data: { id : id, shared_id : shared_id, _token : '{{ csrf_token() }}' },

			success: function(result) {
				msgshowfewsecond('Question removed successfully');
				$('.proposal_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" onclick="shareproposal('+userid+','+id+')"  name="proposale-checkox-'+userdata.details_id+'"><i class="n-p-a"></i>');

			},error: function(result) {

			}

		});

	}

	$('#open-proposal-share').on('hidden.bs.modal', function () {
	    ($("#searchproposalshareuser")[0]).reset();
	});
</script>
@stop
