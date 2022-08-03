@extends('admin.master')
@section('title', 'dashboard')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <!-- Small boxes (Stat box) -->
      <div class="row">
        @if( (isset(session('user_access_data')->bsread) && session('user_access_data')->bsread == 1) OR (isset(session('user_access_data')->bschange) && session('user_access_data')->bschange == 1) OR session("userid") == 1 )
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$sellersbuyerscount}}</h3>

              <p>Total Sellers/Buyers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="{{route('admin.sellerbuyers')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif


        @if( (isset(session('user_access_data')->agentread) && session('user_access_data')->agentread == 1) OR (isset(session('user_access_data')->agentchange) && session('user_access_data')->agentchange == 1) OR session("userid") == 1 )
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$agentscount}}</h3>

              <p>Total Agents</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{route('admin.agents')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif

        @if( (isset(session('user_access_data')->postlistread) && session('user_access_data')->postlistread == 1) OR (isset(session('user_access_data')->postlistchange) && session('user_access_data')->postlistchange == 1) OR session("userid") == 1 )
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$postcount}}</h3>

              <p>Total Post</p>
            </div>
            <div class="icon">
              <i class="fa fa-newspaper-o"></i>
            </div>
            <a href="{{route('admin.getpost')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif
      </div>

      <div class="row">
        
      @if( (isset(session('user_access_data')->quesread) && session('user_access_data')->quesread == 1) OR (isset(session('user_access_data')->queschange) && session('user_access_data')->queschange == 1) OR session("userid") == 1 )
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$post_question}}</h3>

              <p>Total Questions</p>
            </div>
            <div class="icon">
              <i class="fa fa-question"></i>
            </div>
            <a href="{{route('admin.getQuestionAnswers')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        @endif

        @if( (isset(session('user_access_data')->squesread) && session('user_access_data')->squesread == 1) OR (isset(session('user_access_data')->squeschange) && session('user_access_data')->squeschange == 1) OR session("userid") == 1 ) 
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$postsecurty_question}}</h3>

              <p>Total Security Questions</p>
            </div>
            <div class="icon">
              <i class="fa fa-question"></i>
            </div>
            <a href="{{route('admin.getsecurtyquestion')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        @endif
        @if( (isset(session('user_access_data')->certificationread) && session('user_access_data')->certificationread == 1) OR (isset(session('user_access_data')->certificationchange) && session('user_access_data')->certificationchange == 1) OR session("userid") == 1 )
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$post_certifications}}</h3>

              <p>Total Certifications</p>
            </div>
            <div class="icon">
              <i class="ino ion-ribbon-b"></i>
            </div>
            <a href="{{route('admin.certifications')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        @endif
        @if( (isset(session('user_access_data')->franchread) && session('user_access_data')->franchread == 1) OR (isset(session('user_access_data')->franchchange) && session('user_access_data')->franchchange == 1) OR session("userid") == 1 )
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$post_franchise}}</h3>

              <p>Total Franchise</p>
            </div>
            <div class="icon">
              <i class="fa fa-cubes"></i>
            </div>
            <a href="{{route('admin.Franchisees')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        @endif
      </div>
      <div class="row">
        @if( (isset(session('user_access_data')->arearead) && session('user_access_data')->arearead == 1) OR (isset(session('user_access_data')->areachange) && session('user_access_data')->areachange == 1) OR session("userid") == 1 )
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$postarea}}</h3>

              <p>Total Area</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-pin"></i>
            </div>
            <a href="{{route('admin.areas')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        @endif


        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$postcity}}</h3>

              <p>Total City</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-pin"></i>
            </div>
            <a href="{{route('admin.cities')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        @if( (isset(session('user_access_data')->stateread) && session('user_access_data')->stateread == 1) OR (isset(session('user_access_data')->statechange) && session('user_access_data')->statechange == 1) OR session("userid") == 1 )
        
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$poststate}}</h3>

              <p>Total State</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-pin"></i>
            </div>
            <a href="{{route('admin.states')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        @endif
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  @endsection