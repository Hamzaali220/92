<div class="col-md-3 grid cs-style-5">
	@if($user->agents_users_role_id==4)
	<a href="{{url('/post')}}" class="cursor btn-block btn btn-default  margin-bottom-10 margin-top-6"> Find Posts </a>
	@else
	<a href="{{url('/agents')}}" class="cursor btn-block btn btn-default  margin-bottom-10 margin-top-6"> Find Agents </a>
	@endif

	<ul class="list-group sidebar-nav-v1" id="sidebar-nav-1">		
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "documents"): ?> active <?php endif; ?>">
			<a id="DOCUMENTS" href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/documents/')}}" ><i class="fa fa-file-text"></i> Documents </a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$segment[2] == "questions"): ?> active <?php endif; ?>">
			<a id="QUESTIONS" href="{{url('/profile/buyer/questions')}}" ><i class="fa fa-question-circle"></i> Questions</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "survey"): ?> active <?php endif; ?>">
			<a id="SURVEYQUES" href="{{url('/survey/buyers/list')}}" ><i class="fa fa-question"></i> Survey Questions</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "importance"): ?> active <?php endif; ?>">
			<a id="IMPORTANT" href="{{url('/importance/list')}}" ><i class="fa fa-question-circle"></i> Important Questions</a>
		</li>
		
		
	</ul>
</div>