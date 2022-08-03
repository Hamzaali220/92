<header class="main-header">
    <!-- Logo -->
    <a href="{{route('admin.dashboard')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>92</b>A</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>92</b>Agent</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('admin/defaultUser.png')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{session('username')}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset('admin/defaultUser.png')}}" class="img-circle" alt="User Image">

                <p>
                  92Agent 
                </p>
              </li>
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('admin.password')}}" class="btn btn-success btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="{{url('/adminlogout')}}" class="btn btn-danger btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
           
          </li>
        </ul>
      </div>
    </nav>
  </header>