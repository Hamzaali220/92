@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/messages.css') }}"><style>
.unreadCountStatus{	
	background-color: #72c02c;
	/* height: 10px; */
	border-radius: 20px;
	position: absolute;
	top: -7px;
}
.fa-eye,.fa-eye-slash{
	font-size: 13px;
    color: #7266ba;
    margin-left: 6px;
}
</style>
@stop
@section('title', 'Messaging')
@section('content')
<?php  $topmenu='messages'; ?>
@include('dashboard.include.sidebar')
	<div class="breadcrumbs breadcrumbs1 no-border" style="    margin-top: 14px;">
		<div class="col-md-2 min-height-54 col-sm-12 text-center border1-bottom ">
			<h1 class="color-black text-25">Inbox</h1>
		</div>
		<div class="col-md-10 min-height-54 col-sm-12 border-left padding-6 text-center border-bottom">
			<div class="name1"></div>
            <div class="mood1"></div>
		</div>

		<!--Left Sidebar-->
		<div class="col-md-2 col-sm-12 margin-top-20 sidebox">
			<ul class="list-group message-index-list-ul" id="sidebar-nav-1">
				<li class="list-group-item  no-border">
					<a class="nav-link nesusersignup" id="inbox"><i class="fa fa-inbox"></i> Inbox <span id="unreadinbox"> </span></a>
				</li>
				<li class="list-group-item no-border">
					<a class="nav-link nesusersignup" id="sent"><i class="fa fa-rocket"></i> Sent</a>
				</li>
			<!-- 	<li class="list-group-item no-border">
					<a class="nav-link nesusersignup" id="important"><i class="fa fa-bookmark"></i> Important</a>
				</li> -->
			</ul>
		</div>
		<!--End Left Sidebar-->

		<!-- Profile Content -->
		<div class="col-md-10 col-sm-12 border-left ">
			<div class="">
				<div class="row row-broken">
			        <div class="col-md-9 col-sm-12  border-right whaite-bg" style="overflow: hidden; outline: none; min-height: 501px;" tabindex="5001">
			          
			          <div class="col-inside-lg chat convertion_list decor-default style-6" data-mcs-theme="minimal-dark" >
			           
			            <div class="chat-body chat-users">
			             
                			<div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop usermessageslistloader1" width="40px" height="40px"/></div>
											No Messages Available
		            	 	<div class="conversation_users_messages_list" id="conversation_users_messages_list">					                	
			                </div>
	                		<input type="hidden" name="nextloadconvertionlist" value="" class="nextloadconvertionlist">
			            </div>

			          </div>
			          <div class="col-inside-lg chat messages_list decor-default style-6" data-mcs-theme="minimal-dark" >
			           
			            <div class="chat-body chat-users">
			             
                			<div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop usermessageslistloader" width="40px" height="40px"/></div>
		            	 	<div class="conversation_messages_list" id="conversation_messages_list">
			                </div>
	                		<input type="hidden" name="nextloadmessageslist" value="" class="nextloadmessageslist">
			            </div>

			          </div>
			          	<div class="row border-top hide" id="answer-add" style="position: relative;">
							<div class="answer-add" >
								<form class="" action="#" id="send-message">
					                <textarea placeholder="Write a message" id="answer-add-textarea" spellcheck="true" style="position: relative; z-index: 2;" autocomplete="off"></textarea>
					                <span class="answer-btn answer-btn-2"><a href="#"><i class=""></i></a></span>
					                <input type="hidden" name="conversationid" value="" id="conversationid">
								</form>
			              	</div>
						</div>
			        </div>
			        <div class="site-bg col-md-3 col-sm-12" style="padding: 0px;overflow: hidden; outline: none; min-height: 501px;" tabindex="5001">
			          <div class="chat style-6" data-mcs-theme="minimal-dark" style="overflow: hidden; outline: none;" tabindex="5000">
			            <div class="chat-users">
			                <div class="conversation_users_list margin-top-10" id="conversation_users_list">
			                </div>
	                		<div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop userlistloader" width="20px" height="20px"/></div>
			                <input type="hidden" name="nextloadconvlist" value="" class="nextloadconvlist">
			            </div>
			          </div>
			        </div>

					<!--End Profile Post-->
				</div><!--/end row-->
				
			</div>
		</div>
		<!-- End Profile Content -->

	</div>

		


