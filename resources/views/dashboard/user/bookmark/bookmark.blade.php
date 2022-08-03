@extends('dashboard.master')
@section('title', 'home page')
@section('content')
<?php  $topmenu='Home'; ?>
<?php $activemenu = 'Bookmark'; ?>
@include('dashboard.include.sidebar')

    <div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@if($user->agents_users_role_id==4)

			@include('dashboard.user.agents.include.sidebar')
			@include('dashboard.user.agents.include.sidebar-dashbord')
			
			@else

			@include('dashboard.user.buyers.include.sidebar')
			@include('dashboard.user.buyers.include.sidebar-dashbord')
			@endif
			
			<!--End Left Sidebar-->

			<!-- Profile Content -->
			<div class="col-md-9">
				<div class="box-shadow-profile margin-bottom-40">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left"> My Bookmarks </h2>
						</div>
						<div class="panel-body row" >							
							<div id="scrollbarbookmark" class="panel-body no-padding" data-mcs-theme="minimal-dark" ></div>
							<div class="text-center "><button type="button" class="btn-u text-center margin-top-10 hide" id="loadbookmark">Load More</button></div>
							<div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop bookmark-loader" width="40px" height="40px"/></div>
						</div>						
					</div>
					<!-- Default Proposals -->
				</div>				
			</div>
			<!-- End Profile Content -->
		</div>
	</div>	
	<!-- survey popup -->
	<div class="modal fade" id="deletefromnb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content not-top">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title-text"></h4>
					</div>
					<div class="modal-body">
						<br>
						<div class="body-overlay body-overlay-nb"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
						<p class="model-bodu-text">Are you sure remove?</p>
					</div>
					<div class="modal-footer foote-nb">
						<button type="button" class="btn-u btn-u-primary delete">Sure</button>
						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">No</button>
					</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script type="text/javascript">
	var bookmark_data  = [];
	$( document ).ready(function() {
		$('#loadbookmark').click(function(e){
			e.preventDefault();
			var limit = $(this).attr('title');
			loadbookmark(limit);
		});	
		loadbookmark(0);		
	});
	/*load Bookmark */
	function loadbookmark(limit) {
		if(limit==0){
			$('#scrollbarbookmark').html('');
		}
		$.ajax({
			url: "{{ url('/bookmarked/list/get/') }}/"+limit,
			type: 'get',
			beforeSend: function(){$(".bookmark-loader").show();},
    	    processData:false,
    	    contentType: false,
			success: function(result) {	
				$(".bookmark-loader").hide();
				if(result.count !== 0){
					$.each( result.result, function( key, value ) {
						bookmark_data[value.bookmark_id] = value;
						var usertype = '';
						var url='';
						if(value.bookmark_type == 1){
							usertype = '<strong>Question -> Post</strong> <span>('+value.post_text+')</span>';
							url = '{{ url("/search/$pagetype/details/") }}/'+value.bookmark_item_parent_id+'/8';
						}
						if(value.bookmark_type == 2){
							if(value.receiver_role==2){
								usertype = '<strong>Buyer -> Post </strong><span>('+value.post_text+')</span>';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.bookmark_item_parent_id;
							}
							if(value.receiver_role==3){
								usertype = '<strong>Seller -> Post </strong><span>('+value.post_text+')</span>';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.bookmark_item_parent_id;
							}
							if(value.receiver_role==4){
								usertype = '<strong>Agents -> Post </strong><span>('+value.post_text+')</span>';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.receiver_id+'/'+value.bookmark_item_parent_id;
							}
						}
						if(value.bookmark_type == 3){
							usertype = '<strong>Message</strong> ('+value.name+') -><strong> Post </strong><span>('+value.post_text+')</span>';
							url = '{{ url("/messages/") }}/'+value.post_id+'/'+value.message_id+'/'+value.message_role_id;
						}
						if(value.bookmark_type == 4){
							usertype = '<strong>Asked Question Answer -> Post </strong><span>('+value.post_text+')</span>';
							if(value.sender_role==4){
								url = '{{ url("/search/$pagetype/details/") }}/'+value.post_id+'/10';
							}else{
								url = '{{ url("/search/$pagetype/details/") }}/'+value.receiver_id+'/'+value.post_id+'/10';
							}
						}
						if(value.bookmark_type == 5){
							usertype = '<strong>Proposal </strong><span>('+value.post_text+')</span>';
							if(value.sender_role==4){
								url = '{{ url("/search/$pagetype/details/") }}/'+value.post_id+'/3';
							}else{
								url = '{{ url("/search/$pagetype/details/") }}/'+value.receiver_id+'/'+value.post_id+'/3';

							}
						}

						var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
						var bhtml = '<div class="profile-event border1-bottom" id="bookmark_id_'+value.bookmark_id+'">'+
										'<div class="width-90 profile-post-in">'+
											'<a class="cursor" onclick="redarecturl(\''+url+'\');" ><h3 class="heading-xs hidetext2line">'+usertype+'</h3></a>'+
											'<p><i class="fa fa-bookmark bookmarkquestion-icon"></i> ' +value.bookmark_text+' <span class=right"><i class="fa fa-clock-o"> </i> <small> '+date+'</small></span> </p>'+
										'</div>'+
										'<span class="width-10 profile-post-icon-remove" title="Remove bookmark from list" onclick="removebookmark('+value.bookmark_id+');" ><i class="fa  fa-trash"></i></span>'+
									'</div>';
			 			var msc = $('#bookmark_id_'+value.bookmark_id).find('#scrollbarbookmark');
				 		var msct = msc.prevObject.length;
				 		if(msct==0){
				 			if(limit==0){
	                        	$('#scrollbarbookmark').append(bhtml); 
	                    	}else{
	                        	$('#scrollbarbookmark').append(bhtml); 
	                    	}
	                    }else{
	                    	$('#bookmark_id_'+value.bookmark_id).replaceWith( bhtml );
	                    }
					});
					if(result.next!=0){
						$('#loadbookmark').removeClass('hide').attr('title',result.next);
					}else{
						$('#loadbookmark').addClass('hide');
					}
					
				}else{
					$('#scrollbarbookmark').html('<p class="profile-event">No bookmark available in list.</p>');
				}
				
			},
		  	error: function(data) 
	    	{	$("#scrollbarbookmark").hide();
	    		if(data.status=='500'){
					$('#scrollbarbookmark').text(data.statusText).css({'color':'red'});
	    		}else if(data.status=='422'){
					$('#scrollbarbookmark').text(data.responseJSON.image[0]).css({'color':'red'});
	    		}
    				// setInterval(function() { },1000);
	    	}
		});
	}
	/*load notes */
	function removebookmark(id) {
		$('.model-bodu-text').removeClass('alert alert-success alert-danger text-center').text('Are you sure this bookmark remove in bookmark list?');
		$('.modal-title-text').text('Note');
		$('.foote-nb').show();
		$('#deletefromnb')
	        .modal({ backdrop: 'static', keyboard: false })
	        .one('click', '.delete', function (e) {
	           	$.ajax({
					url: "{{url('/bookmarked/delete/by/')}}/"+id,
					type: 'get',
					beforeSend: function(){$('.foote-nb').hide(); $(".body-overlay-nb").show();},
					success: function(result) {	
						$(".body-overlay-nb").hide();
						$('.model-bodu-text').addClass('alert alert-success text-center').text('Removed from bookmarks.');
						$('#bookmark_id_'+id).remove();
						anymodelhideinfewsecond('#deletefromnb');
						loadbookmark(0);
					},error: function(data) {	$(".body-overlay-nb").hide(); 	}
				});        
        });
	}
</script> 
@stop