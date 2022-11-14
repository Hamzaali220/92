@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/page_job.css') }}">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />


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
				<div class="row">
					<div class="col-sm-3 md-margin-bottom-10 statediv d-flex">

						<div class="input-group width100">										

							{{-- <select id="pending" name="pending" class="state form-control multipalselecte text-13" placeholder="Select Post Type">

								<option value="0">Select</option>
								<option value="1"><a href="{{route('appliedposts',$userdetails->name)}}">All</a></option>
								<option value="1">Unpaid</option>
								<option value="2">Paid</option>


							</select> --}}

						</div>
						



					</div>
					<div class="col-sm-12">
						<a href="{{url('/'.str_replace(' ','',$userdetails->name).'/applied/post/2')}}" class="btn-u padding-8">All</a>
						<a href="{{url('/'.str_replace(' ','',$userdetails->name).'/applied/post/1')}}" class="btn-u padding-8">Paid</a>
						<a href="{{url('/'.str_replace(' ','',$userdetails->name).'/applied/post/0')}}" class="btn-u padding-8">Unpaid</a>
					</div>
				
						<!--=== Profile ===-->

	<div class="container profile">

		<div class="row">



			<!-- Profile Content -->

			<div class="col-md-12">

				{{-- <h2><b>Search deals to happen near you...</b></h2> --}}

				<div class="box-shadow-profile">

					<div class="panel-profile">

						<div class="panel-heading  air-card">

							{!! Form::open(array('url' => '#','id'=>'searchpost','class'=>'sky-form')) !!}

							<div class="row">

								<div class="col-sm-6  datediv">

									<div class="input-group">

										<span class="input-group-addon sitegreen"><i class="fa fa-calendar"></i></span>

										<input type="text" id="date" title="Select Date" value="" name="date" value="<?php echo @$search_post['date'] ?>" class="text-13 col-lg-10 form-control reservation date" placeholder="Date">

									</div>

								</div>
								<div class="col-sm-6 md-margin-bottom-10 datediv">
									<div class="col-sm-3 usertypediv">

										<div class="input-group width100">
	
											<select id="usertype" name="usertype" class="usertype form-control multipalselecte text-13">
	
												<option value="2" {{ @$search_post['usertype'] && $search_post['usertype'] == '2' ? 'selected' : '' }}> Buyer </option>
	
												<option value="3" {{ @$search_post['usertype'] && $search_post['usertype'] == '3' ? 'selected' : '' }}> Seller </option>
	
											</select>
	
											<p class="usertypeerror red hide">Please select user type.</p>
	
										</div>
	
									</div>
								</div>

							</div>


							<div class="row">
	
								<div class="col-sm-12 submitdiv">

									<button type="submit" class="btn-u pull-right"  name="searchpost"> Search Post</button>

								</div>	

							</div>

							{!!Form::close()!!}

						</div>

						<!--/start row-->

						{{-- <div class="" >							

							<div id="append-post-ajax"></div>

							<div id="loaderpost" class="col-md-12 center loder loaderpost"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>

							<button type="button" class="btn-u btn-u-default btn-block text-center margin-top-10 hide" id="loadpost">Load More</button>

						</div> --}}

						<!--/end row-->

					</div>

				</div>

				

			</div>

			<!-- End Profile Content -->

		</div><!--/end row-->

	</div>

	<!--=== End Profile ===-->
				
				</div>
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
						                <th>Platform Fee</th>
						                {{-- <th>Posted At</th> --}}
						                <th>Closing Date</th>
						                <th>Sale Price</th>
						                <th>Status</th>
						                <th>Actions</th>
						                <th>
											<?php 
											if($post_status!=1){
											?>
											<input type="checkbox" value="" class="" id="checkAll" />
												<?php }?>
										</th>
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
						                    <?php 
															$per_10 = $in->sale_price*10/100;
															$per_10_03 = $per_10*3/100;
															// $total_pay += $per_10_03;
															echo number_format((float)$per_10_03, 2, '.', '')." $";
														?>
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
						                        Closing<br>Pending
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
						                        Sale<br> Pending
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
									<?php
									if($post_status!=1){
										?>
										<button type='submit' class="btn-u padding-6 getselected">Pay it now</a>
											<?php }?>
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

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>



<script type="text/javascript">

    $(function() {

    	var start = moment().subtract(29, 'days');

    	var end = moment();

        $('#date,#proposaldate').daterangepicker({

    	 	// autoUpdateInput: false,

    	  	//timePicker: true,

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

	           // format: 'YYYY/MM/DD'

			   format: 'MM/DD/YYYY'

	          }

        });

    });

