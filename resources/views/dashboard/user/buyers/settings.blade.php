@extends('dashboard.master')
@section('title', 'Setting')
@section('content')
<?php
$topmenu='';
$activemenu = 'settings';
?>
@include('dashboard.include.sidebar')
	<!--=== Profile ===-->
	<div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@include('dashboard.user.buyers.include.sidebar')
			@include('dashboard.user.buyers.include.sidebar-profile')
			<!--End Left Sidebar-->

			<!-- Profile Content -->
			<div class="col-md-9">
				@if($segment[2] == "settings")
				<h2><b>Profile Settings</b></h2>
				<div class="box-shadow-profile margin-bottom-40">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left"> Account {{ucfirst($user->email)}}</h2>
						</div>

						<div class="tab-v2">
							<div class="tab-content">
								<div id="profile" class="profile-edit">
									<dl class="dl-horizontal">
										<dt><strong>Email </strong></dt>
										<dd >
											{{ucfirst($user->email)}}
										</dd>
										<hr>
										<dt><strong>Full Name </strong></dt>
										<dd class="name" id="name" title="Full Name">
											{{ucfirst($userdetails->name)}}
											@php echo $editfield @endphp
										</dd>
									</dl>
								</div>
							</div>
						</div>
					</div>
					<!-- Default Proposals -->
				</div>
				<div class="box-shadow-profile margin-bottom-40">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left"> Location </h2>
						</div>
						<div class="tab-v2">
							<div class="tab-content">
								<div id="profile" class="profile-edit">
									<dl class="dl-horizontal">
										<dt><strong>Address line 1 </strong></dt>
										<dd class="address" id="address" title="Address line 1">
											{{$userdetails->address}}
											@php echo $editfield @endphp
										</dd>
										<hr>
										<dt><strong>Address line 2  </strong></dt>
										<dd class="address2" id="address2" title="Address line 2 ">
											{{$userdetails->address2}}
											@php echo $editfield @endphp
										</dd>
										<hr>

										<dt><strong>State </strong></dt>
										<dd class="state_id" id="state_id" skey="{{ $userdetails->state_id }}" title="State">
											{{$userdetails->state_name}}
											@php echo $editfield @endphp
										</dd>
										<hr>
										<dt><strong>City</strong></dt>
										<dd class="city_id" id="city_id" skey="{{ $userdetails->city_id }}" title="city">
											{{$userdetails->city_name}}
											@php echo $editfield @endphp
										</dd>
										<hr>
										<dt><strong>Phone (Cell) </strong></dt>
										<dd class="phone" id="phone" title="Phone (cell)">
											{{ $userdetails->phone }}
											@php echo $editfield @endphp
										</dd>
										<hr>
										<dt><strong>Phone (Home) </strong></dt>
										<dd class="phone_home" id="phone_home" title="phone (home)">
											{{ $userdetails->phone_home }}
											@php echo $editfield @endphp
										</dd>
										<hr>
										<dt><strong>Phone (Work) </strong></dt>
										<dd class="phone_work" id="phone_work" title="phone (work)">
											{{ $userdetails->phone_work }}
											@php echo $editfield @endphp
										</dd>
										<hr>
										<dt><strong>Fax</strong></dt>
										<dd class="fax_no" id="fax_no" title="Fax">
											{{ $userdetails->fax_no }}
											@php echo $editfield @endphp
										</dd>
										<hr>
										<dt><strong>Zip Code </strong></dt>

										<dd class="zip_code" id="zip_code" title="Zip Code">
											{{ $userdetails->zip_code }}
											@php echo $editfield @endphp
										</dd>

									</dl>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="box-shadow-profile ">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left">About You</h2>
						</div>

						<div class="tab-v2">
							<div class="tab-content">
								<div id="profile" class="profile-edit">
									<dl class="">
										<dd class="description" id="description" title="Description">
											{!! $userdetails->description != null ? $userdetails->description : 'Write something about your self.' !!}
											@php echo $editfield @endphp
										</dd>
									</dl>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif

				@if($segment[2] == "personal")
				<h2><b>Update Personal Biodata</b></h2>
				<div class="box-shadow-profile ">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<!--<h2 class="heading-sm pull-left">  Personal Biodata {{ucfirst($user->email)}}</h2>-->
						</div>

						<div class="tab-v2">
							<div class="tab-content">
								<div id="profile" class="profile-edit">
									{!! Form::open(array('url' => '#','class'=>'sky-form','enctype'=>'multipart/form-data','id'=>'update-profile')) !!}
										<div class="hide post-msg" id="post-msg"></div>
										<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
										<section class="border1-bottom padding-bottom-10">
											<label class="label weight">Address line 1 <span class="mandatory">*</span> </label>
											<label class="input">
												<input type="text" class="address" id="address" name="address" value="{{ $userdetails->address }}"  placeholder="Address line 1">
												<b class="error-text" id="address_error"></b>
											</label>
										</section>
										<section class="border1-bottom padding-bottom-10">
											<label class="label weight">Address line 2 <span class="mandatory">*</span></label>
											<label class="input">
												<input type="text" class="address2" id="address2" name="address2" value="{{ $userdetails->address2 }}"  placeholder="Address line 2">
												<b class="error-text" id="address2_error"></b>
											</label>
										</section>


										<section class="border1-bottom padding-bottom-10">
											<label class="label weight">State <span class="mandatory">*</span>  </label>
											<label class="select">
												<select id="state_id1" name="state_id" class="multipalselecte " placeholder="Selecte State">
													<option value="">Select State</option>

												</select>
												<b class="error-text" id="state_id_error"></b>
											</label>
										</section>

										<section class="border1-bottom padding-bottom-10">
											<label class="label weight">City <span class="mandatory">*</span></label>
											<label class="select">
											<!-- <input type="text" class="address2" id="city_id1" name="city_id" value="{{ $userdetails->city_id }}"  placeholder="city"> -->
											<select id="city_id1" name="city_id" class="multipalselecte " placeholder="Selecte City">
													<option value="">Select City</option>
												</select>
												<b class="error-text" id="city_id_error"></b>
											</label>
										</section>

										<section class="border1-bottom padding-bottom-10">
											<label class="label weight">Zip Code<span class="mandatory">*</span> </label>
											<label class="input">
												<input type="number" id="zip_code" maxlength="5" name="zip_code" value="{{ $userdetails->zip_code }}"  placeholder="Zip Code">
												<b class="error-text" id="zip_code_error"></b>
											</label>
										</section>
										<!-- <section >
											<label class="label weight">Need Cash back/Negotiate Commision<span class="mandatory">*</span></label>
											<div class="inline-group">
												<div class="infopopup"><p >some states don't allow cash back </p></div>
												<label class="radio"><input type="radio" name="need_Cash_back" class="need_Cash_back_1" value="1" ><i class="rounded-x"></i>Yes</label>
												<label class="radio"><input type="radio" name="need_Cash_back" class="need_Cash_back_0" value="0" checked=""><i class="rounded-x"></i>No</label>

												<b class="error-text" id="need_Cash_back_error"></b>
											</div>
										</section> -->
										<section title="Specific requirements" class="border1-bottom padding-bottom-10">
											<label class="label weight">Description<span class="mandatory">*</span> </label>
											<label class="textarea">
												<textarea rows="3" name="description" class="description jqte-test" placeholder="Description">{{$userdetails->description}}</textarea>
												<b class="error-text" id="description_error"></b>
											</label>
										</section>
										<input  type="hidden" value="<?php echo $user->id; ?>"  name="id" >
										<input  type="hidden" value="<?php echo $user->agents_users_role_id; ?>"  name="role_id" >
										<button class="btn-u" type="submit">Save Changes</button>
									{!!Form::close()!!}
								</div>
							</div>
						</div>
					</div>
					<!-- Default Proposals -->
				</div>
				@endif

				@if($segment[2] == "security")
				<h2><b>Security Settings</b></h2>
				<div class="box-shadow-profile ">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left"> Security Question </h2>
						</div>
									<script>
										function selectSecondQuestions(questionId){
											//alert();
											if(!questionId){
												questionId = 0;
											}
										$("#question2").html("");
											$.ajax({
												url: "{{url('/')}}/profile/agent/getQuestions/"+questionId,
												type: 'get',
												success: function(result) {
													var newQuestions = JSON.parse(result);
													var sel = $('<select>').appendTo('body');
													var options = '<option value="">Select Question 2</option>';;

													$(newQuestions).each(function() {
														options += '<option value="'+this.securty_question_id+'">'+this.question+'</option>';
													});
													$("#question2").append(options);
												},
											});

										}
									</script>
						<div class="tab-v2">
							<div class="tab-content">
								<div id="settings" class="profile-edit">
									<div class="message-securty-question"> </div>
									<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
									{!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'edit-securty-question')) !!}
										<dl>
											<dt>Select Question 1 <span class="mandatory">*</span></dt>
											<dd>
												<section>
													<label class="select">

														<select onchange="selectSecondQuestions(this.value)" id="question1" name="question1" placeholder="Question 1">
															<option value="">Select Question 1</option>
															@if(!empty($securty_questio))
																@foreach($securty_questio as $questio)
																	@if($userdetails->question_1 == $questio->securty_question_id)
																		<option value="{{ $questio->securty_question_id }}" selected>{{ ucfirst($questio->question) }}</option>
																	@else
																		<option class="anc" value="{{ $questio->securty_question_id }}">{{ ucfirst($questio->question) }}</option>
																	@endif

																@endforeach
															@endif
														</select>
														<b class="error-text" id="question1_error"></b>
													</label>
												</section>
											</dd>

											<dt>Enter Answer 1</dt>
											<dd>
												<section>
													<label class="input">
														<i class="icon-append fa fa-lock"></i>
														<!-- {{ $userdetails->answer_1 }} -->
														<input type="text" id="answer1" name="answer1" data-toggle="tooltip" data-placement="top" placeholder="Answer 1" value="{{$userdetails->answer_1}}">
														<b class="error-text" id="answer1_error"></b>
													</label>
												</section>
											</dd>
											<dt>Select Question 2 <span class="mandatory">*</span></dt>
											<dd>
												<section>
													<label class="select">
														<select id="question2" name="question2" placeholder="Question 2" >
															<option value="">Select Question 2</option>
															@if(!empty($securty_questio))
																@foreach($securty_questio as $questio)
																	@if($userdetails->question_2 == $questio->securty_question_id)
																		<option value="{{ $questio->securty_question_id }}" selected>{{ ucfirst($questio->question) }}</option>
																	@else
																		<option class="anc" value="{{ $questio->securty_question_id }}">{{ ucfirst($questio->question) }}</option>
																	@endif

																@endforeach
															@endif
														</select>
														<b class="error-text" id="question2_error"></b>
													</label>
												</section>
											</dd>

											<dt>Enter Answer 2</dt>
											<dd>
												<section>
													<label class="input">
														<i class="icon-append fa fa-lock"></i>
														<input type="text" id="answer2" name="answer2" value="{{ $userdetails->answer_2 }}" data-toggle="tooltip" data-placement="top" placeholder="Answer 2">
														<b class="error-text" id="answer2_error"></b>
													</label>
												</section>
											</dd>
										</dl>
										<input type="hidden" name="id" value="{{$user->id}}">
										<button class="btn-u" type="submit">Update</button>
									{!!Form::close()!!}
								</div>
							</div>
						</div>
					</div>
					<!-- Default Proposals -->
				</div>
				@endif
				@if($segment[2] == "password")
				<h2><b>Password Settings</b></h2>
				<div class="box-shadow-profile ">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="heading-sm pull-left"> Change Password </h2>
						</div>

						<div class="tab-v2">
							<div class="tab-content">
								<div id="passwordTab" class="profile-edit">
									<div class="message-password"> </div>
									<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
									{!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'edit-password')) !!}
										<dl class="dl-horizontal">
											<dt>Enter Old Password</dt>
											<dd>
												<section>
													<label class="input">
														<i class="icon-append fa fa-lock"></i>
														<input type="password" id="oldpassword" name="oldpassword"  data-toggle="tooltip" data-placement="top" placeholder="Old Password">
														<b class="error-text" id="oldpassword_error"></b>
													</label>
												</section>
											</dd>
											<dt>Enter New Password</dt>
											<dd>
												<section>
													<label class="input">
														<i class="icon-append fa fa-lock"></i>
														<input type="password" id="password" name="password"  data-toggle="tooltip" data-placement="top" placeholder="Password">
														<b class="error-text" id="password_error"></b>
													</label>
												</section>
											</dd>
											<dt>Confirm New Password</dt>
											<dd>
												<section>
													<label class="input">
														<i class="icon-append fa fa-lock"></i>
														<input type="password" name="password_confirmation" id="password_confirmation" data-toggle="tooltip" data-placement="top" placeholder="Confirm password">
														<input type="hidden" name="id" value="{{$user->id}}">
														<b class="error-text" id="password_confirmation_error"></b>
													</label>
												</section>
											</dd>
										</dl>
										<br>
										<button class="btn-u" type="submit">Update</button>
									{!!Form::close()!!}
								</div>
							</div>
						</div>
					</div>
					<!-- Default Proposals -->
				</div>
				@endif

			</div>
			<!-- End Profile Content -->
		</div><!--/end row-->
	</div>
	<!--=== End Profile ===-->
	<!-- <button class="btn-u" data-toggle="modal" data-target="#profilemodel">Modal Form Sample</button> -->
	<div class="modal fade" id="profilemodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
				{!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'edit-profile-model')) !!}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title field-header-title" id="myModalLabel4">{{ucfirst($userdetails->name)}}</h4>
					</div>
					<div class="modal-body">
						<p class="alfa_value_err"></p>
						<div class="row">
							<p class="col-md-12 success-text center hide" id="successsome"></p>
							<fieldset class="col-md-12" id="field-add-model">


							</fieldset>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" value="<?php echo $user->id; ?>" name="id" >
						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn-u btn-u-primary" name="edit-profile-submit" value="Save changes" title="Save changes">Save Changes</button>
					</div>
				{!!Form::close()!!}
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script type="text/javascript">
	var statearray = <?php @print_r(json_encode($state)) ?>;
	var cityarray = <?php @print_r(json_encode($city)) ?>;
	var city_data = [];
	var state_data = [];

	(function() {

		$('#when_u_want_to_buy').val('<?php echo $userdetails->when_u_want_to_buy; ?>');
		$('#price_range').val('<?php echo $userdetails->price_range; ?>');
		$('#property_type').val('<?php echo $userdetails->property_type; ?>');
		$('#bids_emailed').val('<?php echo $userdetails->bids_emailed; ?>');
		$.ajax({
			url: "{{url('/')}}/state/get",
			type: 'get',
			success: function(result) {
				statearray = result;
				$.each( result, function( key, val ) {
					state_data = result;
					var selected= val.state_id == '{{ $userdetails->state_id }}' ? 'selected' : '';
					$('#state_id1').append('<option value="'+val.state_id+'" '+selected+' >'+val.state_name+'</option>');
				});
				$('#state_id1').multiselect({
					nonSelectedText: 'Select State',
					columns: 1,
				    search: true,
				    onChange: function(option, checked) {

		            },
		            buttonContainer: '<div class="btn-grouptest" />',
				});
			}
		});

		$.ajax({
			url: "{{url('/')}}/city/get",
			type: 'get',
			success: function(result) {
				cityarray = result;
				$.each( result, function( key, val ) {
					city_data = result;
					var selected= val.city_id == '{{ $userdetails->city_id }}' ? 'selected' : '';
					$('#city_id1').append('<option value="'+val.city_id+'" '+selected+' >'+val.city_name+'</option>');
				});

			}
		});


		$('#state_id1').on('change',function(){
			state_id=$(this).val();
			$('#city_id1').children('option:not(:first)').remove();
			if(state_id!=''){
				$.ajax({
					url: "{{url('/')}}/city/get/"+state_id,
					type: 'get',
					success: function(result) {
						statearray = result;
						$.each( result, function( key, val ) {
							city_data = result;
							var selected= val.city_id == '{{ $userdetails->city_id }}' ? 'selected' : '';
							$('#city_id1').append('<option value="'+val.city_id+'" '+selected+' >'+val.city_name+'</option>');
						});

					}
				});
			}
		});



		// $.ajax({
		// 	url: "{{url('/')}}/area/get",
		// 	type: 'get',
		// 	success: function(result) {
		// 		statearray = result;
		// 		$.each( result, function( key, val ) {
		// 			var selected= jQuery.inArray(val.area_id, [<?php echo $userdetails->area; ?>]) !== -1 ? 'selected' : '';
		// 			$('#area').append('<option value="'+val.area_id+'" '+selected+' >'+val.area_name+'</option>');
		// 		});
		// 		$('#area').multiselect({
		// 			nonSelectedText: 'Select Area',
		// 			columns: 1,
		// 		    search: true,
		// 		    onChange: function(option, checked) {

		//             }
		// 		});
		// 	}
		// });
	    $('#update-profile').submit(function(e){
			e.preventDefault();

			var $form = $(e.target),esmsg = $('#post-msg');
			$.ajax({

				url: "{{url('/')}}/profile/buyer/editbuyerprofile",
				type: 'POST',
				data: $form.serialize(),
				beforeSend: function(){$(".body-overlay").show();},
	    	    processData:false,

				success: function(result) {
					$(".body-overlay").hide();
					$('.error-text').text('');
					$('#update-profile input, #update-profile select, #update-profile textarea').removeClass('error-border');

					if(typeof result.error !='undefined' && result.error !=null){
					 	var i=0;
					 	$.each( result.error, function( key, value ) {
					 	 	if(i==0){
					 	 		scroleerr = $('#'+key+'_error');
					 	 	}
					 	 	i++;
					 	 	$('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
					 	 	var text = $('#'+key+'_error').text();
						    text = text.replace("id", "");
						    $('#'+key+'_error').text(text);
						 	$('#'+key).addClass('error-border');
						});
					 	esmsg.text('').removeClass('show').addClass('hide');
					 	$('html, body').animate({
						    scrollTop: scroleerr.offset().top-200
						},1000);

					}

					if(typeof result.msg !='undefined' && result.msg !=null){

						esmsg.removeClass('hide').addClass('show alert alert-success text-center').html(result.msg).css({'color':'green'});
						$('html, body').animate({
						    scrollTop: $('body').offset().top
						},1000);
						// setInterval(function() { esmsg.removeClass('alert alert-success text-center').html(''); },5000);
					}

				},
			  	error: function(data)
		    	{
		    		if(data.status=='500'){
						esmsg.addClass('show').removeClass('hide').text(data.statusText).css({'color':'red'});
		    		}else if(data.status=='422'){
						esmsg.addClass('show').removeClass('hide').text(data.responseJSON.image[0]).css({'color':'red'});
		    		}
		    		$(".body-overlay").hide();
		    		$('html, body').animate({
					    scrollTop: $('#update-profile').offset().top
					},1000);
		    	}

			});

		});

		function get_city_of_state(){
			let state_id='{{ $userdetails->state_id }}';
			let data = [];
			$.ajax({
				url: "{{url('/')}}/city/get/"+state_id,
				type: 'get',
				async:false,
				success: function(result) {
					data = result;
				}
			});

			if(state_id !== '{{ $oldCityStateId }}'){
				data.push({city_id : '{{ $oldCityId }}',city_name : '{{ $oldCityName }}'});
			}

			return data;
		};

	    var header_title = $('.field-header-title');
		var a,listindex,fieldtype,innerHTML,innerText,html,title,id = $('#field-add-model'),model = $('#profilemodel');
		$('.field-edit').click(function(){
	        a = $(this).parent(),listindex=1,fieldtype = a[0].id,innerHTML = a[0].innerHTML,innerText = a[0].innerText,html='',title = a[0].title,id = $('#field-add-model'),model = $('#profilemodel');
			$('#successsome').text('');

	        // console.log(a);
	        if(fieldtype == 'description') {
	        	header_title.text('Overview');
	    		model.modal('show');
				html += '<section><label class="label">'+title+'<span class="mandatory">*</span></label>';
				html += '<label class="textarea">';
				html += '<textarea rows="5"  type="text" data-toggle="tooltip" data-placement="top" class="form-control jqte-testd edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" name="'+fieldtype+'">'+innerText+'</textarea>';
				html += '</label></section>';

	    	}else if(fieldtype == 'city_id') {

	    		header_title.text('Profile City');
	    		model.modal('show');
				html += '<section><label class="label"> Select '+title+'</label>';
				//html += '<input type="text" data-toggle="tooltip" data-placement="top" class="form-control edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" value="'+innerText+'" name="'+fieldtype+'" />';
				html += '<label class="select">';
					html += '<select data-toggle="tooltip" data-placement="top" class="form-control multipalselecte edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" name="'+fieldtype+'">';
						let newCityData = get_city_of_state();
						$.each( newCityData, function( key, val ) {
							var selected = val.city_id == '{{ $userdetails->city_id }}' ? 'selected' : '';
							html += '<option value="'+val.city_id+'" '+selected+'>'+val.city_name+'</option>';
						});
					html += '</select>';
				html += '</section>';

	    	}else if(fieldtype == 'state_id') {

	    		header_title.text('Profile State');
	    		model.modal('show');
				html += '<section><label class="label"> Select '+title+'</label>';
				html += '<label class="select">';
					html += '<select data-toggle="tooltip" id="setting_state" data-placement="top" class="form-control multipalselecte edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" name="'+fieldtype+'">';
						$.each( state_data, function( key, val ) {
							var selected = val.state_id == '{{ $userdetails->state_id }}' ? 'selected' : '';
							html += '<option value="'+val.state_id+'" '+selected+'>'+val.state_name+'</option>';
						});
					html += '</select>';
				html += '</label></section>';

	    	}else if(fieldtype=='phone' || fieldtype=='phone_work' || fieldtype=='phone_home'){

	        	header_title.text(' ' + title);
	        	model.modal('show');
				html += '<section><label class="label">'+title+'<span class="mandatory">*</span></label>';
				html += '<label class="input">';
				html += '<input type="text" minlength="1" maxlength="20"  onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" required data-toggle="tooltip" data-placement="top" class="form-control edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" value="'+innerText+'" name="'+fieldtype+'" />';
				html += '</label></section>';
	        }else{

	        	header_title.text(' ' + title);
	        	model.modal('show');
				html += '<section><label class="label">'+title+'<span class="mandatory">*</span></label>';
				html += '<label class="input">';
				html += '<input type="text" data-toggle="tooltip" data-placement="top" class="form-control edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" value="'+innerText+'" name="'+fieldtype+'" />';
				html += '</label></section>';
	        }
	    	id.html(html);

	    	//$('.jqte-testd').jqte();
	    	if(fieldtype=='phone' || fieldtype=='phone_work' || fieldtype=='phone_home'){
			   var phones = [{ "mask": "(###) ###-####"}];
			    $('#edit-field-'+fieldtype).inputmask({
			        mask: phones,
			        greedy: false,
			        definitions: { '#': { validator: "[0-9]", cardinality: 1}}
			    });
			}
			$('.jqte-testd').summernote();
		});
		Object.defineProperty(String.prototype, 'capitalize', {
			value: function() {
				return this.charAt(0).toUpperCase() + this.slice(1);
			},
			enumerable: false
		});
		$(document).on("click",'button[name="edit-profile-submit"]',function(){
			if($("#edit-field-phone_home").length !== 0){
				if ($("#edit-field-phone_home").inputmask("isComplete") == false){
					$("#edit-field-phone_home").addClass('error-border').attr('title','Required');
					$("#edit-field-phone_home").tooltip({trigger:'manual'}).tooltip('show');
				}
			}
			if($("#edit-field-phone").length !== 0){
				if ($("#edit-field-phone").inputmask("isComplete") == false){
					$("#edit-field-phone").addClass('error-border').attr('title','Required');
					$("#edit-field-phone").tooltip({trigger:'manual'}).tooltip('show');
				}
			}

			if($("#edit-field-phone_work").length !== 0){
				if ($("#edit-field-phone_work").inputmask("isComplete") == false){
					$("#edit-field-phone_work").addClass('error-border').attr('title','Required');
					$("#edit-field-phone_work").tooltip({trigger:'manual'}).tooltip('show');
				}
			}

		});

	    $('#edit-profile-model').submit(function(e){
			e.preventDefault();

			var $form = $(e.target),fv= $form.data('edit-profile-model'),error = true;

				$("#profilemodel input, #profilemodel textarea, #profilemodel select").each(function() {
			   		var fieldjv = $(this);
			   		// alert('abhis'+$("#profilemodel input").val()+'112');

					if($(this).val() === "" && fieldjv[0].className !='note-codable' && fieldjv[0].className !='note-link-text form-control'&& fieldjv[0].className !='note-link-url form-control'&& fieldjv[0].className !='note-image-input form-control' && fieldjv[0].className !='note-image-url form-control col-md-12' && fieldjv[0].className !='note-video-url form-control span12'){
				   		fieldjv.addClass('error-border').attr('title','Required');
				   		fieldjv.tooltip({trigger:'manual'}).tooltip('show');
				   		error = false;
				   	}else if(fieldjv[0].localName != 'input' && fieldjv[0].localName == 'textarea' && $('#edit-field-description').summernote('code')==""){
				   		fieldjv.addClass('error-border').attr('title','Required');
				   		fieldjv.tooltip({trigger:'manual'}).tooltip('show');
				   		error = false;

				   	} else{
				   		//fieldjv.removeClass('error-border').tooltip({trigger:'manual'}).tooltip('hide');
				   	}
				});

			if(error){
				$.ajax({
					url: "{{url('/')}}/profile/buyer/editfields",
					type: 'POST',
					data: $form.serialize(),
					beforeSend: function(){$(".body-overlay").show();},
		    	    processData:false,
					success: function(result) {
						;
						$(".body-overlay").hide();
						if (result.status==0 || result.status==1){ $('#successsome').addClass('show alert alert-success').removeClass('hide').text(title.capitalize()+' has been updated sucessfully');
							setTimeout(location.reload(),5000);
							// $("#profilemodel").modal("hide");
						}
						if (result.status=='nameerror') { var fieldjv = $('#edit-field-name'); fieldjv.addClass('error-border').attr('title','Required'); fieldjv.tooltip({trigger:'manual'}).tooltip('show'); }
						if (result.status=='addresserror') { var fieldjvadr = $('#edit-field-address'); fieldjvadr .addClass('error-border').attr('title','Required'); fieldjvadr.tooltip({trigger:'manual'}).tooltip('show'); }

						if (result.status=='phoneerror') { var fieldjvadr = $('#edit-field-phone'); fieldjvadr .addClass('error-border').attr('title','Required'); fieldjvadr.tooltip({trigger:'manual'}).tooltip('show'); }
						if (result.status=='phone_home') { var fieldjvadr = $('#edit-field-phone_home'); fieldjvadr .addClass('error-border').attr('title','Required'); fieldjvadr.tooltip({trigger:'manual'}).tooltip('show'); }
						if (result.status=='phone_work') { var fieldjvadr = $('#edit-field-phone_work'); fieldjvadr .addClass('error-border').attr('title','Required'); fieldjvadr.tooltip({trigger:'manual'}).tooltip('show'); }

						/* For fax_no */
						if (result.status=='faxerror') {
							var fieldjvadr = $('#edit-field-fax_no');
							fieldjvadr .addClass('error-border').attr('title','Required');
							fieldjvadr.tooltip({trigger:'manual'}).tooltip('show');
						}

						if (result.status=='faxErr') {
							 var fieldjvadr = $('#edit-field-zip_code');
							 $(".alfa_value_err").html(result.message);
							 $(".alfa_value_err").css({'color':'red', 'padding-left':'14px'});
						}
						/* For zip_code */
						if (result.status=='ziperror') {
							 var fieldjvadr = $('#edit-field-zip_code');
							 fieldjvadr .addClass('error-border').attr('title','Required');
							 fieldjvadr.tooltip({trigger:'manual'}).tooltip('show');
						}

						if (result.status=='zipErr') {
							 var fieldjvadr = $('#edit-field-zip_code');
							 $(".alfa_value_err").html(result.message);
							 $(".alfa_value_err").css({'color':'red', 'padding-left':'14px'});
						}

						if (result.status=='loginerorr') {
							location.reload();
							$("#profilemodel").modal("hide");
						}
					}
				});
			}

		});

	   	/* edit password*/
	    $('#edit-password').submit(function(e){
			e.preventDefault();
			var $form = $(e.target),esmsg = $('.message-password');

			$.ajax({

				url: "{{url('/')}}/password/changepassword",
				type: 'POST',
				data: $form.serialize(),
				beforeSend: function(){$(".body-overlay").show();},
	    	    processData:false,

				success: function(result) {
					$(".body-overlay").hide();
					$('.error-text').text('');
					$('input[type="password"]').removeClass('error-border');

					if(typeof result.error !='undefined' && result.error !=null){

					 	$.each( result.error, function( key, value ) {
						 	 $('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
							 $('#'+key).addClass('error-border');
							});
					 	esmsg.text('');

					}

					if(typeof result.msg !='undefined' && result.msg !=null){
						esmsg.addClass('alert alert-success text-center').html(result.msg);
						setInterval(function() { esmsg.removeClass('alert alert-success text-center').html(''); },10000);
						$('input[type="password"]').val('');
					}
				},
			  	error: function(data)
		    	{
		    		if(data.status=='500'){
						esmsg.text(data.statusText).css({'color':'red'});
		    		}else if(data.status=='422'){
						esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
		    		}
		    		$(".body-overlay").hide();
		    	}

			});
		});
		/* edit password*/

		/* securty */
		$('#edit-securty-question').submit(function(e){
			e.preventDefault();
			if($('#answer2').val().toLowerCase() == $('#answer1').val().toLowerCase()){
							$('#answer2_error').removeClass('success-text').addClass('error-text').text('Answer 2 & Answer 1 can not be same!');
							return false;
					}
			var $form = $(e.target),esmsg = $(".message-securty-question");
			$.ajax({
				url: "{{url('/')}}/securtyquestion/change",
				type: 'POST',
				data: $form.serialize(),
				beforeSend: function(){
					
					$(".body-overlay").show();
				},
	    	processData:false,
				success: function(result) {
					$(".body-overlay").hide();
					$('.error-text').text('');
					if(typeof result.error !='undefined' && result.error !=null){
					 	$.each( result.error, function( key, value ) {
						 	 $('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
							});
					 	esmsg.text('');
					}
					if(typeof result.msg !='undefined' && result.msg !=null){
						if(result.msg.error !='undefined' && result.msg.error !=null){
							esmsg.text(result.msg.error).css({'color':'red'});
						}else{
							esmsg.text('').css({'color':'green'});
							esmsg.addClass('alert alert-success text-center').text(result.msg);
							// setTimeout(location.reload(),5000);
						}
					}
				},
			  	error: function(data)
		    	{
		    		if(data.status=='500'){
						esmsg.text(data.statusText).css({'color':'red'});
		    		}else if(data.status=='422'){
						esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
		    		}
		    		setInterval(function() {$(".body-overlay").hide(); },1000);
		    	}
			});
		});
	    /* securty */

    })();
    function closegroup(id) {
		$('.'+id).remove();
	}
</script>
@stop
