@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

@stop
@section('title', 'Profile')
@section('content')
<?php  $topmenu='Other_Resources'; ?>
<?php $activemenu = 'documents'; ?>
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
							<h2 class="heading-sm pull-left"> Documents </h2>
							<a class="uploadandshare cursor pull-right btn btn-default"><i class="fa fa-plus"></i> Upload New Documents</a>
						</div>
						<div class="panel-body row">							
							<div id="append-uploadshares-ajax"></div>
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
		</div>
	</div>	
	<!-- profile model -->

	<!-- uploads and share -->
	<div class="modal fade" id="uploadsharedeleteconfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content not-top">
				<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Remove Upload Documents</h4>
					</div>
					<div class="modal-body">
						<br>
						<div class="upload-delete-msg"> </div>
						<p class="upload-popup-title">Are you sure this file delete?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn-u btn-u-primary" id="delete">Delete</button>
						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
					</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="open-uploadshare-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content not-top">
				<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>
					</div>
					<div class="modal-body uploadshare-src-ifram">
						
					</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="uploadandshare" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content not-top">
				<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
				{!! Form::open(array('url' => '#','class'=>'sky-form','enctype'=>'multipart/form-data','id'=>'add-upload-all-type')) !!}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>
					</div> 
					<div class="modal-body">
						<fieldset>
							<div id="message-uploadandshare" class="message-uploadandshare"> </div>
							<label>Files Name</label>
							<section>
								<label for="file" class="input input-file">
									<input type="text" name="name" />
									<!--select style="width: 100%; height: 35px; outline: none;" id="documentNams">
										<option>Document Name</option>
									</select-->
								</label>
								<p class="error-text name-error" id="name-error"></p>
							</section>

							<label>Upload Files</label>
							<section>
								<label for="file" class="input input-file">
									<div class="button">
										<input type="file" accept="application/pdf,application/docx,application/doc" id="uploadshare-file" name="uploadshare" onchange="this.parentNode.nextSibling.value = this.value.replace(/^.*\\/, '')">Upload files </div>
										<input type="text" placeholder="Upload files" readonly>
								</label>
								<p class="error-text uploadshare-error" id="uploadshare-error"></p>
							</section>		
						</fieldset>
					</div>
					<div class="modal-footer">
						<input type="hidden" value="" name="id" id="uploadshare_id_update" >
						<input type="hidden" value="<?php echo $user->id; ?>" name="agents_user_id" >
						<input type="hidden" value="<?php echo $user->agents_users_role_id; ?>" name="agents_users_role_id" >
						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn-u btn-u-primary" name="add-proposal-submit" id="submitDoc" value="Save changes" title="Save changes">Save</button>
					</div>
				{!!Form::close()!!}
			</div>
		</div>
	</div>
	<!-- share option  start-->
	<!-- document -->
	<div class="modal fade" id="open-Document-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content not-top">
				<div id="loadDocumentshare"  class="loadDocumentshare body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Share Documents With Seller/Buyer</h4>
				</div>
				<div class="row margin-10">
					{!! Form::open(array('url' => '#','id'=>'searchdocumentsshareuser')) !!}
						<div class="col-sm-6 md-margin-bottom-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-tag"></i></span>
								<input type="text" autofocus placeholder="Search With Seller/Buyer" value="" name="documentskeyword" id="documentskeyword" class="keyword form-control">
							</div>
						</div>
						<div class="col-sm-6 md-margin-bottom-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
								<input type="text" autofocus placeholder="Search With Address & Zipcode" name="documentsaddress" value="" id="documentsaddress" class="address form-control">
							</div>
						</div>
						<div class="col-sm-6 ">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" id="documentsdate" title="Select Date" value="" name="documentsdate" value="" class="col-lg-10 form-control reservation documentsdate" placeholder="Search With Connected date">
							</div>
						</div>
						<div class="col-sm-6 ">
							<button type="submit" class="btn-u btn-block btn-u-dark"  name="searchdocuments"> Search </button>
						</div>
						<input type="hidden" name="documentid" id="documentid" value="">
					{!!Form::close()!!}
				</div>
				<div class="modal-body sky-form" id="append-Document-share-user-list">
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
	$('#open-Document-share').on('hidden.bs.modal', function () {
	    ($("#searchdocumentsshareuser")[0]).reset();
	});

	$("#uploadandshare").on('hidden.bs.modal', function () {
		($("#add-upload-all-type")[0]).reset();
		$("#uploadandshare").find(".error-text").html("");
	});
	
	$("#uploadshare-file").change(function () {
        var fileExtension = ['jpeg','jpg','png','pdf', 'doc','docx'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
           $("#uploadshare-error").text("Only formats are allowed : "+fileExtension.join(', '));
		    $('#submitDoc').prop('disabled', true);
			return false; 
        }
		 $('#submitDoc').prop('disabled', false);
    });
	$(function() {
		var start = moment().subtract(60, 'days');
    	var end = moment();
        $('#proposaldate,#documentsdate').daterangepicker({
         	 format: 'MM/DD/YYYY',
         	"opens": "left",
     	 	// "autoUpdateInput": false,
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
	var uploadshare_data = [];
	var shared_document_connected_user_list  = [];
	$( document ).ready(function() {
		/*add-upload-all-type*/
		$('#add-upload-all-type').submit(function(e){
			e.preventDefault();
			var $form = $(e.target),esmsg = $("#message-uploadandshare");
			$.ajax({
				url: "{{url('/')}}/uploadshare/insert",
				type: 'POST',
				data: new FormData(this),
				beforeSend: function(){$(".body-overlay").show();},
	    	    processData:false,
	    	    contentType: false,
				success: function(result) {	
					$(".body-overlay").hide();
					$('.error-text').text('');

					if(typeof result.error !='undefined' && result.error !=null){
					
					 	$.each( result.error, function( key, value ) {
						 	 $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value);
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
		    		// setInterval(function() {$(".body-overlay").hide(); },1000);
		    	}
			});
		});

		/* upload and share */
		$('.uploadandshare').click(function(e){
			e.preventDefault();
			$('#upload_viewer').attr('src','').addClass('hide');
			$('#uploadshare_id_update').val('');
		 	$('#uploadandshare').modal('show');
		});
		$('#loaduploadandshare').click(function(e){
			e.preventDefault();
			var limit = $(this).attr('title');
			loaduploadandshare(limit);
		});
		loaduploadandshare(0);
		$('#searchdocumentsshareuser').submit(function(e){
			e.preventDefault();
			shareuploadshare($('#documentid').val());
		});		
    });	

	/*load uploadandshare */
	function loaduploadandshare(limit) {

		$.ajax({
			url: "{{url('/')}}/uploadshare/get/ten/"+limit+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",
			type: 'get',
			beforeSend: function(){$(".loaduploadshare").show();},
    	    processData:false,
    	    contentType: false,
			success: function(result) {	
				$(".loaduploadshare").hide();
				// console.log(result);
				if(result.count !== 0){
					$.each( result.result, function( key, value ) {
						uploadshare_data[value.upload_share_id] = value;
						var extension = value.attachments.substr( (value.attachments.lastIndexOf('.') +1) );
							extension = extension.toLowerCase();
						var docs = '';
							if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){

								docs ='<img 		class="documen document_'+value.upload_share_id+'" src="'+value.attachments+'" frameborder="0" scrolling="no"  width="225" height="150"><h4>'+value.attachments.replace(/^.*[\\\/]/, '')+'</h4>';
							}else{
								docs ='<iframe 	class="documen document_'+value.upload_share_id+'" src="https://docs.google.com/viewer?url='+value.attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';
							}
							if(value.name != ''){
								var docName = value.name;
							}else{
								var completeUrl = value.attachments;
								var tempdocName = completeUrl.toString().match(/.*\/(.+?)\./);
								if (tempdocName && tempdocName.length > 1){
									var docName = tempdocName[1];
								}else{
									var docName = '';
								}
							}
							
						var htmll = '<div class="col-md-4">'+
										'<div class="thumbnails thumbnail-style thumbnail-kenburn">'+
											'<div class="cbp-caption thumbnail-img">'+
												'<div class="overflow-hidden cbp-caption-defaultWrap">'+docs+'</div>'+
												'<div class="removehover cbp-caption-activeWrap">'+
													'<div class="cbp-l-caption-alignCenter">'+
														'<div class="cbp-l-caption-body">'+
															'<ul class="link-captions no-bottom-space">'+
																'<li><a class="cursor" title="View" onclick="openuploadshare('+value.upload_share_id+')"><i class="rounded-x fa fa-eye"></i></a>'+
																'<li><a class="cursor" title="Share" onclick="shareuploadshare('+value.upload_share_id+')"><i class="rounded-x fa fa-share-alt"></i></a>'+
																'<li><a class="cursor" title="Remove" onclick="removeuploadshare('+value.upload_share_id+')"><i class="rounded-x fa fa-trash-o"></i></a>'+
															'</ul>'+

														'</div>'+

													'</div>'+	

												'</div>'+

											'</div> <span class="document-caption" style="  display: block;text-align: center;    background: #f2f2f2;padding: 3px 0;    font-size: 12px;letter-spacing: 1px;">'+docName+'</span>'+

										'</div>'+
									'</div>';
				 		$('#append-uploadshares-ajax').append(htmll);
				 		$("#documentNams").append('<option>'+value.attachments.replace(/^.*[\\\/]/, '')+'</option>');
					});
					if(result.next!=0){
						$('#loaduploadandshare').removeClass('hide').attr('title',result.next);
					}else{
						$('#loaduploadandshare').addClass('hide');
					}
				}
				
			},
		  	error: function(data) 
	    	{	$(".loaduploadshare").hide();
	    		if(data.status=='500'){
					$('.loaduploadshare').text(data.statusText).css({'color':'red'});
	    		}else if(data.status=='422'){
					$('.loaduploadshare').text(data.responseJSON.image[0]).css({'color':'red'});
	    		}
	    	}
		});
	}
	function openuploadshare(el) {
		var src = uploadshare_data[el].attachments;
		var extension = uploadshare_data[el].attachments.substr( (uploadshare_data[el].attachments.lastIndexOf('.') +1) );
			extension = extension.toLowerCase();
		var docs='';
		if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){
			docs ='<img 		class="documen document_uploadfiles_'+uploadshare_data[el].upload_share_id+'" src="'+uploadshare_data[el].attachments+'" frameborder="0" scrolling="no" width="100%" height="300">';
		}else{
			docs ='<iframe 	class="documen document_uploadfiles_'+uploadshare_data[el].upload_share_id+'" src="https://docs.google.com/viewer?url='+uploadshare_data[el].attachments+'&embedded=true" frameborder="0" scrolling="no" width="100%" height="300"></iframe>';
		}
		var hh = 	docs+
					'<div class="modal-footer">'+
						'<button type="button" class="btn-u btn-u-primary" onclick="uploadshare_Edit('+el+');" data-dismiss="modal">Edit</button>'+
						'<button type="button" class="btn-u btn-u-primary" onclick="removeuploadshare('+el+');" data-dismiss="modal">Delete</button>'+
						'<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>'+
					'</div>';
		$('.uploadshare-src-ifram').html(hh);
		$('#open-uploadshare-popup').modal('show');
	}
	function removeuploadshare(el) {
		var value = uploadshare_data[el];

		var extension = value.attachments.substr( (value.attachments.lastIndexOf('.') +1) );
			extension = extension.toLowerCase();
		var docs = '';
			if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){
				docs ='<img 		class="documen document_'+value.upload_share_id+'" src="'+value.attachments+'" frameborder="0" scrolling="no"  width="225" height="142">';
			}else{
				docs ='<iframe 	class="documen document_'+value.upload_share_id+'" src="https://docs.google.com/viewer?url='+value.attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';
			}
		$('.upload-popup-title').html('<p>Are you sure you want to remove from your Documents?</p> <br> '+docs);
		$('#uploadsharedeleteconfirm')
	        .modal({ backdrop: 'static', keyboard: false })
	        .one('click', '#delete', function (e) {
        
           	$.ajax({
				url: "{{url('/')}}/uploadshare/delete/"+el,
				type: 'get',
				beforeSend: function(){$(".body-overlay").show();},
	    	    processData:false,
				success: function(result) {	
					$(".body-overlay").hide();
					if(result.status=='error'){
						$('.upload-delete-msg').addClass('alert alert-danger text-center').text(result.msg);
					}else{
						$('.upload-delete-msg').addClass('alert alert-success text-center').text(result.msg);
					}
					setTimeout(location.reload(),7000);
				},error: function(data) {	$(".body-overlay").hide(); 	}
					
			});
        
        });

	}

	function shareuploadshare(id) {
		var praposaldata = uploadshare_data[id];
		$('#append-Document-share-user-list').html('');
		$('#open-Document-share').modal('show');
		
		$('#documentid').val(id);
		var keyword = $('#documentskeyword').val();			
		var address = $('#documentsaddress').val();		
		var date = $('#documentsdate').val();	

		$.ajax({
			url: "{{url('/')}}/shared/documents/with/connected/users/by/"+id+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",
			type: 'post',
			data: {date :date,keyword : keyword,address : address,_token : '{{ csrf_token() }}'},
			headers: {
			        'X-CSRF-TOKEN': '{{ csrf_token() }}'
			    },
			beforeSend: function(){$(".loadDocumentshare").show();},
			success: function(result) {	
				$(".loadDocumentshare").hide();
				if(result.count !== 0){
					$.each( result.result, function( index, value ) {
						shared_document_connected_user_list[value.details_id] = value;
						if(value.share_file.result != '' && value.share_file.result != null){
							var asrvfun ='<input type="checkbox" checked onclick="shareDocumentremove('+value.details_id+','+id+','+value.share_file.result.shared_id+')" name="Documente-checkox-'+value.details_id+'"><i class="o-p-a"></i>';
						}else{
							var asrvfun ='<input type="checkbox" onclick="shareDocument('+value.details_id+','+id+')"  name="Documente-checkox-'+value.details_id+'"><i class="n-p-a"></i>';
						} 
						var htmll = '<section><label class="checkbox" style="border-bottom: 1px solid #e6e6e6;">'+
										'<span class="Document_share_'+value.details_id+'_'+value.details_id_role_id+'">'+asrvfun+'</span>'+
										'<strong>'+value.name+'</strong>'+
										'<p>(<small>'+
										value.posttitle+
										'<small>)</p>'+
									'</label></section>';
				 		$('#append-Document-share-user-list').append(htmll);
					});
				}else{
					let no_records = `No Records Found`;
					$('#append-Document-share-user-list').html(no_records);
				}
				
			},
		  	error: function(data) 
	    	{	
	    		$(".loadDocumentshare").hide();
	    		if(data.status=='500'){
					$('#append-Document-share-user-list').text(data.statusText).css({'color':'red'});
	    		}else if(data.status=='422'){
					$('#append-Document-share-user-list').text(data.responseJSON.image[0]).css({'color':'red'});
	    		}
	    	}
		});
	}
	function shareDocument(userid,id) {
		var userdata = shared_document_connected_user_list[userid];
       	$.ajax({
			url: "{{url('/shared/data/insert')}}",
			type: 'post',
			data: {notification_type : 2,notification_message : '{{ $userdetails->name }} shared a Document related to your post `'+userdata.posttitle+'`' ,shared_type:2 ,shared_item_id:id,shared_item_type : 1,shared_item_type_id : userdata.post_id,receiver_id : userdata.details_id,receiver_role: userdata.details_id_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
			success: function(result) {	
				msgshowfewsecond('Document shared successfully');
				
				$('.Document_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" checked onclick="shareDocumentremove('+userid+','+id+','+result.data+')"  name="Documente-checkox-'+userdata.details_id+'"><i class="o-p-a"></i>');
			},error: function(result) {	
			}
		});  

	}
	function shareDocumentremove(userid,id,shared_id) {		
		var userdata = shared_document_connected_user_list[userid];
       	$.ajax({
			url: "{{url('/shared/data/delete')}}",
			type: 'post',
			data: { id : id, shared_id : shared_id, _token : '{{ csrf_token() }}' },
			success: function(result) {	
				msgshowfewsecond('Document removed successfully');
				$('.Document_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" onclick="shareDocument('+userid+','+id+')"  name="Documente-checkox-'+userdata.details_id+'"><i class="n-p-a"></i>');
			},error: function(result) {	
			}
		});    
	}
	function uploadshare_Edit(el) {
		$('#uploadshare_id_update').val(el);
	 	$('#uploadandshare').modal('show');
	}
	/* end */

</script> 
@stop