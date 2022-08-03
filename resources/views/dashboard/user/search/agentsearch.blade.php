@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/page_job.css') }}">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@stop
@section('title', 'Agents Search')
@section('content')
<?php  $topmenu='my_post'; ?>
@php  $activemenu='Agents' @endphp
@include('dashboard.include.sidebar')

	<!--=== Profile ===-->
	<div class="container content profile">
		<div class="row">

			<!-- Profile Content -->
			<div class="col-md-12">
				<h2><b>Find appropriate agents for your deal</b></h2>
				<div class="box-shadow-profile margin-bottom-40">
					<div class="panel-profile">
						<div class="panel-heading  air-card">
							{!! Form::open(array('url' => '#','id'=>'searchagents','class'=>'sky-form')) !!}
							<div class="row">
								<?php
								/*
								<div class="col-sm-6 md-margin-bottom-10 keyworddiv" style='display:none'>
									<div class="input-group">
										<span class="input-group-addon sitegreen dropdown-toggle cursor" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></span>

										<input type="text" autofocus placeholder="search agents" value="<?php echo @$search_post['keyword'] ?>" name="keyword" id="keyword" class="keyword form-control text-13">

										<input type="hidden" value="<?php echo @$search_post['searchinputtype'] != '' ? $search_post['searchinputtype'] : 'name';  ?>" name="searchinputtype" id="searchinputtype" class="searchinputtype">

										<ul class="dropdown-menu" role="menu">
											<li class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='name' ? 'active' : '' }} name"><a class="padding-5-20 " onclick="changesearchinput('name');">Name</a></li>
											<li class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='messages' ? 'active' : '' }} messages"><a class="padding-5-20 " onclick="changesearchinput('messages');">Messages</a></li>
											<li class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='questions_asked' ? 'active' : '' }} questions_asked"><a class="padding-5-20 " onclick="changesearchinput('questions asked');">Questions Asked</a></li>
											<li class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='questions_answered' ? 'active' : '' }} questions_answered"><a class="padding-5-20 " onclick="changesearchinput('questions answered');">Questions Answered</a></li>
											<li class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='answers' ? 'active' : '' }} answers"><a class="padding-5-20 " onclick="changesearchinput('answers');">Answers</a></li>
											<!-- <li class="searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='post_contains' ? 'active' : '' }} post_contains"><a class="padding-5-20 " onclick="changesearchinput('post contains');">Post Contains</a></li> -->
										</ul>
									</div>
								</div>
								*/
								?>
								<div class="col-sm-3 md-margin-bottom-10 keyworddiv" >

									<input type="hidden" value="<?php echo $search_post['searchinputtype'] != '' ? $search_post['searchinputtype'] : 'name';  ?>" name="searchinputtype" id="searchinputtype" class="searchinputtype">

										<select class="form-control text-13" id="search_by_value">
											<option class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='name' ? 'selected' : '' }} name" value="name">

												Name
											</option>
											<option class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='messages' ? 'selected' : '' }} messages" value="messages">

												Messages
											</option>
											<option class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='questions_asked' ? 'selected' : '' }} questions_asked" value="questions asked">

												Questions Asked
											</option>
											<option class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='questions_answered' ? 'selected' : '' }} questions_answered" value="questions answered">

												Questions Answered
											</option>
											<option class="cursor border1-bottom searchlist {{ @$search_post['searchinputtype'] && $search_post['searchinputtype']=='answers' ? 'selected' : '' }} answers" value="answers">
												Answers
											</option>

										</select>

								</div>
								<div class="col-sm-3 md-margin-bottom-10 datediv">
									<input type="text" autofocus placeholder="search agents" value="<?php echo @$search_post['keyword'] ?>" name="keyword" id="keyword" class="keyword form-control text-13">
								</div>
								<div class="col-sm-6 md-margin-bottom-10 datediv">
									<div class="input-group">
										<span class="input-group-addon sitegreen"><i class="fa fa-calendar"></i></span>
										<input type="text" id="date" title="Select Date" value="" name="date" value="<?php echo @$search_post['date'] ?>" class="text-13 col-lg-10 form-control reservation date" placeholder="Date">
									</div>
								</div>
							</div>

							<div class="row" id="alladdress">
								<div class="col-sm-3 md-margin-bottom-10 addressdiv">
									<div class="input-group width100">
										<span class="input-group-addon sitegreen"><i class="fa fa-map-marker"></i></span>
										<input type="text"  placeholder="Address" name="address" value="<?php echo @$search_post['address'] ?>" id="address" class="text-13 address form-control">
									</div>
								</div>


								<div class="col-sm-3 md-margin-bottom-10 statediv">
									<div class="input-group width100">
										<select id="state" name="state" class="state form-control multipalselecte text-13" placeholder="Selecte State">
											<option value="">Select State</option>
											@foreach($state as $states)
												<option value="{{ $states->state_id }}" {{ @$search_post['state'] && $search_post['state']== $states->state_id ? 'selected' : '' }}> {{ $states->state_name }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-sm-3 md-margin-bottom-10 citydiv">
									<div class="input-group width100">

										<select id="city" name="city" class="cityform-control multipalselecte text-13" placeholder="Selecte City">
											<option value="">Select City</option>

										</select>
									</div>
								</div>

								<div class="col-sm-3 md-margin-bottom-10 zipcodesdiv">
									<div class="input-group width100">
										<input type="text"  placeholder="Zip Code" name="zipcodes" value="<?php echo @$search_post['zipcodes'] ?>" id="zipcodes" class="text-13 zipcodes form-control">

									</div>

								</div>

							</div>

							<div class="row">

								<div class="col-sm-3 pricerangediv">

									<div class="input-group width100">

										<!-- <select id="pricerange" name="pricerange" class="pricerange form-control multipalselecte text-13" placeholder="Selecte Price Range">

											<option value="">Price Range</option>

											<option value="75" {{ @$search_post['pricerange'] && $search_post['pricerange'] == '75' ? 'selected' : '' }}> Less Than 75k </option>

											<option value="75-150" {{ @$search_post['pricerange'] && $search_post['pricerange'] == '75-150' ? 'selected' : '' }}>  75k - 150k </option>

											<option value="150-250" {{ @$search_post['pricerange'] && $search_post['pricerange'] == '150-250' ? 'selected' : '' }}> 150k - 250k </option>

											<option value="250-400" {{ @$search_post['pricerange'] && $search_post['pricerange'] == '250-400' ? 'selected' : '' }}> 250k - 400k </option>

											<option value="400" {{ @$search_post['pricerange'] && $search_post['pricerange'] == '400' ? 'selected' : '' }}> Above 400k </option>

										</select> -->

										<label class="label rounded-x">Sales Range (<span id="slider2-value1-rounded">0</span> - <span id="slider2-value2-rounded">10000000</span>)</label>

										<div id="slider2-rounded"></div>

									</div>

								</div>



								<input type="hidden" name="usertype" id="usertype" value="4">

								<div class="col-md-9 submitdiv">

									<button type="submit" class="btn-u pull-right"  name="searchagents">Search</button>

								</div>

							</div>

							{!!Form::close()!!}

						</div>


						<!-- Horizontal advert -->

						<!--right Sidebar-->
						@include('dashboard.user.buyers.include.horizontal-ad')
						<!--End right Sidebar-->

						<!--/start row-->

						<div class="" >

							<div id="append-agents-ajax"></div>

							<div id="loaderagents" class="col-md-12 center loder loaderagents"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>

							<button type="button" class="btn-u btn-u-default btn-block text-center margin-top-10 hide" id="loadagents">Load More</button>

						</div>

						<!--/end row-->

					</div>

				</div>



			</div>

			<!-- End Profile Content -->

		</div><!--/end row-->

	</div>

	<!--=== End Profile ===-->

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

								<input type="text" autofocus placeholder="Seller/Buyer/Post" value="" name="proposalkeyword" id="proposalkeyword" class="keyword form-control">

							</div>

						</div>

						<div class="col-sm-6 md-margin-bottom-10">

							<div class="input-group">

								<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

								<input type="text" autofocus placeholder="Address & Zipcode" name="proposaladdress" value="" id="proposaladdress" class="address form-control">

							</div>

						</div>

						<div class="col-sm-6 ">

							<div class="input-group">

								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>

								<input type="text" id="proposaldate" title="Select Date" autofocus="" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" placeholder="Search With Connected date">

							</div>

						</div>

						<div class="col-sm-6 ">

							<button type="submit" class="btn-u btn-block btn-u-dark"  name="searchproposal"> Search </button>

						</div>

						<input type="hidden" name="searchpost_id" id="searchpost_id" value="">

						<input type="hidden" name="praposalid" id="praposalid" value="">

						<input type="hidden" name="praposalidrole" id="praposalidrole" value="">

					{!!Form::close()!!}

				</div>

				<div class="modal-body sky-form border-none" id="append-proposal-share-user-list">

				</div>

				<div class="modal-footer">

					<button type="button" class="btn-u" data-dismiss="modal">Share</button>

					<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

				</div>

			</div>

		</div>

	</div>

@endsection

@section('scripts')



<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script type="text/javascript">




	$('#state').on('change',function(){
		$('#city').children('option:not(:first)').remove();
		state_id= $(this).val();
		$.ajax({
			url: "{{url('/')}}/city/get/"+state_id,
			type: 'get',
			success: function(result) {
				statearray = result;
				console.log('--inside the success');
				$.each( result, function( key, val ) {
					console.log('inside the loop');
					$('#city').append('<option value="'+val.city_id+'" >'+val.city_name+'</option>');
					$('#city').multiselect('rebuild');
				});
			}
		});

		// $('#city').multiselect('rebuild');
	});

    $(function() {

    	var start = moment().subtract(30, 'days');

    	var end = moment();

        $('#date,#proposaldate').daterangepicker({


    	 	// autoUpdateInput: false,

    	  	// timePicker: true,

         	format: 'MM/DD/YYYY',

         	"opens": "center",

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

	            format: 'MM/DD/YYYY'

	          }

		});

		$("#date").val("");
    });


