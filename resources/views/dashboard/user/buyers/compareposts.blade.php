@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
@stop
@section('title', 'Profile')
@section('content')
<?php  $topmenu='my_post'; ?>
<?php $activemenu = 'compareposts'; ?>
@include('dashboard.include.sidebar')
<!--=== Profile ===-->
    <div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@include('dashboard.user.buyers.include.sidebar')
			<!--End Left Sidebar-->

			<!-- Profile Content -->
			<div class="col-md-12">
				<h2><b>Select Post to Compare</b></h2>
				<div class="box-shadow-profile ">
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left"> Posts </h2>
						</div>
						<div class="" >	
							<div class="loadredirectcompare body-overlay" style="display: none;"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"></div></div>
							<div class="postappend"></div>
							<div id="loaduploadshare" class="col-md-12 center loder loaduploadshare"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
							<div class="text-center"><button type="button" id="loaduploadandshare" class="hide btn-u btn-u-default btn-u-sm ">Load More</button></div>
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
	var postdata = [];
	(function() {
		$('input[name="interested_short_sale"]').on('change',function(e) {
			// console($(this).val());
		});
		loadpostlimit(0);
	 	/* post  */
	 	$('#loaduploadandshare').click(function(e){
			e.preventDefault();
			var limit = $(this).attr('title');
			loadpostlimit(limit);
		});
	})();
	/*load loadpostlimit */
	function loadpostlimit(limit) {

		$.ajax({
			url: "{{url('/')}}/profile/buyer/post/get/"+limit,
			type: 'POST',
			data: { agents_user_id : '{{ $user->id }}',agents_users_role_id : '{{ $user->agents_users_role_id }}',selectedpost : '2',_token : '{{ csrf_token() }}'},
			beforeSend: function(){ $(".loaduploadshare").show(); },
			success: function(result) {	
				$(".loaduploadshare").hide();
				// console.log(result);
				if(result.count !== 0){
					if(limit==0){
						$('.postappend').html('');
					}
					$.each( result.result, function( key, value ) {
						postdata[value.post_id] = value;
						var date = timeDifference(new Date(), new Date(value.created_at));
						var htm = '<div class="border1-bottom">'+
										'<div class="funny-boxes acpost">'+
											'<h2 class="title margin-bottom-20"><a target="_blank" onclick="comapretoselecteagents(\''+value.post_id+'\');">'+value.posttitle+'</a></h2>'+
											'<div class="funny-boxes-img">'+
												'<ul class="list-inline">'+
													'<li><strong>  <i class="fa-fw fa fa-map-marker"></i>  </strong> '+(value.address1 !=null ? value.address1 : '' )+'  '+(value.city_name !=null ? value.city_name : '' )+' '+(value.state_name !=null ? value.state_name : '' )+'  '+(value.zip!=null ? value.zip : '' )+' '+(value.area!=null ? value.area : '' )+' </li> - '+
													'<li><strong> Posted <i class="fa fa-clock-o"></i>: </strong> '+date+' </li>'+
												'</ul>'+
											'</div>';
											if(value.details){
												htm +='<div class="limited-post-text hidetext2line margin-bottom-10" title="'+value.details+'">'+
															value.details
														+'</div>';
											}
									htm +='<ul class="list-inline margin-top-20 margin-bottom-0">'+
												'<li><a class="cursor" target="_blank" onclick="comapretoselecteagents('+value.post_id+');"><b>Details</b></a></li> , '+
												'<li><a rel="popover" data-popover-content="#myPopover'+value.post_id+'">'+value.post_view_count+' Agents Applied </a></li>'+
											'</ul>'+
										'</div>'+

										'<div id="myPopover'+value.post_id+'" class="hide">'+
									      '<div class="panel panel-profile">'+
											
											'<div class="panel-heading overflow-h border1-bottom">'+
												'<h2 class="panel-title heading-sm pull-left color-black"><i class="fa fa-users"></i> Active Agents</h2>'+
											'</div>'+
											
											'<div id="postagentshowinpopup" class="panel-body no-padding " data-mcs-theme="minimal-dark">';
									if(value.post_view_count != 0)	{
										$.each( value.connected_agent_list, function( key, agentdata ) {
											var adate = timeDifference(new Date(), new Date(Date.fromISO(agentdata.created_at)));
											if(agentdata.photo){
												var photo = '<img class="rounded-x" src="{{ URL::asset("assets/img/profile/") }}/'+agentdata.photo+'">';
											}else{
												var photo = '<img class="rounded-x" src="{{ URL::asset("assets/img/testimonials/user.jpg") }}" alt="">';
											}
											var selectedclass = '';
											var title='';
											if(value.applied_post == 1 && value.applied_user_id == agentdata.details_id){
												selectedclass = 'agents_selected';
												title = 'Selected this agents for post ( '+value.posttitle+' )';
											}
											htm +='	<div onclick="onclickagent('+agentdata.details_id+','+value.post_id+');" title="'+title+'" class="'+selectedclass+' cursor alert-blocks alert-dismissable">'+photo+
														'<div class="overflow-h">'+
															'<strong class="color">'+agentdata.name+' <small class="pull-right" style="margin-left: 20px;"><em>'+adate+'</em></small></strong>'+
															'<div class="hidetext1line">'+(agentdata.description!=null ? agentdata.description : '&nbsp;' )+'</div>'+
														'</div>'+
													'</div>';
										});
									}

									htm += '</div>'+

										  '</div>'+

									    '</div>'+

									'</div>';
						$('.postappend').append(htm);
					});
					$(function(){
					    $('[rel="popover"]').popover({
					        container: 'body',
					        html: true,
					       // trigger: 'manual',
					        animation:true,
					        content: function () {
					            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
					            return clone;
					        }
					    }).click(function(e) {
					        e.preventDefault();
					        var $popover = $(this);
					      //  $popover.popover('show');
					    });
					});
					if(result.next != 0){
						$('#loaduploadandshare').attr('title',result.next).addClass('show').removeClass('hide');
					}else{
						$('#loaduploadandshare').addClass('hide').removeClass('show');
					}
				}else{
					$('.postappend').html('<h2 style="padding: 20px;text-align: center;"> No agent is connected to you. <a href="{{ URL("/agents") }}"> Find.</a> </h2>');
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
	function comapretoselecteagents(post_id) {
		var postdata1 = postdata[post_id];
		$.ajax({
			url: "{{url('/')}}/profile/buyer/post/details/agents/get/few/"+post_id+"/"+postdata1.agents_user_id +"/"+postdata1.agents_users_role_id,
			type: 'get',
			beforeSend: function(){$(".loadredirectcompare").show();},
    	    processData:true,
			success: function(result) {	
				console.log(result);
				var proppos   = result;
				$(".loadredirectcompare").hide();
				if(proppos.count !== 0){
					$.each( proppos.result, function( key, value ) {
						$.ajax({
							url: "{{url('/compare/insert')}}",
							type: 'post',
							data: {post_id : post_id ,compare_item_id : value.id, _token : '{{ csrf_token() }}'},
							success: function(result) {	
							},error: function(result) {	
							}
						});  
					});
				}
				window.location.href = '{{ URL("/") }}/profile/buyer/post/details/'+post_id+'/compare';
			},
		  	error: function(data) 
	    	{	
	    	}
		});
	}
	/* end */
	function onclickagent(d,p) {
		window.location.href = '{{ URL("/") }}/search/agents/details/'+d+'/'+p;
	}
</script> 
@stop