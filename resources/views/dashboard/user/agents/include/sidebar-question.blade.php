<div class="col-md-3 grid cs-style-5">
	@if($user->agents_users_role_id==4)
	<a href="{{url('/post')}}" class="cursor btn-block btn btn-default margin-bottom-10 margin-top-6"> Find Posts </a>
	@else
	<a href="{{url('/agents')}}" class="cursor btn-block btn btn-default margin-bottom-10 margin-top-6"> Find Agents </a>
	@endif
	<ul class="list-group sidebar-nav-v1" id="sidebar-nav-1">		
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "agent"): ?> active <?php endif; ?>">
			<a href="{{url('/profile/agent')}}" > My Profile </a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$segment[2] == "questions"): ?> active <?php endif; ?>">
			<a href="{{url('/profile/agent/questions')}}" > Questions</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "survey"): ?> active <?php endif; ?>">
			<a href="{{url('/survey/agent/list')}}" > Survey Questions</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$segment[2] == "tests"): ?> active <?php endif; ?>">
			<a href="{{url('/profile/agent/tests')}}"> Tests</a>
		</li>
		
	</ul>
</div>