@extends('dashboard.master')

@section('style')

<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />



@stop

@section('title', 'Profile')

@section('content')

<?php  $topmenu='Other_Resources'; ?>

<?php $activemenu = 'proposal'; ?>

@include('dashboard.include.sidebar')

<!--=== Profile ===-->

    <div class="container content profile">

		<div class="row">

			<!--Left Sidebar-->

			@include('dashboard.user.agents.include.sidebar')

			@include('dashboard.user.agents.include.sidebar-files')

			<!--End Left Sidebar-->



			<!-- Profile Content -->

			<div class="col-md-9">

				<div class="box-shadow-profile ">

					<!-- Default Proposals -->

					<div class="panel-profile">

						<div class="panel-heading overflow-h air-card">

							<h2 class="heading-sm pull-left"> Proposals </h2>

							<a class="defaultproposal cursor pull-right btn btn-default"><i class="fa fa-plus"></i> Upload New Proposals</a>

						</div>

						<div class="panel-body row" >							

							<div id="append-proposal-ajax"></div>

							<div id="loadproposal" class="col-md-12 center loder loadproposal"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>

							<div class="center col-md-12 btn-buy animated fadeInRight">

								<a  id="loadmoreproposal" class="cursor hide">Load More </a>

							</div>

						</div>						



					</div>

					<!-- Default Proposals -->

				</div>

			</div>

			<!-- End Profile Content -->

		</div>

	</div>	



	<!-- default proposal -->

	<div class="modal fade" id="defaultproposal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content not-top">

				<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

				{!! Form::open(array('url' => '#','class'=>'sky-form','enctype'=>'multipart/form-data','id'=>'add-default-proposal')) !!}

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

						<h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>

					</div>

					<div class="modal-body">

						<fieldset>

							<div id="message-proposal"> </div>

							<dt>Proposal Title</dt>

							<dd>

								<section>

									<label class="input">

										<input type="text" id="proposals_title" name="proposals_title"  placeholder="Proposal Title">

									</label>

									<p class="error-text proposals_title-error" id="proposals_title-error"></p>

								</section>

							</dd>

							<dt>Selecte Proposal Type</dt>

							<dd>

								<section>

									<div class="inline-group">

										<label class="radio"><input type="radio" name="type" class="type_1 type" value="1" ><i class="rounded-x"></i>Files Upload</label>

										<label class="radio"><input type="radio" name="type" class="type_2 type" value="2" ><i class="rounded-x"></i>Text Html</label>

										<p class="error-text type-error" id="type-error"></p>

									</div>

								</section>

							</dd>



							<div class="filesupload hide">

								<label>Upload Your proposal</label>

								<section>

									<label for="file" class="input input-file">

										<div class="button"><input type="file" id="proposal-file" name="proposal_file" class="proposal_file" accept="application/pdf,application/doce,application/doc" onchange="this.parentNode.nextSibling.value = this.value.replace(/^.*\\/, '')">Upload proposal </div><input type="text" placeholder="Upload proposal" readonly>

									</label>

									<p class="error-text proposal_file-error" id="proposal_file-error"></p>

								</section>		

								<div style="clear:both">

						           <iframe id="viewer" class="hide" frameborder="0" scrolling="no" width="200" height="200"></iframe>

						        </div>

							</div>



							<div class="texthtml hide">

								<dd>

									<label class="label">Type Text</label>

									<section>

										<label class="textarea ">

											<textarea rows="2" class="field-border proposals_html jqte-test" name="proposals_html" id="proposals_html" placeholder="Enter Text"></textarea>

											<b class="error-text" id="proposals_html_error"></b>

										</label>

									</section>

								</dd>

							</div>

						</fieldset>

					</div>

					<div class="modal-footer">

						<input type="hidden" value="" name="id" id="proposal_id_update" >

						<input type="hidden" value="<?php echo $user->id; ?>" name="agents_user_id" >

						<input type="hidden" value="<?php echo $user->agents_users_role_id; ?>" name="agents_users_role_id" >

						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

						<button type="submit" class="btn-u btn-u-primary" name="add-proposal-submit" value="Save changes" id="submitDoc" title="Save changes">Save</button>

					</div>

				{!!Form::close()!!}

			</div>

		</div>

	</div>

	<div class="modal fade" id="open-proposal-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content not-top">

				<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

						<h4 class="modal-title proposal-popup-title">{{ucfirst($userdetails->name)}}</h4>

					</div>

					<div class="modal-body append-src-ifram">

						

					</div>

			</div>

		</div>

	</div>

	<div class="modal fade" id="proposaledeleteconfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content not-top">

				<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

						<h4 class="modal-title ">Remove Proposal</h4>

					</div>

					<div class="modal-body">

						<br>

						<div class="proposal-delete-msg"> </div>

						<p class="proposal-popup-title">Are you sure this proposal delete?</p>

					</div>

					<div class="modal-footer">

						<button type="button" class="btn-u btn-u-primary" id="delete">Delete</button>

						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

					</div>

			</div>

		</div>

	</div>

	<!-- share option  start-->

	<!-- praposal -->

	<div class="modal fade" id="open-proposal-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content not-top">

				



				<div id="loadproposalshare"  class="loadproposalshare body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

					<h4 class="modal-title">Share Proposals With Seller/Buyer</h4>

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

	            format: 'MM/DD/YYYY'

	          }

        });

    });

