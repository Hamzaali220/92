@extends('dashboard.master')
@section('style')
<script src="https://checkout.stripe.com/checkout.js"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/page_job_inner.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/profile.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('title', $post->posttitle)
@section('content')
<?php  $topmenu='Home'; ?>
@include('dashboard.include.sidebar')

		<!--=== Block Description ===-->
	<div class="block-description">
		<div class="container">
			<div class="col-md-9">
			<!-- <i class="center-icon rounded-x fa fa-edit"></i> -->
			<div class="row md-margin-bottom-10">
				<!-- Profile Content -->
				<div class="col-md-12 ">
					<div class="padding-left-10 "> 
						<h2 class="postdetailsh2 ">{{ $post->posttitle }}</h2>
						<!-- <h4>Closing Date : {{ ($post->closing_date != null ) ? date('d-m-Y', strtotime($post->closing_date)) : "" }}</h4> -->
						<span class="margin-right-20"> <strong> Closing Date :</strong> {{ ($post->closing_date != null ) ? date('d-m-Y', strtotime($post->closing_date)) : "Not updated yet" }} </span>

						<div>  
							<span class="margin-right-20"> <strong> Posted by:</strong> {{ ucfirst($post->name) }} </span>
							@if($post->when_do_you_want_to_sell)
								<span class="margin-right-20 skill-lable label label-success"> {{$types}} {{ str_replace('_',' ',$post->when_do_you_want_to_sell) }}</span>
							@endif
							@if($post->home_type)
								<span class="margin-right-20 skill-lable label label-success">{{ str_replace('_',' ',$post->home_type) }} </span> 
							@endif							
							<span class="margin-right-20"> Posted <i class="fa fa-clock-o"> </i>: <script type="text/javascript">document.write(timeDifference(new Date(), new Date(Date.fromISO('{{ $post->created_at }}'))));</script> </span>

							<span> <strong><i class="fa fa-map-marker"></i></strong> {{ $post->address1 != null ? $post->address1.',' : '' }} {{ $post->address2 !=null ? $post->address2.',' : '' }} {{ $post->city_name!=null ?  $post->city_name.',' : '' }}  {{ $post->state_name !=null ? $post->state_name.',' : ''  }} {{ $post->area!=null ? $post->area.',' : '' }} {{ $post->zip!=null ? $post->zip : '' }} </span>
						</div>



						@if($post->agent_send_review == 1 && !empty($selecteagent) &&  $selecteagent != '' && $post->applied_post==1)
						<div>
							<h2>{{ $selecteagent->name }} is gave you rating</h2>
						</div>
						@endif

						@php
							$diff_in_days = 0;
							if($post->agent_select_date != '') {
								$to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $post->agent_select_date);
								$from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:s:i'));
								$diff_in_days = $to->diffInDays($from);
							}
						@endphp

						@if($post->closing_date == '' && $post->agents_user_id == $user->id && $post->applied_user_id != '')
							@if($diff_in_days > env('MIN_CLOSE_DATE'))
							<button class="btn-u margin-top-20 cursor" data-target="#set-agent-closingdate" data-toggle="modal"> Add Closing Date </button>
							@else
								<button class="btn-u margin-top-20 cursor" disabled="true" style="background: #aaa;"> Add Closing Date </button> 
							<small>Button will be enabled after {{ env('MIN_CLOSE_DATE') }} days of selecting agent</small>
							@endif
						
						@endif
					</div>
				</div>			
			</div>

			<div class="row">
			
				<div class="col-md-12">
					
					<div class="box-shadow-profile margin-bottom-40">
						<div class="panel-profile">

							<!--/start row-->
							<div class="left-inner border1-bottom">								
								<h2><strong> {{ $user->agents_users_role_id == 2 ? 'Specific requirements' : 'Details' }} </strong></h2>
								<div class="postdetailsdescription"> {!! $post->details !!} </div>
							</div>
							<div class="left-inner border1-bottom">
								<h2><strong>Post Overview</strong></h2>
								<ul class="list-unstyled">							
									@if($post->when_do_you_want_to_sell)
										<li><i class="fa fa-check color-green"></i> <strong> Want to  {{$types}} </strong> {{ str_replace('_',' ',$post->when_do_you_want_to_sell) }}.</li>
									@endif								
									@if($post->need_Cash_back == 1)
										<li><i class="fa fa-check color-green"></i> <strong> Need Cash back and Negotiate Commision </strong></li>
									@endif								
									@if($post->interested_short_sale == 1)
										<li><i class="fa fa-check color-green"></i> <strong> Interested in a Short Sale </strong></li>
											@if($post->got_lender_approval_for_short_sale == 1)
											<li><i class="fa fa-check color-green"></i> <strong> Got Lender approval for  short sale </strong></li>
											@endif
									@endif

									@if($post->price_range)
										<li><i class="fa fa-check color-green title"></i> <strong>Price Range</strong> {{ str_replace('-','k to',$post->price_range) .'k' }}.</li>
									@endif									

									@if($post->home_type)
										<li><i class="fa fa-check color-green title"></i> <strong> {{ $user->agents_users_role_id ==2 ? 'Property Type' : 'Home type' }}</strong> {{ str_replace('_',' ',$post->home_type) }}.</li>
									@endif

									@if($post->firsttime_home_buyer == 1)
										<li><i class="fa fa-check color-green"></i> <strong> first time home buyer </strong></li>
									@endif									

									@if($post->do_u_have_a_home_to_sell == 1)
										<li><i class="fa fa-check color-green"></i>   have a home to sell 
											@if($post->if_so_do_you_need_help_selling == 1)
												<strong> yes </strong>
												@else
												<strong> No </strong>
											@endif
										</li>
									@endif

									@if($post->interested_in_buying == 1)
										<li><i class="fa fa-check color-green"></i> <strong> yes </strong> interested in buying a foreclosure, short sale or junker </li>
									@endif

									@if($post->bids_emailed != null)
										<li><i class="fa fa-check color-green"></i> <strong> {{ str_replace('_',' ',$post->bids_emailed) }} </strong> </li>
									@endif



									@if($post->do_you_need_financing != null)

										<li><i class="fa fa-check color-green"></i>  need financing amount <strong> {{ str_replace('_',' ',$post->do_you_need_financing).'$' }} </strong> </li>

									@endif





								</ul>

							</div>



							@if(!empty($post->best_features))

							<div class="left-inner border1-bottom">

								<h2><strong>Best Features of Home </strong></h2>

								<ul class="list-unstyled">

									@foreach (json_decode($post->best_features) as $value) 

										<li><i class="fa fa-check color-green"></i>  {!! $value !!} </li>

									@endforeach

							 	</ul>

							</div>

							@endif

								

								

							<!--/end row-->

						</div>

					</div>
					
					<div class="box-shadow-profile homedata homedatanotes margin-bottom-40">
						<div class="panel-profile">
							<div class="panel-heading overflow-h air-card">
								<h2 class="panel-title heading-sm pull-left"><i class="fa fa-commenting"></i>Notes History</h2>
							</div>
							<div class="panel-body no-padding" data-mcs-theme="minimal-dark">						
								<ul class="list-group">
								<?php foreach ($notes_history as $note){ ?>
									<li class="list-group-item"><i class="fa fa-clock-o"> </i> <b>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $note->created_at)->format('d, M Y h:i A')  }}</b> : {!! $note->notes  !!}</li>
								<?php } ?>
								</ul>
							</div>
							<input type="hidden" name="notes-more-load" id="notes-more-load">
							<div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop notes-loader" width="40px" height="40px"/>
							</div>
						</div>
					</div>


					@if(!empty($selecteagent) &&  $selecteagent != '' && $post->applied_post==1)

						<div class="box-shadow-profile margin-bottom-40">

							<!-- Default Proposals -->

							<div class="panel-profile whaite-bg">

								<div class="panel-heading overflow-h air-card">

									<h2 class="heading-sm pull-left"> Selected Agent ( {{ $selecteagent->name }} ) </h2>

								</div>

								<div class="panel-body row " >							

									<div class="profile-edit">

										<div class="col-md-9">

	                        				<div class="padding-left-10 "> 

												@if($selecteagent->photo)

												<img class="img-circle header-circle-img1 img-margin" width="80" height="80" src="{{ URL::asset('assets/img/profile/'.$selecteagent->photo) }}" alt="">

												@else

												<img class="img-circle header-circle-img1 img-margin" width="80" height="80" src="{{ URL::asset('assets/img/testimonials/user.jpg') }}" alt="">

												@endif

												<div class="padding-top-5"> 


													<h2 class="postdetailsh2"><a  target="_blank" href="{{ URL('/') }}/search/agents/details/{{ $selecteagent->id }}/{{ $selecteagent->post_id }}">{{ ucwords(strtolower($selecteagent->name)) }}</a> <sub class="{{ $selecteagent->login_status }}"> {{ $selecteagent->login_status }} </sub></h2> 

													<span class="margin-right-20"> <strong> Experience : </strong> {!! $selecteagent->years_of_expreience !='' ? @str_replace('-', ' to ', $selecteagent->years_of_expreience).' Year' : '' !!} </span>

													<span class="margin-right-20"> <strong> Broker : </strong> {{ $selecteagent->brokers_name }} </span>

													<span class="margin-right-20"> <strong> Selected date </strong> <script type="text/javascript">document.write(timeDifference(new Date(), new Date(Date.fromISO('{{ $selecteagent->agent_select_date }}'))));</script> </span>

													<span> <strong><i class="fa fa-map-marker"></i></strong> {{ $post->city_name }},{{ $selecteagent->state_name }} </span>

												</div>

												<a class="btn-u margin-top-20 cursor" href="{{URL('/messages/')}}/{{ $selecteagent->post_id }}/{{ $selecteagent->id }}/{{ $selecteagent->agents_users_role_id }}"> Message </a>

											</div>

										</div>

										<div class="col-md-3">
											
											@if($post->closing_date == '')

												<!-- <button class="btn-u margin-top-20 cursor" data-target="#set-agent-closingdate" data-toggle="modal"> Add Closing Date </button>   -->

											@endif

											@if($agentPaymentStatus==true)

												<!--button class="btn-u margin-top-20 cursor" data-target="#make_payment" data-toggle="modal"> Make Payttttment </button-->

											@endif

											@if($post->closing_date != '' && $post->final_status != 2)

												<button class="btn-u margin-top-20 cursor" data-target="#set-agent-review" data-toggle="modal"> Close This Post</button>

											@endif

											@if($post->final_status == 2)

												<button class="btn-u margin-top-20 cursor" > Post Is Closed </button>

											@endif

										</div>

										<div class="col-md-12">

											<div class=" margin-top-40">

												<div class="left-inner padding-5-20">								

													<h2><strong> Details </strong></h2>

													<div class="postdetailsdescription"> {!! $selecteagent->description !!} </div>

												</div>

											</div>

						                </div>

									</div>

								</div>

								<!--/end row-->

							</div>

							<!-- Default Proposals -->

						</div>

						@if($selecteagent->buyer_seller_send_review==2)

						<!-- give agent review start  -->

						<div class="modal fade " id="set-agent-review" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

							<div class="modal-dialog " style="display: grid;">

								<div class="modal-content not-top sky-form">

									

									<div id="set-agent-review-loader" class="body-overlay col-md-12 center loder set-agent-review-loader"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>

									

									

									<div class="modal-header">

										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

										<h4 class="modal-title set-agent-review-title">Give a feedback to {{ $selecteagent->name }} </h4>

									</div>

									{!! Form::open(array('id'=>'give_a_review_for_agents' ,'class'=>'sky-form')) !!}

									<div class="modal-body">

										<fieldset style="padding: 0px 15px;">

											<p class="review-msg-text hide"></p>

											<section class="margin-0">

												<label class="label margin-0"> Rating </label>

												<label class="margin-0">

													<div id="ratinganswer" class="rating1">

								                        <input class="stars star5"  type="radio"  name="rating" id="star5" value="5" />

								                        <label class = "full tooltips" data-toggle="tooltip" data-original-title="Awesome" data-placement="top" for="star5" title="Awesome"></label>

								                       

								                        <input class="stars star4_5" type="radio" name="rating" id="star4_5" value="4_5" />

								                        <label class="half tooltips" data-toggle="tooltip" data-original-title="Pretty good" data-placement="top" for="star4_5" title="Pretty good"></label>

								                       

								                        <input class="stars star4" type="radio" name="rating" id="star4" value="4" />

								                        <label class = "full tooltips" data-toggle="tooltip" data-original-title="Pretty good" data-placement="top" for="star4" title="Pretty good"></label>

								                       

								                        <input class="stars star3_5" type="radio" name="rating" id="star3_5" value="3_5" />

								                        <label class="half tooltips" data-toggle="tooltip" data-original-title="Meh" data-placement="top" for="star3_5" title="Meh"></label>

								                       

								                        <input class="stars star3" type="radio" name="rating" id="star3" value="3" />

								                        <label class = "full tooltips" data-toggle="tooltip" data-original-title="Meh" data-placement="top" for="star3" title="Meh"></label>

								                       

								                        <input class="stars star2_5" type="radio" name="rating" id="star2_5" value="2_5" />

								                        <label class="half tooltips" data-toggle="tooltip" data-original-title="Kinda bad" data-placement="top" for="star2_5" title="Kinda bad "></label>

								                       

								                        <input class="stars star2" type="radio" name="rating" id="star2" value="2" />

								                        <label class = "full tooltips" data-toggle="tooltip" data-original-title="Kinda bad" data-placement="top" for="star2" title="Kinda bad"></label>

								                       

								                        <input class="stars star1_5" type="radio" name="rating" id="star1_5" value="1_5" />

								                        <label class="half tooltips" data-toggle="tooltip" data-original-title="Meh" data-placement="top" for="star1_5" title="Meh"></label>

								                       

								                        <input class="stars star1" type="radio" name="rating" id="star1" value="1" />

								                        <label class = "full tooltips" data-toggle="tooltip" data-original-title="Sucks big time" data-placement="top" for="star1" title="Sucks big time"></label>

								                       

								                        <input class="stars star0_5" type="radio"  name="rating" id="star0_5" value="0_5" />

								                        <label class="half tooltips" data-toggle="tooltip" data-original-title="Sucks big time" data-placement="top" for="star0_5" title="Sucks big time"></label>

								                    </div>

													<b class="error-text" id="rating_error"></b>

												</label>

											</section>	

											

											<section class="margin-0">

												<label class="label margin-0"> Review </label>

												<label class="textarea margin-0">

													<textarea rows="2" class="field-border jqte-test" name="review" id="review" placeholder="Enter Review"></textarea>

													<b class="error-text" id="review_error"></b>

												</label>

											</section>					

										</fieldset>

									</div>

									<div class="modal-footer" >

										<input type="hidden" name="post_id" value="{{ $selecteagent->post_id }}">

										<input type="hidden" name="notification_type" value="14">

										<input type="hidden" name="notification_message" value="{{ $userdetails->name }} has given you a review for post ({{ $selecteagent->posttitle }})">

										<input type="hidden" name="rating_type" value="3">

										<input type="hidden" name="rating_item_id" value="{{ $selecteagent->applied_user_id }}">

										<input type="hidden" name="rating_item_parent_id" value="{{ $selecteagent->post_id }}">

										<input type="hidden" name="receiver_id" value="{{ $selecteagent->id }}">

										<input type="hidden" name="receiver_role" value="{{ $selecteagent->agents_users_role_id }}">

										<input type="hidden" name="sender_id" value="{{ $user->id }}">

										<input type="hidden" name="sender_role" value="{{ $user->agents_users_role_id }}">



										<button type="button" data-dismiss="modal" aria-hidden="true" class="btn-u" style="padding: 10px 20px;margin-right: 5px;color: #74c52c;box-shadow: 0 0.5px 4px rgba(57,73,76,.35);background: white;">Close</button>

										<button type="submit" class="btn-u">Give</button>

									</div>

									{!!Form::close()!!}

								</div>

							</div>

						</div>

						@endif

						<!-- give agent review end  -->

