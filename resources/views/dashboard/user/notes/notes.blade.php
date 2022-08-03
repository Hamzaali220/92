@extends('dashboard.master')
@section('title', 'home page')
@section('content')
<?php  $topmenu='Home'; ?>
<?php $activemenu = 'Notes'; ?>
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
							<h2 class="heading-sm pull-left"> My Notes </h2>
						</div>
						<div class="panel-body row" >							
							<div id="scrollbar10" class="panel-body no-padding " data-mcs-theme="minimal-dark"></div>
							<div class="text-center "><button type="button" class="btn-u text-center margin-top-10 hide" id="loadnotes">Load More</button></div>
							<div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop notes-loader" width="40px" height="40px"/></div>
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
	var notes_data = [];
	$( document ).ready(function() {
		$('#loadnotes').click(function(e){
			e.preventDefault();
			var limit = $(this).attr('title');
			loadnotes(limit);
		});	
		loadnotes(0);	
	});
	/*load notes */
	function loadnotes(limit) {
		if(limit==0){
			$('#scrollbar10').html('');
		}
		$.ajax({
			url: "{{ url('/notes/list/get/') }}/"+limit,
			type: 'get',
			beforeSend: function(){$(".notes-loader").show();},
    	    processData:false,
    	    contentType: false,
			success: function(result) {	
				$(".notes-loader").hide();
				if(result.count !== 0){
					$.each( result.result, function( index, value ) {
						notes_data[value.notes_id] = value;
						var usertype = '';
						var url='';
						if(value.notes_type == 1){
							usertype = 'Message';
							url = '{{ url("/messages/") }}/'+value.post_id+'/'+value.receiver_id+'/'+value.receiver_role;
						}
						if(value.notes_type == 2){
							if(value.sender_role==4){
								usertype = 'Asked Question';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.post_id+'/8';
							}else{
								usertype = 'Asked Question';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.receiver_id+'/'+value.post_id+'/1';
							}
						}
						if(value.notes_type == 3){
							if(value.sender_role==4){
								usertype = 'Asked Question Answer';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.post_id+'/10';
							}else{
								usertype = 'Asked Question Answer';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.receiver_id+'/'+value.post_id+'/10';
							}
						}
						if(value.notes_type == 4){
							if(value.sender_role==4){
								usertype = 'Proposal';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.post_id+'/3';
							}else{
								usertype = 'Proposal';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.receiver_id+'/'+value.post_id+'/3';

							}
						}
						if(value.notes_type == 5){
							if(value.sender_role==4){
								if(value.receiver_role==2){
									usertype = 'Buyer';
									url = '{{ url("/search/$pagetype/details/") }}/'+value.post_id;
								}else{
									
									usertype = 'Seller';
									url = '{{ url("/search/$pagetype/details/") }}/'+value.post_id;
								}
							}else{
								usertype = 'Agent';
								url = '{{ url("/search/$pagetype/details/") }}/'+value.receiver_id+'/'+value.post_id;
							}
						}
						var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
						var bhtml = '<div class="profile-post border1-bottom" id="notes_id_'+value.notes_id+'">'+
										'<span class="width-5 profile-post-numb">'+(index+1)+'</span>'+
										'<div class="width-85 profile-post-in">'+
											'<h3 class="heading-xs hidetext2line"><a class="cursor" onclick="redarecturl(\''+url+'\');"><strong>'+usertype+'</strong> ('+value.notes_type_text+') <strong>Post</strong> ('+value.post_text+')</a></h3>'+
											'<div class="texteditp"> <strong class="float-left "> Note : </strong> <div class="float-left margin-left-right-5"> '+value.notes+'</div> <span class=""><i class="fa fa-clock-o"> </i> <small> '+date+'</small></span> </div>'+
										'</div>'+
									'</div>';
			 			var msc = $('#notes_id_'+value.notes_id).find('#scrollbar10');
				 		var msct = msc.prevObject.length;
				 		if(msct==0){
				 			if(limit==0){
	                        	$('#scrollbar10').append(bhtml); 
	                    	}else{
	                        	$('#scrollbar10').append(bhtml); 
	                    	}
	                    }else{
	                    	$('#notes_id_'+value.notes_id).replaceWith( bhtml );
	                    }
					});
					if(result.next!=0){
						$('#loadnotes').removeClass('hide').attr('title',result.next);
					}else{
						$('#loadnotes').addClass('hide');
					}
				}else{
					$('#scrollbar10').html('<p class="profile-event">No notes available in list.</p>');
				}
				
			},
		  	error: function(data) 
	    	{	$("#scrollbar10").hide();
	    		if(data.status=='500'){
					$('#scrollbar10').text(data.statusText).css({'color':'red'});
	    		}else if(data.status=='422'){
					$('#scrollbar10').text(data.responseJSON.image[0]).css({'color':'red'});
	    		}
    				// setInterval(function() { },1000);
	    	}
		});
	}
	function removenotes(id) {
		$('.model-bodu-text').removeClass('alert alert-success alert-danger text-center').text('Are you sure, you want to delete this note?');
		$('.modal-title-text').text('Note');
		$('.foote-nb').show();
		$('#deletefromnb')
	        .modal({ backdrop: 'static', keyboard: false })
	        .one('click', '.delete', function (e) {
	           	$.ajax({
					url: "{{url('/notes/delete/by/')}}/"+id,
					type: 'get',
					beforeSend: function(){$('.foote-nb').hide(); $(".body-overlay-nb").show();},
					success: function(result) {	
						$(".body-overlay-nb").hide();
						$('.model-bodu-text').addClass('alert alert-success text-center').text('Removed from note.');
						$('#notes_id_'+id).remove();
						anymodelhideinfewsecond('#deletefromnb');
						loadnotes(0);		
					},error: function(data) {	$(".body-overlay-nb").hide(); 	}
				});        
        });
	}
</script> 
@stop