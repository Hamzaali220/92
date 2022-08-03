@extends('dashboard.master')

@section('style')

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

@stop

@section('title', 'Importance')

@section('content')

<?php  $topmenu='Other_Resources'; ?>

<?php $activemenu = 'importance'; ?>

@include('dashboard.include.sidebar')

	<!--=== Profile ===-->

	<div class="container content profile">

		<div class="row">

			<!--Left Sidebar-->

			@include('dashboard.user.buyers.include.sidebar')

			@include('dashboard.user.buyers.include.sidebar-question')

			<!--End Left Sidebar-->



			<!-- Profile Content -->

			<div class="col-md-9">

				

				<div class="box-shadow-profile">

					<!-- Default Proposals -->

					<div class="panel-profile">

						<div class="panel-heading overflow-h air-card">

							<h2 class="heading-sm pull-left"> Important Questions For Agents </h2>

							<a class="cursor pull-right btn btn-default new-ask-question"><i class="fa fa-plus"></i> Add </a>

						</div>

						<div class="panel-body padding-list" >							

							<div id="append-importantlist-ajax">

									

							</div>

							<div id="loaduploadshare" class="col-md-12 center loder loaduploadshare"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>

							<div class="center col-md-12 btn-buy animated fadeInRight">

								<a  id="loaduploadandshare" class="cursor hide"><i class="fa fa-spinner"> </i> load more </a>

							</div>

						</div>

						<!--/end row-->

					</div>

					<!-- Default Proposals -->

				</div>

			</div>

			<!-- End Profile Content -->

		</div><!--/end row-->

	</div>

	<!--=== End Profile ===-->

	<!-- important popup -->

	<div class="modal fade" id="uploadsharedeleteconfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content not-top">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

						<h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>

					</div>

					<div class="modal-body">

						<br>

						<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

						<div id="upload-delete-msg"> </div>

						<p class="rempovemessag">Are you sure that you need to remove question to the Important List.</p>

					</div>

					<div class="modal-footer">

						<button type="button" class="btn-u btn-u-primary" id="delete">Sure</button>

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

					<button type="button" class="btn-u" data-dismiss="modal">Share</button>

					<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

				</div>

			</div>

		</div>

	</div>

	<!-- share option  end-->

	<!-- add new question  -->

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

								<label class="label">Enter Question</label>

								<label class="textarea ">

									<textarea rows="2" class="field-border" name="question" id="Question_id" placeholder="Enter Question"></textarea>

									<b class="error-text" id="question_error"></b>

								</label>

							</section>

							<section class="row">

								<input type="hidden" name="importance1" value="1" >

								<div class="col col-12">

									<label class="label weight">Add question to Survey list </label>

									<div class="inline-group">

										<label class="radio"><input type="radio" name="survey" class="survey_1" value="1" ><i class="rounded-x"></i>Yes</label>

										<label class="radio"><input type="radio" name="survey" class="survey_2" value="0" checked><i class="rounded-x"></i>No</label>

									</div>

								</div>

							</section>

						</fieldset>

					</div>

					<div class="modal-footer">

						<input type="hidden" value="{{ $user->id }}" name="add_by" >

						<input type="hidden" value="4" name="question_type" >

						<input type="hidden" value="{{ $user->agents_users_role_id }}" name="add_by_role" >

						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

						<button type="submit" class="btn-u btn-u-primary" name="edit-profile-submit" value="Save changes" title="Save changes">Save</button>

					</div>

				{!!Form::close()!!}

			</div>

		</div>

	</div>

	<!-- end add new question  -->



@endsection

@section('scripts')

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> 

<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script type="text/javascript">

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

