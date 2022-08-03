@if($userdetails->contract_verification !== 2 && (strpos(Request::url(),"profile/agent/personal") == false) && $user->agents_users_role_id==4)
<script>
// 	alert('Please Update Personal Bio.');
// 	window.location.href="{{url('/')}}/profile/agent/personal";
</script>
@endif
		<!--=== Header v6 ===-->
		<div class="header-v6 header-sticky header-classic-white">

			<!-- Navbar -->
			<div class="navbar mega-menu" role="navigation">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="menu-container">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<!-- Navbar Brand -->
						<div class="navbar-brand">
							<a href="{{ URL('/dashboard') }}">
								<img class="default-logo" src="{{ URL::asset('/assets/img/logo1-default.png') }}" alt="Logo">

								<img class="shrink-logo" src="{{ URL::asset('/assets/img/logo1-default.png') }}" alt="Logo">
							</a>
						</div>
						<!-- ENd Navbar Brand -->

						<!-- Header Inner Right -->
						<div class="header-inner-right">
							<ul class="menu-icons-list">
								<li class="menu-icons shopping-cart">
									<i class="menu-icons-style radius-x fa fa-bell"></i>
									<span class="badge n-p"  id="notification_count"></span>
									<div class="shopping-cart-open">
										<span class="shc-title">Notifications</span>
										<ul id="notificationMenu" class="notifications open">
									      <div class="notifbox" id="notification-body">


									      </div>
								          <input type="hidden" name="notificationmoreload" id="notificationmoreload">

									      <div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop notification-loader" width="40px" height="40px"/></div>

									    </ul>
									</div>
								</li>

								<li class="menu-icons shopping-cart">
									<i class="menu-icons-style radius-x fa fa-comments"></i>
									<span class="badge n-p" id="message_notification_count"></span>
									<div class="shopping-cart-open">
										<span class="shc-title">Unread Messages</span>
										<ul id="message_notificationMenu" class="notifications open">
									      <div class="notifbox" id="message_notification-body">
									      </div>

								          <input type="hidden" name="message_notificationmoreload" id="message_notificationmoreload">

									      <div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop message_notification-loader" width="40px" height="40px"/></div>
									    </ul>
									</div>
								</li>

								<li class="menu-icons shopping-cart">
									<i class="menu-icons-style radius-x">
										<img  class="img-circle header-circle-img" width="30" height="30" id="profile-pic" src="@if($userdetails->photo != '') {{ url('/assets/img/profile/'.$userdetails->photo) }} @else {{ url('/assets/img/team/img32-md.jpg') }} @endif " alt="img04">

										<span style="text-transform: capitalize;" id="USERPROFILESIDE" class="organization-selector" data-ng-non-bindable="">{{ucwords(strtolower($userdetails->name))}}</span>
										<span class="caret glyphicon air-icon-arrow-expand" aria-hidden="true"></span>
									</i>

									<div class="shopping-cart-open">
										<ul class="notifications open">
										  <div>
										      <li class="notif-profile" >
									      		<img class="img-circle header-circle-img1 img-margin" width="35" height="35" id="profile-pic" src="@if($userdetails->photo != '') {{ url('/assets/img/profile/'.$userdetails->photo) }} @else {{ url('/assets/img/team/img32-md.jpg') }} @endif " alt="img04">

										      	<div class="organization-selector1" >
										      		<a href="#" class="sitegreen capitalize">{{ucwords(strtolower($userdetails->name))}}</a>
										      		<br>{{ ucwords(env('user_role_'.Auth::user()->agents_users_role_id)) }}</div>
										      </li>

										      @if($user->agents_users_role_id==4)

										      <li class="notif-profile header-profile {{ @$activemenu=='agent' ? 'active' : '' }}">
										      	<a href="{{url('/profile/agent/')}}" class="capitalize"><i class="fa fa-user"></i> Profile</a>
										      </li>

										      <li class="notif-profile header-profile {{ @$activemenu=='settings' ? 'active' : '' }}">
										      	<a href="{{ url('/profile/agent/settings') }}" class="capitalize"><i class="fa fa-cog"></i> Settings</a>
										      </li>
										      @endif

										      @if($user->agents_users_role_id!=4)
										      <li class="notif-profile header-profile {{ @$activemenu=='buyer' ? 'active' : '' }}">
										      	<a href="{{url('/profile/buyer/')}}" class="capitalize"><i class="fa fa-user"></i> Profile</a>
										      </li>

										      <li class="notif-profile header-profile {{ @$activemenu=='settings' ? 'active' : '' }}">
										      	<a href="{{ url('/profile/buyer/settings') }}" class="capitalize"><i class="fa fa-cog"></i> Settings</a>
										      </li>
										      @if($user->agents_users_role_id==2)
										      <li class="notif-profile header-profile">
										      	<a href="javascript:" class="capitalize" id="3" onclick="switchuser(this.id)"><i class="fa fa-cog"></i> Switch to Seller</a>
										      </li>
										      @endif
										       @if($user->agents_users_role_id==3)
										      <li class="notif-profile header-profile">
										      	<a href="javascript:" class="capitalize" id="2" onclick="switchuser(this.id)"><i class="fa fa-cog"></i> Switch to Buyer</a>
										      </li>
										      @endif
										      @endif
										      <li class="notif-profile header-profile">
										      	<a href="{{ url('/logout') }}" class="capitalize"><i class="fa fa-sign-out"></i> Logout</a>
										      </li>
									      </div>
									    </ul>
									</div>
								</li>

								<!-- <li class="menu-icons">

									<i class="menu-icons-style search search-close search-btn fa fa-search"></i>

									<div class="search-open">

										<input type="text" class="animated fadeIn form-control" placeholder="Start searching ...">

									</div>

								</li> -->

							</ul>
						</div>
						<!-- End Header Inner Right -->
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-responsive-collapse">
						<div class="menu-container">
							<ul class="nav navbar-nav">

								<!-- Home -->
								<li class="dropdown {{ @$topmenu=='Home' ? 'active' : '' }}">
									@if($user->agents_users_role_id==4)
									<a href="{{ url('/post') }}" class="dropdown-toggle" data-toggle="dropdown" id="DASHBOARDSIDE">
										Dashboard
									</a>
									@endif
									@if($user->agents_users_role_id!=4)

									<a href="{{ url('/agents') }}" class="dropdown-toggle" data-toggle="dropdown" id="DASHBOARDSIDE">
										Dashboard
									</a>
									@endif

									<ul class="dropdown-menu">
										<li class="{{ @$activemenu=='dashboard' ? 'active' : '' }}"><a href="{{url('/dashboard')}}">Dashboard</a></li>

										@if($user->agents_users_role_id==4)
										<li class="{{ @$activemenu=='appliedpost' ? 'active' : '' }}"><a href="{{url('/'.str_replace(' ','',$userdetails->name).'/applied/post')}}">My Jobs</a></li>

										<li class="{{ @$activemenu=='connectedpost' ? 'active' : '' }}"><a href="{{ url('/agent/connected/post') }}">Connected Jobs</a></li>

										<li class="{{ @$activemenu=='Post' ? 'active' : '' }}"><a href="{{ url('/post') }}">Find Jobs</a></li>


										<li class="{{ @$activemenu=='selected_post' ? 'active' : '' }}"><a href="{{ url('/agent/myall/selected/post') }}"> Selected Job</a></li>


										<li class="{{ @$activemenu=='agent' ? 'active' : '' }}"><a href="{{ url('/profile/agent/') }}">Profile</a></li>

										<li class="{{ @$activemenu=='tests' ? 'active' : '' }}"><a href="{{ url('/profile/agent/tests') }}">Tests</a></li>

										<li class="{{ @$activemenu=='Notes' ? 'active' : '' }}"><a href="{{url('/'.str_replace(' ','',$userdetails->name).'/notes/')}}">Notes</a></li>

										<li class="{{ @$activemenu=='Bookmark' ? 'active' : '' }}"><a href="{{url('/'.str_replace(' ','',$userdetails->name).'/bookmark/')}}">Bookmark</a></li>

										<!--<li class="{{ @$activemenu=='proposal' ? 'active' : '' }}"><a href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/proposal/')}}">Proposals</a></li>-->
										@endif

										@if($user->agents_users_role_id !=4)

										<li class="{{ @$activemenu=='posts' ? 'active' : '' }}"><a href="{{url('/profile/buyer/posts')}}">My Jobs</a></li>

										<li class="{{ @$activemenu=='Agents' ? 'active' : '' }}"><a href="{{ url('/agents') }}">Find Agents</a></li>

										<li class="{{ @$activemenu=='buyer' ? 'active' : '' }}"><a href="{{url('/profile/buyer/')}}">Profile</a></li>

										<li class="{{ @$activemenu=='tests' ? 'active' : '' }}"><a href="{{url('/profile/buyer/tests')}}">Tests</a></li>

										<li class="{{ @$activemenu=='Notes' ? 'active' : '' }}"><a href="{{url('/'.str_replace(' ','',$userdetails->name).'/notes/')}}">Notes</a></li>

										<li class="{{ @$activemenu=='Bookmark' ? 'active' : '' }}"><a href="{{url('/'.str_replace(' ','',$userdetails->name).'/bookmark/')}}">Bookmark</a></li>
										@endif
									</ul>
								</li>
								<!-- End Home -->

								<!-- Active Posts -->
								@if($user->agents_users_role_id==4)
								<li class="dropdown {{ @$topmenu=='Post' ? 'active' : '' }}">
									<a id="FINDJOBSSIDE" href="#">
										Find Jobs
									</a>
								</li>
								@else
								<li class="dropdown {{ @$topmenu=='my_post' ? 'active' : '' }}">

									<a id="MYJOBSSIDE" href="{{url('/profile/buyer/posts')}}" class="dropdown-toggle" data-toggle="dropdown">
										My Jobs
									</a>

									<ul class="dropdown-menu">
										<li class="{{ @$activemenu=='posts' ? 'active' : '' }}"><a href="{{url('/profile/buyer/posts')}}">My Jobs</a></li>

										<li class="{{ @$activemenu=='Agents' ? 'active' : '' }}"><a href="{{ url('/agents') }}">Find Agents</a></li>

										<li class="{{ @$activemenu=='compareposts' ? 'active' : '' }}"><a href="{{url('/profile/buyer/compareposts')}}">Compare Agents</a></li>
									</ul>
								</li>
								@endif
								<!-- End Active Posts -->

								<!-- Questions -->
								<li class="dropdown {{ @$topmenu=='Profile' ? 'active' : '' }}">
									<a id="{{ $user->agents_users_role_id==4 ? 'AGENTPROFILESIDESIDE' : 'BUYERSELLERPROFILESIDESIDE' }}" href="{{ url('/profile/agent/') }}" class="dropdown-toggle" data-toggle="dropdown">
										Profile
									</a>
									<ul class="dropdown-menu">
										@if($user->agents_users_role_id==4)

										<li class="{{ @$activemenu=='agent' ? 'active' : '' }}"><a href="{{ url('/profile/agent/') }}">Profile</a></li>

										<li class="{{ @$segment[2]=='settings' ? 'active' : '' }}"><a href="{{ url('/profile/agent/settings') }}">Settings</a></li>

										<li class="{{ @$segment[2]=='personal' ? 'active' : '' }}"><a href="{{url('/profile/agent/personal')}}">Personal Bio</a></li>

										<li class="{{ @$segment[2]=='professional' ? 'active' : '' }}"><a href="{{url('/profile/agent/professional')}}">Professional Bio</a></li>

										<li class="{{ @$segment[2]=='security' ? 'active' : '' }}"><a href="{{url('/profile/agent/security')}}">Security</a></li>

										<li class="{{ @$segment[2]=='password' ? 'active' : '' }}"><a href="{{url('/profile/agent/password')}}">Change Password </a></li>

										<!--<li class="{{ @$activemenu=='survey' ? 'active' : '' }}"><a href="{{url('/survey/agent/list')}}">Survey</a></li>-->
										@endif

										@if($user->agents_users_role_id!=4)
											<li class="{{ @$activemenu=='buyer' ? 'active' : '' }}"><a href="{{url('/profile/buyer/')}}">Profile</a></li>

											<li class="{{ @$segment[2]=='settings' ? 'active' : '' }}"><a href="{{url('/profile/buyer/settings')}}">Settings</a></li>

											<li class="{{ @$segment[2]=='personal' ? 'active' : '' }}"><a href="{{url('/profile/buyer/personal')}}">Personal Bio</a></li>

											<li class="{{ @$segment[2]=='security' ? 'active' : '' }}"><a href="{{url('/profile/buyer/security')}}">Security</a></li>

											<li class="{{ @$segment[2]=='password' ? 'active' : '' }}"><a href="{{url('/profile/buyer/password')}}">Change Password </a></li>
										@endif
									</ul>
								</li>

								<!--<li class="dropdown {{ @$topmenu=='Questions' ? 'active' : '' }}">

									<a href="{{url('/profile/agent/questions')}}" class="dropdown-toggle" data-toggle="dropdown">

										Questions

									</a>

									<ul class="dropdown-menu">

										@if($user->agents_users_role_id==4)

										<li class="{{ @$activemenu=='Questions' ? 'active' : '' }}"><a href="{{url('/profile/agent/questions')}}">Questions</a></li>

										<li class="{{ @$activemenu=='survey' ? 'active' : '' }}"><a href="{{url('/survey/agent/list')}}">Survey</a></li>

										@endif

										@if($user->agents_users_role_id!=4)

										<li class="{{ @$activemenu=='Questions' ? 'active' : '' }}"><a href="{{url('/profile/buyer/questions')}}">Questions</a></li>

										<li class="{{ @$activemenu=='survey' ? 'active' : '' }}"><a href="{{url('/survey/buyers/list')}}">Survey</a></li>

										<li class="{{ @$activemenu=='importance' ? 'active' : '' }}"><a href="{{url('/importance/list')}}">Importance</a></li>

										@endif

									</ul>

								</li>-->

								<!-- End Questions -->

								<li class="dropdown {{ @$topmenu=='Other_Resources' ? 'active' : '' }}">

									<a id="{{ $user->agents_users_role_id==4 ? 'AGENTOTHERRESOURCESSIDE' : 'BUYERSELLEROTHERRESOURCESSIDE'  }}" href="{{ url('/') }}" class="dropdown-toggle" data-toggle="dropdown">
										Other Resources
									</a>

									<ul class="dropdown-menu">
										@if($user->agents_users_role_id==4)
											<li class="{{ @$activemenu=='proposal' ? 'active' : '' }}"><a href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/proposal/')}}">Proposals</a></li>

											<li class="{{ @$activemenu=='documents' ? 'active' : '' }}"><a href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/documents/')}}">Documents</a></li>

											<li class="{{ @$activemenu=='Questions' ? 'active' : '' }}"><a href="{{url('/profile/agent/questions')}}">Questions</a></li>

											<li class="{{ @$activemenu=='survey' ? 'active' : '' }}"><a href="{{url('/survey/agent/list')}}">Survey Questions</a></li>
										@endif

										@if($user->agents_users_role_id!=4)
										<li class="{{ @$activemenu=='documents' ? 'active' : '' }}"><a href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/documents/')}}">Documents</a></li>

										<li class="{{ @$activemenu=='Questions' ? 'active' : '' }}"><a href="{{url('/profile/buyer/questions')}}">Questions</a></li>

										<li class="{{ @$activemenu=='survey' ? 'active' : '' }}"><a href="{{url('/survey/buyers/list')}}">Survey Questions</a></li>

										<li class="{{ @$activemenu=='importance' ? 'active' : '' }}"><a href="{{url('/importance/list')}}">Important Questions</a></li>
										@endif
									</ul>
								</li>

								<!-- Message -->
								<li class="dropdown {{ @$topmenu=='messages' ? 'active' : '' }}">
									<a id="{{ $user->agents_users_role_id==4 ? 'AGENTMESSAGESIDE' : ( $user->agents_users_role_id==3 ? 'SELLERMESSAGESIDE' : 'BUYERSMESSAGESIDE' ) }}" href="{{url('/messages/')}}">
										Messages
									</a>
								</li>

								<li class="dropdown {{ @$topmenu=='messages' ? 'active' : '' }}">
									<a><button type="button" id="demo" class="btn-u padding-6" data-demo="">Start Guide</button></a>
								</li>
								<!-- End Message -->
							</ul>
						</div>
					</div><!--/navbar-collapse-->
				</div>
			</div>
			<!-- End Navbar -->
		</div>
		<!--=== End Header v6 ===-->

		<div class="modal fade in" id="Surveyquestionloop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="body-overlay survey-loop"><div><img src="{{ url('/') }}/assets/img/loder/loading.gif" width="64px" height="64px"></div></div>
					{!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'survey-loop')) !!}
						<div class="modal-header">
							<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
							<h4 class="modal-title">Survey Question</h4>
						</div>
						<div class="modal-body">
							<fieldset>
								<div id="surveyquestionanswers"> </div>
								<section>
									<label class="label" id="querysurvay"> </label>
									<label class="textarea">
										<textarea rows="2" class="field-border" name="answers" id="question_survay_answers" placeholder="Enter Answers"></textarea>
										<b class="error-text" id="answers_error"></b>
									</label>
								</section>
								<p class="success-text" id="success-pic-checkpost"></p>
							</fieldset>
						</div>
						<div class="modal-footer">
							<input type="hidden" value="" class="survey_question_id" name="question_id" >
							<input type="hidden" value="{{ $user->id }}" name="from_id" >
							<input type="hidden" value="{{ $user->agents_users_role_id }}" name="from_role" >
							<button type="submit" class="btn-u btn-u-primary" name="edit-profile-pic-submit" value="Save changes" title="Save changes">Save</button>
						</div>
					{!!Form::close()!!}
				</div>
			</div>
		</div>
		@if(Auth::user()->first_login == 1)
			@php $securty_questio = \App\Models\SecurtyQuestion::where('is_deleted','0')->get(); @endphp
		<div class="modal fade" id="firstsetsecurty" >
			<div class="modal-dialog">
				<div class="modal-content">
					{!! Form::open(array('url' => '','class'=>'sky-form','id'=>'first-set-securty-form')) !!}
						<div class="modal-header modal-xs">
							<button type="button" data-dismiss="modal" class="close">×</button>
							<h4 class="modal-title text-center"><b>Manage Your Security</b></h4>
						</div>

						<div class="modal-body">
							<div class="message-password"> </div>
							<div class="body-overlay first-set-securty-loder"><div><img src="{{ url('/') }}/assets/img/loder/loading.gif" width="64px" height="64px"></div></div>
							<dl>
								<dt>Select Question 1</dt>
								<dd>
									<section>
										<label class="select">
											<select id="question1" name="question1" placeholder="Question 1">
												<option value="">Select Question 1</option>
												@if(!empty($securty_questio))
													@foreach($securty_questio as $questio)
														<option value="{{ $questio->securty_question_id }}" @if($userdetails->question_1 == $questio->securty_question_id) selected="selected" @endif >{{ ucfirst($questio->question) }}</option>
													@endforeach
												@endif
											</select>
											<b class="error-text question1_error" id="question1_error"></b>
										</label>
									</section>
								</dd>

								<dt>Enter Answer 1</dt>
								<dd>
									<section>
										<label class="input">
											<i class="icon-append fa fa-lock"></i>
											<input type="text" maxlength="200" id="answer1" name="answer1" value="{{ $userdetails->answer_1 }}"  data-toggle="tooltip" data-placement="top" placeholder="Answer 1">
											<b class="error-text answer1_error" id="answer1_error"></b>
										</label>
									</section>
								</dd>
								<dt>Select Question 2</dt>
								<dd>
									<section>
										<label class="select">
											<select id="question2" name="question2" placeholder="Question 2">
												<option value="">Select Question 2</option>
												@if(!empty($securty_questio))
													@foreach($securty_questio as $questio)
														<option value="{{ $questio->securty_question_id }}" @if($userdetails->question_2 == $questio->securty_question_id) selected="selected" @endif >{{ ucfirst($questio->question) }}</option>
													@endforeach
												@endif
											</select>
											<b class="error-text question2_error" id="question2_error"></b>
										</label>
									</section>
								</dd>

								<dt>Enter Answer 2</dt>
								<dd>
									<section>
										<label class="input">
											<i class="icon-append fa fa-lock"></i>
											<input type="text" maxlength="200" id="answer2" name="answer2" value="{{ $userdetails->answer_2 }}" data-toggle="tooltip" data-placement="top" placeholder="Answer 2">
											<b class="error-text answer2_error" id="answer2_error"></b>
										</label>
									</section>
								</dd>
							</dl>
						</div>

						<div class="modal-footer">
							<input type="hidden" value="{{ Auth::user()->id }}" name="id" >
							<input type="hidden" value="{{ Auth::user()->agents_users_role_id }}" name="agents_users_role_id" >
							<button type="submit" class="btn-u btn-u-primary" name="edit-profile-pic-submit" value="Save changes" title="Save changes">Save</button>
							<!--<button type="button" data-dismiss="modal" class="btn-u btn-u-red">Close</button>-->
						</div>
					{!!Form::close()!!}
				</div>
			</div>
		</div>
		@endif
		<div class="padding-top-80">

<script>
	$(document).ready(function() {
		@if($user->agents_users_role_id==4)
		/* For check agent status */
		$(document).click(function() {
			$.ajax({
				url: "{{url('/')}}/agentStatus",
				type: 'GET',
				success: function(result) {
					if(result == 0) {
						window.location.href="{{url('/')}}/logout";
						alert("Your Account Is Deactivated.");
					}
				}
			});
		});
		@endif

		$("#FINDJOBSSIDE").click(function(e) {
			event.preventDefault();
			$.ajax({
				url: "{{url('/')}}/postForAgents",
				type: "POST",
				data: {'userId':"<?php echo $user->id; ?>"},
				success: function(result) {
					if(result == 1) {
						window.location.href="{{url('/')}}/post";
					} else{
						alert('Please Update Personal Bio.');
						window.location.href="{{url('/')}}/profile/agent/personal";
					}
				}
			});
		});

	});

	function switchuser(id) {
		$.ajax({
			url: "{{url('/')}}/switchuser",
			type: "POST",
			dataType:'json',
			data: {'userId':"<?php echo $user->id; ?>",'role':id},
			success: function(response) {
				if(response.result=='1'){
					window.location.href="{{url('/')}}/dashboard";
				}
			}
		});
	}
</script>