</script>

{{-- <script type="text/javascript">

	var post_data = [];

	var shared_proposal_connected_user_list  = [];

	(function() {

		$('.multipalselecte').multiselect({

			columns: 1,

		    search: true,

		    onChange: function(option, checked) {

		    	

            }

		});

		$('#searchproposalshareuser').submit(function(e){

			e.preventDefault();

			shareproposalpopup($('#praposalid').val(),$('#praposalidrole').val());

		});	

		$('#searchpost').submit(function(e){

			e.preventDefault();

			

			
			var date 			= $('#date').val();	

			
			var usertype 		= $('#usertype').val();


			var error = true;

			$('#usertypeerror').addClass('hide');

			if(searchinputtype=='name' && usertype == ''){

				$('#usertypeerror').removeClass('hide');

				error = false;

			}

			if(error){

				$.ajax({

					url: "{{url('/')}}/search/post/list/0",

					type: 'post',

					data: {keyword : keyword,searchinputtype : searchinputtype,date :date,address : address,city : city,state : state,zipcodes : zipcodes,pricerange : pricerange,usertype : usertype,_token : '{{ csrf_token() }}',cityName:cityName},

					headers: {

					       'X-CSRF-TOKEN': '{{ csrf_token() }}'

					    },

					beforeSend: function(){$(".loaderpost").show();},

					success: function(result) {	

						$(".loaderpost").hide();

						$('#append-post-ajax').html('');

						loadhtml(result,'yes');					

					},

				  	error: function(data) 

			    	{	

			    		$(".loaderpost").hide();

			    		if(data.status=='500'){

							$('.loaderpost').text(data.statusText).css({'color':'red'});

			    		}else if(data.status=='422'){

							$('.loaderpost').text(data.responseJSON.image[0]).css({'color':'red'});

			    		}

			    	}

				});

			}

		});



		$('#loadpost').click(function(e){

			e.preventDefault();

			var limit = $(this).attr('title');

			loadpost(limit);

		});

		loadpost(0);

		var st = ("<?php echo @$search_post['searchinputtype'] !='' ? $search_post['searchinputtype'] : 'post contains';  ?>").replace('_',' ');

		changesearchinput(st);

    })();

    /*load uploadandshare */

	function loadpost(limit) {

		

		var keyword 		= $('#keyword').val();			

		var searchinputtype = $('#searchinputtype').val();			

		var date 			= $('#date').val();	

		var address 		= $('#address').val();		

		var city 			= $('#city').val();	

		var state 			= $('#state').val();	

		var zipcodes 		= $('#zipcodes').val();	

		var pricerange 		= $('#pricerange').val();

		var usertype 		= $('#usertype').val();

		var cityName 		= $('#cityName').val();

		

		var error = true;

		$('#usertypeerror').addClass('hide');

		if(searchinputtype=='name' && usertype == ''){

			$('#usertypeerror').removeClass('hide');

			error = false;

		}

		if(error){

			$.ajax({

				url: "{{url('/')}}/search/post/list/"+limit,

				type: 'post',

				data: {keyword : keyword,searchinputtype : searchinputtype,date :date,address : address,city : city,state : state,zipcodes : zipcodes,pricerange : pricerange,usertype : usertype,_token : '{{ csrf_token() }}',cityName:cityName},

				headers: {

				        'X-CSRF-TOKEN': '{{ csrf_token() }}'

				    },

				beforeSend: function(){$(".loaderpost").show();},

				success: function(result) {	

					$(".loaderpost").hide();

					loadhtml(result,'null');

				},

			  	error: function(data) 

		    	{	

		    		if(data.status=='500'){

						$('.loaderpost').text(data.statusText).css({'color':'red'});

		    		}else if(data.status=='422'){

						$('.loaderpost').text(data.responseJSON.image[0]).css({'color':'red'});

		    		}

					setInterval(function() {$(".loaderpost").hide(); },1000);

		    	}

			});

		}

	}

    function loadhtml(result,load) {

    	var searchtype = $('#searchinputtype').val();

    	if(load=='yes'){

    		$('#append-post-ajax').html('');

    	}

		if(result.count !== 0){

			if(searchtype=='post_contains'){

				$.each( result.result, function( key, value ) {

					post_data[value.post_id] = value;

					if(value.home_type){

						var ht = value.home_type.replace("_", " ");

					}else{

						var ht = value.home_type;

					}

					//console.log(value.login_status);

					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));

					var htmll = '<div class="border1-bottom" id="post_list_data_'+value.post_id+'">'+

									'<div class="funny-boxes acpost padding-bottom-5" onclick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'\')">'+

										'<h2 class="title  line-height-5"><a href="{{ URL("/") }}/search/post/details/'+value.post_id+'">'+value.posttitle+' <small style="font-size: 55%;">'+value.role_name+'</small></a></h2>'+

										'<div class="funny-boxes-img">'+

											'<ul class="list-inline">'+

												'<li><strong> Posted By : </strong> '+value.name+'<sub class="'+value.login_status+' mini"> '+value.login_status+' </sub>  </li>  '+

												'<li><strong> Posted : </strong> '+date+' </li>'+

											'</ul>'+

										'</div>';

										if(value.details){
											htmll +='<div class="limited-post-text hidetext2line margin-bottom-10" onclick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'\')" title="'+msc+'">'+
														value.details
													+'</div>';
										}

										if(value.agents_users_role_id == 2){

							           	var types = 'Buy';

							          	}else{

							           	var types = 'Sell';

							          	}

									 

									 if(typeof value.post_view_count != 'undefined' && value.post_view_count != 0 ) {

									htmll +=

										

										'<ul class="list-inline">'+

											'<li> <strong>Agents:</strong> '+ value.post_view_count +' </li>'+

										'</ul>'+

										'<ul class="list-inline">'+

											(value.when_do_you_want_to_sell !=null ? '<li> '+types+' '+ (value.when_do_you_want_to_sell).replace('_',' ') +' </li> - ' : '')+

											(value.home_type !=null ? '<li> '+ (value.home_type).replace('_',' ') +' </li> - ' : '' )+

											'<li>';

											if ( value.city != null || value.state_name != null) {

												htmll += '<strong><i class="fa fa-map-marker"></i></strong> ';

											}

											if (typeof value.city_name != 'undefined' && value.city_name !=null && value.city_name !='') {

												htmll +=  value.city_name  +', ';

											}

											if (typeof value.state_name != 'undefined' && value.state_name !=null && value.state_name !='') {

												htmll += value.state_name;

											}

											htmll += '</li>'+

										'</ul>';

										}

									htmll += '</div>'+

								'</div>';



			 		var msc = $('#post_list_data_'+value.post_id).find('#append-post-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-post-ajax').append(htmll); 

	                }else{

	                	$('#post_list_data_'+value.post_id).replaceWith( htmll );

	                }

				});

			}

			if(searchtype=='name'){

				var usertype 		= $('#usertype').val();

				$.each( result.result, function( key, value ) {


					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
					var htmll = '<div class="border1-bottom" id="agents_list_data_'+value.id+'">'+

									'<div class="funny-boxes acpost" onclick="redarecturl(\'{{ URL("/") }}/search/buyer/details/'+value.id+'/'+usertype+'\')">'+

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

													(value.price_range != null ? '<li><strong>Price Range:</strong> '+ (value.price_range).replace('-','k to ')+'k </li> - ' : '' )+

													'<li><strong>Posted <i class="fa fa-clock-o"></i>: </strong>'+date+'</li> - '+

													'<li><strong><i class="fa fa-map-marker"></i></strong> '+ value.city_id +','+ value.state_name +' </li>'+

											'</ul>'+

										'</div>';

										

										if(value.description){

											htmll +='<div class="clear-both limited-post-text hidetext2line margin-bottom-10" title="'+value.description+'">'+

														value.description

													+'</div>';

										}

								htmll +='<ul class="list-inline clear-both">'+

											(value.when_u_want_to_buy != null ? '<li> <span class="skill-lable label label-success">'+value.when_u_want_to_buy+'</span></li>' : '' )+

											(value.property_type !=null ? '<li> <span class="skill-lable label label-success">'+value.property_type+'</span></li>' : '')+

										'</ul>'+

										'<ul class="list-inline clear-both" style="margin-bottom: 0px;">'+

											'<li><a class="cursor"><strong> Details </strong></a></li>'+									

										'</ul>'+

									'</div>'+

								'</div>';



			 		var msc = $('#agents_list_data_'+value.id).find('#append-post-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-post-ajax').append(htmll); 

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



			 		var msc = $('#agents_list_data_'+value.messages_id).find('#append-post-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-post-ajax').append(htmll); 

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

												'<strong>For Post: </strong>'+value.posttitle

											+'</div>'+

											'<ul class="list-inline margin-bottom-0">'+

													'<li><strong><i class="fa fa-clock-o"></i>: </strong>'+date+'</li> - '+

													'<li><strong> Shared on </strong>'+value.name+'</li>'+

													'<li><span class="text-15 sitegreen margin cursor  share_'+value.question_id+'"  Title="Share" onclick="shareproposalpopup('+value.question_id+','+value.question_type+')" id="share_'+value.question_id+'"> <i class="rounded-x fa fa-share-alt"></i> <small> Share </small></span></li>'+

											'</ul>'+

										'</div>'+

									'</div>'+

								'</div>';



			 		var msc = $('#agents_list_data_'+value.shared_id).find('#append-post-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-post-ajax').append(htmll); 

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

												'<strong>Answers: </strong>'+value.answers

											+'</div>'+

											'<div class="clear-both limited-post-text hidetext2line margin-bottom-10" title="'+value.posttitle+'">'+

												'<strong>For Post: </strong>'+value.posttitle

											+'</div>'+

											'<ul class="list-inline margin-bottom-0">'+

													'<li><strong><i class="fa fa-clock-o"></i>: </strong>'+date+'</li> - '+

													'<li><strong> Shared on </strong>'+value.name+'</li>'+

													'<li><span class="text-15 sitegreen margin cursor  share_'+value.question_id+'"  Title="Share" onclick="shareproposalpopup('+value.question_id+','+value.question_type+')" id="share_'+value.question_id+'"> <i class="rounded-x fa fa-share-alt"></i> <small> Share </small></span></li>'+

											'</ul>'+

										'</div>'+



									'</div>'+

								'</div>';



			 		var msc = $('#agents_list_data_'+value.shared_id).find('#append-post-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-post-ajax').append(htmll); 

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

												'<strong>Answers: </strong>'+value.answers

											+'</div>'+

											'<div class="clear-both limited-post-text hidetext2line margin-bottom-10" title="'+value.posttitle+'">'+

												'<strong>For Post: </strong>'+value.posttitle

											+'</div>'+

											'<ul class="list-inline margin-bottom-0">'+

													'<li><strong><i class="fa fa-clock-o"></i>: </strong>'+date+'</li> - '+

													'<li><strong> Shared on </strong>'+value.name+'</li>'+

													// '<li><span class="text-15 sitegreen margin cursor  share_'+value.question_id+'"  Title="Share" onclick="shareproposalpopup('+value.question_id+','+value.question_type+')" id="share_'+value.question_id+'"> <i class="rounded-x fa fa-share-alt"></i> <small> Share </small></span></li>'+

											'</ul>'+

										'</div>'+



									'</div>'+

								'</div>';



			 		var msc = $('#agents_list_data_'+value.answers_id).find('#append-post-ajax');

			 		var msct = msc.prevObject.length;

			 		if(msct==0){

	                    $('#append-post-ajax').append(htmll); 

	                }else{

	                	$('#agents_list_data_'+value.answers_id).replaceWith( htmll );

	                }

				});

			}



			if(result.next!=0){

				$('#loadpost').removeClass('hide').attr('title',result.next);

			}else{

				$('#loadpost').addClass('hide');

			}

		}else{

			$('#loadpost').addClass('hide');

		}

	}

	function changesearchinput(perams) {



		if(perams=='post contains'){



			$('#keyword').attr('placeholder','Search post by anything & everything');

			$('.addressdiv,.citydiv2,.statediv,.zipcodesdiv,.pricerangediv,.submitdiv').show();

			$('.usertypediv,.citydiv').hide();

			$('.submitdiv').removeClass('col-sm-9').addClass('col-sm-12');

		}else if(perams=='name'){

			

			$('#keyword').attr('placeholder','Search seller & buyer by name');

			$('.keyworddiv,.datediv,.addressdiv,.citydiv,.statediv,.zipcodesdiv,.pricerangediv,.submitdiv,.usertypediv').show();

			//$('.citydiv2').hide();

			$('.submitdiv').removeClass('col-sm-12').addClass('col-sm-9');

		}else{



			$('#keyword').attr('placeholder','Search '+perams);

			$('.keyworddiv,.datediv,.submitdiv').show();

			$('.addressdiv,.citydiv,.statediv,.zipcodesdiv,.pricerangediv,.usertypediv,.citydiv2').hide();

			$('.submitdiv').removeClass('col-sm-9').addClass('col-sm-12');

		}



		var rvalu =perams.replace(' ','_');

		$('#searchinputtype').val(rvalu);

		$('.searchlist').removeClass('active');

		$('.'+rvalu).addClass('active');

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

</script>  --}}



<script type="text/javascript">
	/* edit-personal-bio */
	$("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });

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