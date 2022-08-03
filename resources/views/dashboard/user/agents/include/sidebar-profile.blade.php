<div class="col-md-3 sm-margin-bottom-20 grid cs-style-5">
	<div class="media border1-bottom margin-bottom-10 padding-bottom-10">
		<div class="pull-left">
			<a href="javascript:" data-toggle="modal" data-target="#changeprofilepic">
				<img class="img-circle avatar avatar-xs"  id="profile-pic" src="@if($userdetails->photo != '') {{ url('/assets/img/profile/'.$userdetails->photo) }} @else {{ url('/assets/img/team/img32-md.jpg') }} @endif " alt="img04">
			</a>
		</div>
		<div class="media-body">
			<h4 class="display-inline-block">User Settings</h4>
		</div>
	</div>
	<ul class="list-group sidebar-nav-v1" id="sidebar-nav-1">		
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "agent"): ?> active <?php endif; ?>">
			<a id="MYPROFILE" href="{{url('/profile/agent')}}" ><i class="fa fa-user"></i> My Profile</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$segment[2] == "settings"): ?> active <?php endif; ?>"> 
			<a id="MYSETTING" href="{{url('/profile/agent/settings')}}" ><i class="fa fa-cog"></i> Settings</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$segment[2] == "personal"): ?> active <?php endif; ?>">
			<a id="PERBOI" href="{{url('/profile/agent/personal')}}" ><i class="fa fa fa-server"></i> Personal Bio</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$segment[2] == "professional"): ?> active <?php endif; ?>">
			<a id="PROBOI" href="{{url('/profile/agent/professional')}}" ><i class="fa fa-university"></i> Professional Bio</a>
		</li>
		@if($user->agents_users_role_id==4)
		<!--<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='proposal'): ?> active <?php endif; ?>">
			<a href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/proposal/')}}" > Proposals</a>
		</li>-->
		@endif
		<!--<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='documents'): ?> active <?php endif; ?>">
			<a href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/documents/')}}" > Documents</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='Questions'): ?> active <?php endif; ?>">
			<a href="{{url('/profile/agent/questions')}}" > Questions</a>
		</li>-->
		<li class="list-group-item1 border1-bottom <?php if(@$segment[2] == "security"): ?> active <?php endif; ?>">
			<a id="SECURITY" href="{{url('/profile/agent/security')}}" ><i class="fa fa-lock"></i> Security </a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$segment[2] == "password"): ?> active <?php endif; ?>" >
			<a id="CHANGEPASSWORD" href="{{url('/profile/agent/password')}}" ><i class="fa fa-key"></i> Change Password</a>
		</li>
	</ul>
</div>