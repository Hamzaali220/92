@extends('admin.master')
@section('title', 'dashboard')
@section('style')
<link href="cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<style>
.modal-content{
  border-radius:10px !important;
}
</style>
@stop
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Active Post
         <small>{{$user->name}}</small>
      </h1>

      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.agents')}}">Agent</a></li>
        <li class="active">{{$user->name}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content profile">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="@if($user->photo != '') {{ url('/assets/img/profile/'.$user->photo) }} @else {{ url('/assets/img/team/img32-md.jpg') }} @endif" alt="User profile picture">

              <h3 class="profile-username text-center">{{$user->name}}</h3>

              <p class="text-muted text-center">{!!$user->description!!}</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="profile-body">
            <div class="row">
              <div class="append-aplied-post-data" id="append-aplied-post-data"></div>              
            </div><!--/end row-->
            <div id="loadappliedpost" class="col-md-12 center loder loadappliedpost"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
            <button type="button" id="loaduploadandshare" class="hide btn-u btn-u-default btn-u-sm btn-block">Load More</button>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
@endsection
@section('scripts')
<script type="text/javascript">
  var appliedpost_data  = [];
  $( document ).ready(function() {

    $('#loaduploadandshare').click(function(e){
      e.preventDefault();
      var limit = $(this).attr('title');
      loadappliedpost(limit);
    });
    loadappliedpost(0);
  });
  /*load aonnected post data list*/
  function loadappliedpost(limit) {

    $.ajax({
      url: "{{url('/agentadmin/applied/post/list/get/')}}/"+limit+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",
      type: 'get',
      beforeSend: function(){ $(".loadappliedpost").show(); },
          processData:true,
      success: function(result) { 
        
        console.log(result);
        var postdata   = result;
        
        $(".loadappliedpost").hide();
        if(postdata.count !== 0){
          
          $.each( postdata.result, function( key, value ) {
            let allConectedAgents = new Array();
            let connectedAgentCount = 0;
            for(let i=0;i < value.connected_agent_list.length;i++){
              let single_agent = value.connected_agent_list[i];
              if(typeof allConectedAgents["agent_"+single_agent.details_id] == "undefined")
                connectedAgentCount++;
                
              allConectedAgents["agent_"+single_agent.details_id] = single_agent;
              
            };
            
            appliedpost_data[value.post_id] = value;
            let date = timeDifference(new Date(), new Date(value.created_at));
            let post_detail = (value.details !== null)?value.details:"No description"; 
            let htmll = '<div class="col-sm-12 margin-bottom-20">'+
                    '<div class="projects">'+
                      '<h2><a class="color-dark" target="_blank" href="{{ URL("/agentadmin/") }}/post/details/{{ $user->id }}/{{ $user->agents_users_role_id }}/'+value.post_id+'">'+value.posttitle+'</a></h2>'+
                      '<ul class="list-unstyled list-inline blog-info-v2">'+
                        '<li>By: <a class="color-green" href="#">'+value.name+'</a></li>'+
                        '<li><i class="fa fa-clock-o"></i> '+date+'</li>'+
                      '</ul>'+
                      '<p>'+post_detail+'</p>'+
                    '</div>'+
                    '<div class="project-share">'+
                      '<ul class="list-inline comment-list-v2 pull-left">'+
                        '<li><a class="cursor" target="_blank" href="{{ URL("/agentadmin/") }}/post/details/{{ $user->id }}/{{ $user->agents_users_role_id }}/'+value.post_id+'">View Post</a></li>'+
                        '<li><a href="#" rel="popover" data-popover-content="#myPopover'+value.post_id+'">, '+connectedAgentCount+' Agents Applied</a></li>'+
                      '</ul>'+
                    '</div>'+

                    '<div id="myPopover'+value.post_id+'" class="hide">'+
                        '<div class="panel panel-profile">'+
                      
                      '<div class="panel-heading overflow-h border1-bottom">'+
                        '<h2 class="panel-title heading-sm pull-left color-black"><i class="fa fa-users"></i> Active Agents</h2>'+
                      '</div>'+
                      
                      '<div id="scrollbar3" class="panel-body no-padding mCustomScrollbar" data-mcs-theme="minimal-dark">';
                        if(value.post_view_count != 0)  {
                          // $.each( value.connected_agent_list, function( key, agentdata ) {
                          // });
                          for(let key in allConectedAgents){
                            let agentdata = allConectedAgents[key];
                            let exp = (agentdata.years_of_expreience != null) ? agentdata.years_of_expreience : "0";
                            let description = (agentdata.description != null) ? agentdata.description : "";
                            let photo = '<img class="rounded-x" src="{{ URL::asset("assets/img/testimonials/user.jpg") }}" alt="">';
                            if(agentdata.photo){
                              photo = '<img class="rounded-x" src="{{ URL::asset("assets/img/profile/") }}/'+agentdata.photo+'">';
                            }
                            
                            htmll +=' <div onclick="onclickagent('+agentdata.details_id+','+value.post_id+');" class="cursor alert-blocks alert-dismissable">'+photo+
                                  '<div class="overflow-h">'+
                                    '<strong class="color">'+agentdata.name+' <small class="pull-right">Ex. <em>'+exp+'</em></small></strong>'+
                                    '<p class="hidetext1line">'+description+'</p>'+
                                  '</div>'+
                                '</div>';
                          }
                        }

                        htmll += '</div>'+

                      '</div>'+

                      '</div>'+

                  '</div>';
                  
            $('#append-aplied-post-data').append(htmll);
          });
          if(postdata.next!=0){
            $('#loaduploadandshare').removeClass('hide').attr('title',postdata.next);
          }else{
            $('#loaduploadandshare').addClass('hide');
          }
        }else{
          let no_active_post = `<div style='display:flex;flex-direction:column;justify-content:center;align-items:center;'>
                                    <div class="icon">
                                      <i style="font-size:46px" class="fa fa-newspaper-o"></i>
                                    </div>
                                    <h3>No active post</h3>
                                    <p>There is no active post of this agent</p>
                                </div>`;
          $('#append-aplied-post-data').append(no_active_post);
        }
        $(function(){
            $('[rel="popover"]').popover({
                container: 'body',
                html: true,
                animation:true,
                content: function () {
                    var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
                    return clone;
                }
            }).click(function(e) {
                e.preventDefault();
            });
        });
        
      },
        error: function(data) 
        { $(".loadappliedpost").hide();
          if(data.status=='500'){
          $('.append-aplied-post-data').text(data.statusText).css({'color':'red'});
          }else if(data.status=='422'){
          $('.append-aplied-post-data').text(data.responseJSON.image[0]).css({'color':'red'});
          }
        }
    });
  }
</script> 
@stop