<div class="modal fade " id="make_payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

							<div class="modal-dialog " style="display: grid;">

								<div class="modal-content not-top sky-form">

									

									<div id="set-agent-review-loader" class="body-overlay col-md-12 center loder set-agent-review-loader"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>

									

									

									<div class="modal-header">

										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

										<h4 class="modal-title set-agent-review-title">Make Payment To {{ $selecteagent->name }} </h4>

									</div>

									{!! Form::open(array('id'=>'make_payment_for_agents' ,'class'=>'sky-form')) !!}

									<div class="modal-body">
										<div id="paymentResponse"></div>

										<fieldset style="padding: 0px 15px;">

											<p class="review-msg-text hide"></p>

											

											

											<section class="margin-0">

												<label class="label margin-0"> Agent 3% Charges </label>

												<label class="textarea margin-0">

													<input type="text" id="amount" name="amount" class="form-control" />

													<b class="error-text" id="amount_error"></b>

												</label>

											</section>					

										</fieldset>

									</div>

									<div class="modal-footer" >

										<input type="hidden" name="post_id" value="{{ $selecteagent->post_id }}">

										<input type="hidden" name="notification_type" value="14">

										<input type="hidden" name="notification_message" value="{{ $userdetails->name }} has given you a review for post ({{ $selecteagent->posttitle }})">

										<input type="hidden" name="rating_type" value="3">

										<input type="hidden" name="rating_item_id" value="{{ $selecteagent->applied_user_id }}">

										<input type="hidden" name="rating_item_parent_id" value="{{ $selecteagent->post_id }}">

										<input type="hidden" name="receiver_id" value="{{ $selecteagent->id }}">

										<input type="hidden" name="receiver_role" value="{{ $selecteagent->agents_users_role_id }}">

										<input type="hidden" name="sender_id" value="{{ $user->id }}">

										<input type="hidden" name="sender_role" value="{{ $user->agents_users_role_id }}">



										<button type="button" class="btn btn-link" data-dismiss="modal" aria-hidden="true">Close</button>

										<button type="submit" class="btn-u">Make Payment</button>

									</div>

									{!!Form::close()!!}

								</div>

							</div>

						</div>

					@else

						<div class="box-shadow-profile margin-bottom-40 hide" id="comparecount">

							<!-- Default Proposals -->

							<div class="panel-profile whaite-bg">

								<div class="panel-heading overflow-h air-card">

									<h2 class="heading-sm pull-left"> Compare Agents </h2>

								</div>

								<div class="panel-body compare-listing-body row " >							

									<div class="profile-edit">

										<div class="compare-thumb-main col-md-12" id="addecomparediv">

	                        

						                </div>

					                	<div class="col-md-12 margin-top-5"><a onclick="comparenow();" class="cursor btn-u pull-right">Compare</a></div>

						                <div id="compare-loader" class="body-overlay col-md-12 center loder compare-loader"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>

									</div>

								</div>

								<!--/end row-->

							</div>

							<!-- Default Proposals -->

						</div>

					@endif

					<div class="box-shadow-profile "> 
						<!-- Default Proposals -->
						<div class="panel-profile whaite-bg">
							<div class="panel-heading overflow-h air-card">
								<h2 class="heading-sm pull-left"> Applied Agents </h2>
							</div>

							<div class="panel-body row">					
								<div class="connectedagents-data" id="connectedagents-data">							
								</div>
								<div id="loadagents" class="loadagents col-md-12 center loder loadappliedpost"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
								<div class="text-center"><button type="button" id="loadmoreagents" class="hide btn-u btn-u-default ">Load More</button></div>
							</div>
							<!--/end row-->
						</div>
						<!-- Default Proposals -->
					</div>
				</div>
				<!-- col-md-12 end -->

				<!-- End Profile Content -->
			</div>
		</div> <!-- End of main content -->

		<!--right Sidebar-->
		@include('dashboard.user.buyers.include.sidebar-advert')
		<!--End right Sidebar-->
		

		</div> <!-- End of container -->
	</div>

	<!--=== End Block Description ===-->

	<!-- comapre staging peramitter start  -->
	<form class="sky-form" id="compare_agents" action=" {{ url('compare') }}" method="POST">
		{{ csrf_field() }}
	<div class="modal fade bs-example-modal-sm" id="set-compare-peramitter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" style="display: grid;">
			<div class="modal-content not-top">
				<div id="set-compare-peramitter-loader" class="body-overlay col-md-12 center loder set-compare-peramitter-loader"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title set-compare-peramitter-title">Select Compare Staging Parameter</h4>
				</div>

				<div class="modal-body sky-form" id="compcheckbox">
						<fieldset>
							<section>						
								<label class="checkbox">
									<input type="checkbox" name="agent_rating" value="1" id="agent_rating">
									<i></i>Agent Rating
								</label>

								<label class="checkbox">
									<input type="checkbox" name="asked_question" value="1" id="asked_question">
									<i></i>Asked Question
								</label>

								<label class="checkbox">
									<input type="checkbox" name="bookmark_agents" value="1" id="bookmark_agents">
									<i></i>Bookmark Agents
								</label>

								<label class="checkbox">
									<input type="checkbox" name="bookmark_answers" value="1" id="bookmark_answers">
									<i></i>Bookmark Answers
								</label>

								<label class="checkbox">
									<input type="checkbox" name="bookmark_messages" value="1" id="bookmark_messages">
									<i></i>Bookmark Messages
								</label>

								<label class="checkbox">
									<input type="checkbox" name="bookmark_proposal" value="1" id="bookmark_proposal">
									<i></i>Bookmark Proposal
								</label>

								<label class="checkbox">
									<input type="checkbox" name="rating_answers" value="1" id="rating_answers">
									<i></i>Rating Answers
								</label>

								<label class="checkbox">
									<input type="checkbox" name="rating_messages" value="1" id="rating_messages">
									<i></i>Rating Messages
								</label>

								<label class="checkbox">
									<input type="checkbox" name="proposals" value="1" id="proposals">
									<i></i>Proposals
								</label>

								<label class="checkbox">
									<input type="checkbox" name="documents" value="1" id="documents">
									<i></i>Documents
								</label>

								<label class="checkbox">
									<input type="checkbox" name="notes_messages" value="1" id="notes_messages">
									<i></i>Notes Messages
								</label>

								<label class="checkbox">
									<input type="checkbox" name="notes_asked_question" value="1" id="notes_asked_question">
									<i></i>Notes Asked Question
								</label>

								<label class="checkbox">
									<input type="checkbox" name="notes_answers" value="1" id="notes_answers">
									<i></i>Notes Answer
								</label>

								<label class="checkbox">
									<input type="checkbox" name="notes_proposal" value="1" id="notes_proposal">
									<i></i>Notes Proposal
								</label>

								<label class="checkbox">
									<input type="checkbox" name="notes_agents" value="1" id="notes_agents">
									<i></i>Notes Agents
								</label>
							</section>
						</fieldset>				

						<input type="hidden" value="" name="compare_id" class="compare_id" id="compare_id">
						<input type="hidden" value="{{ $user->id }}" name="sender_id" >
						<input type="hidden" value="{{ $user->agents_users_role_id }}" name="sender_role" >
				</div>

				<div class="modal-footer" id="notes-compare-peramitter-footer">
					<button type="button" class="btn-u btn-u-primary pull-right" id="comparebutton" name="submit" title="Compare Now">Compare</button>
				</div>

			</div>

		</div>

	</div>

	<div class="modal fade bs-example-modal-md" id="set-compare-asked_question-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

		<div class="modal-dialog modal-md" style="display: grid;">

			<div class="modal-content not-top">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

					<h4 class="modal-title set-compare-peramitter-title">Select Asked Question</h4>

				</div>

				<div class="modal-body sky-form">

					<div id="set-asked_question-loader" class="body-overlay col-md-12 center loder set-asked_question-loader">
						<img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/>
					</div>
					<fieldset>
						<section class="row">
							<label class="radio col-md-6">
								<input type="radio" id="sellectall" name="selectall" value="1">
								<i></i>Select all
							</label>
							<label class="radio col-md-6">
								<input type="radio" id="sellectallnone" name="selectall" value="1">
								<i></i>Select none
							</label>
						</section>
						<section id="asked_question_list">
						</section>
					</fieldset>
					<footer>
						<button type="button" class="btn-u btn-u-primary" data-dismiss="modal" aria-hidden="true">Done</button>
					</footer>
				</div>
			</div>
			<div class="modal-footer" id="notes-compare-peramitter-footer">		
			</div>
		</div>
	</div>
	</form>
	<!-- comapre staging peramitter end  -->
