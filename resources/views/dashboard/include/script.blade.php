<!--test1-->
	<div id="snackbar">Some text some message..</div>
	<div class="modal fade bs-example-modal-sm" id="set-messages-rating" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" style="display: grid;">
			<div class="modal-content not-top">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title set-messages-rating-title"></h4>
				</div>
				<div class="modal-body">
					<div id="set-messages-rating-loader" class="col-md-12 center loder set-messages-rating-loader"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
					<div class="set-messages-rating-body"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade bs-example-modal-md" id="set-messages-notes" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" style="display: grid;">
			<div class="modal-content not-top sky-form">
				<div id="set-messages-notes-loader" class="body-overlay col-md-12 center loder set-messages-notes-loader"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title set-messages-notes-title"></h4>
				</div>
				<div class="modal-body">
					<div class="set-messages-notes-body">
						<p class="notes-msg-text green"></p>

						<div class="row">
						<div class="col-md-12">
							<label class="label"> Enter Your Note</label>
							<label class="textarea1">
								<textarea rows="5" class="field-border jqte-test" name="notes_textarea" id="notes_textarea" placeholder="Enter Notes"></textarea>
								<b class="error-text" id="notes_textarea_error"></b>
							</label>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer" id="notes-message-form-footer">

				</div>
			</div>
		</div>
	</div>


	<!--script type="text/javascript" src="{!! asset('/js/app.js') !!}" charset="utf-8"></script-->
	<script>
    	(function () {
	        window.Laravel = {!! json_encode([
			    'csrfToken' => csrf_token(),
			    'user' 		=> Auth::user(),
			    'pusherKey' => '7e6e48eadd13bff5b388',
			    'segment' 	=> Request::segment(1),
			  ]) !!};
	    })();

	</script>
	<!-- JS Implementing Plugins -->
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery/jquery-migrate.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/back-to-top.js') }}"></script>
	<!-- <script type="text/javascript" src="{{ URL::asset('assets/plugins/smoothScroll.js') }}"></script> -->
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/counter/waypoints.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/counter/jquery.counterup.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery.parallax.js') }}"></script>

	<!-- JS Customization -->
	<script type="text/javascript" src="{{ URL::asset('/assets/js/custom.js') }}"></script>
	<!-- JS Page Level -->
	<script type="text/javascript" src="{{ URL::asset('assets/js/app.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/formvalidation/formValidation.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/formvalidation/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/captionhovereffects/js/modernizr.custom.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/captionhovereffects/js/toucheffects.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/js/plugins/style-switcher.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/classyedit/js/jquery-te-1.4.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap-multiselect.js') }}"></script>
	<!-- js html to pdf -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
	<script type="text/javascript" src="{{ URL::asset('/assets/plugins/summernote/js/summernote.min.js') }}"></script>
	<!-- <script type="text/javascript" src="{{ URL::asset('assets/plugins/tour/js/jquery.smoothscroll.js') }}"></script> -->
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/tour/js/bootstrap-tour.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/tour/js/bootstrap-tour.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/js/plugins/form-sliders.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('front/js/inputmask.js') }}"></script>


	<script type="text/javascript">


		/*set notes in proposal*/
		function setnotesinusers(users_id,post_id) {
			$('#notes_textarea_users').summernote('code','');
			$('#notes-users-form-footer').html('');
			$('#notes_textarea_users_error').text('');
			$('.notes-msg-text').text('');
			$('#set-users-notes').modal('show');
			$.ajax({
				url: "{{url('/')}}/notes/get/{{ $user->id }}/{{ $user->agents_users_role_id }}/5/"+users_id+"/"+post_id+"/{{@$agents->id}}/{{@$agents->agents_users_role_id}}",
				type: 'get',
				beforeSend: function(){$(".set-users-notes-loader").show();},
				success: function(result) {
					$(".set-users-notes-loader").hide();
					if(result.status === "error" ){
						var notesset ="";
						var error =  result.status;
						$('#notes_textarea_users_error').text(error);

					}else{

						var notesset = result.notes;

					}
					//$('#notes_textarea_users').jqteVal(notesset);
					$('#notes_textarea_users').summernote('code',notesset);

					$('#notes-users-form-footer').html('<button class="btn-u btn-u-primary notes-users-form-submit" onclick="users_notes_add('+users_id+','+post_id+');" title="Save note">Save</button>');
				},
			  	error: function(data)
		    	{

		    	}
			});
		}



		function set_post_note_by_agent(users_id,post_id, post_title) {

			$('#notes_textarea_users').summernote('code','');
			$('#notes-users-form-footer').html('');
			// $('#notes_textarea_users_error').text('');
			$('#notes_textarea_users_error').hide();
			$('.notes-msg-text').text('');
			$('#set-users-notes').modal('show');



			$('.notes-msg-text').text('');
			var value = $('#notes_textarea_users').summernote('code');
			// var value = post_title;


			if(value !=''){
				$('#notes_textarea_users_error').hide();
				$.ajax({
					url: "{{url('/notes/data/insert')}}",
					type: 'post',
					beforeSend: function(){$(".set-users-notes-loader").show();},
					// processData: false,
					data: {
						notes_type :5,
						notes : value,
						notes_item_id :users_id,
						notes_item_parent_id : post_id,
						receiver_id : '{{@$user->id}}',
						receiver_role: '{{@$user->agents_users_role_id}}',
						sender_id: '{{ $user->id }}',
						sender_role : '{{ $user->agents_users_role_id }}',
						_token : '{{ csrf_token() }}'
					},

					success: function(result) {
						console.log(result);
						if(result.status =="error"){
						      $('#notes_textarea_users_error').text(result.message);
						}else{

						msgshowfewsecond('Saved the note successfully');
						$('#set-users-notes').modal('hide');
						}

					},error: function(result) {

					},
					complete: function () {
						$(".set-users-notes-loader").hide();
					}
				});
			}else{
				$('#notes_textarea_users_error').text('This is required.');
			}
		}


		function set_agent_note_with_text(users_id,post_id,user_role_id){
			$('#notes_textarea_users_error').text('');
			$('.notes-msg-text').text('');
			var value = $('#notes_textarea_users').summernote('code');
			// var value = post_title;

			if(value !=''){
				$('#notes_textarea_users_error').hide();
				$.ajax({
					url: "{{url('/notes/data/insert')}}",
					type: 'post',
					beforeSend: function(){$(".set-users-notes-loader").show();},
					// processData: false,

					data: {
						notes_type :5,
						notes : value,
						notes_item_id :users_id,
						notes_item_parent_id : post_id,
						receiver_id : users_id,
						receiver_role: user_role_id,
						sender_id: '{{ $user->id }}',
						sender_role : '{{ $user->agents_users_role_id }}',
						_token : '{{ csrf_token() }}'
					},

					success: function(result) {
						console.log(result);
						if(result.status =="error"){
						      $('#notes_textarea_users_error').text(result.message);
						}else{

						msgshowfewsecond('Saved the note successfully');
						$('#set-users-notes').modal('hide');
						}
						location.reload();

					},error: function(result) {

					},
					complete: function () {
						$(".set-users-notes-loader").hide();
					}
				});
			}else{
				$('#notes_textarea_users_error').text('This is required.').show();
				// $('#notes_textarea_users_error').text('This is required.');
			}
		}



	 	var $demo, duration, remaining, tour;
	    $(document).ready(function () {
	    	/*theme action*/
			App.init();
			App.initCounter();
			App.initScrollBar();
			StyleSwitcher.initStyleSwitcher();
	    	window.sessionStorage;
	        /*theme action*/

	    	/*compare popover*/
	    	$('.popover-compare-hover').popover().click(function(e) {
		        e.preventDefault();
		      	var wi = $(this).attr('aria-describedby');
		      	if(typeof wi != 'undefined' && wi != null){
		      		$('#'+wi).css({'width': '467px','max-width': '852px !important'});
		      	}
	         	var open = $(this).attr('data-easein');
		        if(open == 'shake') {
	                  $(this).next().velocity('callout.' + open);
	            } else if(open == 'pulse') {
	              $(this).next().velocity('callout.' + open);
	            } else if(open == 'tada') {
	                $(this).next().velocity('callout.' + open);
	            } else if(open == 'flash') {
	                  $(this).next().velocity('callout.' + open);
	            }  else if(open == 'bounce') {
	                 $(this).next().velocity('callout.' + open);
	            } else if(open == 'swing') {
	                 $(this).next().velocity('callout.' + open);
	            }
	            if(typeof wi != 'undefined' && wi != null){
		      		$('#'+wi).css({'width' : '450px'});
		      	}
		    });
			$('.popover-compare-hover').hover(
			  function(){
			    $(this).click();
			  }
			);
			$('body').on('click', function (e) {
			    if (typeof e.target.attributes[1] == 'undefined' && $(e.target).parents('.popover.in').length === 0) {
			        $('.popover').popover('hide');
			        $('[rel="popover"]').removeAttr('aria-describedby');
			    }
			});
	    	$('body').on('click','.accordion-toggle',function(e){

				var attr = $(this).attr('data-href');
	    		$('.accordion-toggle').not(this).addClass('collapsed');
	    		$(this).toggleClass('collapsed');
				$('.panel-collapse').not( attr ).removeClass('in');
				$(attr).toggleClass('in');
				var partofid = attr.split('-');
				var id  = 'question_default_'+partofid[2];
				document.getElementById(id).focus();
				//alert('dilipgautam');
			});

	    	/*summernote init*/
			$('.jqte-test').summernote({ dialogsInBody: true });
			/*notifcation click action */
		  	$(".notificationicon").click(function () {
			    $(this).toggleClass("open");
			    $("#notificationMenu").toggleClass("open");
		  	});
		  	$(".message_notificationicon").click(function () {
			    $(this).toggleClass("open");
			    $("#message_notificationMenu").toggleClass("open");
		  	});
		  	$(".listing-btn").click(function () {
			    $('#compare-listings').toggleClass("listing-open");
		  	});

		  	if('{{ Auth::user()->first_login }}' == 1){
		  		$('#firstsetsecurty').modal({
					backdrop: 'static'
				});
				$('#firstsetsecurty').modal('show');
		  	}



  		   	/* edit password*/
		    $('#first-set-securty-form').submit(function(e){
				e.preventDefault();
				var $form = $(e.target),esmsg = $('.message-password');

				$.ajax({

					url: "{{url('/')}}/password/changepassword",
					type: 'POST',
					data: $form.serialize(),
					beforeSend: function(e){
                        if($('#answer1').val().length > 50){
                            $('.answer1_error').removeClass('success-text').addClass('error-text').text('Answer should be less that 200 characters!');
                            e.preventDefault();
                        }
                        if($('#answer2').val().length > 50){
                            $('.answer2_error').removeClass('success-text').addClass('error-text').text('Answer should be less that 200 characters!');
                            e.preventDefault();
                        }
                        if($('#answer1').val().length ==0){
                            $('.answer1_error').removeClass('success-text').addClass('error-text').text('Answer 1 is required!');
                            e.preventDefault();
                        }
                        if($('#answer2').val().length == 0){
                            $('.answer2_error').removeClass('success-text').addClass('error-text').text('Answer 2 is required!');
                            e.preventDefault();
                        }
                        if($('#answer2').val().toLowerCase() == $('#answer1').val().toLowerCase()){
                            $('.answer2_error').removeClass('success-text').addClass('error-text').text('Answer 2 & Answer 1 can not be same!');
                            e.preventDefault();
                        }
                        $(".first-set-securty-loder").show();
                        },
		    	    processData:false,

					success: function(result) {
						$(".first-set-securty-loder").hide();
						$('.error-text').text('');
						// $('input[type="password"]').removeClass('error-border');
						if(typeof result.error !='undefined' && result.error !=null){
						 	$.each( result.error, function( key, value ) {
							 	 $('.'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
								 // $('#'+key).addClass('error-border');
								});
						 	esmsg.text('');
						}
						if(typeof result.msg !='undefined' && result.msg !=null){
							$('#firstsetsecurty').modal('hide');
							msgshowfewsecond('Your security successfully change.');
							tour.restart();
						}
					},
				  	error: function(data)
			    	{
			    		if(data.status=='500'){
							esmsg.text(data.statusText).css({'color':'red'});
			    		}else if(data.status=='422'){
							esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
			    		}
			    		$(".first-set-securty-loder").hide();
			    	}

				});

				/*firt time change security questin*/
				$.ajax({
					url: "{{url('/')}}/securtyquestion/change",
					type: 'POST',
					data: $form.serialize(),
					beforeSend: function(){$(".first-set-securty-loder").show();},
		    	    processData:false,
					success: function(result) {
						$(".first-set-securty-loder").hide();
						if(typeof result.error !='undefined' && result.error !=null){
						// $('.error-text').text('');
						 	$.each( result.error, function( key, value ) {
							 	 $('.'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
								});
						 	esmsg.text('');
						}
						if(typeof result.msg !='undefined' && result.msg !=null){
							$('#firstsetsecurty').modal('hide');
							msgshowfewsecond('Your security successfully change.');
						}
					},
				  	error: function(data)
			    	{	$(".first-set-securty-loder").hide();
			    		if(data.status=='500'){
							esmsg.text(data.statusText).css({'color':'red'});
			    		}else if(data.status=='422'){
							esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
			    		}
			    	}
				});

			});
			/* edit password*/

		});

	    function msgshowfewsecond(text) {
		    var x = document.getElementById("snackbar")
		    x.className  = "show";
		    x.innerHTML  = text;
		    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
		}
		function anymodelhideinfewsecond(id) {
		    setTimeout(function(){ $(id).modal('hide'); }, 2000);
		}

	 // 	window.onbeforeunload = function (event) {
		//     var message = 'Important: Please click on \'Save\' button to leave this page.';
		//     if (typeof event == 'undefined') {
		//         event = window.event;
		//         alert(event);
		//     }
		//     if (event) {
		//         event.returnValue = message;
		//     }
		//     return message;
		// };

		// $(function () {
		//     $("a").not('#lnkLogOut').click(function () {
		//         window.onbeforeunload = null;
		//     });
		//     $(".btn").click(function () {
		//         window.onbeforeunload = null;
		// 	});
		// });

	// <!-- chat script start -->
		//this function can remove a array element.
        function remove(array, from, to) {
            var rest = array.slice((to || from) + 1 || array.length);
            array.length = from < 0 ? array.length + from : from;
            return array.push.apply(array, rest);
        }

        var total_popups = 0;
        var messagesrating = [];
        var currentchat = [];
        var allchatconversation =[];
        // var compare_data = [];
        //arrays of popups ids
        var popups = [];
        //this is used to close a popup
        function close_popup(id)
        {
            for(var iii = 0; iii < popups.length; iii++)
            {
                if(id == popups[iii])
                {
                    remove(popups, iii);
                    localStorage.clear();
                    window.localStorage.setItem("popups", JSON.stringify(popups));
                   	$('#'+id).remove();
                    calculate_popups();
                    return;
                }
            }
        }
    	function minimaish_popup(id) {
    		$('#'+id).toggleClass('minimish');
    	}
        //displays the popups. Displays based on the maximum number of popups that can be displayed on the current viewport width
        function display_popups()
        {
            var right = 220;

            var iii = 0;
            for(iii; iii < total_popups; iii++)
            {
                if(popups[iii] != undefined)
                {
                    var element = document.getElementById(popups[iii]);
                    element.style.right = right + "px";
                    right = right + 320;
                    element.style.display = "block";
                }
            }

            for(var jjj = iii; jjj < popups.length; jjj++)
            {
                var element = document.getElementById(popups[jjj]);
                element.style.display = "none";
            }
        }

        function trunc(string,n){
            return string.length > n ? string.substr(0,n-1)+'...' : string.toString();
        }
        //creates markup for a new popup. Adds the id to popups array.
       	function register_popup(post_id,receiver_id,receiver_role_id)
        {
        	var id = 'converstionpostid_'+post_id+'_'+receiver_id+'_'+receiver_role_id;
            for(var iii = 0; iii < popups.length; iii++)
            {
                //already registered. Bring it to front.
                if(id == popups[iii])
                {
                    remove(popups, iii);
                    popups.unshift(id);
                    calculate_popups();
                    return;
                }
            }
            $.ajax({
				url: "{{url('/')}}/NewConversation/"+post_id+"/"+receiver_id+"/"+receiver_role_id,
				type: 'get',
				success: function(result) {
					result = result.result[0];
					allchatconversation[result.conversation_id] = result;
					if(result.login_status=='Online'){
						var login_status = result.login_status;
					}else{
						var login_status = 'last active '+timeDifference(new Date(), new Date(Date.fromISO(result.last_login_time)));
					}
					readupdatefooter(result.conversation_id);
					var element = '<div class="chatbox" id="'+id+'">'+
								    '<div  class="p1 chatview" style="display: block;">    	'+
								        '<div class="profilechatt animate">'+

								            '<div class="close" onclick="close_popup(\''+id+'\');">'+
								                '<div class="cy s1 s2 s3"></div>'+
								                '<div class="cx s1 s2 s3"></div>'+
								            '</div>'+
								             '<div class="close2" onclick="minimaish_popup(\''+id+'\');">'+

								                '<div class="cx s1 s5 s4"></div>'+
								            '</div>'+

								            ' <p class="animate" >'+result.name+'</p>'+
								            '<span class="status_'+result.user_id+'">'+login_status+'</span>'+
								        '</div>'+
							    		'<div class="center"><img src="{{ url("/assets/img/loder/loading.gif") }}" class="messageloadertop chat_message_loader_'+id+'" width="40px" height="40px"/></div>'+
								        '<div class="animate chat-messages" id="chat_messages_append_'+id+'">'+
								         '</div>'+
								        '<div class="sendmessage"><form style="padding: 8px;" id="send-chat-message_'+id+'" class="send-chat-message_'+id+'" action="#">'+
								        	'<textarea placeholder="Write a message" style="position: relative; z-index: 2;" name="chat-add-textarea_'+id+'" id="chat-add-textarea_'+id+'" class="chat-add-textarea chat-add-textarea_'+id+'" spellcheck="true" autocomplete="off" ></textarea>'+
								        	'<input type="hidden" name="conversationid_'+id+'" value="'+result.conversation_id+'" id="conversationid_'+id+'">'+
								           	'<input type="hidden" name="nextloadconvmessageslist_'+id+'" value="" class="nextloadconvmessageslist_'+id+'">'+
								           '<span class="answer-btn answer-btn-2"><a href="#"><i class=""></i></a></span>'+
								        '</form></div>'+

								    '</div>  '+
							    '</div> ';
        		 	var msc1 = $("#chat_messages_append_"+id).find('body');
			 		var msct1 = msc1.prevObject.length;
			 		if(msct1==0){
			        	$('body').append(element);
                    }

			        var append = $("#chat_messages_append_"+id),loder = $('.chat_message_loader_'+id),next = $('.nextloadconvmessageslist_'+id);
                   	var conversation_id = result.conversation_id;
                    $.ajax({
						url: "{{url('/')}}/messageslist/get/conversation/messages/0",
						type: 'post',
						data: {bookmark : 'bookmark',conversation_id : conversation_id, sender_id: '{{ Auth::user()->id }}', sender_role : '{{ Auth::user()->agents_users_role_id }}', _token : '{{ csrf_token() }}'},
						beforeSend: function(){ loder.show(); },
						success: function(result) {
							var resultt = result[0];
							var bookmarkdd = result[1];
							var ratting = result[2];
							loder.hide();
							if(resultt.count !== 0){
								$.each( resultt.result, function( key, value ) {

									currentchat[conversation_id+'_'+value.messages_id] = value;
									var userclass = '';
					                if(value.sender_id == '{{ Auth::user()->id }}' && value.sender_role == '{{ Auth::user()->agents_users_role_id }}'){
					                	userclass = 'right';
					                }else{
					                	userclass = 'left';
					                }
			    					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
									var photo =  value.photo != null ?  '{{ url("/assets/img/profile/") }}/'+value.photo : '{{ url("/assets/img/testimonials/user.jpg") }}';

									var rating1 = '';
									var ratingset = 0;
									if(ratting[value.messages_id] !=null && ratting[value.messages_id] != 'undefined' && ratting[value.messages_id] !=''){

										var rat = ratting[value.messages_id];
									 	ratingset = rat.rating;
										var rclasid = value.messages_id;
										rating1 = 	'<div id="ratinganswer_'+rclasid+'" class="gautam rating-show-only chatinrating">'+

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
									var htmll = '';

									if(typeof value.message_text !=="undefined" && value.message_text !== null && value.message_text !="" ){
										//console.log(value.message_text);
								 	htmll += '<div class="message  '+userclass+'" c_c_id_'+value.messages_id+'" id="c_c_id_'+value.messages_id+'">'+rating1+
									            	'<img width="30" height="30"  src="'+photo+'" id="img_'+value.messages_id+'" alt="'+value.name+'">'+
									                '<div class="bubble">'+
									                	value.message_text+
									                    '<br><div class="corner">';

							                    htmll += '<div class="_40fu moreicon_'+userclass+'"><div class="_2rvp  toolmodelopen" id="toolmodelopen_'+value.messages_id+'"></div></div>'+
										                    '<div class="uiContextualLayer uiContextualLayerAboveCenter  toolmodelopen_'+value.messages_id+'">'+
															    '<div class="_5v-0 _53ik">'+
															        '<div class="_53ij">'+
															            '<div>'+
															                '<ul class="_hw3">'+
															                	'<li class="_hw4 bookmark_messages_data_'+value.messages_id+'" >';
															                	if(bookmarkdd[value.messages_id]){
															                		var book = bookmarkdd[value.messages_id];
												                				 	htmll +='<a class="_hw5" onclick="messages_remove_bookmark_list('+value.messages_id+','+value.conversation_id+','+book.bookmark_id+',\'chat\');"><i  data-toggle="tooltip" data-original-title="Bookmarked " class="tooltips fa fa-bookmark book_question_'+value.messages_id+'"></i></a>';
															                	}else{
												                				 	htmll +='<a class="_hw5" onclick="messages_add_bookmark_list('+value.messages_id+','+value.conversation_id+',\'chat\');"><i  data-toggle="tooltip" data-original-title="Bookmark" class="tooltips fa fa-bookmark-o book_question_'+value.messages_id+'"></i></a>';
															                	}
													                	 htmll +='</li>';
														                	 	if('{{ Auth::user()->agents_users_role_id }}' != 4){

													                	 		 	htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setratinginmessage(\'chat\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Rating" class="tooltips fa fa-star"></i> </a> </li>';
														                	 	}
												                	 		 		htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setnotesinmessage(\'chat\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Note" class="tooltips fa fa-commenting"></i> </a> </li>';
													                 htmll +='</ul>'+
															            '</div>'+
															        '</div>'+
															        '<i class="_53io"></i>'+
															        '<a class="accessible_elem layer_close_elem" href="#" role="button" tabindex="0">Close popup and return</a>'+
															    '</div>'+
															'</div>';

							                    htmll +='</div>'+
									                    '<span>'+date+'</span>'+
									                '</div>'+
									            '</div>';
									}
						            var msc = $('#c_c_id_'+value.messages_id).find("#chat_messages_append_"+id);
							 		var msct = msc.prevObject.length;
							 		if(msct==0){
				                        append.prepend(htmll);
				                    }else{
				                    	$('#c_c_id_'+value.messages_id).replaceWith( htmll );
				                    }
			                     	if(ratingset !=0){
				                    	$('#star'+ratingset+'_'+value.messages_id).attr("checked", "checked");
				                    }
								});
								$("#chat_messages_append_"+id).scrollTop($("#chat_messages_append_"+id)[0].scrollHeight);
								if(resultt.next!=0){
									next.val(resultt.next);
								}else{
									next.val('');
								}

								$("#chat_messages_append_"+id).scroll(function(valu){
									if ($("#chat_messages_append_"+id).scrollTop() == '0' && next.val() != 0){
										let limit = $(`#${id}`).children(".chat-messages").find(".message").length;
										loadmorechatmessages(limit,conversation_id,id);
									}
								});
							}

						},
					  	error: function(data)
				    	{
				    		if(data.status=='500'){
								append.text(data.statusText).addClass('red');
				    		}else if(data.status=='422'){
								append.text(data.responseJSON.image[0]).addClass('red');
				    		}
			    				setInterval(function() { append.html('').removeClass('red'); },1000);
				    	}
					});

                    popups.unshift(id);
                   	window.localStorage.setItem("popups", JSON.stringify(popups));
					calculate_popups();


					setInterval(()=>{
						let limit = $(`#${id}`).children(".chat-messages").find(".message").length;
						loadmorechatmessages(0,conversation_id,id);
					},1500);


                    $('#send-chat-message_'+id).keypress(function(e){
			            if(e.which == 13){
				            e.preventDefault();
				            var answer = e.currentTarget[0].value;
				            var c_id   = e.currentTarget[1].value;
				            var ccdata = allchatconversation[c_id];

				            var append = $("#chat_messages_append_"+id);
							var ucode = new Date().getTime();
							var photo =  '{{ url("/assets/img/testimonials/user.jpg") }}';
							$('#chat-add-textarea_'+id).val('');


							var htmll = '<div class="message  right c_c_id_'+ucode+'" id="c_c_id_'+ucode+'">'+
							            	'<img width="30" height="30"  src="'+photo+'" id="img_'+ucode+'">'+
							                '<div class="bubble">'+
							                	answer+
							                    '<div class="corner">'+

				                     				'<div class="_40fu moreicon_right"><div class="_2rvp  toolmodelopen" id="toolmodelopen_'+ucode+'"></div></div>'+

								                    '<div class="uiContextualLayer uiContextualLayerAboveCenter  toolmodelopen_'+ucode+'">'+
													    '<div class="_5v-0 _53ik">'+
													        '<div class="_53ij">'+
													            '<div>'+
													                '<ul class="_hw3" >'+
													                	'<li class="_hw4 bookmark_messages_data_'+ucode+'" >'+
											                	 		'</li>';
											                	 		if('{{ Auth::user()->agents_users_role_id }}' != 4){
											                	 		htmll +='<li class="_hw4 margin-left-10" id="appendrating_'+ucode+'"> </li>';
											                	 		}
											                	 		htmll +='<li class="_hw4 margin-left-10" id="appendnotes_'+ucode+'"> </li>'+
													                '</ul>'+
													            '</div>'+
													        '</div>'+
													        '<i class="_53io"></i>'+
													        '<a class="accessible_elem layer_close_elem " href="#" role="button" tabindex="0">Close popup and return</a>'+
													    '</div>'+
													'</div>'+

				                    			'</div>'+
							                    '<span>few s ago</span>'+
							                '</div>'+
							            '</div>';
							 // append.append(htmll);

					 		$("#chat_messages_append_"+id).scrollTop($("#chat_messages_append_"+id)[0].scrollHeight);
					 		$.ajax({
								url: "{{url('/insert/new/messages')}}",
								type: 'POST',
								data: {
										name:'{{ $userdetails->name }}',
										message_text:answer,
										receiver_id: ccdata.user_id,
										receiver_role: ccdata.agents_users_role_id,
										sender_id: '{{ Auth::user()->id }}',
										sender_role: '{{ Auth::user()->agents_users_role_id }}',
										post_id: ccdata.post_id,
										conversation_id: c_id,
										is_user : ccdata.is_user,
										_token : '{{ csrf_token() }}',
									},
								success: function(response) {
									if(response.status == 'success'){
										var data = response.data;

										currentchat[c_id+'_'+data.messages_id] = data;

										var photo =  data.photo != null ?  '{{ url("/assets/img/profile/") }}/'+data.photo : '{{ url("/assets/img/testimonials/user.jpg") }}';

				                        $('#c_c_id_'+ucode+'').addClass('c_c_id_'+data.messages_id).attr('id','c_c_id_'+data.messages_id).removeClass('c_c_id_'+ucode); // Here we need jQuery
				                    	$('#img_'+ucode).attr('src',photo).addClass('img_'+data.messages_id).removeClass('img_'+ucode);

				                    	$('#toolmodelopen_'+ucode).attr('id','toolmodelopen_'+data.messages_id);

				                    	$('.toolmodelopen_'+ucode).addClass('toolmodelopen_'+data.messages_id).removeClass('toolmodelopen_'+ucode);

										var htmll ='<a class="_hw5" onclick="messages_add_bookmark_list('+data.messages_id+','+c_id+',\'chat\');"><i  data-toggle="tooltip" data-original-title="Bookmark" class="tooltips fa fa-bookmark-o book_question_'+data.messages_id+'"></i></a>';
										$('.bookmark_messages_data_'+ucode).html(htmll).addClass('bookmark_messages_data_'+data.messages_id).removeClass('bookmark_messages_data_'+ucode);

										if('{{ Auth::user()->agents_users_role_id }}' != 4){
											$('#appendrating_'+ucode).html('<a class="_hw5" onclick="setratinginmessage(\'chat\','+data.messages_id+','+c_id+');"> <i  data-toggle="tooltip" data-original-title="Rating" class="tooltips fa fa-star"></i> </a> ');
										}

				                    	var htmll ='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setnotesinmessage(\'chat\','+data.messages_id+','+c_id+');"> <i  data-toggle="tooltip" data-original-title="Note" class="tooltips fa fa-commenting"></i> </a> </li>';
				                    	$('#appendnotes_'+ucode).html(htmll);

				                    }else{

				                        $('#c_c_id_'+ucode+'').html('some issue').css('color','red');

				                        $('#answer-add-textarea').val(answer);

				                        setInterval(function() { $('#c_c_id_'+ucode+'').remove(); },5000);
				                    }

								},
							  	error: function(data)
						    	{
						    		if(data.status=='500'){
										$('#c_c_id_'+ucode+'').text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');
						    		}else if(data.status=='422'){
										$('#c_c_id_'+ucode+'').text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');
						    		}
						    		setInterval(function() { $('#c_c_id_'+ucode+'').remove(); },5000);
						    	}
							});
							readupdatefooter(c_id);
				        }
			        });
				},
			  	error: function(data)
		    	{

		    	}
			});
            // var sendername = trunc(response.data.participants_name,25);
        }
       	/*load chat messages using scroll time and cron auto update messages*/
    	function loadmorechatmessages(limit,conversation_id,id) {

    		var append = $("#chat_messages_append_"+id),loder = $('.chat_message_loader_'+id),next = $('.nextloadconvmessageslist_'+id);
            $.ajax({
				url: "{{url('/')}}/messageslist/get/conversation/messages/"+limit,
				type: 'post',
				data: {bookmark : 'bookmark',conversation_id : conversation_id, sender_id: '{{ Auth::user()->id }}', sender_role : '{{ Auth::user()->agents_users_role_id }}', _token : '{{ csrf_token() }}'},
				beforeSend: function(){ if(limit!=0) { loder.show(); } },
				success: function(result) {
					if(limit!=0) { loder.hide(); }

					var resultt = result[0];
					var bookmarkdd = result[1];
					if(resultt.count !== 0){
						$.each( resultt.result, function( key, value ) {

							currentchat[conversation_id+'_'+value.messages_id] = value;
							var userclass = '';
			                if(value.sender_id == '{{ Auth::user()->id }}' && value.sender_role == '{{ Auth::user()->agents_users_role_id }}'){
			                	userclass = 'right';
			                }else{
			                	userclass = 'left';
			                }
	    					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));
							var photo =  value.photo != null ?  '{{ url("/assets/img/profile/") }}/'+value.photo : '{{ url("/assets/img/testimonials/user.jpg") }}';
					var htmll='';
						if(typeof value.message_text !=="undefined" && value.message_text !== null && value.message_text !="" ){
							htmll = '<div class="message  '+userclass+'" c_c_id_'+value.messages_id+'" id="c_c_id_'+value.messages_id+'">'+
							            	'<img width="30" height="30" src="'+photo+'" id="img_'+value.messages_id+'" alt="'+value.name+'">'+
							                '<div class="bubble">'+
							                	value.message_text+
							                    '<br><div class="corner"> ';
				                    	 htmll += '<div class="_40fu moreicon_'+userclass+'"><div class="_2rvp  toolmodelopen" id="toolmodelopen_'+value.messages_id+'"></div></div>'+
								                    '<div class="uiContextualLayer uiContextualLayerAboveCenter  toolmodelopen_'+value.messages_id+'">'+
													    '<div class="_5v-0 _53ik">'+
													        '<div class="_53ij">'+
													            '<div>'+
													                '<ul class="_hw3">'+
													                	'<li class="_hw4 bookmark_messages_data_'+value.messages_id+'" >';
													                	if(bookmarkdd[value.messages_id]){
													                		var book = bookmarkdd[value.messages_id];
										                				 	htmll +='<a class="_hw5" onclick="messages_remove_bookmark_list('+value.messages_id+','+value.conversation_id+','+book.bookmark_id+',\'chat\');"><i  data-toggle="tooltip" data-original-title="Bookmarked " class="tooltips fa fa-bookmark book_question_'+value.messages_id+'"></i></a>';
													                	}else{
										                				 	htmll +='<a class="_hw5" onclick="messages_add_bookmark_list('+value.messages_id+','+value.conversation_id+',\'chat\');"><i  data-toggle="tooltip" data-original-title="Bookmark" class="tooltips fa fa-bookmark-o book_question_'+value.messages_id+'"></i></a>';
													                	}
											                	 htmll +='</li>';
											                	 		if('{{ Auth::user()->agents_users_role_id }}' != 4){
											                	 			htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setratinginmessage(\'chat\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Rating" class="tooltips fa fa-star"></i> </a> </li>';
											                	 		}
											                	 		htmll +='<li class="_hw4 margin-left-10"> <a class="_hw5" onclick="setnotesinmessage(\'chat\','+value.messages_id+','+value.conversation_id+');"> <i  data-toggle="tooltip" data-original-title="Note" class="tooltips fa fa-commenting"></i> </a> </li>';
											                htmll +='</ul>'+
													            '</div>'+
													        '</div>'+
													        '<i class="_53io"></i>'+
													        '<a class="accessible_elem layer_close_elem" href="#" role="button" tabindex="0">Close popup and return</a>'+
													    '</div>'+
													'</div>';
					                    htmll +='</div>'+
							                    '<span>'+date+'</span>'+
							                '</div>'+
							            '</div>';
						}
				            var msc = $('#c_c_id_'+value.messages_id).find("#chat_messages_append_"+id);
					 		var msct = msc.prevObject.length;
					 		if(msct==0){
					 			if (limit==0) {
			                        append.append(htmll);
					 			}else{
			                        append.prepend(htmll);
					 			}
		                    }
						});
						if (limit==0) {
							$("#chat_messages_append_"+id).animate({
							    scrollTop: $("#chat_messages_append_"+id).scrollTop() + 100
							});

						}
						if(limit!=0){
		                	$("#chat_messages_append_"+id).scrollTop(200);
		            	}
						if(resultt.next!=0){
							next.val(resultt.next);
						}else{
							next.val('');
						}
					}

				},
			  	error: function(data)
		    	{
		    	}
			});
    	}
    	function CheckChatPopup(response) {
			var chatid = 'converstionpostid_'+response.post_id+'_'+response.sender_id+'_'+response.sender_role;
    		var msc1 = $('#'+chatid).find('body');
	 		var msct1 = msc1.prevObject.length;
	 		if(msct1==0){
	        	register_popup(response.post_id,response.sender_id,response.sender_role);
            }else{
            	loadmorechatmessages(0,response.conversation_id,chatid);
            }
            checkalluserstatus();
    	}
    	function checkalluserstatus() {
    		if (JSON.parse(localStorage.getItem( 'popups' )) !=null && JSON.parse(localStorage.getItem( 'popups' )) !='') {
	        	var popups1 = JSON.parse(localStorage.getItem( 'popups' ));

	        	$.each( popups1, function( key, value ) {
	        		var sd = value.split("_");
	        		 $.ajax({
						url: "{{url('/')}}/users/"+sd[1]+'/'+sd[2],
						type: 'get',
						success: function(result) {

							if(result.login_status){
								if(result.login_status && result.login_status=='Online'){
									var login_status = result.login_status;
								}else{
									var login_status = 'last active '+timeDifference(new Date(), new Date(Date.fromISO(result.last_login_time)));
								}
								$('.status_'+sd[1]).text(login_status);
							}else{
								$('.status_'+sd[1]).text('Offline');
							}
						},
					  	error: function(data)
				    	{
				    	}
					});
	        	});
	        }
    	}
        //calculate the total number of popups suitable and then populate the toatal_popups variable.
        function calculate_popups()
        {
            var width = window.innerWidth;

            if(width < 540)
            {
                total_popups = 0;
            }
            else
            {
                width = width - 200;
                //320 is width of a single popup box
                total_popups = parseInt(width/320);
            }
            display_popups();

        }
        function readupdatefooter(cid) {

				var ccdata = allchatconversation[cid];
				$.ajax({
					url: "{{url('/')}}/read/update/messages",
					type: 'post',
					data: {cid: cid,_token : '{{ csrf_token() }}'},
					success: function(result) {
					},
					error: function(data)
					{

					}
				});
				readnotificationbyreciverid(ccdata.user_id,ccdata.agents_users_role_id,'{{ $user->id }}','{{ $user->agents_users_role_id }}',6);
				readnotificationbyreciverid(ccdata.user_id,ccdata.agents_users_role_id,'{{ $user->id }}','{{ $user->agents_users_role_id }}',7);

		}

        //recalculate when window is loaded and also when window is resized.
        window.addEventListener("resize", calculate_popups());
        window.addEventListener("load", calculate_popups());

        /*Bookmark option question*/
		function messages_add_bookmark_list(mid,cid,type) {
			if(type=='message'){
				var messdd = allmessages[mid];
			}else if(type=='chat'){
				var messdd = currentchat[cid+'_'+mid];
			}
	       	$.ajax({
				url: "{{url('/bookmark/data/insert')}}",
				type: 'post',
				data: {bookmark_type : 3,bookmark_item_id : mid, bookmark_item_parent_id : cid,receiver_id : messdd.user_id,receiver_role: messdd.agents_users_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
				success: function(result) {
					$('.bookmark_messages_data_'+mid).html('<a class="_hw5" onclick="messages_remove_bookmark_list('+mid+','+cid+','+result.data+',\''+type+'\');"><i  data-toggle="tooltip" data-original-title="Bookmarked " class="tooltips fa fa-bookmark book_question_'+mid+'"></i></a>');
					msgshowfewsecond('Message successfully bookmark.');
				},error: function(result) {

				}
			});
		}

		function messages_remove_bookmark_list(mid,cid,bookmark_id,type) {
	       	$.ajax({
				url: "{{url('/bookmark/data/delete')}}/"+bookmark_id,
				type: 'get',
				success: function(result) {
					$('.bookmark_messages_data_'+mid).html('<a class="_hw5" onclick="messages_add_bookmark_list('+mid+','+cid+',\''+type+'\');"><i  data-toggle="tooltip" data-original-title="Bookmark" class="tooltips fa fa-bookmark-o book_question_'+mid+'"></i></a>');
					msgshowfewsecond('Message removed from bookmarks.');
				},error: function(result) {
				}
			});
		}

		/*set rating in messages*/
		function setratinginmessage(type,mid,cid) {
			if(type=='chat'){
			var mess = currentchat[cid+'_'+mid];
			var ccdata = allchatconversation[cid];
			}
			if(type=='message'){

			var mess   = allmessages[mid];
			var ccdata = allconversation[cid];
			}
			$('.set-messages-rating-title').text(mess.message_text);
			$('.set-messages-rating-body').html('');
			$('#set-messages-rating').modal('show');
			$.ajax({
				url: "{{url('/')}}/rating/get/{{ $user->id }}/{{ $user->agents_users_role_id }}/2/"+mid+"/"+cid+"/"+ccdata.user_id+"/"+ccdata.agents_users_role_id,
				type: 'get',
				beforeSend: function(){$(".set-messages-rating-loader").show();},
				success: function(result) {
					$(".set-messages-rating-loader").hide();
					if(result !=null && result != 'undefined' && result !=''){
						var ratingset = result.rating;
					}else{
						var ratingset = 0
					}
					var html = '<div id="ratingmessages_'+mid+'" class="rating1">'+

			                        '<input class="mstars"  onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar5_'+mid+'\');" type="radio"  id="mstar5_'+mid+'" name="rating" value="5" />'+
			                        '<label class = "full tooltips" data-toggle="tooltip" data-original-title="Awesome " data-placement="top" for="mstar5_'+mid+'" title="Awesome"></label>'+

			                        '<input class="mstars" onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar4_5_'+mid+'\');" type="radio" id="mstar4_5_'+mid+'" name="rating" value="4_5" />'+
			                        '<label class="half tooltips" data-toggle="tooltip" data-original-title="Pretty good " data-placement="top" for="mstar4_5_'+mid+'" title="Pretty good"></label>'+

			                        '<input class="mstars" onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar4_'+mid+'\');" type="radio" id="mstar4_'+mid+'" name="rating" value="4" />'+
			                        '<label class = "full tooltips" data-toggle="tooltip" data-original-title="Pretty good " data-placement="top" for="mstar4_'+mid+'" title="Pretty good"></label>'+

			                        '<input class="mstars" onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar3_5_'+mid+'\');" type="radio" id="mstar3_5_'+mid+'" name="rating" value="3_5" />'+
			                        '<label class="half tooltips" data-toggle="tooltip" data-original-title="Meh " data-placement="top" for="mstar3_5_'+mid+'" title="Meh"></label>'+

			                        '<input class="mstars" onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar3_'+mid+'\');" type="radio" id="mstar3_'+mid+'" name="rating" value="3" />'+
			                        '<label class = "full tooltips" data-toggle="tooltip" data-original-title="Meh " data-placement="top" for="mstar3_'+mid+'" title="Meh"></label>'+

			                        '<input class="mstars" onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar2_5_'+mid+'\');" type="radio" id="mstar2_5_'+mid+'" name="rating" value="2_5" />'+
			                        '<label class="half tooltips" data-toggle="tooltip" data-original-title="Kinda bad " data-placement="top" for="mstar2_5_'+mid+'" title="Kinda bad "></label>'+

			                        '<input class="mstars" onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar2_'+mid+'\');" type="radio" id="mstar2_'+mid+'" name="rating" value="2" />'+
			                        '<label class = "full tooltips" data-toggle="tooltip" data-original-title="Kinda bad " data-placement="top" for="mstar2_'+mid+'" title="Kinda bad"></label>'+

			                        '<input class="mstars" onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar1_5_'+mid+'\');" type="radio" id="mstar1_5_'+mid+'" name="rating" value="1_5" />'+
			                        '<label class="half tooltips" data-toggle="tooltip" data-original-title="Meh " data-placement="top" for="mstar1_5_'+mid+'" title="Meh"></label>'+

			                        '<input class="mstars" onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar1_'+mid+'\');" type="radio" id="mstar1_'+mid+'" name="rating" value="1" />'+
			                        '<label class = "full tooltips" data-toggle="tooltip" data-original-title="Sucks big time " data-placement="top" for="mstar1_'+mid+'" title="Sucks big time"></label>'+

			                        '<input class="mstars" onclick="messages_rating_add(\''+type+'\','+cid+','+mid+',\'mstar0_5_'+mid+'\');" type="radio"  id="mstar0_5_'+mid+'" name="rating" value="0_5" />'+
			                        '<label class="half tooltips" data-toggle="tooltip" data-original-title="Sucks big time " data-placement="top" for="mstar0_5_'+mid+'" title="Sucks big time"></label>'+
			                    '</div>';

					$('.set-messages-rating-body').html(html);
					$('#mstar'+ratingset+'_'+mid).attr("checked", "checked");
				},
			  	error: function(data)
		    	{

		    	}
			});
		}
		/*insert rating for messages*/
		function messages_rating_add(type,cid,mid,id) {
			if(type=='chat'){
			var mess = currentchat[cid+'_'+mid];
			var ccdata = allchatconversation[mess.conversation_id];
			}
			if(type=='message'){

			var mess   = allmessages[mid];
			var ccdata = allconversation[cid];
			}
			var value = $("#"+id).val();
			$.ajax({
				url: "{{url('/rating/data/insert')}}",
				type: 'post',
				data: {post_id : ccdata.post_id,notification_type : 9,notification_message : '{{ $userdetails->name }} give '+removedsh(value)+' rating on message `'+mess.message_text+'`', rating_type : 2,rating : value,rating_item_id :mid, rating_item_parent_id : mess.conversation_id,receiver_id : ccdata.user_id,receiver_role: ccdata.agents_users_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
				success: function(result) {
					$('#set-messages-rating').modal('hide');
				},error: function(result) {

				}
			});
		}

		/*set notes in messages*/
		function setnotesinmessage(type,mid,cid) {
			if(type=='chat'){
				var mess = currentchat[cid+'_'+mid];
				var ccdata = allchatconversation[cid];
			}
			if(type=='message'){
				var mess   = allmessages[mid];
				var ccdata = allconversation[cid];
			}
			$('.set-messages-notes-title').text(mess.message_text);
			//$('#notes_textarea').jqteVal('');
			$('#notes_textarea').summernote('code','');
			$('#notes-message-form-footer').html('');
			$('#notes_textarea_error').text('');
			$('.notes-msg-text').text('');
			$('#set-messages-notes').modal('show');
			$.ajax({
				url: "{{url('/')}}/notes/get/{{ $user->id }}/{{ $user->agents_users_role_id }}/1/"+mid+"/"+cid+"/"+ccdata.user_id+"/"+ccdata.agents_users_role_id,
				type: 'get',
				beforeSend: function(){$(".set-messages-notes-loader").show();},
				success: function(result) {
					$(".set-messages-notes-loader").hide();
					if(result !=null && result != 'undefined' && result !=''){
						var notesset = result.notes;
					}else{
						var notesset = '';
					}
					//$('#notes_textarea').jqteVal(notesset);
					$('#notes_textarea').summernote('code',notesset);
					$('#notes-message-form-footer').html('<button class="btn-u btn-u-primary notes-message-form-submit" onclick="messages_notes_add(\''+type+'\','+cid+','+mid+');" title="Save note">Save</button>');
				},
			  	error: function(data)
		    	{

		    	}
			});
		}
		/*insert rating for messages*/
		function messages_notes_add(type,cid,mid) {
			if(type=='chat'){
			var mess = currentchat[cid+'_'+mid];
			var ccdata = allchatconversation[mess.conversation_id];
			}
			if(type=='message'){

			var mess   = allmessages[mid];
			var ccdata = allconversation[cid];
			}
			$('#notes_textarea_error').text('');
			$('.notes-msg-text').text('');
			var value = $('#notes_textarea').summernote('code');
			if(value !=''){
				$.ajax({
					url: "{{url('/notes/data/insert')}}",
					type: 'post',
					data: {notes_type : 1,notes : value,notes_item_id :mid, notes_item_parent_id : mess.conversation_id,receiver_id : ccdata.user_id,receiver_role: ccdata.agents_users_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
					success: function(result) {
						msgshowfewsecond('Note successfully save.');
						$('#set-messages-notes').modal('hide');
					},error: function(result) {

					}
				});
			}else{
				$('#set-messages-notes').text('This is required.');
			}
		}

		/*set notes in answer*/
		function setnotesinanswer(aid,qid) {
			var ans = share_question_return_answer[aid];
			$('.set-answers-notes-title').text(ans.answers);
			//$('#notes_textarea_answers').jqteVal('');
			$('#notes_textarea_answers').summernote('code','');

			$('#notes-answers-form-footer').html('');
			$('#notes_textarea_answers_error').text('');
			$('.notes-msg-text').text('');
			$('#set-answers-notes').modal('show');
			$.ajax({
				url: "{{url('/')}}/notes/get/{{ $user->id }}/{{ $user->agents_users_role_id }}/3/"+aid+"/"+qid+"/"+ans.from_id+"/"+ans.from_role,
				type: 'get',
				beforeSend: function(){$(".set-answers-notes-loader").show();},
				success: function(result) {
					$(".set-answers-notes-loader").hide();
					if(result !=null && result != 'undefined' && result !=''){
						var notesset = result.notes;
					}else{
						var notesset = '';
					}
					//$('#notes_textarea_answers').jqteVal(notesset);
					$('#notes_textarea_answers').summernote('code',notesset);

					$('#notes-answers-form-footer').html('<button class="btn-u btn-u-primary notes-answers-form-submit" onclick="answer_notes_add('+aid+','+qid+');" title="Save note">Save</button>');
				},
			  	error: function(data)
		    	{

		    	}
			});
		}
		/*insert note for answer*/
		function answer_notes_add(aid,qid) {
			var ans = share_question_return_answer[aid];
			$('#notes_textarea_answers_error').text('');
			$('.notes-msg-text').text('');
			var value = $('#notes_textarea_answers').summernote('code');
			if(value !=''){
				$.ajax({
					url: "{{url('/notes/data/insert')}}",
					type: 'post',
					data: {notes_type : 3,notes : value,notes_item_id :aid, notes_item_parent_id : qid,receiver_id : ans.from_id,receiver_role: ans.from_role,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
					success: function(result) {
						// $('.notes-msg-text').text('Note successfully save.');
						msgshowfewsecond('Note successfully save.');
						$('#set-answers-notes').modal('hide');
					},error: function(result) {

					}
				});
			}else{
				$('#notes_textarea_answers_error').text('This is required.');
			}
		}

		/*set notes in proposal*/
		function setnotesinproposal(proposals_id,post_id) {
			var proposals = sharedproposale_data[proposals_id];
			$('.set-proposal-notes-title').text(proposals.proposals_title);
			$('#notes_textarea_proposal').summernote('code','');
			$('#notes-proposal-form-footer').html('');
			$('#notes_textarea_proposal_error').text('');
			$('.notes-msg-text').text('');
			$('#set-proposal-notes').modal('show');
			$.ajax({
				url: "{{url('/')}}/notes/get/{{ $user->id }}/{{ $user->agents_users_role_id }}/4/"+proposals_id+"/"+post_id+"/"+proposals.sender_id+"/"+proposals.sender_role,
				type: 'get',
				beforeSend: function(){$(".set-proposal-notes-loader").show();},
				success: function(result) {
					$(".set-proposal-notes-loader").hide();
					if(result !=null && result != 'undefined' && result !=''){
						var notesset = result.notes;
					}else{
						var notesset = '';
					}
					//$('#notes_textarea_proposal').jqteVal(notesset);
					$('#notes_textarea_proposal').summernote('code',notesset);

					$('#notes-proposal-form-footer').html('<button class="btn-u btn-u-primary notes-proposal-form-submit" onclick="proposal_notes_add('+proposals_id+','+post_id+');" title="Save note">Save</button>');
				},
			  	error: function(data)
		    	{

		    	}
			});
		}
		/*insert note for proposal*/
		function proposal_notes_add(proposals_id,post_id) {
			var proposals = sharedproposale_data[proposals_id];
			$('#notes_textarea_proposal_error').text('');
			$('.notes-msg-text').text('');
			var value = $('#notes_textarea_proposal').summernote('code');
			if(value !=''){
				$.ajax({
					url: "{{url('/notes/data/insert')}}",
					type: 'post',
					data: {notes_type : 4,notes : value,notes_item_id :proposals_id, notes_item_parent_id : post_id,receiver_id : proposals.sender_id,receiver_role: proposals.sender_role,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
					success: function(result) {
						msgshowfewsecond('Note successfully save.');
						$('#set-proposal-notes').modal('hide');
					},error: function(result) {

					}
				});
			}else{
				$('#notes_textarea_proposal_error').text('This is required.');
			}
		}
		/*set notes in proposal*/
		function setnotesinusers(users_id,post_id) {
			$('#notes_textarea_users').summernote('code','');
			$('#notes-users-form-footer').html('');
			$('#notes_textarea_users_error').text('');
			$('.notes-msg-text').text('');
			$('#set-users-notes').modal('show');
			$.ajax({
				url: "{{url('/')}}/notes/get/{{ $user->id }}/{{ $user->agents_users_role_id }}/5/"+users_id+"/"+post_id+"/{{@$agents->id}}/{{@$agents->agents_users_role_id}}",
				type: 'get',
				beforeSend: function(){$(".set-users-notes-loader").show();},
				success: function(result) {
					$(".set-users-notes-loader").hide();
					if(result.status === "error" ){
						var notesset ="";
						var error =  result.status;
						$('#notes_textarea_users_error').text(error);

					}else{

						var notesset = result.notes;

					}
					//$('#notes_textarea_users').jqteVal(notesset);
					$('#notes_textarea_users').summernote('code',notesset);

					$('#notes-users-form-footer').html('<button class="btn-u btn-u-primary notes-users-form-submit" onclick="users_notes_add('+users_id+','+post_id+');" title="Save note">Save</button>');
				},
			  	error: function(data)
		    	{

		    	}
			});
		}
		/*insert note for users*/
		function users_notes_add(users_id,post_id) {
			$('#notes_textarea_users_error').text('');
			$('.notes-msg-text').text('');
			var value = $('#notes_textarea_users').summernote('code');
			if(value !=''){
				$.ajax({
					url: "{{url('/notes/data/insert')}}",
					type: 'post',
					data: {notes_type :5,notes : value,notes_item_id :users_id, notes_item_parent_id : post_id,receiver_id : '{{@$agents->id}}',receiver_role: '{{@$agents->agents_users_role_id}}',sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
					success: function(result) {
					console.log(result);
						if(result.status =="error"){
						      $('#notes_textarea_users_error').text(result.message);
						}else{

						msgshowfewsecond('Saved the note successfully');
						$('#set-users-notes').modal('hide');
						}

					},error: function(result) {

					}
				});
			}else{
				$('#notes_textarea_users_error').text('This is required.');
			}
		}


		/*update notes by notes id note*/
		function update_notes_show(notes_id,notes_title) {
			var notedata = notes_data[notes_id];
			$('.set-messages-notes-title').text(notes_title);
			//markupStr $('#notes_textarea').jqteVal(notedata.notes);
			$('#notes_textarea').summernote('code',notedata.notes);
			$('.dropdown-toggle').dropdown();
			//$('#notes_textarea').summernote('555');
			$('#notes-message-form-footer').html('<button class="btn-u btn-u-primary notes-message-form-submit" onclick="update_notes('+notes_id+');" title="Save note">Update</button>');
			$('#notes_textarea_error').text('');
			$('.notes-msg-text').text('');
			$('#set-messages-notes').modal('show');

		}
		function update_notes(notes_id) {
			$('#notes_textarea_error').text('');
			$('.notes-msg-text').text('');
			var value = $('#notes_textarea').summernote('code');
			if(value !=''){
				$('#notes_textarea_answers_error').text('');
				$.ajax({
					url: "{{url('/notes/data/update/')}}/"+notes_id,
					type: 'post',
					data: {notes : value,_token : '{{ csrf_token() }}'},
					success: function(result) {
						loadnotes(0);
						msgshowfewsecond('Note successfully update.');
						$('#set-messages-notes').modal('hide');
					},error: function(result) {

					}
				});
			}else{
				$('#notes_textarea_answers_error').text('This is required.');
			}
		}
		/*set notes in asked question*/
		function setnotesinaskedquestion(qid,pid) {
			var qq = sharedquestion_data[qid];
			$('.set-asked_question-notes-title').text(qq.question);
			//$('#notes_textarea_asked_question').jqteVal('');
			$('#notes_textarea_asked_question').summernote('code','');
			$('#notes-asked_question-form-footer').html('');
			$('#notes_textarea_error').text('');
			$('.notes-msg-text').text('');
			$('#set-asked_question-notes').modal('show');
			$.ajax({
				url: "{{url('/')}}/notes/get/{{ $user->id }}/{{ $user->agents_users_role_id }}/2/"+qid+"/"+pid+"/"+qq.sender_id+"/"+qq.sender_role,
				type: 'get',
				beforeSend: function(){$(".set-asked_question-notes-loader").show();},
				success: function(result) {
					$(".set-asked_question-notes-loader").hide();
					if(result !=null && result != 'undefined' && result !=''){
						var notesset = result.notes;
					}else{
						var notesset = '';
					}
					$('#notes_textarea_asked_question').summernote('code',notesset);
					$('#notes-asked_question-form-footer').html('<button class="btn-u btn-u-primary notes-asked_question-form-submit" onclick="askedquestion_notes_add('+qid+','+pid+');" title="Save note">Save</button>');
				},
			  	error: function(data)
		    	{

		    	}
			});
		}
		/*insert note for asked question*/
		function askedquestion_notes_add(qid,pid) {
			var qq = sharedquestion_data[qid];
			$('#notes_textarea_asked_question_error').text('');
			$('.notes-msg-text').text('');
			var value = $('#notes_textarea_asked_question').summernote('code');
			if(value !=''){
				$.ajax({
					url: "{{url('/notes/data/insert')}}",
					type: 'post',
					data: {notes_type : 2,notes : value,notes_item_id :qid, notes_item_parent_id : pid,receiver_id : qq.sender_id,receiver_role: qq.sender_role,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
					success: function(result) {
						// $('.notes-msg-text').text('Note successfully save.');
						msgshowfewsecond('Note successfully save.');
						$('#set-asked_question-notes').modal('hide');
					},error: function(result) {

					}
				});
			}else{
				$('#notes_textarea_asked_question_error').text('This is required.');
			}
		}


		/*chat script end*/
        $( document ).ready(function(e) {
	        $('body').on('click','.toolmodelopen',function(e){
	        	var mid = e.currentTarget.id;
	        	$('body .toolmodelpopup').not( 'body .'+mid ).toggleClass('toolmodelpopup');
	        	$('body .'+mid).toggleClass('toolmodelpopup');
	        });
	        $( "body" )
			  .on( "mouseenter",'.tooltips',function() {
			    $( this ).tooltip({trigger:'manual'}).tooltip('show');
			  })
			  .on( "mouseleave",'.tooltips', function() {
			    $( this ).tooltip({trigger:'manual'}).tooltip('hide');
			  });
	        /*submit message new*/
	        if (JSON.parse(localStorage.getItem( 'popups' )) !=null && JSON.parse(localStorage.getItem( 'popups' )) !='') {
	        	var popups1 = JSON.parse(localStorage.getItem( 'popups' ));

	        	$.each( popups1, function( key, value ) {
	        		var sd = value.split("_");
	        		register_popup(sd[1],sd[2],sd[3]);
	        	});
	        }
	    	var starttt = (new Date()).getTime() + 60000;
    	 	if (!sessionStorage.getItem( 'sstt' )) {
	            sessionStorage.setItem("sstt", starttt);
	        }else{
	        	starttt = sessionStorage.getItem( 'sstt' )
	        }
	        var inter = ( (starttt - (new Date).getTime())/1);
	        if (inter <= '60000')  {
	            	// setTimeout(function (){ servayloop();}, inter);
	        }else{
	        	starttt = (new Date()).getTime() + 60000;
	        	sessionStorage.setItem("sstt", starttt);
	        	var inter = ( (starttt - (new Date).getTime())/1);
		        if (inter <= '60000')  {
		            // setTimeout(function (){ servayloop();}, inter);
		        }
	        }

		    $("#profile-img").change(function(){
		        readURL(this);
		    });

		    /* edit profile picter for agent*/
			$("#edit-profile-pic").on('submit',(function(e) {
				e.preventDefault();
				$.ajax({
		        	url: "{{url('/')}}/profile/agent/editprofilepic",
					type: "POST",
					data:  new FormData(this),
					beforeSend: function(){$(".body-overlay").show();},
					contentType: false,
		    	    processData:false,
					success: function(data)
				    {	$(".body-overlay").hide();
						if(data.status=='loginerorr'){
							/*location.reload();*/
                                                          window.location.reload(true);
			    		}else{
							var src = $("#profile-img-tag").attr('src');
							$('#profile-pic').attr('src',src);
							$("#success-pic").text('Profile picture successfully change').css({'color':'green'});
							$('#changeprofilepic').modal('hide');
							$('.modal-backdrop').remove();
							//msgshowfewsecond('Profile picture successfully change.');
							msgshowfewsecond('Profile picture has been uploaded successfully');
							setTimeout(function () {
								/*location.reload();*/
                                                          window.location.reload(true);
							}, 2500);
			    		}
					},
				  	error: function(data)
			    	{	$(".body-overlay").hide();
			    		if(data.status=='500'){
							$("#success-pic").text(data.statusText).css({'color':'red'});
			    		}else if(data.status=='422'){
							$("#success-pic").text(data.responseJSON.image[0]).css({'color':'red'});
			    		}
			    	}
			   });
			}));

			/* edit post deatils for buyer and seller*/
			$("#edit-posttitle").on('submit',(function(e) {
				e.preventDefault();
				var $form = $(e.target);
				$.ajax({
		        	url: "{{url('/profile/buyer/updateposttitle')}}",
					type: "POST",
					data:  $form.serialize(),
					beforeSend: function(){$(".body-overlay").show();},
		    	    processData:false,
					success: function(result)
				    {
						$(".body-overlay").hide();
						if(typeof result.error !='undefined' && result.error !=null){
							var errors = result.error;
							if(errors['posttitle']){
								let err_msg = errors['posttitle'][0];
								err_msg = err_msg.replace("The posttitle","Post Title");
						   		$("#postmsgcheckpost").addClass('alert alert-danger text-center').html(err_msg);
							}else{
								$("#postmsgcheckpost").removeClass('alert alert-danger text-center').html('');
							}
						}
						if(typeof result.msg !='undefined' && result.msg !=null){
							$("#postmsgcheckpost").removeClass('alert alert-danger text-center').html('');
							$('#postmsgcheckpost').addClass('alert alert-success text-center').html(result.msg);
							// setInterval(function() {$("#postmsgcheckpost").removeClass('alert alert-success text-center').html(''); },5000);
							setTimeout(location.reload(),5000);
						}
					},
				  	error: function(data)
			    	{	$(".body-overlay").hide();
			    		if(data.status=='500'){
							$("#success-pic-checkpost").text(data.statusText).css({'color':'red'});
			    		}else if(data.status=='422'){
							$("#success-pic-checkpost").text(data.responseJSON.image[0]).css({'color':'red'});
			    		}
			    		// setInterval(function() {$(".body-overlay").hide(); },5000);
			    	}
			   });

			}));

			/* edit post deatils for buyer and seller*/
			$("#survey-loop").on('submit',(function(e) {
				e.preventDefault();
				var $form = $(e.target);
				$.ajax({
		        	url: "{{url('/questiontoanswer')}}",
					type: "POST",
					data:  $form.serialize(),
					beforeSend: function(){$(".survey-loop").show();},
		    	    processData:false,
					success: function(result)
				    {
						$(".survey-loop").hide();
						if(typeof result.error !='undefined' && result.error !=null){
							var errors = result.error;
							if(errors['answers']){
						   		$("#surveyquestionanswers").addClass('alert alert-danger text-center').html(errors['answers'][0]);
							}else{
								$("#surveyquestionanswers").removeClass('alert alert-danger text-center').html('');
							}
						}
						if(typeof result.msg !='undefined' && result.msg !=null){
							$("#surveyquestionanswers").removeClass('alert alert-danger text-center').html('');
							$('#surveyquestionanswers').addClass('alert alert-success text-center').html(result.msg);
							$('#Surveyquestionloop').addClass('hide').removeClass('show').css('background','#fff');
						}
					},
				  	error: function(data)
			    	{	$(".survey-loop").hide();
			    		if(data.status=='500'){
							$("#success-pic-checkpost").text(data.statusText).css({'color':'red'});
			    		}else if(data.status=='422'){
							$("#success-pic-checkpost").text(data.responseJSON.image[0]).css({'color':'red'});
			    		}
			    	}
			   });
			}));

			if('{{ Auth::user()->agents_users_role_id }}' == 2 ||  '{{ Auth::user()->agents_users_role_id }}' == 3){
				$.ajax({
					url: "{{url('/')}}/profile/buyer/post/get",
					type: 'POST',
					data: {agents_users_role_id :'{{ Auth::user()->agents_users_role_id }}', agents_user_id: '{{ Auth::user()->id }}', _token : '{{ csrf_token() }}'},
					success: function(result) {

						if(!result.post_id){
							$('#postcheck').addClass('show').css('background','#4343437d');
						}
					}
				});
			}

		});

	 	/*notification start*/
		var allnotification = [];
	 	function notification(limit,type) {
	 		if(limit==0){
	 			$('#notification-body').html('');
	 		}
		 	$.ajax({
				url: "{{url('/')}}/notification/get/"+limit,
				type: 'get',
				//beforeSend: function(){$(".notification-loader").show();},
		    	processData:false,
				success: function(result) {
					//$(".notification-loader").hide();
					if (result.unreadcount > 0) {
						$('#notification_count').addClass('o-p').removeClass('n-p').text(result.unreadcount);
					}else{
						$('#notification_count').addClass('n-p').removeClass('o-p');
					}
					if(result.count !== 0){
						$.each( result.result, function( key, value ) {
							allnotification[value.notification_id] = value;
							var url='';
							if(value.receiver_role == 4){
								if(value.notification_type==9){
								url = '{{ url("/messages/") }}/'+value.post_id+'/'+value.sender_id+'/'+value.sender_role;
								}else if(value.notification_type==11){
								url = '{{ url("/search/post/details/") }}/'+value.notification_child_item_id+'/'+value.notification_type;
								}else if(value.notification_type==12){
								url = '{{ url("/search/post/details/") }}/'+value.notification_item_id+'/'+value.notification_type;
								}else if(value.notification_type==13){
								url = '{{ url("/search/post/details/") }}/'+value.notification_item_id+'/'+value.notification_type;
								}else{
								url = '{{ url("/search/post/details/") }}/'+value.post_id+'/'+value.notification_type;
								}
							}else{
								if(value.notification_type==11){
								url = '{{ url("/search/agents/details/") }}/'+value.sender_id+'/'+value.notification_child_item_id+'/'+value.notification_type;
								} else{
								url = '{{ url("/search/agents/details/") }}/'+value.sender_id+'/'+value.post_id+'/'+value.notification_type;
								}
							}
							var unread = '';
							if(value.status == 1){
								unread = 'unread';
							}
							var currentDate = new Date();
							var endDate = value.created_at;
	    					var date = timeDifference(currentDate, new Date(endDate));
	    					// console.log(value);
	    					// alert(new Date(Date.fromISO(value.created_at)));


							var nhtmll = '<li class=" notif '+unread+'" id="notification_main_'+value.notification_id+'">'+
								          '<a class="cursor" onclick="readnotification('+value.notification_id+',\''+url+'\');">'+
								            '<div class="messageblock">'+
								              '<div class="message">'+value.notification_message+'</div>'+
								              '<div class="messageinfo">'+date+'</div>'+
								            '</div>'+
								          '</a>'+
								        '</li>';
					 		var msc = $('#notification_main_'+value.notification_id).find('#notification-body');
					 		var msct = msc.prevObject.length;
					 		if(msct==0){
					 			// if(type=='new'){
		       //                  $('#notification-body').prepend(nhtmll);
					 			// }else{
		                        $('#notification-body').append(nhtmll);
					 			// }
		                    }else{
		                    	$('#notification_main_'+value.notification_id).replaceWith( nhtmll );
		                    }
						});

						if(result.next!=0){
							$('#notificationmoreload').val(result.next);
						}else{
							$('#notificationmoreload').val('');
						}

						if(limit==0){
			                $('#notification-body').scroll(function(){
			                    var infiniteList = $('#notification-body');
							      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')  && $('#notificationmoreload').val() != 0) {
							      		notification($('#notificationmoreload').val());
							      }
			                });
						}
					}else{
						$('#notification-body').html(' <span class="label center black"> No new notification.</span>');
					}
				}
			});

	 	}


	 	function messages_notification(limit,type) {
	 		if(limit==0){
	 			$('#message_notification-body').html('');
	 		}
		 	$.ajax({
				url: "{{url('/')}}/message/notification/get/"+limit,
				type: 'get',
				beforeSend: function(){$(".message_notification-loader").show();},
		    	processData:false,
				success: function(result) {
					$(".message_notification-loader").hide();
					if(result.count !== 0){
						$('#message_notification_count').addClass('o-p').removeClass('n-p').text(result.count);
						$.each( result.result, function( key, value ) {
							allnotification[value.notification_id] = value;
							var url='';
							url = '{{ url("/messages/") }}/'+value.post_id+'/'+value.sender_id+'/'+value.sender_role;
							var photo ='{{ url("/assets/img/testimonials/user.jpg") }}';
							if(value.photo != null && value.photo != ''){
								photo = '{{ url("/assets/img/profile/") }}/'+value.photo;
							}
							var unread = '';
							if(value.status == 1){
								unread = 'unread';
							}
	    					var date = timeDifference(new Date(), new Date(Date.fromISO(value.created_at)));

							var nhtmll = '<li class=" notif '+unread+'" id="message_notification_main_'+value.notification_id+'">'+
								          '<a class="cursor" onclick="readnotification('+value.notification_id+',\''+url+'\');">'+
								            '<img src="'+photo+'" class="m-notification-img"> '+
								            '<div class="messageblock">'+
								              '<div class="message">'+value.name+' <br> '+value.snippet+'</div>'+
								              '<div class="message-notification-time messageinfo">'+date+'</div>'+
								            '</div>'+
								          '</a>'+
								        '</li>';
					 		var msc = $('#message_notification_main_'+value.notification_id).find('#notification-body');
					 		var msct = msc.prevObject.length;
					 		if(msct==0){
					 			// if(type=='new'){

		       //                  $('#message_notification-body').prepend(nhtmll);
					 			// }else{

		                        $('#message_notification-body').append(nhtmll);
					 			// }
		                    }else{
		                    	$('#message_notification_main_'+value.notification_id).replaceWith( nhtmll );
		                    }
						});

						if(result.next!=0){
							$('#message_notificationmoreload').val(result.next);
						}else{
							$('#message_notificationmoreload').val('');
						}

						if(limit==0){
			                $('#message_notification-body').scroll(function(valu){
			                    var infiniteList = $('#message_notification-body');
							      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')  && $('#message_notificationmoreload').val() != 0) {
							      		messages_notification($('#message_notificationmoreload').val());
							      }
			                });
						}
					}else{
						$('#message_notification-body').html('<span class="label center black"> No new messages.</span>');
						$('#message_notification_count').addClass('n-p').removeClass('o-p');
					}
				}
			});
	 	}
  notification(0);
  messages_notification(0);
	 	function readnotification(notification_id,url) {
 			$.ajax({
				url: "{{ url('/notification/update/read/') }}/"+notification_id,
				type: 'get',
				success: function(result) {
	 				window.location.href = url;
				},error: function(result) {
				}
			});
	 	}
	 	function redarecturl(url) {
	 		window.location.href = url;
	 	}
	 	function maxLengthCheck(object) {
          if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
        }

        function isNumeric (evt) {
          var theEvent = evt || window.event;
          var key = theEvent.keyCode || theEvent.which;
          key = String.fromCharCode (key);
          var regex = /[0-9]|\./;
          if ( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
          }
        }
	 	function readnotificationbyreciverid(sender_id,sender_role,receiver_id,receiver_role,notification_type) {
 			$.ajax({
				url: "{{ url('/notification/update/read/by/receiver_id') }}",
				type: 'post',
				data: {receiver_id : receiver_id,receiver_role : receiver_role,notification_type :notification_type, sender_id : sender_id,sender_role : sender_role,_token : '{{ csrf_token() }}'},
				success: function(result) {
				console.log(result);
				},error: function(result) {
				}
			});
			messages_notification(0,'new');
            notification(0,'new');
	 	}
	 	/*notification end*/

	 	function readURL(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            reader.onload = function (e) {
	               // $('#profile-img-tag').attr('src', e.target.result);
	            }
	          //  reader.readAsDataURL(input.files[0]);
	        }
	    }

		function servayloop() {
			$.ajax({
				url: "{{url('/survey/loop/question/get')}}",
				type: 'get',
				success: function(result) {
					if(result.question){
						$("#surveyquestionanswers").removeClass('alert alert-danger text-center').html('');
						$('#querysurvay').text('1). '+result.question);
						$('.survey_question_id').val(result.question_id);
						$('#question_survay_answers').val('');
						$('#Surveyquestionloop').addClass('show').css('background','#4343437d');
					}
				}
			});
			starttt = (new Date()).getTime() + 60000;
        	sessionStorage.setItem("sstt", starttt);
        	var inter = ( (starttt - (new Date).getTime())/1);
	        //
	        if (inter <= '60000')  {
	            // setTimeout(function (){ servayloop();}, inter);
	        }
		}
		function removedsh(value) {
			return value.replace('_', '.');
		}
		function loadcompare(post_id) {
	       	$.ajax({
				url: "{{url('/compare/list/')}}/0/{{ Auth::user()->id }}/{{ Auth::user()->agents_users_role_id }}/"+post_id,
				type: 'get',
				beforeSend: function(){$(".compare-loader").show();},
    	    	processData:true,
				success: function(result) {

					$(".compare-loader").hide();

					if(result.count !== 0){
						$('#addecomparediv').html('');
						$.each( result.result, function( key, value ) {

							if(value.name != null){
								// compare_data[value.compare_id] = value;
								var photo = '{{ URL::asset("assets/img/testimonials/user.jpg") }}';
								if(value.photo != null && value.photo != ''){
									photo = '{{ url("assets/img/profile/") }}/'+value.photo;
								}
								//console.log(value);
								var compd = '<div class="compare-thumb col-md-3 compare-property compare-agents-'+value.details_id+' row" data-property-id="771">'+
					                            '<div class="col-sm-2 c-list-img"><img class="compare-property-img rounded-x" width="40" height="40" src="'+photo+'" alt="" title=""></div>'+
					                            '<div class="col-sm-10 c-list-text">'+
					                            	'<h5 class="hidetext1line">'+value.name+'  </h5>'+
					                                '<div class="hidetext1line">'+(value.description !=null ? value.description : '&nbsp;')+'</div>'+
					                            '</div>'+
					                            '<button type="button" class="compare-property-remove" onclick="removetocompare('+value.compare_id+','+value.details_id+');"><i class="fa fa-times"></i></button>'+
					                        '</div>';
								$('#addecomparediv').append(compd);
							}
						});
						$('#comparecount').removeClass('hide');
					}else{
						$('#addecomparediv').html('<p class="text-center"> Not any selected to compare agents </p>');
						$('#comparecount').addClass('hide');
					}

				},error: function(result) {

				}
			});

		}

		function addtocompare(id) {
			var agentdata = agentsdata[id];
			if($('.compare-property').length ==0){
				$('#addecomparediv').html('');
			}
			if($('.compare-property').length > 5){
        		alert('Select Only 5 Agents.');
            }else{

		       	$.ajax({
					url: "{{url('/compare/insert')}}",
					type: 'post',
					data: {post_id : agentdata.post_id ,compare_item_id : agentdata.id, _token : '{{ csrf_token() }}'},
					success: function(result) {
						$('#compare_id').val(result.data);
						$('.compare_list_'+id).html('<a class="cursor red" onclick="removetocompare('+result.data+','+id+')"> <i class="fa fa-times-circle red"></i> Remove To Compare </a>');
						var photo = '{{ URL::asset("assets/img/testimonials/user.jpg") }}';
						if(agentdata.photo != null && agentdata.photo != ''){
							photo = '{{ url("assets/img/profile/") }}/'+agentdata.photo;
						}
						let desc = (agentdata.description !== null && agentdata.description !== '') ? `<div class="hidetext1line">${agentdata.description}</div>`:"";
						var compd = '<div class="compare-thumb compare-property compare-agents-'+id+' row" data-property-id="771">'+
			                            '<div class="col-md-2 c-list-img"><img class="compare-property-img rounded-x" width="40" height="40" src="'+photo+'" alt="" title=""></div>'+
										'<div class="col-md-10 c-list-text"><h5>'+agentdata.name+'</h5>'
										+desc+
			                            '</div>'+
			                            '<button type="button" class="compare-property-remove" onclick="removetocompare('+result.data+','+id+');"><i class="fa fa-times"></i></button>'+
			                        '</div>';
						$('#addecomparediv').append(compd);
						$('#comparecount').removeClass('hide');
					},error: function(result) {
					}
				});

            }
		}
		function removetocompare(compare_id,userid) {
			var agentdata = agentsdata[userid];
			$('.compare-agents-'+userid).remove();
			if($('.compare-property').length==0){
				$('#comparecount').addClass('hide');
			}
	       	$.ajax({
				url: "{{ url('/compare/delete') }}/"+compare_id+'/'+userid,
				type: 'get',
				success: function(result) {
					$('.compare_list_'+userid).html('<a class="cursor sitegreen" onclick="addtocompare('+userid+')"> <i class="fa fa-plus-circle sitegreen"></i> Add To Compare </a>');
				},error: function(result) {
				}
			});
		}
		// function lastactivity() {
	 //       	$.ajax({
		// 		url: "{{ url('/lastactivity') }}",
		// 		type: 'get',
		// 		success: function(result) { setTimeout(lastactivity(), 180000); },error: function(result) {}
		// 	});
		// }

		function loadmultipalselectebox() {
	        $('html').on('click','.multiselectkamlesh',function(e){
	        	jQuery(this).parent('.btn-group').addClass('open');
	        });
		}



$(document).ready(function(){
$('.jqte-test').summernote({
		dialogsInBody: true ,
		/*onDialogHidden: function(e) {
			alert(1);
		}*/
});
$('.dropdown-toggle').dropdown();
$('.note-editable').removeClass('panel-body');
});


	(function() {
	  $(function() {

	    $demo = $("#demo");
	    duration = 5000;
	    remaining = duration;
	    tour = new Tour({
	      onStart: function() {
	        return $demo.addClass("disabled", true);
	      },
	      onEnd: function() {
	        // return $demo.removeClass("disabled", false);
	        return $demo.removeClass("disabled");
		  },
		  onNext: function (tour) {

			  if(tour._current == 18){
				tour.end();
			  }
		  },
	      debug: true,
	      steps: [
	        {
	          element: "#AgentsDASHBOARDTOUR",
	          title: "Dashboard",
	          content: "<p> Dashboard is where all actions come to life. <br> See and Do everything in one place </p>"
	        },
	        {
	          element: "#AgentsMYJOBSTOUR",
	          title: "My Jobs",
	          content: "<p> See all your buyers and sellers here. <br> Their Posts, Messages, Notifications etc </p>"
	        },
	        {
	          element: "#CONNECTEDJOBSTOUR",
	          title: "Connected Jobs",
	          content: "</p> Buyer, Seller select you for 'XYZ' post </p>"
	        },
	        {
	          element: "#FINDJOBS",
	          title: "Find Jobs",
	          content: "<p> Search all buy, sell postings and more <br> "+
						"Example.  <br> "+
						"Search Buyer and Seller by name <br> "+
						"Search Questions, Messages and Answers <br> "+
						"Search posts  <br> "+
						"Search posts containing keywords like 'ASAP' or 'foreclosing' etc. <br> "+
						"Search by date, partial address , city, state and ZIP Code </p> <br> ",
	          reflex: true
	        },

			{
	          element: "#AgentPROFILEture,#AGENTPROFILESIDESIDE",
	          title: "Profile",
	          content: "<p> It has Profile,Security settings, Personal bio, Professional bio and more </p>"
	        },

			{
	          element: "#NOTESTOUR",
	          title: "Notes",
	          content: 	"<p> Don't memorize !!! <br>"+
						" Take note on anything important in the site. Use it for later reference </p>"
	        },
			{
	          element: "#BOOKMARKTOUR",
	          title: "Bookmark",
	          content: "<p> Bookmark anything important in the site.<br> Use it whenever needed </p>",
	          reflex: true
	        },
			{
	          element: "#AgentsQUESTIONSture",
	          title: "Questions",
	          content: "<p> Pre-written questions for buyer and the seller.<br> share any of these when needed </p>",
	          reflex: true
	        },
		 	{
	          element: "#AGENTOTHERRESOURCESSIDE",
	          placement: "bottom",
	          title: "Other Resources",
	          content: 	"<p> here you will create and share several key items <br>"+
							"1. Create and upload proposals <br> "+
							"2. Upload documents <br> "+
							"3. Add questions to buyer and seller <br> "+
							"4. Add a survey questions to the site admin <br> "+
						"</p>",
	          reflex: true
	        },
	        {
	          element: "#BuyerDASHBOARDTOUR",
	          title: "Dashboard",
	          content: "<p> Dashboard is where all actions come to life </p>"
	        },
         	{
	          element: "#BuyersellerMYJOBSTOUR",
	          title: "My Jobs",
	          content: "<p> See all your {{ Auth::user()->agents_users_role_id==2 ? 'buy' : 'sell' }}  posts here </p>"
	        },
         	{
	          element: "#BuyersellerFindAgents",
	          title: "Find Agents",
	          content: "<p> Search all Agents, Questions, Messages, Answers <br> "+
						"Example. <br> "+
						"Search agents by name <br> "+
						"Search partial questions like commission <br> "+
						"Search partial answers like 1% <br> "+
						"Search by date, partial address , city, state and ZIP Code <br> "+
 					"</p>"
	        },
         	{
	          element: "#buyerPROFILE,#BUYERSELLERPROFILESIDESIDE",
	          title: "Profile",
	          content: "<p> It has Personal Profile,Security settings, <br> Personal bio and Password Settings </p>"
	        },
         	{
	          element: "#buyerNOTESTOUR",
	          title: "Notes",
	          content: "<p> Take note on anything in the site including messages and chats. <br> Use it for Side-by-side Compare </p>"
	        },
         	{
	          element: "#buyerBookmark",
	          title: "Bookmark",
	          content: "<p> Bookmark anything in the site including messages and chats. <br> Use it for Side-by-side Compare </p>"
	        },
	        {
	          element: "#BUYERSELLEROTHERRESOURCESSIDE",
	          title: "Other Resources",
	          content: "<p> here you will create and share several key items <br>"+
						"1. Upload documents and share it with the agents <br>"+
						"2. Add questions to the agents. Mark them as Important <br>"+
						"3. Add a survey questions to the site admin <br>"+
						"4. Share important questions to agents <br>"+
						 "</p>"
	        },
	        {
	          element: "#SELLERMESSAGESIDE",
	          placement: "bottom",
	          title: "Message",
	          content: "<p> Get messages from all the Agents </p>",
	          reflex: true
	        },
	        {
	          element: "#BUYERSMESSAGESIDE",
	          placement: "bottom",
	          title: "Message",
	          content: "<p> Get messages from all the Agent </p>",
	          reflex: true
	        },
	        {
	          element: "#AGENTMESSAGESIDE",
	          placement: "bottom",
	          title: "Message",
	          content: "<p> Get all messages from buyers and sellers </p>",
	          reflex: true
	        },
	      ]
	    }).init();
	    $(document).on("click", "[data-demo]", function(e) {
	      e.preventDefault();
	      if ($(this).hasClass("disabled")) {
	        return;
	      }
	      tour.restart();
	      return $(".alert").alert("close");
	    });
	    // $("html").smoothScroll();
	  });
	}).call(this);


	//$('#question1').on('change', function (e) {
				$(document).on('change','#question1',function (e) {
			    var valueSelected = $(this).val();
			    $('#question2 option').removeClass('hide');
				//alert(1);
			    if(valueSelected!=''){
			    $('#question2 option[value='+valueSelected+']').addClass('hide');
				}
			});
			$(document).on('change','#question2',function (e) {
			//$('#question2').on('change', function (e) {
			    var valueSelected = $(this).val();
				//alert(2);
			    $('#question1 option').removeClass('hide');
			    if(valueSelected!=''){
			    $('#question1 option[value='+valueSelected+']').addClass('hide');
				}
			});

			$(document).on('click','#changsecunj',function (e) {
			//$('#changsecunj').click(function(e) {
				var valueSelected = $('#question1').val();
			    $('#question2 option').removeClass('hide');
			    if(valueSelected!=''){
			    $('#question2 option[value='+valueSelected+']').addClass('hide');
			    }
			    var valueSelected = $('#question2').val();
			    $('#question1 option').removeClass('hide');
			    if (valueSelected!='') {
			    $('#question1 option[value='+valueSelected+']').addClass('hide');
			    }
			});


$('.modal').on('show.bs.modal', function (e) {
			$('body').addClass('bs-modal-open');
		})
	.on('hidden.bs.modal', function (e) {
		$('body').removeClass('bs-modal-open');
	});

	function fetch_notification() {
	  myVar = setInterval(notification, 10000, '0');
	  myVar1 = setInterval(messages_notification, 15000, '0');
	}

	fetch_notification();
</script>
@yield('scripts')

<!-- token:     description:             example:
#YYYY#     4-digit year             1999
#YY#       2-digit year             99
#MMMM#     full month name          February
#MMM#      3-letter month name      Feb
#MM#       2-digit month number     02
#M#        month number             2
#DDDD#     full weekday name        Wednesday
#DDD#      3-letter weekday name    Wed
#DD#       2-digit day number       09
#D#        day number               9
#th#       day ordinal suffix       nd
#hhhh#     2-digit 24-based hour    17
#hhh#      military/24-based hour   17
#hh#       2-digit hour             05
#h#        hour                     5
#mm#       2-digit minute           07
#m#        minute                   7
#ss#       2-digit second           09
#s#        second                   9
#ampm#     "am" or "pm"             pm
#AMPM#     "AM" or "PM"             PM
var now = new Date(value.updated_at);

-->