@endsection
@section('scripts')
<script type="text/javascript">
	localStorage.clear();
	var allconversation 		= 	[]; var allmessages = []; var oldate = '';
	var currentconvertionrun 	= 	'';
	var answer_form 			= 	$('#answer-add'),name1 = $('.name1'),mood1 = $('.mood1'),conversationid = $('#conversationid');
	var ccappend 				= 	$(".conversation_users_messages_list"), ccloder = $('.usermessageslistloader1'), ccnext = $('.nextloadconvertionlist');
	var mmappend 				= 	$(".conversation_messages_list"), mmloder = $('.usermessageslistloader'), mmnext = $('.nextloadmessageslist');
	var setlisttype 			= 	'';
	let loadMoreInterval 		= "";
	(function() {
		chngecla('convertion_list');
		unreadinbox();
		loaconversation(0,'yes');


		$('#inbox').click(function(e) {		
			setlisttype = 'inbox';	
			chngecla('convertion_list'),actione();
			window.history.pushState('data',"Title", '{{ url("/messages") }}');
			loaconversation(0);
		});
		$('#sent').click(function(e) {
			setlisttype = 'send';	
			chngecla('convertion_list'),actione();
			window.history.pushState('data',"Title", '{{ url("/messages") }}');
			loadsendedconversation(0);
		});
		$('#important').click(function(e) {
			setlisttype = 'inbox';	
			chngecla('convertion_list'),actione();
			loaconversation(0);
		});
		

		$(".chat-body").on("click", ".conversation_users_messages_list .newcovasation", function(e){
			
			chngecla('messages_list');
			answer_form.removeClass('hide');
			var convertionid = $(this).attr('id');
			var id = (convertionid.split("_"))[2];
			currentconvertionrun = id;
			conversationid.val(id);
			var ccdata = allconversation[id];
			let history_url = '{{ url("/messages/") }}/'+ccdata.post_id+'/'+ccdata.user_id+'/'+ccdata.agents_users_role_id;
			window.location.href = history_url;
			/*
			window.history.pushState('data',"Title", history_url);
			addrightdiv(ccdata);
	      	readupdate(id);
			loadconversationmessages(0,id);
			*/
		});

		
	 	$('#send-message').keypress(function(e){
	        if(e.which == 13){
	            e.preventDefault();
	            var answer = e.currentTarget[0].value;
	            var c_id   = e.currentTarget[1].value;
	            var ccdata = allconversation[c_id];
	            
				var ucode = new Date().getTime();
				var photo =  '{{ $userdetails->photo }}' != '' ?  '{{ url("/assets/img/profile/") }}/{{ $userdetails->photo }}' : '{{ url("/assets/img/testimonials/user.jpg") }}';
				$('#answer-add-textarea').val('');
				var esmsg = $('#c_m_id_'+ucode+'');
				var htmll ='';
				if(typeof answer !=="undefined" && answer !== null && answer !="" ){
				htmll = '<div class="answer right c_m_id_'+ucode+'" id="c_m_id_'+ucode+'">'+
				            
				                '<span class="moreicon1_right"><span class="_2rvp toolmodelopen" id="toolmodelopen_'+ucode+'"></span></span>'+

				                '<div class="uiContextualLayer uiContextualmessages toolmodelopen_'+ucode+'">'+
								    '<div class="_5v-0 _53ik">'+
								        '<div class="_53ij">'+
								            '<div>'+
								                '<ul class="_hw3">'+
								                	'<li class="_hw4 bookmark_messages_data_'+ucode+'">'+
						                   			'</li>'+
						                   			'<li class="_hw4 margin-left-10" id="appendrating_'+ucode+'"> </li>'+
						                   			'<li class="_hw4 margin-left-10" id="appendnotes_'+ucode+'"> </li>'+
								                '</ul>'+
								            '</div>'+
								        '</div>'+
								        '<i class="_53io"></i>'+
								        '<a class="accessible_elem layer_close_elem" href="#" role="button" tabindex="0">Close popup and return</a>'+
								    '</div>'+
								'</div>'+
				            
				                '<div class="avatar">'+
				                  '<img src="'+photo+'" alt="{{ $userdetails->name }}" width="40" height="40">'+
				                  '<div class="status "></div>'+
				                '</div>'+
				            
				                '<div class="text">'+answer+' <img src="{{ url("/assets/img/loder/loading.gif") }}" width="15px" height="15px" class="mCS_img_loaded messageloader posi-left hide messageloader_'+ucode+'"></div>'+
				            
				                '<div class="time">few s ago</div>'+
				            
				            	'</div>';
		 		}
		 		// mmappend.append(htmll);
		 		$('.messages_list').scrollTop($('.messages_list')[0].scrollHeight);	
				$.ajax({
					url: "{{url('/insert/new/messages')}}",
					type: 'POST',
					data: {	name:'{{ $userdetails->name }}',message_text:answer,receiver_id: ccdata.user_id,receiver_role: ccdata.agents_users_role_id,sender_id: '{{ $user->id }}',sender_role: '{{ $user->agents_users_role_id }}',post_id: ccdata.post_id,conversation_id: c_id,is_user : ccdata.is_user,_token : '{{ csrf_token() }}' },
					beforeSend: function(){$(".messageloader_"+ucode).show();},
					success: function(response) {	
						$(".messageloader_"+ucode).hide();
						if(response.status == 'success'){
						
							var data = response.data;
							allmessages[data.messages_id] = data;
	                        $('#c_m_id_'+ucode+'').addClass('c_m_id_'+data.messages_id).attr('id','c_m_id_'+data.messages_id).removeClass('c_m_id_'+ucode); 
							
							$('.messageloader_'+ucode).removeClass('messageloader_'+ucode).addClass('messageloader_'+data.messages_id);
	                    	
	                    	$('#toolmodelopen_'+ucode).attr('id','toolmodelopen_'+data.messages_id);
	                    	
	                    	$('.toolmodelopen_'+ucode).addClass('toolmodelopen_'+data.messages_id).removeClass('toolmodelopen_'+ucode);
							
							var htmll ='<a class="_hw5" onclick="messages_add_bookmark_list('+data.messages_id+','+c_id+',\'message\');"><i  data-toggle="tooltip" data-original-title="Bookmark" class="tooltips fa fa-bookmark-o book_question_'+data.messages_id+'"></i></a>';
							$('.bookmark_messages_data_'+ucode).html(htmll).addClass('bookmark_messages_data_'+data.messages_id).removeClass('bookmark_messages_data_'+ucode);

							if('{{ $user->agents_users_role_id }}' != 4){
								$('#appendrating_'+ucode).html('<a class="_hw5" onclick="setratinginmessage(\'message\','+data.messages_id+','+c_id+');"> <i  data-toggle="tooltip" data-original-title="Rating" class="tooltips fa fa-star"></i> </a> ');
							}

							var htmll ='<a class="_hw5" onclick="setnotesinmessage(\'chat\','+data.messages_id+','+c_id+');"> <i  data-toggle="tooltip" data-original-title="Note" class="tooltips fa fa-commenting"></i> </a>';
	                    	$('#appendnotes_'+ucode).html(htmll);

	                    }else{
	                    
	                        $('#c_m_id_'+ucode+'').html('some issue').css('color','red');
	                        $('#answer-add-textarea').val(answer);
	                        setInterval(function() { $('#c_m_id_'+ucode+'').remove(); },5000);	                    
	                    }
									            	
					},
				  	error: function(data) 
			    	{	
			    		if(data.status=='500'){
							$('#c_m_id_'+ucode+'').text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');
			    		}else if(data.status=='422'){
							$('#c_m_id_'+ucode+'').text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');
			    		}
			    		setInterval(function() { $('#c_m_id_'+ucode+'').remove(); },5000);
			    	}
				});
				readupdate(c_id);

	        }
	    });

		

    })();

    /* unread count get and show*/
    function unreadinbox() {
		$.ajax({
			url: "{{url('/')}}/messageslist/get/unread",
			type: 'get',
			success: function(result) {	
				if(result.unreadusercount != 'undefined' && result.unreadusercount != null){
					$('#unreadinbox').html('<span class="badge badge-danger">'+result.unreadusercount+'</span>');
				}else{
					$('#unreadinbox').html('');
				}
			},
		  	error: function(data) 
	    	{	
	    		
	    	}
		});
    }

	// display unread/read option under message
	// unreadSign(){
	// // 	$.ajax({
	// // 		url: "{{url('/')}}/messageslist/get/unread",
	// // 		type: 'get',
	// // 		success: function(result) {	
	// // 			if(result.unreadusercount != 'undefined' && result.unreadusercount != null){
	// // 				$('#unreadinbox').html('<span class="badge badge-danger">'+result.unreadusercount+'</span>');
	// // 			}else{
	// // 				$('#unreadinbox').html('');
	// // 			}
	// // 		},
	// // 	  	error: function(data) 
	// //     	{	
	    		
	// //     	}
	// // 	});
	// }

    /*load uploadandshare */
    function loaconversation(limit,indexx) {
		$.ajax({
			url: "{{url('/')}}/messageslist/get/conversation/"+limit,
			type: 'post',
			data: {sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
			beforeSend: function(){ ccloder.show(); },
			success: function(result) {	
				ccloder.hide();
				if(result.count !== 0){
					
					$.each( result.result, function( key, value ) {
						allconversation[value.conversation_id] = value;
						var unread = '';
						if(value.tags_user_id == '{{ $user->id }}'){
							unread = '<div class="unread unreadCountStatus badge badge-danger">'+value.unread_count+'</div>';
						}
						if(value.login_status=='Online'){
							var login_status = 'online';
						}else{
							var login_status = 'offline';//last active '+timeDifference(new Date(), new Date(value.last_login_time));
						}
						
							if(loadMoreInterval != ""){
								clearInterval(loadMoreInterval);
							}

							loadMoreInterval = setInterval(()=>{
								loadNewMsg(0,value.conversation_id);
							},2000);

						if('{{ @$conversation_id }}' == value.conversation_id && indexx == 'yes'){
							chngecla('messages_list');
							answer_form.removeClass('hide');
							currentconvertionrun = value.conversation_id;
							conversationid.val(value.conversation_id);
							var ccdata = allconversation[value.conversation_id];
							addrightdiv(ccdata);
					      	readupdate(value.conversation_id);
							loadconversationmessages(0,value.conversation_id);
							
							

							return false;
						}else{
    					var date = timeDifference(new Date(), new Date(Date.fromISO(value.updated_at)));
						var photo = value.photo != null ?  '{{ url("/assets/img/profile/") }}/'+value.photo : '{{ url("/assets/img/testimonials/user.jpg") }}';						var htmll ='';
						htmll = '<div title="'+value.name+'" class="user newcovasation conversation_id_'+value.conversation_id+'" id="conversation_id_'+value.conversation_id+'">'+
					                    '<div class="avatar">'+
					                    '<img src="'+photo+'" width="40" height="40" alt="User name">';
										htmll += '<span class="unread_'+value.conversation_id+'"> '+unread+'</span>';
					                    htmll += '<div class="status '+login_status+' status_class_'+value.conversation_id+'"></div>'+
					                    '</div>'+
					                    '<div class="name">'+value.name+' <small class="text-9" title="post">('+value.posttitle+')</small> <span class="lastsine">'+date+'</span> </div>'+
					                    '<div class="mood">'+value.snippet+'<img src="{{ url("/assets/img/loder/loading.gif") }}" width="15px" height="15px" class="mCS_img_loaded messageloader hide posi-left conversationloader_'+value.conversation_id+'"></div></div>'+
					                '</div>';
				 		var msc = $('#conversation_id_'+value.conversation_id).find('.conversation_users_messages_list');
				 		var msct = msc.prevObject.length;
				 		if(msct==0){
	                        ccappend.append(htmll); 
						}
						
						}						
					});
					if(result.next!=0){
						ccnext.val(result.next);
					}else{
						ccnext.val('');
					}
					if(limit==0){
		                $('.convertion_list').scroll(function(){
		                	var infiniteList = $('#convertion_list');
					      	if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight') && ccnext.val() != 0) {
					      		loaconversation(ccnext.val());
					      	}
		                    
		                });
					}

					
				}
				
			},
		  	error: function(data) 
	    	{	
	    		if(data.status=='500'){
					ccappend.text(data.statusText).addClass('red');
	    		}else if(data.status=='422'){
					ccappend.text(data.responseJSON.image[0]).addClass('red');
	    		}
    				setInterval(function() { ccappend.html('').removeClass('red'); },1000);
	    	}
		});
	}

	/*load sended conversation*/
    function loadsendedconversation(limit) {
		$.ajax({
			url: "{{url('/')}}/messageslist/get/sended/"+limit,
			type: 'get',
			beforeSend: function(){ ccloder.show(); },
			success: function(result) {	
				ccloder.hide();
				
				if(result.count !== 0){
					
					$.each( result.result, function( key, value ) {
						
	                    if(value.is_user=='sender'){
							var date = timeDifference(new Date(), new Date(Date.fromISO(value.last_sender_da)));
	                    	var snippet = value.last_sender_msg;
	                    }else{
	                    	var snippet = value.last_receiver_msg;
							var date = timeDifference(new Date(), new Date(Date.fromISO(value.last_receiver_da)));
	                    }
	                    if(value.login_status=='Online'){
							var login_status = 'online';
						}else{
							var login_status = 'offline';//last active '+timeDifference(new Date(), new Date(value.last_login_time));
						}
						var photo = value.photo != null ?  '{{ url("/assets/img/profile/") }}/'+value.photo : '{{ url("/assets/img/testimonials/user.jpg") }}';
						var htmll = '<div title="'+value.name+'" class="user newcovasation conversation_id_'+value.conversation_id+'" id="conversation_id_'+value.conversation_id+'">'+
					                    '<div class="avatar">'+
					                    '<img src="'+photo+'" width="40" height="40" alt="User name">'+
					                    '<div class="status '+login_status+' status_class_'+value.conversation_id+'"></div>'+
					                    '</div>'+
					                    '<div class="name">'+value.name+' <small class="text-9" title="post">('+value.posttitle+')</small> <span class="lastsine">'+date+'</span> </div>'+
					                    '<div class="mood">'+snippet+
					                    '<img src="{{ url("/assets/img/loder/loading.gif") }}" width="15px" height="15px" class="mCS_img_loaded messageloader hide posi-left conversationloader_'+value.conversation_id+'"></div></div>'+
					                '</div>';
				 		var msc = $('#conversation_id_'+value.conversation_id).find('.conversation_users_messages_list');
				 		var msct = msc.prevObject.length;
				 		if(msct==0){
	                        ccappend.append(htmll); 
	                    }
					});
					if(result.next!=0){
						ccnext.val(result.next);
					}else{
						ccnext.val('');
					}
					if(limit==0){
		                $('.convertion_list').scroll(function(valu){
		                    var infiniteList = $('#convertion_list');
					      	if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight') && ccnext.val() != 0) {
					      			if(setlisttype=='send'){
			                        loadsendedconversation(ccnext.val());
		                       	}
					      	}
		                });
					}
				}
				
			},
		  	error: function(data) 
	    	{	
	    		if(data.status=='500'){
					ccappend.text(data.statusText).addClass('red');
	    		}else if(data.status=='422'){
					ccappend.text(data.responseJSON.image[0]).addClass('red');
	    		}	
    				setInterval(function() { ccappend.html('').removeClass('red'); },1000);
	    	}
		});
	}
	/*load uploadandshare */
    function loadconversationmessages(limit,conversation_id) {

		$.ajax({
			url: "{{url('/')}}/messageslist/get/conversation/messages/"+limit,
			type: 'post',
			data: {bookmark : 'bookmark',conversation_id : conversation_id, sender_id: '{{ $user->id }}', sender_role : '{{ $user->agents_users_role_id }}', _token : '{{ csrf_token() }}'},
			beforeSend: function(){ mmloder.show(); },
			success: function(result) {
				var resultt = result[0];
				var bookmarkdd = result[1];
				var ratting = result[2];
				mmloder.hide();
				if(resultt.count !== 0){
					$.each( resultt.result, function( key, value ) {
						
						allmessages[value.messages_id] = value;
						var userclass = '';
						let read_or_not = "";
		                if(value.sender_id == '{{ $user->id }}' && value.sender_role == '{{ $user->agents_users_role_id }}'){		                
							userclass = 'right';
							if(value.tags_read == 1){ // for unread
								read_or_not = " <i class='fa fa-eye-slash'></i>";
							}else if(value.tags_read == 2){
								read_or_not = " <i class='fa fa-eye'></i>";
							}
		                }else{
		                	userclass = 'left';                
		                }
		               
		               	var rating1 = '';
						var ratingset = 0;
						var rclasid ='';
						if(ratting[value.messages_id] !=null && ratting[value.messages_id] != 'undefined' && ratting[value.messages_id] !=''){

							var rat = ratting[value.messages_id];
						 	ratingset = rat.rating;
							rclasid = value.messages_id;
							rating1 = 	'<div id="ratinganswer_'+rclasid+'" class="rating-show-only messaginrating">'+
                       
					                        '<input class="stars" disabled type="radio"  id="star5_'+rclasid+'"  value="5" />'+
					                        '<label class = "full " data-original-title="Awesome " data-placement="top" for="star5_'+rclasid+'" title="Awesome"></label>'+
					                       
					                        '<input class="stars" disabled type="radio" id="star4_5_'+rclasid+'"  value="4_5" />'+
					                        '<label class="half " data-original-title="Pretty good " data-placement="top" for="star4_5_'+rclasid+'" title="Pretty good"></label>'+
					                       
					                        '<input class="stars" disabled type="radio" id="star4_'+rclasid+'"  value="4" />'+
					                        '<label class = "full " data-original-title="Pretty good " data-placement="top" for="star4_'+rclasid+'" title="Pretty good"></label>'+
					                       
					                        '<input class="stars" disabled type="radio" id="star3_5_'+rclasid+'"  value="3_5" />'+
					                        '<label class="half " data-original-title="Meh " data-placement="top" for="star3_5_'+rclasid+'" title="Meh"></label>'+
					                       
					                        '<input class="stars" disabled type="radio" id="star3_'+rclasid+'"  value="3" />'+
					                        '<label class = "full " data-original-title="Meh " data-placement="top" for="star3_'+rclasid+'" title="Meh"></label>'+
					                       
					                        '<input class="stars" disabled type="radio" id="star2_5_'+rclasid+'"  value="2_5" />'+
					                        '<label class="half " data-original-title="Kinda bad " data-placement="top" for="star2_5_'+rclasid+'" title="Kinda bad "></label>'+
					                       
					                        '<input class="stars" disabled type="radio" id="star2_'+rclasid+'"  value="2" />'+
					                        '<label class = "full " data-original-title="Kinda bad " data-placement="top" for="star2_'+rclasid+'" title="Kinda bad"></label>'+
					                       
					                        '<input class="stars" disabled type="radio" id="star1_5_'+rclasid+'"  value="1_5" />'+
					                        '<label class="half " data-original-title="Meh " data-placement="top" for="star1_5_'+rclasid+'" title="Meh"></label>'+
					                       
					                        '<input class="stars" disabled type="radio" id="star1_'+rclasid+'"  value="1" />'+
					                        '<label class = "full " data-original-title="Sucks big time " data-placement="top" for="star1_'+rclasid+'" title="Sucks big time"></label>'+
					                       
					                        '<input class="stars" disabled type="radio"  id="star0_5_'+rclasid+'"  value="0_5" />'+
					                        '<label class="half " data-original-title="Sucks big time " data-placement="top" for="star0_5_'+rclasid+'" title="Sucks big time"></label>'+
					                    '</div>';
		                    
						}

    					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
						var photo =  value.photo != null ?  '{{ url("/assets/img/profile/") }}/'+value.photo : '{{ url("/assets/img/testimonials/user.jpg") }}';
						var htmll='';
						if(typeof value.message_text !=="undefined" && value.message_text !== null && value.message_text !="" ){
						htmll = '<div class="answer '+userclass+' c_m_id_'+value.messages_id+'" id="c_m_id_'+value.messages_id+'">'+
						                
						                '<span class="moreicon1_'+userclass+'"><span class="_2rvp toolmodelopen" id="toolmodelopen_'+value.messages_id+'"></span></span>'+

						                '<div class="uiContextualLayer uiContextualmessages toolmodelopen_'+value.messages_id+'">'+
										    '<div class="_5v-0 _53ik">'+
										        '<div class="_53ij">'+
										            '<div>'+
										                '<ul class="_hw3">'+
										                	'<li class="_hw4 bookmark_messages_data_'+value.messages_id+'" >';
										                    	if(bookmarkdd[value.messages_id]){
											                		var book = bookmarkdd[value.messages_id];
								                				 	htmll +='<a class="_hw5" onclick="messages_remove_bookmark_list('+value.messages_id+','+value.conversation_id+','+book.bookmark_id+',\'message\');"><i  data-toggle="tooltip" data-original-title="Bookmarked " class="tooltips fa fa-bookmark book_question_'+value.messages_id+'"></i></a>';
											                	}else{
								                				 	htmll +='<a class="_hw5" onclick="messages_add_bookmark_list('+value.messages_id+','+value.conversation_id+',\'message\');"><i  data-toggle="tooltip" data-original-title="Bookmark" class="tooltips fa fa-bookmark-o book_question_'+value.messages_id+'"></i></a>';
											                	}
								                    htmll +='</li>';
								                	 		if('{{ $user->agents_users_role_id }}' != 4){
								                	 			htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setratinginmessage(\'message\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Rating" class="tooltips fa fa-star"></i> </a> </li>';
								                	 		}
								                	 		htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setnotesinmessage(\'message\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Note" class="tooltips fa fa-commenting"></i> </a> </li>';
								                htmll +='</ul>'+
										            '</div>'+
										        '</div>'+
										        '<i class="_53io"></i>'+
										        '<a class="accessible_elem layer_close_elem" href="#" role="button" tabindex="0">Close popup and return</a>'+
										    '</div>'+
										'</div>'+
						                
						                '<div class="avatar">'+
						                  '<img src="'+photo+'" width="40" height="40" alt="'+value.name+'">'+
						                  '<div class="status "></div>'+
						                '</div>'+
						                '<div class="text">'+value.message_text+' '+rating1+'<img src="{{ url("/assets/img/loder/loading.gif") }}" width="15px" height="15px" class="mCS_img_loaded messageloader posi-left hide messageloader_'+value.messages_id+'"></div>'+
						                '<div class="time">'+date+read_or_not+'</div>'+
						            '</div>';
						}
			            var msc = $('#c_m_id_'+value.messages_id).find('.conversation_messages_list');
				 		var msct = msc.prevObject.length;
				 		if(msct==0){
	                        mmappend.prepend(htmll); 
	                    }else{
	                    	$('#c_m_id_'+value.messages_id).replaceWith( htmll );
	                    }
	                    if(ratingset !=0){
	                    	$('#star'+ratingset+'_'+value.messages_id).attr("checked", "checked");
	                    }
					});
					if(resultt.next!=0){
						mmnext.val(resultt.next);
		                $('.messages_list').scroll(function(valu){
							
		                    if ($('.messages_list').scrollTop() == '0' && mmnext.val() != 0){
								let btn = `<button onclick='loadconversationmessages(${mmnext.val()},${conversation_id})' class="btn-u">Load old chat</button>`;
								if($('.messages_list').find("#load_chat_btn").length == 0){
									let load_more_btn = `<div id="load_chat_btn" class="center">${btn}</div>`;
									$(load_more_btn).insertBefore("#conversation_messages_list");
									
								}else{
									$('.messages_list').find("#load_chat_btn").html(btn);
								}
								// loadconversationmessages(mmnext.val(),conversation_id)
		                    }
		                });
		                if(limit!=0){
							
		                	$('.messages_list').scrollTop(200);
		            	}
					}else{
						$('.messages_list').find("#load_chat_btn").remove();
						mmnext.val('');
					}
					if(limit==0){
						$('.messages_list').scrollTop($('.messages_list')[0].scrollHeight);
					}
				}else{
				 	mmappend.html('<center>You are now connected on Messenger.</center>'); 
				}
				
			},
		  	error: function(data) 
	    	{	
	    		if(data.status=='500'){
					mmappend.text(data.statusText).addClass('red');
	    		}else if(data.status=='422'){
					mmappend.text(data.responseJSON.image[0]).addClass('red');
	    		}
    				setInterval(function() { mmappend.html('').removeClass('red'); },1000);
	    	}
		});

	}

	/*load uploadandshare */
    function loadNewMsg(limit,conversation_id) {
		
		$.ajax({
			url: "{{url('/')}}/messageslist/get/conversation/messages/"+limit,
			type: 'post',
			data: {bookmark : 'bookmark',conversation_id : conversation_id, sender_id: '{{ $user->id }}', sender_role : '{{ $user->agents_users_role_id }}', _token : '{{ csrf_token() }}'},
			success: function(result) {
				var resultt = result[0];
				var bookmarkdd = result[1];
				var ratting = result[2];
				mmloder.hide();
				if(resultt.count !== 0){
					$.each( resultt.result, function( key, value ) {
						
						allmessages[value.messages_id] = value;
						var userclass = '';
						let read_or_not = "";
						if(value.sender_id == '{{ $user->id }}' && value.sender_role == '{{ $user->agents_users_role_id }}'){		                
							userclass = 'right';
							if(value.tags_read == 1){ // for unread
								read_or_not = " <i class='fa fa-eye-slash'></i>";
							}else if(value.tags_read == 2){
								read_or_not = " <i class='fa fa-eye'></i>";
							}
						}else{
							userclass = 'left';		                
						}
					
						var rating1 = '';
						var ratingset = 0;
						var rclasid ='';
						if(ratting[value.messages_id] !=null && ratting[value.messages_id] != 'undefined' && ratting[value.messages_id] !=''){

							var rat = ratting[value.messages_id];
							ratingset = rat.rating;
							rclasid = value.messages_id;
							rating1 = 	'<div id="ratinganswer_'+rclasid+'" class="rating-show-only messaginrating">'+
					
											'<input class="stars" disabled type="radio"  id="star5_'+rclasid+'"  value="5" />'+
											'<label class = "full " data-original-title="Awesome " data-placement="top" for="star5_'+rclasid+'" title="Awesome"></label>'+
										
											'<input class="stars" disabled type="radio" id="star4_5_'+rclasid+'"  value="4_5" />'+
											'<label class="half " data-original-title="Pretty good " data-placement="top" for="star4_5_'+rclasid+'" title="Pretty good"></label>'+
										
											'<input class="stars" disabled type="radio" id="star4_'+rclasid+'"  value="4" />'+
											'<label class = "full " data-original-title="Pretty good " data-placement="top" for="star4_'+rclasid+'" title="Pretty good"></label>'+
										
											'<input class="stars" disabled type="radio" id="star3_5_'+rclasid+'"  value="3_5" />'+
											'<label class="half " data-original-title="Meh " data-placement="top" for="star3_5_'+rclasid+'" title="Meh"></label>'+
										
											'<input class="stars" disabled type="radio" id="star3_'+rclasid+'"  value="3" />'+
											'<label class = "full " data-original-title="Meh " data-placement="top" for="star3_'+rclasid+'" title="Meh"></label>'+
										
											'<input class="stars" disabled type="radio" id="star2_5_'+rclasid+'"  value="2_5" />'+
											'<label class="half " data-original-title="Kinda bad " data-placement="top" for="star2_5_'+rclasid+'" title="Kinda bad "></label>'+
										
											'<input class="stars" disabled type="radio" id="star2_'+rclasid+'"  value="2" />'+
											'<label class = "full " data-original-title="Kinda bad " data-placement="top" for="star2_'+rclasid+'" title="Kinda bad"></label>'+
										
											'<input class="stars" disabled type="radio" id="star1_5_'+rclasid+'"  value="1_5" />'+
											'<label class="half " data-original-title="Meh " data-placement="top" for="star1_5_'+rclasid+'" title="Meh"></label>'+
										
											'<input class="stars" disabled type="radio" id="star1_'+rclasid+'"  value="1" />'+
											'<label class = "full " data-original-title="Sucks big time " data-placement="top" for="star1_'+rclasid+'" title="Sucks big time"></label>'+
										
											'<input class="stars" disabled type="radio"  id="star0_5_'+rclasid+'"  value="0_5" />'+
											'<label class="half " data-original-title="Sucks big time " data-placement="top" for="star0_5_'+rclasid+'" title="Sucks big time"></label>'+
										'</div>';
							
						}


						var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
						var photo =  value.photo != null ?  '{{ url("/assets/img/profile/") }}/'+value.photo : '{{ url("/assets/img/testimonials/user.jpg") }}';
						var htmll='';
						if(typeof value.message_text !=="undefined" && value.message_text !== null && value.message_text !="" ){
						htmll = '<div class="answer '+userclass+' c_m_id_'+value.messages_id+'" id="c_m_id_'+value.messages_id+'">'+
										
										'<span class="moreicon1_'+userclass+'"><span class="_2rvp toolmodelopen" id="toolmodelopen_'+value.messages_id+'"></span></span>'+

										'<div class="uiContextualLayer uiContextualmessages toolmodelopen_'+value.messages_id+'">'+
											'<div class="_5v-0 _53ik">'+
												'<div class="_53ij">'+
													'<div>'+
														'<ul class="_hw3">'+
															'<li class="_hw4 bookmark_messages_data_'+value.messages_id+'" >';
																if(bookmarkdd[value.messages_id]){
																	var book = bookmarkdd[value.messages_id];
																	htmll +='<a class="_hw5" onclick="messages_remove_bookmark_list('+value.messages_id+','+value.conversation_id+','+book.bookmark_id+',\'message\');"><i  data-toggle="tooltip" data-original-title="Bookmarked " class="tooltips fa fa-bookmark book_question_'+value.messages_id+'"></i></a>';
																}else{
																	htmll +='<a class="_hw5" onclick="messages_add_bookmark_list('+value.messages_id+','+value.conversation_id+',\'message\');"><i  data-toggle="tooltip" data-original-title="Bookmark" class="tooltips fa fa-bookmark-o book_question_'+value.messages_id+'"></i></a>';
																}
													htmll +='</li>';
															if('{{ $user->agents_users_role_id }}' != 4){
																htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setratinginmessage(\'message\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Rating" class="tooltips fa fa-star"></i> </a> </li>';
															}
															htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setnotesinmessage(\'message\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Note" class="tooltips fa fa-commenting"></i> </a> </li>';
												htmll +='</ul>'+
													'</div>'+
												'</div>'+
												'<i class="_53io"></i>'+
												'<a class="accessible_elem layer_close_elem" href="#" role="button" tabindex="0">Close popup and return</a>'+
											'</div>'+
										'</div>'+
										
										'<div class="avatar">'+
										'<img src="'+photo+'" width="40" height="40" alt="'+value.name+'">'+
										'<div class="status "></div>'+
										'</div>'+
										'<div class="text">'+value.message_text+' '+rating1+'<img src="{{ url("/assets/img/loder/loading.gif") }}" width="15px" height="15px" class="mCS_img_loaded messageloader posi-left hide messageloader_'+value.messages_id+'"></div>'+
										'<div class="time">'+date+read_or_not+'</div>'+
									'</div>';
						}
						var msc = $('#c_m_id_'+value.messages_id).find('.conversation_messages_list');
						var msct = msc.prevObject.length;
						if(msct==0){
							mmappend.append(htmll); 
							if(htmll.length !== 0){
								$(".messages_list").animate({ scrollTop: $('.messages_list').prop("scrollHeight")}, 1000);
							}
						}	
					});
					
				}
			},
			error: function(data) 
			{	
				window.location.reload();

				if(data.status=='500'){
					mmappend.text(data.statusText).addClass('red');
				}else if(data.status=='422'){
					mmappend.text(data.responseJSON.image[0]).addClass('red');
				}
				setInterval(function() { mmappend.html('').removeClass('red'); },1000);
			}
		});

	}
	/*messages load cron */
    function messagecron(responseuser) {
    	// console.log(responseuser);
    	unreadinbox();
    	var ccdata = responseuser.result[0];
		if(ccdata.login_status=='Online'){
			var login_status = ccdata.login_status;
			$('.status_class_'+ccdata.conversation_id).text('');
		}else{
			var login_status = 'last active '+timeDifference(new Date(), new Date(Date.fromISO(ccdata.last_login_time)));
			$('.status_class_'+ccdata.conversation_id).text('');
		}		//console.log(ccdata);
		$('.unread_'+ccdata.conversation_id).html('<div class="unread unreadCountStatus badge badge-danger">'+ccdata.unread_count+'</div>');
    	if(currentconvertionrun !=''){

			mood1.text(login_status);
			$('.status_'+ccdata.conversation_id).text(login_status);
			$.ajax({
				url: "{{url('/')}}/messageslist/get/conversation/messages/0",
				type: 'post',
				data: {conversation_id : currentconvertionrun, sender_id: '{{ $user->id }}', sender_role : '{{ $user->agents_users_role_id }}', _token : '{{ csrf_token() }}'},
				success: function(result) {
				var resultt = result[0];
				var bookmarkdd = result[1];	
				var ratting = result[2];
					if(resultt.count !== 0){
						$.each( resultt.result, function( key, value ) {
							
							allmessages[value.messages_id] = value;
							var userclass = '';
							let read_or_not = "";
			                if(value.sender_id == '{{ $user->id }}' && value.sender_role == '{{ $user->agents_users_role_id }}'){
								userclass = 'right';
								if(value.tags_read == 1){ // for unread
									read_or_not = " <i class='fa fa-eye-slash'></i>";
								}else if(value.tags_read == 2){
									read_or_not = " <i class='fa fa-eye'></i>";
								}
			                }else{
			                	userclass = 'left';			                
			                }
			                var rating1 = '';
							var ratingset = 0;
							if(ratting[value.messages_id] !=null && ratting[value.messages_id] != 'undefined' && ratting[value.messages_id] !=''){

								var rat = ratting[value.messages_id];
							 	ratingset = rat.rating;
								var rclasid = value.messages_id;
								rating1 = 	'<div id="ratinganswer_'+rclasid+'" class="rating-show-only messaginrating">'+
	                       
						                        '<input class="stars" disabled type="radio"  id="star5_'+rclasid+'"  value="5" />'+
						                        '<label class = "full " data-original-title="Awesome " data-placement="top" for="star5_'+rclasid+'" title="Awesome"></label>'+
						                       
						                        '<input class="stars" disabled type="radio" id="star4_5_'+rclasid+'"  value="4_5" />'+
						                        '<label class="half " data-original-title="Pretty good " data-placement="top" for="star4_5_'+rclasid+'" title="Pretty good"></label>'+
						                       
						                        '<input class="stars" disabled type="radio" id="star4_'+rclasid+'"  value="4" />'+
						                        '<label class = "full " data-original-title="Pretty good " data-placement="top" for="star4_'+rclasid+'" title="Pretty good"></label>'+
						                       
						                        '<input class="stars" disabled type="radio" id="star3_5_'+rclasid+'"  value="3_5" />'+
						                        '<label class="half " data-original-title="Meh " data-placement="top" for="star3_5_'+rclasid+'" title="Meh"></label>'+
						                       
						                        '<input class="stars" disabled type="radio" id="star3_'+rclasid+'"  value="3" />'+
						                        '<label class = "full " data-original-title="Meh " data-placement="top" for="star3_'+rclasid+'" title="Meh"></label>'+
						                       
						                        '<input class="stars" disabled type="radio" id="star2_5_'+rclasid+'"  value="2_5" />'+
						                        '<label class="half " data-original-title="Kinda bad " data-placement="top" for="star2_5_'+rclasid+'" title="Kinda bad "></label>'+
						                       
						                        '<input class="stars" disabled type="radio" id="star2_'+rclasid+'"  value="2" />'+
						                        '<label class = "full " data-original-title="Kinda bad " data-placement="top" for="star2_'+rclasid+'" title="Kinda bad"></label>'+
						                       
						                        '<input class="stars" disabled type="radio" id="star1_5_'+rclasid+'"  value="1_5" />'+
						                        '<label class="half " data-original-title="Meh " data-placement="top" for="star1_5_'+rclasid+'" title="Meh"></label>'+
						                       
						                        '<input class="stars" disabled type="radio" id="star1_'+rclasid+'"  value="1" />'+
						                        '<label class = "full " data-original-title="Sucks big time " data-placement="top" for="star1_'+rclasid+'" title="Sucks big time"></label>'+
						                       
						                        '<input class="stars" disabled type="radio"  id="star0_5_'+rclasid+'"  value="0_5" />'+
						                        '<label class="half " data-original-title="Sucks big time " data-placement="top" for="star0_5_'+rclasid+'" title="Sucks big time"></label>'+
						                    '</div>';
			                    
							}
	    					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
							var photo =  value.photo != null ?  '{{ url("/assets/img/profile/") }}/'+value.photo : '{{ url("/assets/img/testimonials/user.jpg") }}';

							var htmll = '<div class="answer '+userclass+' c_m_id_'+value.messages_id+'" id="c_m_id_'+value.messages_id+'">'+
							                
							                '<span class="moreicon1_'+userclass+'"><span class="_2rvp toolmodelopen" id="toolmodelopen_'+value.messages_id+'"></span></span>'+

							                '<div class="uiContextualLayer uiContextualmessages toolmodelopen_'+value.messages_id+'">'+
											    '<div class="_5v-0 _53ik">'+
											        '<div class="_53ij">'+
											            '<div>'+
											                '<ul class="_hw3">'+
											                	'<li class="_hw4 bookmark_messages_data_'+value.messages_id+'">';
											                    	if(bookmarkdd[value.messages_id]){
												                		var book = bookmarkdd[value.messages_id];
									                				 	htmll +='<a class="_hw5" onclick="messages_remove_bookmark_list('+value.messages_id+','+value.conversation_id+','+book.bookmark_id+',\'message\');"><i  data-toggle="tooltip" data-original-title="Bookmarked " class="tooltips fa fa-bookmark book_question_'+value.messages_id+'"></i></a>';
												                	}else{
									                				 	htmll +='<a class="_hw5" onclick="messages_add_bookmark_list('+value.messages_id+','+value.conversation_id+',\'message\');"><i  data-toggle="tooltip" data-original-title="Bookmark" class="tooltips fa fa-bookmark-o book_question_'+value.messages_id+'"></i></a>';
												                	}
									                    htmll +='</li>';
									                	 		if('{{ $user->agents_users_role_id }}' != 4){
									                	 			htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setratinginmessage(\'message\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Rating" class="tooltips fa fa-star"></i> </a> </li>';
									                	 		}
									                	 		htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setnotesinmessage(\'message\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Note" class="tooltips fa fa-commenting"></i> </a> </li>';
									                htmll +='</ul>'+
											            '</div>'+
											        '</div>'+
											        '<i class="_53io"></i>'+
											        '<a class="accessible_elem layer_close_elem" href="#" role="button" tabindex="0">Close popup and return</a>'+
											    '</div>'+
											'</div>'+
							                
							                '<div class="avatar">'+
							                  '<img src="'+photo+'" width="40" height="40" alt="'+value.name+'">'+
							                  '<div class="status "></div>'+
							                '</div>'+
							                
							                '<div class="text">'+value.message_text+' '+rating1+'<img src="{{ url("/assets/img/loder/loading.gif") }}" width="15px" height="15px" class="mCS_img_loaded messageloader posi-left hide messageloader_'+value.messages_id+'"></div>'+
							                '<div class="time">'+date+read_or_not+'</div>'+
							            '</div>';
				            var msc = $('#c_m_id_'+value.messages_id).find('.conversation_messages_list');
					 		var msct = msc.prevObject.length;
					 		if(msct==0){
		                        mmappend.append(htmll); 
		                    }else{
		                    	$('#c_m_id_'+value.messages_id).replaceWith( htmll );
		                    }
	                        if(ratingset !=0){
		                    	$('#star'+ratingset+'_'+value.messages_id).attr("checked", "checked");
		                    }
						});
					}
					
				},
			  	error: function(data) {
		    		window.location.reload();
		    	}
			});
		}

	}

	
	function chngecla(clas) {
		$('.convertion_list , .messages_list').hide();
		$('.'+clas).show();
	}
	function actione() {
		unreadinbox();
		$('#conversation_users_list').html('');
		$('.nextloadconvmessageslist').val('');
		name1.text('');
		mood1.text('');
		answer_form.addClass('hide');
		currentconvertionrun = '';
		conversationid.val('');
		ccappend.html('');
		ccnext.val('');
		mmappend.html('');
		mmnext.val('');

	}
	function addrightdiv(ccdata) {
		if(ccdata.login_status=='Online'){
			var login_status = ccdata.login_status;
		}else{
			var login_status = 'last active '+timeDifference(new Date(), new Date(Date.fromISO(ccdata.last_login_time)));
		}
		name1.text(ccdata.name);
		mood1.text(login_status);
		var photo = ccdata.photo != null ?  '{{ url("/assets/img/profile/") }}/'+ccdata.photo : '{{ url("/assets/img/testimonials/user.jpg") }}';
		var uurl = '{{ $user->agents_users_role_id }}'=='4' ? '{{ URL("/") }}/search/post/details/'+ccdata.post_id+'' : '{{ URL("/") }}/search/agents/details/'+ccdata.user_id+'/'+ccdata.post_id+'' ;
		var postdetails = '<div class="user border1-bottom">'+
			                    '<div class="avatar">'+
			                    	'<img src="'+photo+'" alt="'+ccdata.name+'" width="40" height="40">'+
			                    '</div>'+
			                    '<div class="name"><a target="_blank" href="'+uurl+'">'+ccdata.name+'</a></div>'+
			                    '<div class="mood"><span class="status_'+ccdata.conversation_id+'">'+login_status+' </span></div>'+
			                '</div>'+
			                '<div class="optiondetails">'+
			                	'<h4 class="_1lj0"><strong>Post : '+ccdata.posttitle+'</strong></h4>'+
			                	'<span>'+((ccdata.details !== null)?ccdata.details:"")+'</span>'+
			                '</div>';
      	$('#conversation_users_list').html(postdetails);          
	}
    function readupdate(cid) {
		var ccdata = allconversation[cid];
		$.ajax({
			url: "{{url('/')}}/read/update/messages",
			type: 'post',
			data: {cid: cid,_token : '{{ csrf_token() }}'},
			success: function(result) {	
				unreadinbox();
			},
		  	error: function(data) 
	    	{	
	    		
	    	}
		});
		readnotificationbyreciverid(ccdata.user_id,ccdata.agents_users_role_id,'{{ $user->id }}','{{ $user->agents_users_role_id }}',6);
		readnotificationbyreciverid(ccdata.user_id,ccdata.agents_users_role_id,'{{ $user->id }}','{{ $user->agents_users_role_id }}',7);
	}
</script> 
@stop