@endsection
<!-- Add Closing Date -->

@if($post->closing_date == '' && $selecteagent != '')
<div class="modal fade " id="set-agent-closingdate" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

							<div class="modal-dialog " style="display: grid;">

								<div class="modal-content not-top sky-form">

									

									<div id="set-agent-review-loader" class="body-overlay col-md-12 center loder set-agent-review-loader"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>

									

									

									<div class="modal-header">

										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

										<h4 class="modal-title set-agent-review-title">Add Closing Date</h4>

									</div>

									{!! Form::open(array('id'=>'set_closing_date' ,'class'=>'sky-form')) !!}

									<div class="modal-body">

										<fieldset style="padding: 0px 15px;">

											<p class="review-msg-text hide"></p>

											

											

											<section class="margin-0">

												<label class="label margin-0"> Closing Date </label>

												<label class="textarea margin-0">

													<input type="text" class="form-control field-border datepicker" name="closing_date" value="" required onkeydown="return false" autocomplete="off"/>

													<b class="error-text" id="closing_date_error"></b>

												</label>

											</section>					

										</fieldset>

									</div>

									<div class="modal-footer" >

										<input type="hidden" name="post_id" value="{{ isset($selecteagent->post_id)?$selecteagent->post_id:'' }}">

										<input type="hidden" name="agent_id" value="{{ isset($selecteagent->id)?$selecteagent->id:'' }}">

										<input type="hidden" name="notification_type" value="14">

										<input type="hidden" name="notification_message" value="{{ isset($selecteagent->name)?$selecteagent->name:'' }} has given you a review for post ({{ 
										isset($selecteagent->posttitle)?$selecteagent->posttitle:'' }})">

										<input type="hidden" name="rating_type" value="3">

										<input type="hidden" name="rating_item_id" value="{{ isset($selecteagent->applied_user_id)?$selecteagent->applied_user_id:'' }}">

										<input type="hidden" name="rating_item_parent_id" value="{{ $selecteagent->post_id }}">

										<input type="hidden" name="receiver_id" value="{{ $selecteagent->id }}">

										<input type="hidden" name="receiver_role" value="{{ $selecteagent->agents_users_role_id }}">

										<input type="hidden" name="sender_id" value="{{ $user->id }}">

										<input type="hidden" name="sender_role" value="{{ $user->agents_users_role_id }}">



										<button type="button" data-dismiss="modal" aria-hidden="true" class="btn-u" style="padding: 10px 20px;margin-right: 5px;color: #74c52c;box-shadow: 0 0.5px 4px rgba(57,73,76,.35);background: white;">Close</button>

										<button type="submit" class="btn-u">Save</button>

									</div>

									{!!Form::close()!!}

								</div>

							</div>

						</div>
						@endif