</script>

<script type="text/javascript">

	var agents_data = [];

	var shared_proposal_connected_user_list  = [];

	var slider = [];

	slider[0] = 0;

	slider[1] = 10000000;



	(function() {

		$('#slider2-rounded').slider({

	      min: 0,

	      max: 10000000,

	      range: true,

	      values: [0, 10000000],

	      slide: function(event, ui)

	      {

	        slider[0] = ui.values[0];

	        $('#slider2-value1-rounded').text(ui.values[0]);

	        slider[1] = ui.values[1];

	        $('#slider2-value2-rounded').text(ui.values[1]);

	      }

        });

		$('.multipalselecte').multiselect({

			columns: 1,

		    search: true,

		    onChange: function(option, checked) {



            }

		});

		$('#searchproposalshareuser').submit(function(e){

			e.preventDefault();

			shareproposalpopup($('#praposalid').val(),$('#praposalidrole').val(),$('#searchpost_id').val());

		});

		$('#searchagents').submit(function(e){

			e.preventDefault();



			var keyword 		= $('#keyword').val();

			var searchinputtype = $('#searchinputtype').val();

			var date 			= $('#date').val();

			var address 		= $('#address').val();

			var city 			= $('#city').val();

			var state 			= $('#state').val();

			var zipcodes 		= $('#zipcodes').val();

			var pricerange 		= slider;//$('#pricerange').val();

			var usertype 		= $('#usertype').val();

			var error = true;

			$('#usertypeerror').addClass('hide');

			if(searchinputtype=='name' && usertype == ''){

				$('#usertypeerror').removeClass('hide');

				error = false;

			}

			if(error){

				$.ajax({

					url: "{{url('/')}}/search/agents/list/0",

					type: 'post',

					data: {keyword : keyword,searchinputtype : searchinputtype,date :date,address : address,city : city,state : state,zipcodes : zipcodes,pricerange : pricerange,usertype : usertype,_token : '{{ csrf_token() }}',agents_users_role_id : 4},

					headers: {

					       'X-CSRF-TOKEN': '{{ csrf_token() }}'

					    },

					beforeSend: function(){$(".loaderagents").show();},

					success: function(result) {

						$(".loaderagents").hide();

						$('#append-agents-ajax').html('');

						loadhtml(result,'yes');

					},

				  	error: function(data)

			    	{

			    		$(".loaderagents").hide();

			    		if(data.status=='500'){

							$('.loaderagents').text(data.statusText).css({'color':'red'});

			    		}else if(data.status=='422'){

							$('.loaderagents').text(data.responseJSON.image[0]).css({'color':'red'});

			    		}

			    	}

				});

			}

		});



		$('#loadagents').click(function(e){

			e.preventDefault();

			var limit = $(this).attr('title');

			loadagents(limit);

		});

		loadagents(0);

		var st = ("<?php echo @$search_post['searchinputtype'] !='' ? $search_post['searchinputtype'] : 'name';  ?>").replace('_',' ');

		changesearchinput(st);

    })();

    /*load uploadandshare */

	function loadagents(limit) {

		var keyword 		= $('#keyword').val();

		var searchinputtype = $('#searchinputtype').val();

		var date 			= $('#date').val();

		var address 		= $('#address').val();

		var city 			= $('#city').val();

		var state 			= $('#state').val();

		var zipcodes 		= $('#zipcodes').val();

		var pricerange 		= slider;//$('#pricerange').val();

		var usertype 		= $('#usertype').val();

		var error = true;

		$('#usertypeerror').addClass('hide');

		if(searchinputtype=='name' && usertype == ''){

			$('#usertypeerror').removeClass('hide');

			error = false;

		}

		if(error){

			$.ajax({

				url: "{{url('/')}}/search/agents/list/"+limit,

				type: 'post',

				data: {keyword : keyword,searchinputtype : searchinputtype,date :date,address : address,city : city,state : state,zipcodes : zipcodes,pricerange : pricerange,usertype : usertype,_token : '{{ csrf_token() }}',agents_users_role_id : 4},

				headers: {

			        	'X-CSRF-TOKEN': '{{ csrf_token() }}'

				    },

				beforeSend: function(){$(".loaderagents").show();},

				success: function(result) {

					$(".loaderagents").hide();

					loadhtml(result,'null');

				},

			  	error: function(data)

		    	{

		    		$(".loaderagents").hide();

		    		if(data.status=='500'){

						$('.loaderagents').text(data.statusText).css({'color':'red'});

		    		}else if(data.status=='422'){

						$('.loaderagents').text(data.responseJSON.image[0]).css({'color':'red'});

		    		}

		    	}

			});

		}

	}



	function loadhtml(result,load) {

		var searchtype = $('#searchinputtype').val();

    	if(load=='yes'){
    		$('#append-agents-ajax').html('');
    	}
		if(result.count !== 0){
			if(searchtype=='name'){
			console.log(result);
				$.each( result.result, function( key, value ) {
					agents_data[value.id] = value;
					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
					var htmll = '<div class="border1-bottom" id="agents_list_data_'+value.id+'">'+
									'<div class="funny-boxes acpost padding-5-20" onclick="redarecturl(\'{{ URL("/") }}/search/agents/details/'+value.id+'\')">'+
									'';
									if(value.photo){
										htmll += '<img class="img-circle header-circle-img1 img-margin" width="80" height="80" src="{{ URL::asset("assets/img/profile/") }}/'+value.photo+'" alt="">';
									}else{
										htmll += '<img class="img-circle header-circle-img1 img-margin" width="80" height="80" src="{{ URL::asset("assets/img/testimonials/user.jpg") }}" alt="">';
									}

						htmll +='<div class="funny-boxes-img " style="margin: 8px 0px 20px;">'+
								'<h2 class="title sm-margin-bottom-20"> <a class="padding-left-7"  class="title">'+value.name+ '<sub class="'+value.login_status+'"> '+value.login_status+' </sub></a> </h2>'+'<ul class="list-inline">';

												if(value.years_of_expreience){
													htmll +='<li><strong>Experience : </strong>'+( value.years_of_expreience !='' ? (value.years_of_expreience).replace('-',' to ')+' Year' : '' )+'</li> - ';
												}

						htmll +=((value.brokers_name != null) ? '<li><strong>Broker : </strong> '+value.brokers_name+' - ' : '') +'</li>'+
								'<li><strong>Posted <i class="fa fa-clock-o"></i> : </strong>'+date+'</li> - '+	'<li><strong><i class="fa fa-map-marker"></i></strong> '+ value.city_name+','+value.state_name +' </li>'+'</ul>'+'</div>';

										if(value.description){
											htmll +='<div class="clear-both limited-post-text hidetext2line margin-bottom-10" onclick="redarecturl(\'{{ URL("/") }}/search/agents/details/'+value.id+'\')" title="'+value.description+'">'+
														value.description
													+'</div>';
										}

										if(value.skill_data != ''){
											htmll +=
												'<ul class="list-inline clear-both">';
												$.each(value.skill_data, function( key, skills ) {
													htmll +='<li> <span class="skill-lable label label-success">'+skills.skill+'</span></li>';
												});

											htmll +='</ul>';
										}

										htmll +='<ul class="list-inline clear-both" style="margin-bottom: 0px;">'+
											'<li><a><strong> Agent Details </strong></a></li>'+
										'</ul>'+
									'</div>'+
								'</div>';

					var msc = $('#agents_list_data_'+value.id).find('#append-agents-ajax');
			 		var msct = msc.prevObject.length;

			 		if(msct==0){
	                    $('#append-agents-ajax').append(htmll);
	                }else{
	                	$('#agents_list_data_'+value.id).replaceWith( htmll );
	                }
				});
			}

			if(searchtype=='messages'){

				$.each( result.result, function( key, value ) {



					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));

					var htmll = '<div class="border1-bottom" id="agents_list_data_'+value.messages_id+'">'+

									'<div class="funny-boxes acpost" onclick="redarecturl(\'{{ URL("/") }}/messages/'+value.post_id+'/'+value.receiver_user_id+'/'+value.receiver_user_role_id+'\')">'+

									'';

									if(value.photo){



										htmll += '<img class="img-circle header-circle-img1 img-margin" width="80" height="80" src="{{ URL::asset("assets/img/profile/") }}/'+value.photo+'" alt="">';

									}else{



										htmll += '<img class="img-circle header-circle-img1 img-margin" width="80" height="80" src="{{ URL::asset("assets/img/testimonials/user.jpg") }}" alt="">';

									}

								htmll +=

										'<div class="funny-boxes-img " style="margin: 8px 0px 20px;">'+

											'<h2 class="title sm-margin-bottom-20"> <a class="padding-left-7" class="title">'+value.name+ '</a> </h2>'+

											'<ul class="list-inline">'+

													'<li><strong><i class="fa fa-clock-o"></i>: </strong>'+date+'</li> - '+

													(value.tags_read == '1' ? '<li><strong> Unread </strong></li> - ' : '' )+

													(value.is_user == 'sender' ? '<li><strong> send </strong></li>' : '<li><strong> Receive </strong></li> ' )+

											'</ul>'+

										'</div>';



										if(value.message_text){

											htmll +='<div class="clear-both limited-post-text hidetext2line margin-bottom-10" title="'+value.message_text+'">'+

														'<strong>Message: </strong>'+value.message_text

													+'</div>';

										}

							htmll +='</div>'+

								'</div>';



			 		var msc = $('#agents_list_data_'+value.messages_id).find('#append-agents-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-agents-ajax').append(htmll);

	                }else{

	                	$('#agents_list_data_'+value.messages_id).replaceWith( htmll );

	                }

				});

			}

			if(searchtype=='questions_asked'){

				$.each( result.result, function( key, value ) {

					key = $('.askquestioncount_agents').length+1-1;

					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));

					var htmll = '<div class="border1-bottom askquestioncount_agents" id="agents_list_data_'+value.shared_id+'">'+

									'<div class="funny-boxes acpost">'+

										'<div class="funny-boxes-img " >'+

											'<h2 class="title sm-margin-bottom-20" onclick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'/10\')"> <a class="" class="title">'+(key+1)+') '+value.question+ '</a> </h2>'+

											'<div class="clear-both limited-post-text hidetext2line margin-bottom-10" title="'+value.posttitle+'">'+

												'<strong>For Post : </strong>'+value.posttitle

											+'</div>'+

											'<ul class="list-inline margin-bottom-0">'+

													'<li><strong><i class="fa fa-clock-o"></i> : </strong>'+date+'</li> - '+

													'<li><strong> Shared on </strong>'+value.name+'</li>'+

													'<li><span class="text-15 sitegreen margin cursor  share_'+value.question_id+'"  Title="Share" onclick="shareproposalpopup('+value.question_id+','+value.question_type+','+value.post_id+')" id="share_'+value.question_id+'"> <i class="rounded-x fa fa-share-alt"></i> <small> Share </small></span></li>'+

											'</ul>'+

										'</div>'+

									'</div>'+

								'</div>';



			 		var msc = $('#agents_list_data_'+value.shared_id).find('#append-agents-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-agents-ajax').append(htmll);

	                }else{

	                	$('#agents_list_data_'+value.shared_id).replaceWith( htmll );

	                }

				});

			}

			if(searchtype=='questions_answered'){

				$.each( result.result, function( key, value ) {

					key = $('.askquestioncount_agents').length+1-1;

					var date = timeDifference(new Date(), new Date(Date.fromISO(value.shared_date)));

					var htmll = '<div class="askquestioncount_agents border1-bottom" id="agents_list_data_'+value.shared_id+'">'+

									'<div class="funny-boxes acpost">'+



										'<div class="funny-boxes-img " >'+

											'<h2 class="title sm-margin-bottom-20" onclick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'/10\')">  <a class="" class="title">'+(key+1)+') '+value.question+ '</a> </h2>'+

											'<div class="clear-both limited-post-text hidetext2line margin-bottom-10" title="'+value.answers+'">'+

												'<strong>Answers : </strong>'+value.answers

											+'</div>'+

											'<div class="clear-both limited-post-text hidetext2line margin-bottom-10" title="'+value.posttitle+'">'+

												'<strong>For Post : </strong>'+value.posttitle

											+'</div>'+

											'<ul class="list-inline margin-bottom-0">'+

													'<li><strong><i class="fa fa-clock-o"></i> : </strong>'+date+'</li> - '+

													'<li><strong> Shared on </strong>'+value.name+'</li>'+

													'<li><span class="text-15 sitegreen margin cursor  share_'+value.question_id+'"  Title="Share" onclick="shareproposalpopup('+value.question_id+','+value.question_type+','+value.post_id+')" id="share_'+value.question_id+'"> <i class="rounded-x fa fa-share-alt"></i> <small> Share </small></span></li>'+

											'</ul>'+

										'</div>'+



									'</div>'+

								'</div>';



			 		var msc = $('#agents_list_data_'+value.shared_id).find('#append-agents-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-agents-ajax').append(htmll);

	                }else{

	                	$('#agents_list_data_'+value.shared_id).replaceWith( htmll );

	                }

				});

			}

			if(searchtype=='answers'){

				$.each( result.result, function( key, value ) {

					key = $('.askquestioncount_agents').length+1-1;

					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));

					var htmll = '<div class="askquestioncount_agents border1-bottom" id="agents_list_data_'+value.answers_id+'">'+

									'<div class="funny-boxes acpost">'+



										'<div class="funny-boxes-img " >'+

											'<h2 class="title sm-margin-bottom-20" onclick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'/4\')"> <a class="" class="title">'+(key+1)+') '+value.question+ '</a> </h2>'+

											'<div class="clear-both limited-post-text hidetext2line margin-bottom-10" title="'+value.answers+'">'+

												'<strong>Answers : </strong>'+value.answers

											+'</div>'+

											'<div class="clear-both limited-post-text hidetext2line margin-bottom-10" title="'+value.posttitle+'">'+

												'<strong>For Post : </strong>'+value.posttitle

											+'</div>'+

											'<ul class="list-inline margin-bottom-0">'+

													'<li><strong><i class="fa fa-clock-o"></i> : </strong>'+date+'</li> - '+

													'<li><strong> Shared on </strong>'+value.name+'</li>'+

													// '<li><span class="text-15 sitegreen margin cursor  share_'+value.question_id+'"  Title="Share" onclick="shareproposalpopup('+value.question_id+','+value.question_type+')" id="share_'+value.question_id+'"> <i class="rounded-x fa fa-share-alt"></i> <small> Share </small></span></li>'+

											'</ul>'+

										'</div>'+



									'</div>'+

								'</div>';



			 		var msc = $('#agents_list_data_'+value.answers_id).find('#append-agents-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-agents-ajax').append(htmll);

	                }else{

	                	$('#agents_list_data_'+value.answers_id).replaceWith( htmll );

	                }

				});

			}

			if(result.next!=0){

				$('#loadagents').removeClass('hide').attr('title',result.next);

			}else{

				$('#loadagents').addClass('hide');

			}

		}else{
			if($('#append-agents-ajax').html().toString().includes("No result found") == false){
				$('#append-agents-ajax').append('<center style="padding-bottom: 3%;">No result found.<center>');
			}
			$('#loadagents').addClass('hide');

		}

	}


	$(document).on("change","#search_by_value",function(){
		let ele = $(this);
		changesearchinput(ele.val());
	});

	function changesearchinput(perams) {





		if(perams=='name'){



			$('#keyword').attr('placeholder','Search agents by name');

			$('.keyworddiv,.datediv,.addressdiv,.citydiv,.statediv,.zipcodesdiv,.pricerangediv,.submitdiv,.usertypediv').show();

			$('.submitdiv').removeClass('col-md-12').addClass('col-md-9');

		}else{



			$('#keyword').attr('placeholder','Search '+perams);

			$('.keyworddiv,.datediv,.submitdiv').show();

			$('.addressdiv,.citydiv,.statediv,.zipcodesdiv,.pricerangediv').hide();

			$('.submitdiv').removeClass('col-md-9').addClass('col-md-12');

		}



		var rvalu =perams.replace(' ','_');

		$('#searchinputtype').val(rvalu);

		$('.searchlist').removeClass('active');

		$('.'+rvalu).addClass('active');

	}

	/*share question all agents shellers buyers*/

	function shareproposalpopup(id,type,post_id) {

		// var praposaldata = proposale_data[id];

		$('#append-proposal-share-user-list').html('');

		$('#open-proposal-share').modal('show');



		$('#searchpost_id').val(post_id);

		$('#praposalid').val(id);

		$('#praposalidrole').val(type);

		var keyword = $('#proposalkeyword').val();

		var address = $('#proposaladdress').val();

		var date = $('#proposaldate').val();



		$.ajax({

			url: "{{url('/')}}/shared/question/with/connected/users/by/"+id+"/"+type+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",

			type: 'post',

			data: {date :date,keyword : keyword,address : address,post_id : post_id,_token : '{{ csrf_token() }}'},

			headers: {

			        'X-CSRF-TOKEN': '{{ csrf_token() }}'

			    },

			beforeSend: function(){$(".loadproposalshare").show();},

			success: function(result) {

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

				}



			},

		  	error: function(data)

	    	{

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

			},error: function(result) {

			}

		});



	}

		function redarecturl(url) {

	 		window.location.href = url;

	 	}

	function shareproposalremove(userid,id,shared_id) {

		var userdata = shared_proposal_connected_user_list[userid];

       	$.ajax({

			url: "{{url('/shared/data/delete')}}",

			type: 'post',

			data: { id : id, shared_id : shared_id, _token : '{{ csrf_token() }}' },

			success: function(result) {

				$('.proposal_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" onclick="shareproposal('+userid+','+id+')"  name="proposale-checkox-'+userdata.details_id+'"><i class="n-p-a"></i>');

			},error: function(result) {

			}

		});

	}

</script>

@stop
