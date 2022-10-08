<script type="text/javascript" src="{{ URL::asset('front/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery-migrate-1.0.0.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/revolution-slider/js/jquery.themepunch.plugins.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/revolution-slider/js/jquery.themepunch.revolution.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery.parallax.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery.wait.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/fappear.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/modernizr-2.6.2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery.bxslider.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery.prettyPhoto.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/superfish.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/tweetMachine.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/tytabs.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery.gmap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery.sticky.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery.countTo.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jflickrfeed.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/imagesloaded.pkgd.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/waypoints.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/wow.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/jquery.fitvids.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/spectrum.js') }}"></script>
<!-- <script type="text/javascript" src="{{ URL::asset('front/js/switcher.js') }}"></script> -->
<script type="text/javascript" src="{{ URL::asset('front/js/custom.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('front/js/inputmask.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/formvalidation/formValidation.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/formvalidation/bootstrap.min.js') }}"></script>

<script type="text/javascript">
	<?php
		if(isset($stype) && !empty($stype)){ ?>
			autosignupmodal('{{ $stype }}');
	<?php
		}
	 ?>
 	var esmsg = $('.message');
	var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        specialKeys.push(9); //Tab
        specialKeys.push(46); //Delete
        specialKeys.push(36); //Home
        specialKeys.push(35); //End
        specialKeys.push(37); //Left
        specialKeys.push(39); //Right
        function IsAlphaNumeric(e) {
            var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
            var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
            return ret;
        }


	function stepchange(step) {
		$("#Step1,#Step2,#Step3").removeClass('show').addClass('hide');
		$("#"+step).removeClass('hide').addClass('show');
	}
	var userrole='';
	$(document).on('click','.nesuserlogine',function(){
		var model = $('#nesuserlogin');
		var roll = $(this).attr('data-target');
		var users_role_id = $('#agents_users_role_id');
		var usertitle = $('.usertitle');
		if(roll=='modalseller'){

		   	users_role_id.val('3');
		   	usertitle.text('Login as Seller');
		   	$('.loginsignupbutton').html('<a class="nesusersignup cursor" data-target="modalseller">Sign Up</a>');

		}else if(roll=='modalbuyer'){

		   	users_role_id.val('2');
		   	usertitle.text('Login as  Buyer');
		   	$('.loginsignupbutton').html('<a class="nesusersignup cursor" data-target="modalbuyer">Sign Up</a>');

		}else if(roll=='modalagent'){

	  	 	users_role_id.val('4');
	  	 	usertitle.text('Login as  Agent');
		   	$('.loginsignupbutton').html('<a class="nesusersignup cursor" data-target="modalagent">Sign Up</a>');

		}

		esmsg.removeClass('alert alert-danger text-center').html('');

		model.modal('show');

	});
	$(document).on('click','.nesusersignup',function(){

		$('.emptyclass').val('');
		stepchange('Step1');

		$('.help-block').hide();
		$('.has-error .form-control').css({'border':'1px solid #ccc'});
		$('.has-error .control-label').css({'color':'#999'});
		$('.has-error i').removeClass('glyphicon glyphicon-remove');
		var roll = $(this).attr('data-target'),model = $('#nesusersignup'),users_role_id = $('.users_role_id'),usertitle = $('.usertitle');

		if(roll=='modalseller'){

			$('.submitbutton').text('I am ready to sell');
		   	users_role_id.val('3');
		   	usertitle.text('Seller');userrole='seller';
		   	$('.signinurl').html('<a class="nesuserlogine cursor" data-target="modalseller">Sign In</a>');

		}else if(roll=='modalbuyer'){

			$('.submitbutton').text('I am ready to buy');
		   	users_role_id.val('2');
		   	usertitle.text('Buyer');
		   	userrole='buyer';
		   	$('.signinurl').html('<a class="nesuserlogine cursor" data-target="modalbuyer">Sign In</a>');

		}else if(roll=='modalagent'){

			$('.submitbutton').text('Submit');
	  	 	users_role_id.val('4');
	  	 	usertitle.text('Agent');
	  	 	userrole='agent';
		   	$('.signinurl').html('<a class="nesuserlogine cursor" data-target="modalagent">Sign In</a>');

		}

		esmsg.removeClass('alert alert-danger text-center').html('');
		$('.has-success .form-control ,.has-error .form-control').css({'border':'1px solid #ccc'});
		$('.has-success i, .has-error i,.form-control-feedback').removeClass('glyphicon glyphicon-remove glyphicon-ok');
		$('.has-success .help-block, .has-error .help-block').hide();
		$('.has-success .control-label, .has-error .control-label').css({'color':'#999'});
		//$('#buyerForm' ).data('formValidation').resetForm();
		$('#buyerFormStep2' ).data('formValidation').resetForm();
		$('#buyerFormStep3' ).data('formValidation').resetForm();
		model.modal('show');

	});

