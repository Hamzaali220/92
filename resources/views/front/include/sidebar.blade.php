<style>
    @media(max-width:780px) {
        .header-mobile-container {
            display: flex;
            flex-wrap: wrap;
            position: relative;
        }

        .header-logo-section {
            margin: 0px !important;
            margin-top:0px;
        }

        .header-nav-section {
            position: absolute;
            right: 0px;
            bottom: 0px;
            margin-bottom: 0px !important;
        }
    }
</style>
<header id="header">

    <!-- Header Top Bar -->
    <div class="top-bar">
        <div class="slidedown collapse">
            <div class="container">
                <div class="pull-left">
                    <ul class="social pull-left">
                        <li class="facebook"><a onclick="changeURL('#')"><i class="fa fa-facebook"></i></a></li>
                        <li class="twitter"><a onclick="changeURL('#')" href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="dribbble"><a onclick="changeURL('#')"><i class="fa fa-reddit"></i></a></li>
                        <li class="linkedin"><a onclick="changeURL('#')"><i class="fa fa-pinterest"></i></a></li>

                    </ul>
                </div>

                <div class="phone-login pull-right">
                    <a><i class="fa fa-phone"></i> Call Us : (615)594-3903</a>
                    @if(!Auth::user())
                    <a href="#" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in"></i> Sign In</a>
                    <a class="cursor" data-toggle="modal" data-target="#registrationModal"><i class="fa fa-edit"></i>
                        Sign Up</a>
                    @endif

                    @if(Auth::user())
                    <a href="/dashboard"><i class="glyphicon glyphicon-dashboard"></i>Dashboard</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /Header Top Bar -->

    <!-- Main Header -->
    <div class="main-header">
        <div class="container">

            <!-- TopNav -->
            <div class="topnav navbar-header">
                <a class="navbar-toggle down-button" data-toggle="collapse" data-target=".slidedown">
                    <i class="fa fa-angle-down icon-current"></i>
                </a>
            </div>
            <!-- /TopNav-->

            <!-- Logo -->
            <div class="header-mobile-container">
                <div class="logo pull-left header-logo-section">
                    <h1>
                        <a href="{{url('/')}}">
                            <img class="logo-color" src="{{ URL::asset('assets/img/logo1-default.png') }}" alt="gallaxy"
                                width="auto">
                        </a>
                    </h1>
                </div>
                <!-- /Logo -->

                <!-- Mobile Menu -->
                <div class="mobile navbar-header header-nav-section">
                    <a class="navbar-toggle" data-toggle="collapse" href=".navbar-collapse">
                        <i class="fa fa-bars fa-2x"></i>
                    </a>
                </div>
            </div>
            <!-- /Mobile Menu -->

            <!-- Menu Start -->
            <nav class="collapse navbar-collapse menu">
                <ul class="nav navbar-nav sf-menu">
                    <li>
                        <a {{ @$topmenu=='Home' ? "id=current" : '' }} href="{{url('/')}}">
                            Home<span class="sf-sub-indicator"></span>
                        </a>
                    </li>

                    <li>
                        <a {{ @$topmenu=='Seller' ? "id=current" : '' }} href="{{ URL('/sellers') }}"
                            class="sf-with-ul">
                            Seller<span class="sf-sub-indicator"></span>
                        </a>
                    </li>

                    <li>
                        <a {{ @$topmenu=='Buyer' ? "id=current" : '' }} href="{{ URL('/buyers') }}" class="sf-with-ul">
                            Buyer<span class="sf-sub-indicator"></span>
                        </a>
                    </li>

                    <li>
                        <a {{ @$topmenu=='Agents' ? "id=current" : '' }} href="{{ URL('/agent') }}" class="sf-with-ul">
                            Agents<span class="sf-sub-indicator"></span>
                        </a>
                    </li>

                    <li>
                        <a {{ @$topmenu=='About' ? "id=current" : '' }} href="{{ URL('/aboutus') }}" class="sf-with-ul">

                            About Us <span class="sf-sub-indicator"></span>
                        </a>
                    </li>

                    <!-- <li>
                        <a {{ @$topmenu=='advertise' ? "id=current" : '' }} href="{{url('/advertise')}}">
                            Advertise <span class="sf-sub-indicator"></span>
                        </a>
                    </li> -->

                    <li>
                        <a {{ @$topmenu=='Blog' ? "id=current" : '' }} href="{{ URL('/blogs') }}" class="sf-with-ul">

                            Blogs <span class="sf-sub-indicator"></span>
                        </a>
                    </li>

                    <li>
                        <a {{ @$topmenu=='Contact' ? "id=current" : '' }} href="{{url('/contactus')}}">
                            Contact Us <span class="sf-sub-indicator"></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /Menu -->
        </div>
    </div>
    <!-- /Main Header -->
</header>
