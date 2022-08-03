@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
<style type="text/css">
	.mCustomScrollBox {
		overflow-y: scroll !important;
	}
</style>
@stop
@section('title', 'Connected Jobs')
@section('content')
<?php  $topmenu='Home'; ?>
<?php $activemenu = 'connectedpost'; ?>
@include('dashboard.include.sidebar')
<!--=== Profile ===-->
    <div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@include('dashboard.user.agents.include.sidebar')
			<!--End Left Sidebar-->
				<!-- Profile Content -->
			<div class="col-md-12">
				<h2><b>Connected Jobs</b>(My Active Jobs)</h2>
				<div class="box-shadow-profile ">
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							
 							<label class="radio-inline">
						      <input type="radio" name="user_type" checked value="">All
						    </label>
						    <label class="radio-inline">
						      <input type="radio" name="user_type" value="3">Seller
						    </label>
						    <label class="radio-inline">
						      <input type="radio" name="user_type" value="2">Buyer
						    </label>
						   
						
						</div>
						<div>	
							<div class="append-aplied-post-data" id="append-aplied-post-data"></div>
							<div id="loadappliedpost" class="col-md-12 center loder loadappliedpost"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
							<button type="button" id="loaduploadandshare" class="hide btn-u btn-u-default btn-u-sm btn-block">Load More</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End Profile Content -->			
		</div>
	</div>	
	

@endsection

@section('scripts')
<script type="text/javascript">

	var appliedpost_data 	= [];
	$( document ).ready(function() {

		$('#loaduploadandshare').click(function(e){
			e.preventDefault();
			var limit = $(this).attr('title');
			loadappliedpost(limit);
		});
		loadappliedpost(0);
	});

	$("[name='user_type']").on('change', function(){
		$('#loadappliedpost').html('');
		$('#loadappliedpost').html('<img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px" id="post_loader_img"/>');
		loadappliedpost(0);
	});

	/*load aonnected post data list*/
	function loadappliedpost(limit) {
		var user_type = $("[name='user_type']:checked").val();
		$.ajax({
			url: "{{ url('/applied/post/list/get/') }}/"+limit+"/{{ $user->id }}/{{ $user->agents_users_role_id }}/1/"+user_type,
			//url: "{{url('/applied/post/list/get/')}}/"+limit+"/{{ $user->id }}/{{ $user->agents_users_role_id }}/2",
			type: 'get',
			beforeSend: function(){ $(".loadappliedpost").show(); },
    	    processData:true,
			success: function(result) {	
				
				console.log(result);
				var postdata   = result;
				
				$(".loadappliedpost").hide();
				if(postdata.count !== 0){
					if(limit==0){
						$('#append-aplied-post-data').html('');
					}
					$.each( postdata.result, function( key, value ) {
						 
						appliedpost_data[value.post_id] = value;
						var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
						var close_date = 'Not updated yet';
						if(value.post_close_date != null) {
							// close_date = timeDifference(new Date(), new Date(Date.fromISO(value.post_close_date)));
							close_date = new Date(Date.fromISO(value.post_close_date)).toISOString().slice(0,10);

							// var todayDate = new Date().toISOString().slice(0,10);
						}
						var htmll = '<div class="border1-bottom" id="post_list_data_'+value.post_id+'">'+
										'<div class="funny-boxes acpost" onlick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'\')">'+
											'<h2 class="title margin-bottom-20"><a target="_blank" href="{{ URL("/") }}/search/post/details/'+value.post_id+'">'+value.posttitle+'</a></h2>'+
											'<div class="funny-boxes-img">'+
												'<ul class="list-inline ">'+
													'<li><strong>Posted By: </strong> '+value.name+' </li> - '+
													'<li><strong> Posted <i class="fa fa-clock-o"></i>: </strong> '+date+' </li>'+
												'</ul>'+
											'</div>';
											if(value.details){
												htmll +='<div onclick="redarecturl(\'{{ URL("/") }}/search/post/details/'+value.post_id+'\')" class="limited-post-text hidetext2line margin-bottom-10" title="'+value.details+'">'+
															value.details
														+'</div>';
											}
										htmll +='<ul class="list-inline">'+
													'<li><a class="cursor" target="_blank" href="{{ URL("/") }}/search/post/details/'+value.post_id+'"> View Post </a></li>'+
													'<li><a>, '+value.post_view_count+' Active Agents </a></li>'+
													'<li><a class="cursor" onclick="register_popup('+value.post_id+','+value.agents_user_id+','+value.agents_users_role_id+');">, New Message  '+value.message_notificatio.count+'</a></li>'+
													'<li><a rel="popover" data-popover-content="#myPopover'+value.connection_id+'">, New Notification '+value.notificatio.count+'</a></li>'+
													'<li><a href="#">, Closing Date : '+close_date+'</a></li>'+
												'</ul>'+
										'</div>'+

										'<div id="myPopover'+value.connection_id+'" class="hide">'+
									      '<div class="panel panel-profile">'+
											
											'<div class="panel-heading overflow-h border1-bottom">'+
												'<h2 class="panel-title heading-sm pull-left color-black"><i class="fa fa-users"></i> '+value.name+' Notifications</h2>'+
											'</div>'+
											
											'<div id="scrollbar" class="panel-body no-padding mCustomScrollbar" data-mcs-theme="minimal-dark">';
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
															'<p class="hidetext2line">'+agentdata.notification_message+'</p>'+
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
				 		$('#append-aplied-post-data').append(htmll);
					});
					if(postdata.next!=0){
						$('#loaduploadandshare').removeClass('hide').attr('title',postdata.next);
					}else{
						$('#loaduploadandshare').addClass('hide');
					}
				}else{
					$('#append-aplied-post-data').html('<h2 style="padding: 20px;text-align: center;"> Line up your next big post!<a href="{{ URL("/post") }}">Start searching now.</a> </h2>');
				}
				$(function(){
				    $('[rel="popover"]').popover({
				        container: 'body',
				        html: true,
				    //    trigger: 'manual',
				        animation:true,
				        content: function () {
				            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
				            return clone;
				        }
				    }).click(function(e) {
				        e.preventDefault();
				        var $popover = $(this);
				        //$popover.popover('show');
				    });
				});
				
			},
		  	error: function(data) 
	    	{	$(".loadappliedpost").hide();
	    		if(data.status=='500'){
					$('.append-aplied-post-data').text(data.statusText).css({'color':'red'});
	    		}else if(data.status=='422'){
					$('.append-aplied-post-data').text(data.responseJSON.image[0]).css({'color':'red'});
	    		}
	    	}
		});
	}
</script>
@stop