<!-- Add Closing Date -->
@section('scripts')

<script type="text/javascript">
	var agentsdata = [];
	var asked_question_list = [];
    var valid = 0;
	var $checkboxes = $('#compcheckbox input[type="checkbox"]');


	$( document ).ready(function() {

		$('.datepicker').datepicker({ dateFormat: "dd/mm/yy",maxDate: 'now',});
		$('#set-agent-closingdate').on('hidden.bs.modal', function () {
			$("[name='closing_date']").val(''); 
			$('.closing_date_warning').html('');
			$('#closingbtn').html('Save');
			count = 0;
		});


   		jQuery("#comparebutton").prop('disabled', true);
	    $checkboxes.change(function(){
	    	console.log($checkboxes.filter(':checked').length);
	        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
	        if(countCheckedCheckboxes > 0){
				jQuery("#comparebutton").prop('disabled', false);
			 	jQuery("#comparebutton").attr('type', 'submit');
	        }
	    });

		// var toValidate = jQuery('#asked_question, #bookmark_agents, #bookmark_answers, #bookmark_messages, #rating_answers, #rating_messages, #proposals, #documents');

		// console.log(toValidate.prop('checked'));

		// toValidate.click(function () {

				

		//     if (jQuery(this).prop('checked')) {

		//         valid = valid+1;

		//     } else {

		//         valid = valid-1;

		//     }

		//     console.log(valid);

		//     if (valid == 0) {

		//         jQuery("#comparebutton").prop('disabled', true);

		//         jQuery("#comparebutton").attr('type', 'button');

		//     } else {

		//         jQuery("#comparebutton").prop('disabled', false);

		//         jQuery("#comparebutton").attr('type', 'submit');

		//     }

		// });

		// $('#comparebutton').click(function(e) {

		// 	if (valid != 0) {

		// 	console.log(valid);

		// 		$('#add-compare-peramitter').submit();

		// 	}

		// });



		$('#sellectall').click(function(e) {

			$('.allcheckbox').prop('checked', true);

		});

		$('#sellectallnone').click(function(e) {

			$('.allcheckbox').prop('checked', false);

		});

		$('#message').click(function(e) {

			localStorage.clear();

			window.location.href = "{{ URL('/messages/') }}";

		});




		$('#loadmoreagents').click(function(e){

			e.preventDefault();

			var limit = $(this).attr('title');

			loadagents(limit);

		});

		loadagents(0);

		loadcompare('{{ $post->post_id }}');

		/* edit password*/

	    $('#give_a_review_for_agents').submit(function(e){

			e.preventDefault();

			var $form = $(e.target),esmsg = $('.review-msg-text');

			

			$.ajax({

				url: "{{url('/')}}/sendratingforagentbybuyerseller",

				type: 'POST',

				data: $form.serialize(),

				beforeSend: function(){$(".set-agent-review-loader").show();},

	    	    processData:false,

				success: function(result) {	

					$(".set-agent-review-loader").hide();

					$('.error-text').text('').removeClass('show').addClass('hide');

				 	esmsg.text('').removeClass('show').addClass('hide');



					if(typeof result.error !='undefined' && result.error !=null){

					 	$.each( result.error, function( key, value ) {

					 	 	$('#'+key+'_error').removeClass('success-text hide').addClass('error-text show').text(value);

						});

					}



					if(typeof result.data !='undefined' && result.data !=null){

						$('#set-agent-review').modal('hide');

						msgshowfewsecond('Your feedback successfully send.');

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


		/* Make 3% of payment to Agent*/

		var handler = StripeCheckout.configure({
		key: 'pk_test_oJH1jATmGtjY6pprv6lXxxxn',
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
		var alert = '<div class="alert alert-success"><strong>Success!</strong>'+output.msg+'</div>';
			$("#paymentResponse").html(alert);
			setTimeout(function(){ location.reload(); }, 1000);
			
          
		}else{
           var alert = '<div class="alert alert-danger"><strong>Info!</strong>'+output.msg+'</div>';
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
					var amount = parseInt($('#amount').val()*100);
					handler.open({
					name: '3% Agent Charges',
					description: '3% Agent Charges paying to agent.',
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

						msgshowfewsecond('Your feedback successfully send.');

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

		function process(date){
			var parts = date.split("/");
			return new Date(parts[2], parts[1] - 1, parts[0]);
		}

		$('#set_closing_date').submit(function(e){

			e.preventDefault();

			var $form = $(e.target),esmsg = $('.review-msg-text');

			let closing_date = process($form.find('input[name="closing_date"]').val());
			let post_create_date = process('{{ date("d/m/Y",strtotime($post->created_at)) }}');

			if((closing_date.getTime() >= post_create_date.getTime()) == false){
				$('#closing_date_error').html('You can not set closing date before the post was created');
	  			return false;
			}
			
			$.ajax({

				url: "{{url('/')}}/addClosingDate",

				type: 'POST',

				data: $form.serialize(),

				beforeSend: function(){$(".set-agent-review-loader").show();},

	    	    processData:false,

				success: function(result) {	
                    console.log(result);

					$(".set-agent-review-loader").hide();

					$('.error-text').text('').removeClass('show').addClass('hide');

				 	esmsg.text('').removeClass('show').addClass('hide');

                    

					if(typeof result.error !='undefined' && result.error !=null){

					 	$.each( result.error, function( key, value ) {

					 	 	$('#'+key+'_error').removeClass('success-text hide').addClass('error-text show').text(value);

						});

					}



					if(typeof result.status !=2){
                         //alert('Second');
						$('#set_closing_date').modal('hide');

						msgshowfewsecond('Your closing date successfully added.');

						setTimeout(function(){ 
                        location.reload();
						 }, 500);


						

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



    });

	

	/*load proposal */

	function loadagents(limit) {



		$.ajax({

			url: "{{url('/')}}/profile/buyer/post/details/agents/get/"+limit+"/{{ $post->post_id }}/{{ $post->agents_user_id }}/{{ $post->agents_users_role_id }}",

			type: 'get',

			beforeSend: function(){$(".loadagents").show();},

    	    processData:true,

			success: function(result) {	

				var proppos   = result;

				$(".loadagents").hide();

				if(proppos.count !== 0){

					if('{{ $compare }}' == 'compare'){

						$('html, body').animate({

						    scrollTop: $('#comparecount').offset().top

						},1000);

					}

					$.each( proppos.result, function( key, value ) {

						console.log(value);
						
						agentsdata[value.id] = value;

						var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));

						if(value.photo){



							var photo = '<img class="img-circle header-circle-img1 img-margin" width="50" height="50" src="{{ URL::asset("assets/img/profile/") }}/'+value.photo+'" alt="">';

						}else{



							var photo = '<img class="img-circle header-circle-img1 img-margin" width="50" height="50" src="{{ URL::asset("assets/img/team/img32-md.jpg") }}" alt="">';

						}

						var selectedclass = '';

						var selected ='';

						var title='';

						if('{{ $post->applied_post }}' == 1 && '{{ $post->applied_user_id }}' == value.details_id){

							selectedclass = 'agents_selected';

							title = 'Selected this agents for post ( {{ $post->posttitle }} )';

							selected = '(is Selected for this post)';

						}

						var htmll = '<div class="col-sm-6 sm-margin-bottom-20 buyer-agent-list" >'+

										'<div class="'+selectedclass+' height-209 funny-boxes acpost profile-blog border-gre" title="'+title+'">'+photo+

											'<div class="name-location sm-margin-bottom-20">'+

												'<h2 class="title sm-margin-bottom-10"><a  target="_blank" href="{{ URL("/") }}/search/agents/details/'+value.details_id+'/{{ $post->post_id }}">'+value.name +' '+selected+' <sub class="'+value.login_status+'"> '+value.login_status+' </sub></a></h2>'+

												'<span><strong> Broker : </strong> '+ ((value.brokers_name != null) ? value.brokers_name : '  ') +'  </span> - '+

												'<span><strong> Applied time : </strong>'+date+'</span>'+

											'</div>'+

											'<div class="hidetext2line clear-both sm-margin-bottom-20">'+ (value.description!=null ? value.description : '')+'</div>'+



											'<ul class="list-inline clear-both">'+

												'<li><strong><a  target="_blank" href="{{ URL("/") }}/search/agents/details/'+value.details_id+'/{{ $post->post_id }}"> Agent Details</a></strong></li>'+

												' - <li><i class="fa fa-bell"></i> <a  rel="popover" data-popover-content="#myPopover'+value.connection_id+'">'+ value.notificatio.count +' Notifications</a></li>'+
												' - <li><i class="fa fa-comments"> </i> <a class="cursor" onclick="register_popup('+value.post_id+','+value.details_id+','+value.details_id_role_id+');">'+value.message_notificatio.count+' Message</a></li>';
												if('{{ $post->applied_post }}'=='2'){
													if(value.compare.result != null){
														$('#compare_id').val(value.compare.result.compare_id);
														htmll +=' - <li class="pull-right compare_list_'+value.details_id+'"> <a class="cursor red" onclick="removetocompare('+value.compare.result.compare_id+','+value.details_id+')">  <i class="fa fa-times-circle red"></i> Remove To Compare </a> </li>';
													}else{
														htmll +=' - <li class="pull-right compare_list_'+value.details_id+'"> <a class="cursor sitegreen" onclick="addtocompare('+value.details_id+')">  <i class="fa fa-plus-circle sitegreen"></i> Add To Compare </a> </li>';
													}
												}
									htmll +='</ul>'+
										'</div>'+										
											'<div id="myPopover'+value.connection_id+'" class="hide">'+
										      '<div class="panel panel-profile">'+										
												'<div class="panel-heading overflow-h border1-bottom">'+
													'<h2 class="panel-title heading-sm pull-left color-black"><i class="fa fa-users"></i> '+value.name+' Notifications</h2>'+
												'</div>'+											
												'<div id="scrollbar3" class="panel-body no-padding mCustomScrollbar" data-mcs-theme="minimal-dark">';

										if(value.notificatio.count != 0)	{
										$.each( value.notificatio.result, function( key, agentdata ) {
											var url='';
											if(agentdata.receiver_role == 4){
												if(agentdata.notification_type==9){
												url = '{{ url("/messages/") }}/'+agentdata.post_id+'/'+agentdata.sender_id+'/'+agentdata.sender_role;
												}else{												
												url = '{{ url("/search/post/details/") }}/'+agentdata.post_id+'/'+agentdata.notification_type;
												}
											}else{
												url = '{{ url("/search/agents/details/") }}/'+agentdata.sender_id+'/'+agentdata.post_id+'/'+agentdata.notification_type;
											}
											var date = timeDifference(new Date(), new Date(Date.fromISO(agentdata.created_at)));
											htmll +='	<div onclick="readnotification('+agentdata.notification_id+',\''+url+'\');" class="cursor alert-blocks alert-dismissable">'+
															'<div class="overflow-h">'+
																'<div class="hidetext2line">'+agentdata.notification_message+'</div>'+
																'<strong><small class="pull-right"><em>'+date+'</em></small></strong>'+
															'</div>'+
														'</div>';
										});
										}else{
											htmll +='<div class="cursor alert-blocks alert-dismissable">No Notification</div>';
										}

										htmll += '</div>'+
											  '</div>'+
										    '</div>'+
									'</div>';
				 		$('#connectedagents-data').append(htmll);
					});

					if(proppos.next!=0){

						$('#loadmoreagents').removeClass('hide').attr('title',proppos.next);

					}else{

						$('#loadmoreagents').addClass('hide');

					}

					$(function(){
					    $('[rel="popover"]').popover({
					        container: 'body',
					        html: true,
					        trigger: 'manual',
					        animation:true,
					        content: function () {
					            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
					            return clone;
					        }
					    }).toggle(function(e) {
					        e.preventDefault();
					        var $popover = $(this);
					        $popover.popover('show');
					    },
					    function(e) {
					        e.preventDefault();
					        var $popover = $(this);
					        $popover.popover('hide');
					    });

					    $(document).on('click touch', function(event) {
						  if (!$(event.target).parents().addBack().is('[rel="popover"]')) {
						    $('.popover').hide();
						  }
						});
						
					});
				}else{
					$('#connectedagents-data').html('<p class="text-center"> Not any applied agents. </p>');
				}		
			},
		  	error: function(data) {	
		  		$(".loadagents").hide();
	    		if(data.status=='500'){
					$('.loadagents').text(data.statusText).css({'color':'red'});
	    		}else if(data.status=='422'){
					$('.loadagents').text(data.responseJSON.image[0]).css({'color':'red'});
	    		}
	    	}
		});
	}

	function comparenow() {

		if($checkboxes.filter(':checked').length > 0){
			jQuery("#comparebutton").prop('disabled', false);
		 	jQuery("#comparebutton").attr('type', 'submit');
        }
		$('#set-compare-peramitter').modal('show');
	}

	$('#asked_question').click(function(){
		if($('#asked_question').prop('checked')){
			$('#set-compare-asked_question-modal').modal('show');
	  		$('#set-compare-peramitter').modal('hide');
		}
	});

	$('#set-compare-asked_question-modal').on('hidden.bs.modal', function (e) {
	  $('#set-compare-peramitter').modal('show');
	});

	// $('#set-compare-peramitter').on('show.bs.modal', function (e) {
	// 	$('#asked_question_list_question').val(asked_question_list);
	// });


		/* compare staging peramiter selected get  */

		function compareagent(){
 			
			$.ajax({
			url: "{{url('/compared/data/get/')}}/{{ $post->post_id }}/{{ $post->agents_user_id }}/{{ $post->agents_users_role_id }}",
			type: 'get',
			beforeSend: function(){$(".set-compare-peramitter-loader").show();},
			success: function(result) {	
				$(".set-compare-peramitter-loader").hide();
				if(result.comparedata!=null && result.comparedata.compare_json != null) {
					var comparedata = result.comparedata;
					var comdd = JSON.parse(comparedata.compare_json);
					if(comdd.asked_question==1){
						$('#asked_question').attr('checked', true);
					}

					if(comdd.bookmark_agents==1){
						$('#bookmark_agents').attr('checked', true);
					}

					if(comdd.bookmark_answers==1){
						$('#bookmark_answers').attr('checked', true);
					}

					if(comdd.bookmark_messages==1){
						$('#bookmark_messages').attr('checked', true);
					}

					if(comdd.bookmark_proposal==1){
						$('#bookmark_proposal').attr('checked', true);
					}

					if(comdd.rating_answers==1){
						$('#rating_answers').attr('checked', true);
					}

					if(comdd.rating_messages==1){
						$('#rating_messages').attr('checked', true);
					}

					if(comdd.proposals==1){
						$('#proposals').attr('checked', true);
					}

					if(comdd.documents==1){
						$('#documents').attr('checked', true);
					}

					if(comdd.notes_messages==1){
						$('#notes_messages').attr('checked', true);
					}

					if(comdd.notes_asked_question==1){
						$('#notes_asked_question').attr('checked', true);
					}

					if(comdd.notes_answers==1){
						$('#notes_answers').attr('checked', true);
					}

					if(comdd.notes_proposal==1){
						$('#notes_proposal').attr('checked', true);
					}

					if(comdd.notes_agents==1){
						$('#notes_agents').attr('checked', true);
					}
				}

				if(result.askedquestiondata != ''){

					$.each( result.askedquestiondata, function( key, val ) {

						asked_question_list[val.question_id] = val;

						var apen = $('#asked_question_list');

						var checked = val.asked != '' && val.asked == val.question_id ? 'checked' : '';

						var htm = 	'<label class="checkbox">'+

										'<input type="hidden" value="'+val.question+'" name="asked_question_text['+val.question_id+']" class="asked_question_text">'+

										'<input type="checkbox" name="asked_question_list['+val.question_id+']" '+checked+' value="'+val.question_id+'" class="asked_question_list allcheckbox asked_question_'+val.question_id+'">'+

										'<i></i>'+val.question+

									'</label>';

						apen.append(htm);

					});



				}

			},

		  	error: function(data) 

	    	{	

	    		$(".set-compare-peramitter-loader").hide();

	    	}

		});

		}
		/*compare end*/

		/*$("#compare_agents").submit(function(e){
	        e.preventDefault(); 
	        compareagent();
	        console.log('Compare Agent called ');
	    });*/

</script> 
@stop