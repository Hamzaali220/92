@extends('dashboard.master')

@section('style')

<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/page_job_inner.css') }}">

<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">

@stop

@section('title', 'Agents Search')

@section('content')

<?php  $topmenu='Agents'; ?>

@include('dashboard.include.sidebar')

	

		<!--=== Block Description ===-->

	<div class="block-description">

		<div class="container">

			<!-- <i class="center-icon rounded-x fa fa-edit"></i> -->

			<div class="row md-margin-bottom-10">

				<!-- Profile Content -->

				<div class="col-md-12 ">

					<div class="padding-left-10 "> 

						@if($buyer->photo)

						<img class="img-circle header-circle-img1 img-margin" width="80" height="80" src="{{ URL::asset('assets/img/profile/'.$buyer->photo) }}" alt="">

						@else

						<img class="img-circle header-circle-img1 img-margin" width="80" height="80" src="{{ URL::asset('assets/img/testimonials/user.jpg') }}" alt="">

						@endif

						<div class="padding-top-5"> 

							<h2 class="postdetailsh2">{{ ucwords(strtolower($buyer->name)) }} <sub class="{{ $buyer->login_status }}"> {{ $buyer->login_status }} </sub></h2>

							<span class="margin-right-20"> <strong> visiting date </strong> <script type="text/javascript">document.write(timeDifference(new Date(), new Date(Date.fromISO('{{ $buyer->created_at }}'))));</script> </span>

							<span> <strong><i class="fa fa-map-marker"></i></strong> {{ $buyer->city_id }},{{ $buyer->state_name }},{{ $buyer->zip_code }} </span>

						</div>

					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-md-12">

					<div class="box-shadow-profile margin-bottom-10">

						<div class="panel-profile">

							<!--/start row-->

							<div class="left-inner border1-bottom">								

								<h2><strong> Details </strong></h2>

								<div class="postdetailsdescription"> {!! $buyer->description !!} </div>

							</div>

								

							<!--/end row-->

						</div>

					</div>

				</div>

				<!-- End Profile Content -->

							

			</div>

			<div class="row">

				<!-- Profile Content -->

				<div class="col-md-12">

					<h2><b>{{ ucwords(strtolower($buyer->name)) }} Posts</b></h2>

					<div class="box-shadow-profile ">

						<div class="panel-profile">

							<div class="panel-heading overflow-h air-card">

								<h2 class="heading-sm pull-left"> Posts </h2>

							</div>

							<div class="" >	

								<div class="postappend" id="postappend"></div>

								<div id="loaduploadshare" class="col-md-12 center loder loaduploadshare"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>

								<div class="text-center"><button type="button" id="loaduploadandshare" class="hide btn-u btn-u-default btn-u-sm ">Load More</button></div>

							</div>

						</div>

					</div>

				</div>

				<!-- End Profile Content -->	

			</div>

			



		</div>

	</div>

	<!--=== End Block Description ===-->







@endsection

@section('scripts')

<script type="text/javascript">

	var postdata = [];

	$( document ).ready(function() {

		loadpostlimit(0);

		$('#loaduploadandshare').click(function(e){

			e.preventDefault();

			var limit = $(this).attr('title');

			loadpostlimit(limit);

		});

	});

	/*load loadpostlimit */

	function loadpostlimit(limit) {



		$.ajax({

			url: "{{url('/')}}/profile/buyer/post/get/"+limit,

			type: 'POST',

			data: { agents_user_id : '{{ $buyer->id }}',agents_users_role_id : '{{ $roleid }}',selectedpost : '2',_token : '{{ csrf_token() }}'},

			beforeSend: function(){ $(".loaduploadshare").show(); },

			success: function(result) {	

				$(".loaduploadshare").hide();

				if(result.count != 0){

					if(limit==0){

						$('.postappend').html('');

					}

					$.each( result.result, function( key, value ) {

				

						postdata[value.post_id] = value;

						if(value.home_type){

							var ht = value.home_type.replace("_", " ");

						}else{

							var ht = value.home_type;

						}

						var dd = new Date(value.created_at);

						var date = dd.toDateString();

						var htmll = '<div class="border1-bottom" id="post_list_data_'+value.post_id+'">'+

										'<div class="funny-boxes acpost" onclick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'\')">'+

											'<h2 class="title margin-bottom-20"><a class="cursor">'+value.posttitle+'</a></h2>'+

											'<div class="funny-boxes-img">'+

												'<ul class="list-inline">'+

													'<li><strong>Posted By: </strong> '+value.name+' </li> - '+

													'<li><strong> Posted <i class="fa fa-clock-o"></i>: </strong> '+date+' </li>'+

												'</ul>'+

											'</div>';

											if(value.details){

												htmll +='<div class="limited-post-text hidetext2line margin-bottom-10" onclick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'\')" title="'+value.details+'">'+

															value.details

														+'</div>';

											}

											if(value.agents_users_role_id == 2){

								           	var types = 'Buy';

								          	}else{

								           	var types = 'Sell';

								          	}

									htmll +=

											'<ul class="list-inline">'+

												'<li> <strong>Agents:</strong> '+ value.post_view_count +' </li>'+

											'</ul>'+

											'<ul class="list-inline">'+

												(value.when_do_you_want_to_sell !=null ? '<li> '+types+' '+ (value.when_do_you_want_to_sell).replace('_',' ') +' </li> - ' : '')+

												(value.home_type !=null ? '<li> '+ (value.home_type).replace('_',' ') +' </li> - ' : '' )+

												'<li> <strong><i class="fa fa-map-marker"></i></strong> '+ value.state_name +' </li>'+

											'</ul>'+

										'</div>'+

									'</div>';



				 		var msc = $('#post_list_data_'+value.post_id).find('#postappend');

				 		var msct = msc.prevObject.length;

				 		if(msct==0){

				 			console.log(result);

		                    $('#postappend').append(htmll); 

		                }else{

		                	$('#post_list_data_'+value.post_id).replaceWith( htmll );

		                }

					});

					

				if(result.next != 0){

					$('#loaduploadandshare').attr('title',result.next).addClass('show').removeClass('hide');

				}else{

					$('#loaduploadandshare').addClass('hide').removeClass('show');

				}

				}else{

					$('.postappend').html('<h2 style="padding: 20px;text-align: center;"> No Post </h2>');

				}

			},

		  	error: function(data) 

	    	{	

	    		if(data.status=='500'){

					$('.loaduploadshare').text(data.statusText).css({'color':'red'});

	    		}else if(data.status=='422'){

					$('.loaduploadshare').text(data.responseJSON.image[0]).css({'color':'red'});

	    		}

    				// setInterval(function() {$(".loaduploadshare").hide(); },5000);

	    	}

		});

	}

</script>

@stop