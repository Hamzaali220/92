<div class="col-md-3 sm-margin-bottom-20 grid cs-style-5">
	@if($user->agents_users_role_id==4)
	<a href="{{url('/post')}}" class="cursor btn-block btn btn-default  top-find-jobs margin-bottom-40 margin-top-6"> Find Jobs </a>
	@else
	<a href="{{url('/agents')}}" class="cursor btn-block btn btn-default margin-bottom-40 margin-top-6"> Find Agents </a>
	@endif
	<ul class="list-group sidebar-nav-v1" id="sidebar-nav-1">		
		<li  class="list-group-item1 border1-bottom <?php if($activemenu == "dashboard"): ?> active <?php endif; ?>">
			<a id="AgentsDASHBOARDTOUR" href="{{url('/dashboard')}}" ><i class="fa fa-dashboard"></i> Dashboard</a>
		</li>
		<li  class="list-group-item1 border1-bottom <?php if($activemenu == "appliedpost"): ?> active <?php endif; ?>">
			<a id="AgentsMYJOBSTOUR" href="{{url('/'.str_replace(' ','',$userdetails->name).'/applied/post')}}" ><i class="fa fa-tasks"></i> My Jobs</a>
		</li>
		<li  class="list-group-item1 border1-bottom <?php if($activemenu == "connectedpost"): ?> active <?php endif; ?>">
			<a id="CONNECTEDJOBSTOUR" href="{{ url('/agent/connected/post') }}" ><i class="fa fa-eye"></i> Connected Jobs</a>
		</li>

		<!-- <li  class="list-group-item1 border1-bottom <?php if($activemenu == "connectedpost"): ?> active <?php endif; ?>">
			<a id="SELECTEDAGENTS" href="{{ url('/agent/selected/post') }}" ><i class="fa fa-check-square-o" aria-hidden="true"></i>Selected Posts</a>
		</li> -->

		<li  class="list-group-item1 border1-bottom <?php if($activemenu == "Post"): ?> active <?php endif; ?>">
			<a id="FINDJOBS" href="{{url('/post')}}" ><i class="fa fa-search"></i> Find Jobs</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "agent"): ?> active <?php endif; ?>">
			<a id="AgentPROFILEture"  href="{{ url('/profile/agent/') }}" ><i class="fa fa-cog"></i> Profile</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "tests"): ?> active <?php endif; ?>">
			<a  id="TESTS" href="{{url('/profile/agent/tests')}}" ><i class="fa fa-file-text"></i> Tests</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "Notes"): ?> active <?php endif; ?>">
			<a  id="NOTESTOUR" href="{{url('/'.str_replace(' ','',$userdetails->name).'/notes/')}}" ><i class="fa fa-sticky-note"></i> Notes</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "Bookmark"): ?> active <?php endif; ?>">
			<a id="BOOKMARKTOUR" href="{{url('/'.str_replace(' ','',$userdetails->name).'/bookmark/')}}" ><i class="fa fa-bookmark"></i> Bookmark</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if($activemenu == "Blog"): ?> active <?php endif; ?>">
			<a id="buyerBlog" href="{{ url('buyer/blog') }}" ><i class="fa fa-pencil"></i> Blog</a>
		</li>
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='Questions'): ?> active <?php endif; ?>">
			<a id="AgentsQUESTIONSture" href="{{url('/profile/agent/questions')}}" ><i class="fa fa-question-circle"></i> Questions</a>
		</li>
		@if($user->agents_users_role_id==4)
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='Advertise'): ?> active <?php endif; ?>">
			<a id="AgentsQUESTIONSture" href="{{url('/buyer/advertisement')}}" ><i class="fa fa-question-circle"></i> Advertise</a>
		</li>
		@endif

		@if($user->agents_users_role_id==4)
		<li class="list-group-item1 border1-bottom <?php if(@$activemenu=='pendinginvoices'): ?> active <?php endif; ?>">
			<a id="AgentsQUESTIONSture" href="{{url('/pendinginvoices')}}" ><i class="fa fa-question-circle"></i> Pending Invoices</a>
		</li>
		@endif
	</ul>
</div>