$('#nesusersignup').on('hidden.bs.modal', function () {

	$('#buyerForm' ).each(function(){
		this.reset();
	});
	$('#buyerFormStep2' ).each(function(){
		this.reset();
	});

	$('#buyerFormStep3' ).each(function(){
		this.reset();
	});
});

	$('#buyerForm').formValidation({
	    framework: 'bootstrap',
	    icon: {
	        valid: 'glyphicon glyphicon-ok',
	        invalid: 'glyphicon glyphicon-remove',
	        validating: 'glyphicon glyphicon-refresh'
	    },
		//excluded: [':disabled'],
	    fields: {
	        fname: {
	            validators: {
	                notEmpty: {
	                message: 'The first name is required'
	                },
					regexp: {
                    regexp: /^[a-zA-Z ]+$/,
                        message: 'The first name can only consist of alphabetical'
                    }
	            }
	        },
			lname: {
	            validators: {
	                notEmpty: {
	                message: 'The last name is required'
	                },
					regexp: {
                    regexp: /^[a-zA-Z ]+$/,
                        message: 'The last name can only consist of alphabetical'
                    }
	            }
	        },
	        email: {
	            validators: {
	                notEmpty: {
	                	message: 'The email address is required'
	                },
                    regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'The value is not a valid email address'
                    }
	            }
	        },
			password: {
				validators: {
					notEmpty: {
						message: 'The password is required'
					},
					stringLength: {
						min: 6,
						message: 'Passwords must be at least 6 characters in length'
					}

				}
			},
			confirm_password: {
				validators: {
				notEmpty: {
					message: 'The Confirm password is required'
				}
				,identical: {
					field: 'password',
						message: 'The password and confirm password are not the same'
					}
				}
			},
	        terms_and_conditions: {
	            validators: {
	                notEmpty: {
	                message: 'Acceptance of Terms and Conditions is required'
	                }
	            }
	        }
	    }
	}).on('success.form.fv', function(e){
		e.preventDefault();
		var $form = $(e.target),
		fv= $form.data('buyerForm');
		$.ajax({
			url: "{{url('/')}}/signup1",
			type: 'POST',
			data: $form.serialize(),
			beforeSend: function(){  $(".body-overlay").removeClass('hide').addClass('show');  },
		 	processData:false,
			success: function(result) {
				$(".body-overlay").removeClass('show').addClass('hide');

				if(typeof result.error !='undefined' && result.error !=null){
					$('.error-text').addClass('hide').text('');
					$.each( result.error, function( key, value ) {
					 	 $('#'+key+'-error').removeClass('hide').text(value);
						});
					 esmsg.text('').addClass('hide').removeClass('show');

				}

				if(typeof result.msg !='undefined' && result.msg !=null){
					esmsg.text(result.msg.error).css({'color':'red'}).removeClass('hide').addClass('show')
					$('.error-text').addClass('hide').text('');
				}

				if(typeof result.userDetails !='undefined' && result.userDetails !=null){

					esmsg.text('').addClass('hide').removeClass('show');
					$('.error-text').addClass('hide').text('');

				 	var detail = result.userDetails;
					$('.step2id').val(detail.id);
					$('.phone').val(detail.phone);
					$('.address1').val(detail.address);
					$('.address2').val(detail.address2);
					//$('.city').val(detail.city_id);
					$(".city option[value='" + detail.city_id + "']").prop("selected", true);
					$(".state option[value='" + detail.state_id + "']").prop("selected", true);
					$('.zip_code').val(detail.zip_code);
					stepchange('Step2');
					if (typeof result.emaildata != 'undefined' && result.emaildata != null) {
						$.ajax({
							url: "{{url('/sendsignupmail/')}}",
							type: 'GET',
							data: { email : result.emaildata.email, rolename : result.emaildata.rolename, url : result.emaildata.url, name : result.emaildata.name, _token : '{{ csrf_token() }}' },
							dataType:'html',
							success:function(response){
							}
						});
					}
				}
			},
		  	error: function(data)
	    	{
	    		$(".body-overlay").removeClass('show').addClass('hide');
	    		if(data.status=='500'){
					esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');
	    		}else if(data.status=='422'){
					esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');
	    		}
	    	}
		});
	});

	$('#buyerFormStep2').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            phone: {
                validators: {
					callback: {
						message: 'The phone is not valid',
						callback: function (value, validator, $field) {
							var value2 = (""+value).replace(/\D/g, '');
							if (value2.length < 10) {
                                return {
                                    valid: false,
                                    message: 'Please enter 10 digits phone number'
                                }
                            }
							 return true;

						}
					}

                }
            },
            address_line_1: {
                validators: {
                    notEmpty: {
                        message: 'The address line 1 is required'
                    }
                }
            },
           city: {
                validators: {
                    notEmpty: {
                        message: 'The city is required'
                    }
                }
            },
            state: {
                validators: {
                    notEmpty: {
                        message: 'The state is required'
                    }
                }
            },
            zip_code: {
                validators: {
                    notEmpty: {
                        message: 'The zip code is required'
                    },
					stringLength: {
                        min: 5,
                        max: 5,
                        message: 'Please enter 5 digits zip code'
                    }

                }
            },
        }
	}).on('keyup', '#phone', function(e) {
            $('#buyerFormStep2').formValidation('revalidateField', 'phone');
        }).
	on('change', '#state', function(e) {
            $('#buyerFormStep2').formValidation('revalidateField', 'state');
             // $('#buyerFormStep2').formValidation('revalidateField', 'city');
             console.log('cc');
        })
	.on('success.form.fv', function(e){
		e.preventDefault();
		var $form = $(e.target),

		fv= $form.data('buyerFormStep2');
		$.ajax({
			url: "{{url('/')}}/signup2",
			type: 'POST',
			data: $form.serialize(),
			beforeSend: function(){ $(".body-overlay").removeClass('hide').addClass('show'); },
		 	processData:false,
			success: function(result) {
				$(".body-overlay").removeClass('show').addClass('hide');

				if(typeof result.error !='undefined' && result.error !=null){
				 	$.each( result.error, function( key, value ) {
				 	 	$('#'+key+'-error').removeClass('hide').text(value);
					});
				 	esmsg.text('').addClass('hide').removeClass('show');

				 	$('#buyerFormStep2Submit').prop("disabled", false);
					$('#buyerFormStep2Submit').removeClass("disabled");
				}

				if(typeof result.msg != 'undefined' && result.msg != null){
					$('.error-text').addClass('hide').text('');
					esmsg.text(result.msg.error).css({'color':'red'}).removeClass('hide').addClass('show')
				}

				if(typeof result.userDetails !='undefined' && result.userDetails !=null){
				 	esmsg.text('').addClass('hide').removeClass('show');
				 	$('.error-text').addClass('hide').text('');

				 	var detail = result.userDetails;

					if(detail.agents_users_role_id == 4){

						$('.license').val(detail.licence_number);

						$('.bysellfield').removeClass('hide').addClass('show');
						$('.agentfield').removeClass('show').addClass('hide');
					}

					if(detail.agents_users_role_id != 4){

						if(result.postdetails !=null){
							$('.posttitle').val(result.postdetails.posttitle);
						}
						if(detail.agents_users_role_id==2){
							$('#posttitlechange').text('Buy Post');
						}else{
							$('#posttitlechange').text('Sell Post');
						}
						$('.agentfield').removeClass('hide').addClass('show');
						$('.bysellfield').removeClass('show').addClass('hide');
					}

					$('.step3id').val(detail.id);
					stepchange('Step3');
				}
			},
		  	error: function(data)
	    	{
	    		$(".body-overlay").removeClass('show').addClass('hide');

	    		if(data.status=='500'){

					esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');
	    		}else if(data.status=='422'){

					esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');
	    		}
	    	}
		});

	});

	$('#buyerFormStep3').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
        }
	}).on('success.form.fv', function(e){
		e.preventDefault();
		var $form = $(e.target),
		fv= $form.data('buyerFormStep3');
		$.ajax({
			url: "{{url('/')}}/signup3",
			type: 'POST',
			data: $form.serialize(),
			beforeSend: function(){ $(".body-overlay").removeClass('hide').addClass('show'); },
		 	processData:false,
			success: function(result) {
				$(".body-overlay").removeClass('show').addClass('hide');

				if(typeof result.error !='undefined' && result.error !=null){

					$.each( result.error, function( key, value ) {
					 	 $('#'+key+'-error').removeClass('hide').text(value);
						});
				 	esmsg.text('').addClass('hide').removeClass('show');

				}

				if(typeof result.msg !='undefined' && result.msg !=null){
					esmsg.text(result.msg.error).css({'color':'red'}).removeClass('hide').addClass('show')
				 	$('.error-text').addClass('hide').text('');
				}

				if(typeof result.userDetails !='undefined' && result.userDetails !=null){

				 	esmsg.removeClass('alert alert-danger text-center show').addClass('hide').html('');
				 	$('.error-text').addClass('hide').text('');


				 	esmsg.removeClass('hide show').addClass('alert alert-success text-center').html('<h4>Thanks you!</h4><p>Your Signup has been successfully! Check your email and verify your account</p>');

			 	 	stepchange('Step4');

					setTimeout(function(){ $('#nesusersignup').modal('hide'); }, 1500);
				}
			},
		  	error: function(data)
	    	{	$('.error-text').addClass('hide').text('');
	    		$(".body-overlay").removeClass('show').addClass('hide');

	    		if(data.status=='500'){

					esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');
	    		}else if(data.status=='422'){

					esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');
	    		}
	    	}
		});
	});

	/*login strat*/
	$('#logineuser').formValidation({
		    framework: 'bootstrap',
		    icon: {
		        valid: 'glyphicon glyphicon-ok',
		        invalid: 'glyphicon glyphicon-remove',
		        validating: 'glyphicon glyphicon-refresh'
		    },
		    fields: {
		        email: {
		            validators: {
		                notEmpty: {
		                message: 'The email address is required'
		                },
		                emailAddress: {
		                message: 'The input is not a valid email address'
		                }
		            }
		        },
				password: {
					validators: {
						notEmpty: {
							message: 'The password is required'
						}
						// stringLength: {
						// 	min: 6,
						// 	message: 'Passwords must be at least 6 characters in length'
						// }

					}
				}
		    }
		}).on('success.form.fv', function(e){
			e.preventDefault();

			var $form = $(e.target),
			fv= $form.data('logineuser');

			$.ajax({
				url: "{{url('/')}}/login_api",
				type: 'POST',
				data: $form.serialize(),
				beforeSend: function(){  $(".body-overlay").removeClass('hide').addClass('show');  },
			 	processData:false,
				success: function(result) {
					grecaptcha.reset();
					$('#gcap_login_btn').prop("disabled", false);
					$('#gcap_login_btn').removeClass("disabled");
					$(".body-overlay").removeClass('show').addClass('hide');

					if(typeof result.error !='undefined' && result.error !=null){
						$.each( result.error, function( key, value ) {
						 	 $('#user-'+key+'-error').removeClass('hide').text(value);
							});
					 	esmsg.text('').addClass('hide').removeClass('show');
					}

					if(typeof result.email !='undefined' && result.email !=null){
					 	$('#user-email-error').removeClass('hide').text(result.email);
						esmsg.text('').addClass('hide').removeClass('show');
					}
					if(typeof result.check !='undefined' && result.check !=null){
						esmsg.text(result.check).css({'color':'red'}).removeClass('hide').addClass('show')
					 	$('.error-text').addClass('hide').text('');
					}

					if(typeof result.success !='undefined' && result.success !=null){
						window.location.href = "{{URL('/dashboard')}}";
					}
				},
			  	error: function(data)
		    	{
		    		$('#gcap_login_btn').prop("disabled", false);
		    		$('#gcap_login_btn').removeClass("disabled");
		    		grecaptcha.reset();
		    		$('.error-text').addClass('hide').text('');
		    		$(".body-overlay").removeClass('show').addClass('hide');
		    		if(data.status=='500'){
						esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');
		    		}else if(data.status=='422'){
						esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');
		    		}
		    	}
			});



		});
	/*login end*/

	$(window).load(function()
	{
	   var phones = [{ "mask": "(###) ###-####"}];
	    $('#phone').inputmask({
	        mask: phones,
	        greedy: false,
	        definitions: { '#': { validator: "[0-9]", cardinality: 1}}

	    });

	});

	$('#nesusersignup').on('show.bs.modal', function (e) {
	  $('#registrationModal').modal('hide');
	  $('#loginModal').modal('hide');
	  $('#nesuserlogin').modal('hide');
	});
	$('#nesuserlogin').on('show.bs.modal', function (e) {
	  $('#loginModal').modal('hide');
	  $('#registrationModal').modal('hide');
	  $('#nesusersignup').modal('hide');
	});
	function loadmultipalselectebox() {
	    $('html').on('click','.multiselectkamlesh',function(e){
	    	jQuery(this).parent('.btn-group').addClass('open');
	    });
	}
	function autosignupmodal(utype) {

		stepchange('Step1');

		$('.help-block').hide();
		$('.has-error .form-control').css({'border':'1px solid #ccc'});
		$('.has-error .control-label').css({'color':'#999'});
		$('.has-error i').removeClass('glyphicon glyphicon-remove');
		var roll = utype,
		model = $('#nesusersignup'),
		users_role_id = $('.users_role_id'),
		usertitle = $('.usertitle');

		if(roll=='seller'){

		   $('.submitbutton').text('I am ready to sell');
		   users_role_id.val('3'); usertitle.text('Seller');userrole='seller';
		   	$('.signinurl').html('<a class="nesuserlogine cursor" data-target="modalseller">Sign In</a>');

		}else if(roll=='buyer'){

		   $('.submitbutton').text('I am ready to buy');
		   users_role_id.val('2'); usertitle.text('Buyer');userrole='buyer';
		   $('.signinurl').attr('href','{{ URL("/") }}/login?usertype=buyer');
		   	$('.signinurl').html('<a class="nesuserlogine cursor" data-target="modalbuyer">Sign In</a>');

		}else if(roll=='agent'){

		   $('.submitbutton').text('Submit');
		   users_role_id.val('4'); usertitle.text('Agent');userrole='agent';
		   $('.signinurl').attr('href','{{ URL("/") }}/login?usertype=agent');
		   	$('.signinurl').html('<a class="nesuserlogine cursor" data-target="modalagent">Sign In</a>');

		}

		$('input[name="fullname"]').val('');$('input[name="email"]').val('');$('input[name="phone"]').val('');$('textarea[name="address"]').val('');$('input[name="posttitle"]').val('');
		$('.message').removeClass('alert alert-danger text-center').html('');
		$('.has-success .form-control ,.has-error .form-control').css({'border':'1px solid #ccc'});
		$('.has-success i, .has-error i,.form-control-feedback').removeClass('glyphicon glyphicon-remove glyphicon-ok');
		$('.has-success .help-block, .has-error .help-block').hide();
		$('.has-success .control-label, .has-error .control-label').css({'color':'#999'});
		model.modal('show');
	    window.history.pushState('data',"Title", '{{ url("/") }}');
	}
	function redirectlogin() {
		window.location.href = "{{ URL('/login/') }}";
	}
	$(document).ready(function () {
		$('.registrationModalclick').on('click',function(){
			$('#registrationModal').modal('show');
		});
	});
	function timeDifference(current, previous) {
	    var msPerMinute = 60 * 1000;
	    var msPerHour = msPerMinute * 60;
	    var msPerDay = msPerHour * 24;
	    var msPerMonth = msPerDay * 30;
	    var msPerYear = msPerDay * 365;

	    var elapsed = current - previous;
	    var now = new Date(previous);
	    if (elapsed < msPerMinute) {
	         return Math.round(elapsed/1000) + 's ago';
	    }

	    else if (elapsed < msPerHour) {
	         return Math.round(elapsed/msPerMinute) + 'm ago';
	    }

	    else if (elapsed < msPerDay ) {
	    	if(now.customFormat( "#hhhh#" ) > '12'){

	    	 return now.customFormat( "#h#:#mm##AMPM#" );
	    	}else{
	    	 return now.customFormat( "#h#:#mm##ampm#" );
	    	}
	    }

	    else if (elapsed < msPerMonth) {
	    	if(now.customFormat( "#hhhh#" ) > '12'){

	    	 return now.customFormat( "#DDD# #h#:#mm##AMPM#" );
	    	}else{
	    	 return now.customFormat( "#DDD# #h#:#mm##ampm#" );
	    	}
	    }

	    else if (elapsed < msPerYear) {
	    	return now.customFormat( "#MMM# #DD#" );
	    }

	    else {
	    	return now.customFormat( "#YYYY# #MMM# #DD#" );
	    }
	}

	  $(document).on('change','#state',function(){
			$('#city').children('option:not(:first)').remove();
        	       state_id= $(this).val();
			$.ajax({
			"_token": "{{ csrf_token() }}",

			url: "{{url('/')}}/get_city/"+state_id,
			type: 'get',
			success: function(result) {
				//statearray = result;
				$.each( result, function( key, val ) {

					$('#city').append('<option value="'+val.city_id+'" >'+val.city_name+'</option>');
				});
				$('#buyerFormStep2').formValidation('revalidateField', 'city');

			}
			});
        });

	Date.prototype.customFormat = function(formatString){
		  var YYYY,YY,MMMM,MMM,MM,M,DDDD,DDD,DD,D,hhhh,hhh,hh,h,mm,m,ss,s,ampm,AMPM,dMod,th;
		  YY = ((YYYY=this.getFullYear())+"").slice(-2);
		  MM = (M=this.getMonth()+1)<10?('0'+M):M;
		  MMM = (MMMM=["January","February","March","April","May","June","July","August","September","October","November","December"][M-1]).substring(0,3);
		  DD = (D=this.getDate())<10?('0'+D):D;
		  DDD = (DDDD=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][this.getDay()]).substring(0,3);
		  th=(D>=10&&D<=20)?'th':((dMod=D%10)==1)?'st':(dMod==2)?'nd':(dMod==3)?'rd':'th';
		  formatString = formatString.replace("#YYYY#",YYYY).replace("#YY#",YY).replace("#MMMM#",MMMM).replace("#MMM#",MMM).replace("#MM#",MM).replace("#M#",M).replace("#DDDD#",DDDD).replace("#DDD#",DDD).replace("#DD#",DD).replace("#D#",D).replace("#th#",th);
		  h=(hhh=this.getHours());
		  if (h==0) h=24;
		  if (h>12) h-=12;
		  hh = h<10?('0'+h):h;
		  hhhh = hhh<10?('0'+hhh):hhh;
		  AMPM=(ampm=hhh<12?'am':'pm').toUpperCase();
		  mm=(m=this.getMinutes())<10?('0'+m):m;
		  ss=(s=this.getSeconds())<10?('0'+s):s;
		  return formatString.replace("#hhhh#",hhhh).replace("#hhh#",hhh).replace("#hh#",hh).replace("#h#",h).replace("#mm#",mm).replace("#m#",m).replace("#ss#",ss).replace("#s#",s).replace("#ampm#",ampm).replace("#AMPM#",AMPM);
	};
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
</script>

<script type="text/javascript">
    $('#nesuserlogin').on('hidden.bs.modal', function () {
        $('#logineuser').trigger('reset');
    });
</script>
<script>
    var total = $('.carousel-item').length;
    var currentIndex = $('div.active').index() + 1;
    $('#slidetext').html(currentIndex + '/' + total);

    // This triggers after each slide change
    $('.carousel').on('slid.bs.carousel', function () {
      currentIndex = $('div.active').index() + 1;

      // Now display this wherever you want
      var text = currentIndex + '/' + total;
      $('#slidetext').html(text);
    });
  </script>

@yield('script')
