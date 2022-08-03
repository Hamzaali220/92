 <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('admin/defaultUser.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{session('username')}}</p>
          <?php
          $user_access_data = session('user_access_data');
          
          $agentread = 1;
          $agentchange = 1;
          $bsread = 1;
          $bschange = 1;
          $empread = 1;
          $empchange = 1;
          $postlistread = 1;
          $postlistchange = 1;
          $badpostread = 1;
          $badpostchange = 1;
          $quesread = 1;
          $queschange = 1;
          $squesread = 1;
          $squeschange = 1;
          $skillread = 1;
          $skillchange = 1;
          $franchread = 1;
          $franchchange = 1;
          $certificationread = 1;
          $certificationchange = 1;
          $stateread = 1;
          $statechange = 1;
          $arearead = 1;
          $areachange = 1;

          if(session('userid') !== 1){
            
            $agentread = $user_access_data->agentread;
            $agentchange = $user_access_data->agentchange;
            $bsread = $user_access_data->bsread;
            $bschange = $user_access_data->bschange;
            $empread = $user_access_data->empread;
            $empchange = $user_access_data->empchange;
            $postlistread = $user_access_data->postlistread;
            $postlistchange = $user_access_data->postlistchange;
            $badpostread = $user_access_data->badpostread;
            $badpostchange = $user_access_data->badpostchange;
            $quesread = $user_access_data->quesread;
            $queschange = $user_access_data->queschange;
            $squesread = $user_access_data->squesread;
            $squeschange = $user_access_data->squeschange;
            $skillread = $user_access_data->skillread;
            $skillchange = $user_access_data->skillchange;
            $franchread = $user_access_data->franchread;
            $franchchange = $user_access_data->franchchange;
            $certificationread = $user_access_data->certificationread;
            $certificationchange = $user_access_data->certificationchange;
            $stateread = $user_access_data->stateread;
            $statechange = $user_access_data->statechange;
            $arearead = $user_access_data->arearead;
            $areachange = $user_access_data->areachange;

          }
           
          ?>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
    		<li class="active"> <a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard text-aqua"></i> <span>Dashboard</span></a></li>
        @if($agentread == 1 OR $bsread == 1)
          <li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i> <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
      				<!-- <li><a href="{{route('admin.agent')}}"><i class="fa  fa-plus-circle"></i>Add Agents</a></li> -->
      				<!-- <li><a href="{{route('admin.sellerbuyer')}}"><i class="fa  fa-plus-circle"></i>Add Buyers/Sellers</a></li> -->
      				@if($agentread == 1)
              <li><a href="{{route('admin.agents')}}"><i class="fa  fa-list"></i>Agents</a></li>
              @endif

              @if($bsread == 1)
              <li><a href="{{route('admin.sellerbuyers')}}"><i class="fa  fa-list-ol"></i>Buyers/Sellers</a></li>
              @endif
            </ul>
          </li>
          @endif

          @if($postlistread == 1 OR $postlistchange == 1 OR ($badpostread == 1 OR $badpostchange == 1))
          <li class="treeview">
            <a href="#">
              <i class="fa fa-newspaper-o"></i> <span>Posts</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            @if($postlistread == 1)
              <li><a href="{{route('admin.getpost')}}"><i class="fa fa-list-ol"></i> Posts List</a></li>
            @endif
            @if($badpostread == 1 OR $badpostchange == 1)
              <li><a href="{{route('admin.validatepost')}}"><i class="fa fa-list-ol"></i> Bad Contents</a></li>
            @endif
            @if($postlistchange == 1)
              <li><a href="{{route('admin.pendinginvoices')}}"><i class="fa fa-list-ol"></i> Pending Invoices</a></li>
            @endif
            </ul>
          </li>
          @endif

          @if($empread == 1 OR $empchange == 1)
          <li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i> <span>Employee</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if($empchange == 1)
              <li><a href="{{route('admin.employee.add')}}"><i class="fa fa-list-ol"></i> Add Employee </a></li>
              @endif
              @if($empread == 1)
              <li><a href="{{route('admin.employee.employeelist')}}"><i class="fa fa-list-ol"></i> Employee list</a></li>
              @endif
            </ul>
          </li>
          @endif

          @if($quesread == 1 OR $queschange == 1)
          <li class="treeview">
            <a href="#">
              <i class="fa fa-question"></i> <span>Questions</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if($queschange == 1)
              <li><a href="{{route('admin.QuestionAnswers')}}"><i class="fa fa-plus-circle"></i> Questions Add</a></li>
              @endif
              @if($quesread == 1)
              <li><a href="{{route('admin.getQuestionAnswers')}}"><i class="fa fa-list-ol"></i> Questions List</a></li>
              @endif
            </ul>
          </li>
          @endif

          @if($squesread == 1 OR $squeschange == 1)
          <li class="treeview">
            <a href="#">
              <i class="fa fa-question"></i> <span>Security Questions</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if($squeschange == 1)
              <li><a href="{{route('admin.securtyquestionaddedit')}}"><i class="fa fa-plus-circle"></i> Security Questions Add</a></li>
              @endif
              @if($squesread == 1)
              <li><a href="{{route('admin.getsecurtyquestion')}}"><i class="fa fa-list-ol"></i> Security Questions List</a></li>
              @endif
            </ul>
          </li>
          @endif

          @if($skillread == 1 OR $skillchange == 1)
          <li class="treeview">
            <a href="#">
              <i class="ion ion-university"></i> <span>Skills & Specialization</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if($skillchange == 1)
              <li><a href="{{route('admin.specialization')}}"><i class="fa fa-plus-circle"></i>Skills Add</a></li>
              @endif
              @if($skillread == 1)
              <li><a href="{{route('admin.specializations')}}"><i class="fa fa-list-ol"></i>Skills List</a></li> 
              @endif
            </ul>
          </li>
          @endif

          @if($franchread == 1 OR $franchchange == 1)
          <li class="treeview">
            <a href="#">
              <i class="fa fa-cubes"></i> <span>Franchisees</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if($franchchange == 1)
                <li><a href="{{route('admin.Franchisee')}}"><i class="fa fa-plus-circle"></i> Add Franchisees</a></li>
              @endif
              @if($franchread == 1)
                <li><a href="{{route('admin.Franchisees')}}"><i class="fa fa-list-ol"></i> Franchisees list</a></li>
              @endif
            </ul>
          </li>
          @endif

          @if($certificationread == 1 OR $certificationchange == 1)
  		    <li class="treeview">
            <a href="#">
              <i class="ino ion-ribbon-b"></i> <span>Certifications</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if($certificationchange == 1)
                <li><a href="{{route('admin.certificationsaddedit')}}"><i class="fa fa-plus-circle"></i> Add Certifications</a></li>
              @endif
              @if($certificationread == 1)
                <li><a href="{{route('admin.certifications')}}"><i class="fa fa-list-ol"></i> Certifications list</a></li>
              @endif
            </ul>
          </li>
          @endif

          <li class="treeview">
            <a href="#">
              <i class="fa fa-file"></i> <span>Package</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
           
           <li><a href="{{route('admin.package')}}"><i class="fa fa-list-ol"></i> Package list</a></li>

           <li><a href="{{route('admin.adrequests')}}"><i class="fa fa-list-ol"></i> Ad Requests</a></li>

            </ul>
          </li>


          <li class="treeview">
            <a href="#">
              <i class="ion ion-android-pin"></i> <span>Blog</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
           <li><a href="{{route('admin.blog.categorylist')}}"><i class="fa fa-plus-circle"></i> Category</a></li>
           <li><a href="{{route('admin.blog.add')}}"><i class="fa fa-plus-circle"></i> Add Blog</a></li>
            <li><a href="{{route('admin.blog.bloglist')}}"><i class="fa fa-list-ol"></i> Blog List</a></li>
            </ul>
          </li>

          @if($stateread == 1 OR $statechange == 1)
          <li class="treeview">
            <a href="#">
              <i class="ion ion-android-pin"></i> <span>States</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
            @if($statechange == 1)
              <li><a href="{{route('admin.state')}}"><i class="fa fa-plus-circle"></i> Add States</a></li>
            @endif
            @if($stateread == 1)
              <li><a href="{{route('admin.states')}}"><i class="fa fa-list-ol"></i> States</a></li>
            @endif
            </ul>
          </li>
          @endif
          
          <li class="treeview">
            <a href="#">
              <i class="ion ion-android-pin"></i> <span>Cities</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
           <li><a href="{{route('admin.city')}}"><i class="fa fa-plus-circle"></i> Add Cities</a></li>
            <li><a href="{{route('admin.cities')}}"><i class="fa fa-list-ol"></i> Cities</a></li>
            </ul>
          </li>

          @if($arearead == 1 OR $areachange == 1) 
          <li class="treeview">
            <a href="#">
              <i class="ion ion-android-pin"></i> <span>Areas</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if($areachange == 1) 
              <li><a href="{{route('admin.area')}}"><i class="fa fa-plus-circle"></i> Add Areas</a></li>
              @endif
              @if($arearead == 1) 
              <li><a href="{{route('admin.areas')}}"><i class="fa fa-list-ol"></i> Areas</a></li>
              @endif
            </ul>
          </li>
          @endif
			<li class="treeview">
				<a href="#">
					<i class="ion ion-android-pin"></i> <span>Notification</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{route('admin.getnotification')}}"><i class="fa fa-list-ol"></i>Notification Settings</a></li>
				</ul>
			</li>


        <li class="treeview">
            <a href="#">
             <i class="fa fa-comments-o" aria-hidden="true"></i> <span> Conversations</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
           
           <li><a href="{{route('admin.conversation')}}"><i class="fa fa-comments-o" aria-hidden="true"></i> Conversations List</a></li>


            </ul>
          </li>

      
      </ul>


         
    </section>
  </aside>