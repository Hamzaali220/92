<div class="col-md-3 sm-margin-bottom-20 grid cs-style-5">
	@if($user->agents_users_role_id==4)
	<a href="{{url('/post')}}" class="cursor btn-block btn btn-default"> Find Posts </a>
	@else
	<a href="{{url('/agents')}}" class="cursor btn-block btn btn-default"> Find Agents </a>
	@endif
	
	<ul class="list-group sidebar-nav-v1" id="sidebar-nav-1">		
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "buyer"): ?> active <?php endif; ?>">
			<a href="{{url('/profile/buyer')}}" > My Profile </a>
		</li>
		@if($user->agents_users_role_id==4)
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='proposal'): ?> active <?php endif; ?>">
			<a href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/proposal/')}}" > Proposals</a>
		</li>
		@endif
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='documents'): ?> active <?php endif; ?>">
			<a href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/documents/')}}" > Documents</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='Bookmark'): ?> active <?php endif; ?>">
			<a href="{{url('/'.str_replace(' ','',$userdetails->name).'/bookmark/')}}" > Bookmark</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='Notes'): ?> active <?php endif; ?>">
			<a href="{{url('/'.str_replace(' ','',$userdetails->name).'/notes/')}}" > Notes</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='Questions'): ?> active <?php endif; ?>">
			<a href="{{url('/profile/buyer/questions')}}" > Questions</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$segment[2] == "settings"): ?> active <?php endif; ?>">
			<a href="{{url('/profile/buyer/settings')}}" > Profile Settings</a>
		</li>
		
	</ul>
</div>