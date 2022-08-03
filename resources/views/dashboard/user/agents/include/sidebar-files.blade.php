<div class="col-md-3 sm-margin-bottom-20 grid cs-style-5">
	@if($user->agents_users_role_id==4)
	<a href="{{url('/post')}}" class="cursor btn-block btn btn-default margin-bottom-20"> Find Jobs </a>
	@else
	<a href="{{url('/agents')}}" class="cursor btn-block btn btn-default margin-bottom-20"> Find Agents </a>
	@endif
	<ul class="list-group sidebar-nav-v1" id="sidebar-nav-1">		
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='proposal'): ?> active <?php endif; ?>">
			<a id="PROPOSALS" href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/proposal/')}}" ><i class="fa fa-empire"></i> Proposals</a>
		</li>
		
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='documents'): ?> active <?php endif; ?>">
			<a id="DOCUMENTS" href="{{url('/profile/'.str_replace(' ','',$userdetails->name).'/documents/')}}" ><i class="fa fa-file-text"></i> Documents</a>
		</li>
		<!--<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='Bookmark'): ?> active <?php endif; ?>">
			<a href="{{url('/'.str_replace(' ','',$userdetails->name).'/bookmark/')}}" > Bookmark</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='Notes'): ?> active <?php endif; ?>">
			<a href="{{url('/'.str_replace(' ','',$userdetails->name).'/notes/')}}" > Notes</a>
		</li>-->
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='Questions'): ?> active <?php endif; ?>">
			<a id="QUESTIONS" href="{{url('/profile/agent/questions')}}" ><i class="fa fa-question-circle"></i> Questions</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu == "survey"): ?> active <?php endif; ?>">
			<a id="SURVEYQUES" href="{{url('/survey/agent/list')}}" ><i class="fa fa-question"></i> Survey Questions</a>
		</li>
		
	</ul>
</div>