</script>

<script type="text/javascript">

	var proposale_data  = [];

	var shared_proposal_connected_user_list  = [];

	$( document ).ready(function() {

		$("#proposal-file").change(function () {

	        var fileExtension = ['jpeg','jpg','png','pdf', 'doc','docx'];

	        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {

	           $("#proposal_file-error").text("Only formats are allowed : "+fileExtension.join(', '));

			    $('#submitDoc').prop('disabled', true);

				return false; 

	        }

			 $('#submitDoc').prop('disabled', false);

	    });

		$('.type').change(function(e) {

			e.preventDefault();

		 	var value = $(this).val();

		 	if(value==1){ 

		        $(".filesupload").addClass('show').removeClass('hide');

		        $(".texthtml").addClass('hide').removeClass('show');		 		

		    }else{

		        $(".filesupload").addClass('hide').removeClass('show');

		        $(".texthtml").addClass('show').removeClass('hide');

		    }

		});

	    /*default-proposal*/

		$('#add-default-proposal').submit(function(e){

			e.preventDefault();

			$(".body-overlay").show();

			var esmsg = $("#message-proposal");



		    var data = [];

	        data = new FormData(this);

	        

	        if($(".type_2").is(':checked')){

	        	

				$('.note-editor img').attr('style', 'width: 100px !important;');



				var doc = new jsPDF("p","mm","letter");

			  	doc.fromHTML($("#proposals_html").summernote('code'), 10, 10, {

			    	'width': 210

			  	}, function(a) {

				    // doc.save("Image.pdf");

		        	var pdf =doc.output('blob'); 

			        data.append("data" , pdf);

			        $.ajax({

						url: "{{url('/')}}/agent/proposal/insert",

						type: 'POST',

						data: data,//new FormData(this),

						beforeSend: function(){$(".body-overlay").show();},

			    	    processData:false,

			    	    contentType: false,

						success: function(result) {	

							$(".body-overlay").hide();

							$('.error-text').text('');



							if(typeof result.error !='undefined' && result.error !=null){

							

							 	$.each( result.error, function( key, value ) {
							 		if(key=='proposal_file'){

								 	 $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value+' Proposal should be less then 2MB.');
							 		}else{
							 			
								 	 $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value);
							 		}

									});

							 	esmsg.text('');

							

							}

							if(typeof result.msg !='undefined' && result.msg !=null){

							

								if(result.msg.error !='undefined' && result.msg.error !=null){

									esmsg.text(result.msg.error).css({'color':'red'});

								}else{

									esmsg.text('').css({'color':'green'});

									esmsg.addClass('alert alert-success text-center').text(result.msg);

									setTimeout(location.reload(),5000);

								}

							}

						},

					  	error: function(data) 

				    	{	$(".body-overlay").hide();

				    		if(data.status=='500'){

								esmsg.text(data.statusText).css({'color':'red'});

				    		}else if(data.status=='422'){

								esmsg.text(data.responseJSON.image[0]).css({'color':'red'});

				    		}

				    	}

					});			    

			  	});

	        }else{

	        	$.ajax({

					url: "{{url('/')}}/agent/proposal/insert",

					type: 'POST',

					data: data,//new FormData(this),

					beforeSend: function(){$(".body-overlay").show();},

		    	    processData:false,

		    	    contentType: false,

					success: function(result) {	

						$(".body-overlay").hide();

						$('.error-text').text('');



						if(typeof result.error !='undefined' && result.error !=null){

						

						 	$.each( result.error, function( key, value ) {

							 	 	if(key=='proposal_file'){

								 	 $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value+' Proposal should be less then 2MB.');
							 		}else{
							 			
								 	 $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value);
							 		}

								});

						 	esmsg.text('');

						

						}

						if(typeof result.msg !='undefined' && result.msg !=null){

						

							if(result.msg.error !='undefined' && result.msg.error !=null){

								esmsg.text(result.msg.error).css({'color':'red'});

							}else{

								esmsg.text('').css({'color':'green'});

								esmsg.addClass('alert alert-success text-center').text(result.msg);

								setTimeout(location.reload(),5000);

							}

						}

					},

				  	error: function(data) 

			    	{	$(".body-overlay").hide();

			    		if(data.status=='500'){

							esmsg.text(data.statusText).css({'color':'red'});

			    		}else if(data.status=='422'){

							esmsg.text(data.responseJSON.image[0]).css({'color':'red'});

			    		}

			    	}

				});	

	        }				

		});



		$('.defaultproposal').click(function(e){

			e.preventDefault();

			$('#proposals_title').val('');

			$('#viewer').attr('src','').addClass('hide');

			$('#proposal_id_update').val('');

			//$('#proposals_html').jqteVal('');

			$('#proposals_html').summernote('code','');

		 	$('#defaultproposal').modal('show');

		});

		$('#loadmoreproposal').click(function(e){

			e.preventDefault();

			var limit = $(this).attr('title');

			loadproposal(limit);

		});

		/*default-proposal*/

		loadproposal(0);

		$('#searchproposalshareuser').submit(function(e){

			e.preventDefault();

			shareproposalpopup($('#praposalid').val());

		});		

    });

    

	/*load proposal */

	function loadproposal(limit) {



		$.ajax({

			url: "{{url('/')}}/agent/proposal/get/ten/"+limit+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",

			type: 'get',

			beforeSend: function(){$(".loadproposal").show();},

    	    processData:false,

    	    contentType: false,

			success: function(result) {	

				$(".loadproposal").hide();

				if(result.count !== 0){

					var i=0;

					$.each( result.result, function( key, value ) {

						

				

						proposale_data[value.proposals_id] = value;



						var extension = value.proposals_attachments.substr( (value.proposals_attachments.lastIndexOf('.') +1) );

							extension = extension.toLowerCase();

						var docep='';

						if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){

							docep 	='<img 		class="documen document_'+value.proposals_id+'" src="'+value.proposals_attachments+'" frameborder="0" scrolling="no" width="225" height="150">';

						}else{

							docep 	='<iframe 	class="documen document_'+value.proposals_id+'" src="https://docs.google.com/viewer?url='+value.proposals_attachments+'&embedded=true" frameborder="0" scrolling="no" width="225" height="142"></iframe>';

						}

						var htmll = '<div class="col-md-4">'+

										'<div class="thumbnails thumbnail-style thumbnail-kenburn">'+

											'<div class="cbp-caption thumbnail-img">'+

												'<div class="overflow-hidden cbp-caption-defaultWrap">'+

													docep+

												'</div>'+

												'<div class="removehover cbp-caption-activeWrap">'+

													'<div class="cbp-l-caption-alignCenter">'+

														'<div class="cbp-l-caption-body">'+

															'<ul class="link-captions no-bottom-space">'+

																'<li><a class="cursor" title="View" onclick="openpropop('+value.proposals_id+')" id="'+value.proposals_id+'"><i class="rounded-x fa fa-eye"></i></a>'+

																'<li><a class="cursor" Title="Share" onclick="shareproposalpopup('+value.proposals_id+')" id="'+value.proposals_id+'"><i class="rounded-x fa fa-share-alt"></i></a>'+

																'<li><a class="cursor" Title="Remove" onclick="removeproposal('+value.proposals_id+')" id="'+value.proposals_id+'"><i class="rounded-x fa fa-trash-o"></i></a>'+

															'</ul>'+

														'</div>'+

													'</div>'+		

												'</div>'+

											'</div>'+

											'<div class="caption cbp-title-dark">'+

												'<span class="cbp-l-grid-agency-title"><a class="cursor hover-effect" onclick="openpropop('+value.proposals_id+')"   title="'+value.proposals_attachments+'"><strong class="showTitle">'+value.proposals_title+'</strong></a></span>'+

											'</div>'+

										'</div>'+

									'</div>';

				 		$('#append-proposal-ajax').append(htmll);

					});

					if(result.next!=0){

						$('#loadmoreproposal').removeClass('hide').attr('title',result.next);

					}else{

						$('#loadmoreproposal').addClass('hide');

					}

				}

				

			},

		  	error: function(data) 

	    	{	$(".loadproposal").hide();

	    		if(data.status=='500'){

					$('.loadproposal').text(data.statusText).css({'color':'red'});

	    		}else if(data.status=='422'){

					$('.loadproposal').text(data.responseJSON.image[0]).css({'color':'red'});

	    		}

	    	}

		});

	}

	function openpropop(el) {

		var src = proposale_data[el].proposals_attachments;

		var text = proposale_data[el].proposals_title;

		// var type = proposale_data[el].type;

		// var proposals_html = proposale_data[el].proposals_html;



		$('.proposal-popup-title').text(text);

		var extension = src.substr( (src.lastIndexOf('.') +1) );

			extension = extension.toLowerCase();

		var docs='';

			if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){

				docs ='<img 		class="documen document_'+proposale_data[el].proposals_id+'" src="'+proposale_data[el].proposals_attachments+'" frameborder="0" scrolling="no"  width="225" height="150">';

			}else{

				docs ='<iframe 	class="documen document_'+proposale_data[el].proposals_id+'" src="https://docs.google.com/viewer?url='+proposale_data[el].proposals_attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';

			}

		$('.append-src-ifram').html(docs+

										'<div class="modal-footer">'+

											'<button type="button" class="btn-u btn-u-primary" Title="Update" onclick="proposal_Edit('+el+');" data-dismiss="modal">Edit</button>'+

											'<button type="button" class="btn-u btn-u-primary" Title="Remove" onclick="removeproposal('+el+');" data-dismiss="modal">Delete</button>'+

											'<button type="button" class="btn-u btn-u-default" Title="Close Popup" data-dismiss="modal">Close</button>'+

										'</div>');

		$('#open-proposal-popup').modal('show');

	}

	function removeproposal(el) {

		var text = proposale_data[el].proposals_title;

		$('.proposal-popup-title').text('Are you sure you want to remove "'+text+'" from your proposals?');

		$('#proposaledeleteconfirm')

	        .modal({ backdrop: 'static', keyboard: false })

	        .one('click', '#delete', function (e) {

        

           	$.ajax({

				url: "{{url('/')}}/agent/proposal/delete/"+el,

				type: 'get',

				beforeSend: function(){$(".body-overlay").show();},

	    	    processData:false,

				success: function(result) {	

					$(".body-overlay").hide();

					if(result.status=='error'){

						$('.proposal-delete-msg').addClass('alert alert-danger text-center').text(result.msg);

					}else{

						$('.proposal-delete-msg').addClass('alert alert-success text-center').text(result.msg);

					}

					setTimeout(location.reload(),7000);

				},error: function(data) {	$(".body-overlay").hide(); 	}

					

			});

        

        });



	}

	function shareproposalpopup(id) {

		var praposaldata = proposale_data[id];

		$('#append-proposal-share-user-list').html('');

		$('#open-proposal-share').modal('show');



		$('#praposalid').val(id);

		var keyword = $('#proposalkeyword').val();			

		var address = $('#proposaladdress').val();		

		var date = $('#proposaldate').val();	

		

		$.ajax({

			url: "{{url('/')}}/shared/proposals/with/connected/users/by/"+id+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",

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

			data: {notification_type : 3,notification_message : '{{ $userdetails->name }} shared a proposal related to your post `'+userdata.posttitle+'`' ,shared_type:3 ,shared_item_id:id,shared_item_type : 1,shared_item_type_id : userdata.post_id,receiver_id : userdata.details_id,receiver_role: userdata.details_id_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},

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

	function proposal_Edit(el) {

		var src = proposale_data[el].proposals_attachments;

		var type = proposale_data[el].type;

		var proposals_html = proposale_data[el].proposals_html;



		$('#proposals_title').val(proposale_data[el].proposals_title);

		$('#proposal_id_update').val(el);

		

		if(type==1){

	        $(".filesupload").addClass('show').removeClass('hide');

	        $(".texthtml").addClass('hide').removeClass('show');		 		

			$('#viewer').attr('src',src).removeClass('hide');

			$(".type_1").prop("checked", true);

		}else{

	        $(".filesupload").addClass('hide').removeClass('show');

	        $(".texthtml").addClass('show').removeClass('hide');

			//$('#proposals_html').jqteVal(proposals_html);

			$('#proposals_html').summernote('code',proposals_html);

			$(".type_2").prop("checked", true);

		}

	 	$('#open-proposal-popup').on('hidden.bs.modal', function (e) {

			

	 		if($('#proposal_id_update').val() !=''){

		  		$('#defaultproposal').modal('show');

	 		}

		});

	}

/* end */

</script> 

@stop