<script type="text/javascript">

	var important_data = [];

	var shared_proposal_connected_user_list  = [];

	(function() {

		/*submit question start*/

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

						var val = result.data;

						important_data[val.question_id] = val;

						esmsg.text('').css({'color':'green'});

						esmsg.removeClass('hide').addClass('show alert alert-success text-center').text(result.msg);

		    		

		    			setInterval(function() { esmsg.text('').addClass('hide').removeClass('show alert-success'); },5000);

						anymodelhideinfewsecond('#new-ask-question');

						loadimportant(0,'yes');	

					}

				},

			  	error: function(data) 

		    	{	

		    		if(data.status=='500'){

						esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');

		    		}else if(data.status=='422'){

						esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');

		    		}

		    		$(".body-overlay-popup").hide();

		    		setInterval(function() { esmsg.text('').addClass('hide').removeClass('show'); },5000);

		    	}

			});

		});

		/*submit question end*/



		$('#loaduploadandshare').hide();

		$('#loaduploadandshare').click(function(e){

			e.preventDefault();

			var limit = $(this).attr('title');

			loadimportant(limit);

		});

		loadimportant(0);

		$('.new-ask-question').click(function(e){

			e.preventDefault();
			$('#Question_id').val('');
		 	$('#new-ask-question').modal('show');

		});

	 	$('#searchproposalshareuser').submit(function(e){

			e.preventDefault();

			shareproposalpopup($('#praposalid').val(),$('#praposalidrole').val());

		});	

    })();

    /*load uploadandshare */

	function loadimportant(limit,html=null) {

		if(html=='yes'){

			$('#append-importantlist-ajax').html('');

		}

		$.ajax({

			url: "{{url('/')}}/importance/get/"+limit+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",

			type: 'get',

			beforeSend: function(){$(".loaduploadshare").show();},

    	    processData:false,

    	    contentType: false,

			success: function(result) {	

				$(".loaduploadshare").hide();

				if(result.count !== 0){

					$.each( result.result, function( key, value ) {

						important_data[value.importance_id] = value;

						key = key+1;

						var htmll = '<div class="askquestioncount survey-list-'+value.importance_id+'" >'+

										'<div class="panel-group margin-0" id="accordion-'+key+'">'+

											

												'<div class="panel-heading border1-bottom">'+

													

													'<h4 class="panel-title question-title"><span>'+

													

													key+') </span><a class="question-question q-s-'+value.question_id+'" >'+

															 value.question+

													 	'</a>'+

													

														'<span class="red margin cursor pull-right "  Title="Remove" onclick="importancedelete('+value.importance_id+');" > <i class="rounded-x fa fa-trash-o"></i> <small> Remove </small></span>'+

														'<span class="sitegreen margin cursor pull-right share_'+value.question_id+'"  Title="Share" onclick="shareproposalpopup('+value.question_id+','+value.question_type+')" id="share_'+value.question_id+'"> <i class="rounded-x fa fa-share-alt"></i> <small> Share </small></span>'+

													'</h4>'+

												'</div>'+											

										'</div>'+

									'</div>';

				 		$('#append-importantlist-ajax').append(htmll);

					});

					if(result.next!=0){

						$('#loaduploadandshare').show().attr('title',result.next);

					}

				}

				

			},

		  	error: function(data) 

	    	{	

	    		if(data.status=='500'){

					$('.loaduploadshare').text(data.statusText).css({'color':'red'});

	    		}else if(data.status=='422'){

					$('.loaduploadshare').text(data.responseJSON.image[0]).css({'color':'red'});

	    		}

    				setInterval(function() {$(".loaduploadshare").hide(); },1000);

	    	}

		});

	}

	function importancedelete(id) {

		var qdata = important_data[id];

		$('#upload-delete-msg').addClass('hide');

		$('.rempovemessag').html('Are you sure that you need to remove question ('+qdata.question+') to the Important List.');

		$('#uploadsharedeleteconfirm')

	        .modal({ backdrop: 'static', keyboard: false })

	        .one('click', '#delete', function (e) {

	           	$.ajax({

					url: "{{url('/')}}/importance/delete/"+id,

					type: 'get',

					processData:false,

					beforeSend: function(){$(".body-overlay").show();},

					success: function(result) {	

						$(".body-overlay").hide();

						if(result.status=='error'){

							$('#upload-delete-msg').removeClass('hide').addClass('alert alert-danger text-center').text(result.msg);

						}else{

							$('#upload-delete-msg').removeClass('hide').addClass('alert alert-success text-center').text(result.msg);

							$('.importance-id-'+id).hide();

						}

						anymodelhideinfewsecond('#uploadsharedeleteconfirm');

						loadimportant(0,'yes');	

					},error: function(data) {	$(".body-overlay").hide(); 	}

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

			data: {notification_type : 4,notification_message : '{{ $userdetails->name }} asked questions related to your post `'+userdata.posttitle+'`' ,shared_type:1 ,shared_item_id:id,shared_item_type : 2,shared_item_type_id : userdata.post_id,receiver_id : userdata.details_id,receiver_role: userdata.details_id_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},

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

</script> 

@stop