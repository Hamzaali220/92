@extends('admin.master')
@section('title', 'dashboard')
@section('style')
<link href="cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
.modal-content{
  border-radius:10px !important;
}
.datepicker.dropdown-menu{
  width:unset !important;
}
</style>
@stop
@section('content')

<?php 
$agent_selected = false;

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">

     @if(session('c_status') && session('c_status') == 'success')
            <div class="alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> {{ session('c_message') }}
            </div>
            @endif

            @if(session('c_status') && session('c_status') == 'failed')
            <div class="alert alert-danger alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Failed!</strong> {{ session('c_message') }}
            </div>
            @endif

    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.getpost')}}">Post</a></li>
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
              <img class="profile-user-img img-responsive img-circle" src="@if($user->photo != '') {{ url('/assets/img/profile/'.$user->photo) }} @else {{ url('/assets/img/profile/5Z5t-BtF_400x400.jpg') }} @endif" alt="User profile picture">

              <h3 class="profile-username text-center">{{$user->name}}</h3>
              @isset($user->description)
              <p class="text-muted text-center">{!! $user->description !!}</p>
              @endisset
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <?php 
          if(isset($selectedagentdetail)){
          $agent_selected = true;
          ?>
           <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h4>Selected Agent</h4>
              <h3 class="profile-username text-center"><a target="_blank" href='{{ URL("/agentadmin/agents/view/".$selectedagentdetail->id) }}'>{{$selectedagentdetail->name}}</a></h3>
            </div>
            <!-- /.box-body -->
          </div>
          <?php 
        }
          ?>
          <!-- /.box -->

        </div>

        <div class="col-md-9">
          <div class="profile-body" style="background-color: #fff;">
            <!-- <img src="assets/img/clients2/ea-canada.png" alt=""> -->
            <h3 class="title">{{ $post->posttitle }}</h3>
            <div class="overflow-h">
              <p class="hex"><i class="fa fa-clock-o"> </i> <span> {{ date('M d, Y', strtotime($post->created_at)) }} </span></p>
              <p class="hex"><i class="fa fa-map-marker"> </i> <span> {{ $post->address1 }} , {{ $post->address2 }} </span></p>
              <p class="hex"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></i> <strong> Closing Date </strong>: {{ ($post->closing_date != null ) ? date('d-m-Y', strtotime($post->closing_date)) : "" }} </span></p>
            </div>
            <hr>
              
            <div class="col-md-6" style="padding: 0px;">
              <h2>Home Overview</h2>
              <ul class="list-unstyled">
                @if($post->when_do_you_want_to_sell)
                <li><i class="fa fa-check color-green"></i> Want to {{$types}} {{ str_replace('_',' ',$post->when_do_you_want_to_sell) }}.</li>
                @endif
                @if($post->need_Cash_back == 1)
                <li><i class="fa fa-check color-green"></i> Need Cash back and Negotiate Commision</li>
                @endif
                @if($post->home_type)
                <li><i class="fa fa-check color-green title"></i> Home type {{ str_replace('_',' ',$post->home_type) }}.</li>
                @endif

              </ul>
            </div>
            <div class="col-md-6" style="padding: 0px;">
              <?php $bestfeature = $post->best_features; 
              if(!empty($bestfeature)):
                echo    '<h2>Best Features of Home </h2>
                        <ul class="list-unstyled">';
                foreach (json_decode($bestfeature) as $value) :
                  echo    '<li><i class="fa fa-check color-green"></i> '.$value.'</li>';
                endforeach;
                echo    '</ul>';
              endif;
              ?>
            </div>
            <div class="col-md-12" style="padding: 0px;">
              <hr>
            </div>
            <h2>Post Description</h2>
            <p>{!! $post->details !!}</p>
            
          </div>
          <!--=== Profile ===-->
          <div class="profile">
            <!-- Profile Content -->
            <div class="profile-body " style="background: #fff;">
              <!--Profile Blog-->
              <div class="col-md-6"><h2>Applied Agents</h2> </div>
              <div class="col-md-6">
                <?php 
                // if(!$agent_selected){
                 ?>
                <form class="form-inline" action="{{ route('admin.selectagentbyadmin') }}" method="post" id='selectagentform'>
                  {{ csrf_field() }}

                  <input type="hidden" name="sapost_id" value="{{ $post->post_id }}">
                  <div class="form-group">
                    <label for="email">Select Agent</label>
                     <select class="form-control selectagentbox" name="saagent_id" required>
                      <option>--Select Agent--</option>
                      <?php 
                      foreach ($agentslist as $agent) {
                        //print_r($agent);
                        ?>
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success">Update</button>
                </form>
                <?php 
                // }
                ?>

              </div>
              <div class="clearfix"></div>
              
              <input type="hidden" id="userid" value="{{$user->id}}">
              <input type="hidden" id="postid" value="{{$post->post_id}}">
              <div class="connectedagents-data row" id="connectedagents-data"></div>
              <div id="loadagents" class="loadagents col-md-12 center loder loadappliedpost"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
              <button type="button" id="loadmoreagents" class="hide btn-u btn-u-default btn-block text-center">Load More</button>
              <!--End Profile Blog-->
            </div>
            <!-- End Profile Content -->
          </div>
          <!--=== End Profile ===-->  




        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->

      <!-- Content -->
    <section class="content">
      <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <div style="background-color: #fff; padding: 2rem;">
              <?php 
              if($agent_selected){
                if(empty($selldetails)){
              ?>
              <h3>Enter Sell Details</h3>
              
              <form action="{{ route('admin.selldetails') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                <input type="hidden" name="selected_agent" value="{{ $selectedagentdetail->id }}">
                <div class="form-group">
                  <label for="">Seller’s name</label>
                  <input type="text" class="form-control" name="sellers_name" placeholder="Seller's name" required>
                </div>
                <div class="form-group">
                  <label for="">Exact home address</label>
                  <input type="text" class="form-control" name="address" placeholder="Exact home address" required>
                </div>

                <div class="form-group">
                  <label for="">Agent commision rate</label> 
                  <input type="text" class="form-control" name="agent_comission" placeholder="Agent commision rate" value="3" required>
                </div>

                <div class="form-group">
                  <label for="">92Agent commision rate</label>
                  <input type="text" class="form-control" name="comission_92agent" placeholder="92Agent commision rate" value="3" required>
                </div>

                <div class="form-group">
                  <label for="">Sale Date</label>
                  <!-- <input type="date" class="form-control" name="sale_date" placeholder="Sale date" required> -->
                  
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="datepicker form-control" onkeydown="return false" autocomplete="off" name="sale_date" placeholder="Sale date" required>
                  </div>
                  
                  
                </div>
                <div class="form-group">
                  <label for="">Sale Price</label>
                  <input type="text" class="form-control" name="sale_price" placeholder="Sale price" required>
                </div>
                <button type="submit" class="btn bt-lg btn-primary">Update Details</button>
              </form>
              <?php 
            } else {
              ?>
              <table class="table table-bordered">
                <tr>
                  <th colspan="2">Seller's Information</th>
                </tr>
                <tr>
                  <th width="20%">Seller's Name</th>
                  <td>{{ $selldetails->sellers_name }}</td>
                </tr>
                <tr>
                  <th>Address</th>
                  <td>{{ $selldetails->address }}</td>
                </tr>

                <tr>
                  <th>Agent commision rate</th>
                  <td>{{ $selldetails->agent_comission }}</td>
                </tr>

                <tr>
                  <th>92Agent commision rate</th>
                  <td>{{ $selldetails->comission_92agent }}</td>
                </tr>
                <tr>
                  <th>Sale Date</th>
                  <td>{{ date('d-m-Y', strtotime($selldetails->sale_date)) }}</td>
                </tr>
                <tr>
                  <th>Sale Price</th>
                  <td>{{ $selldetails->sale_price }}</td>
                </tr>
                <tr>
                  <th>Payment Status</th>
                  
                    <td>
                      @if($selldetails->payment_status == 1 )
                        Paid, <a href='{{ $selldetails->receipt_url }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> View Receipt</a>
                      @else 
                        Unpaid
                      @endif
                    </td>
                 
                </tr>
                <tr>
                  <th>Added On</th>
                  <td>{{  date('d-m-Y', strtotime($selldetails->created_ts)) }}</td>
                </tr>
              </table>
              <?php
            }
          }
            ?>
            </div>
        </div>
          
        </div>
    
    </section>




  </div>
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Shared Documents</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
@endsection
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    
  $('.datepicker').datepicker({ 
        format: 'dd-mm-yyyy',
        endDate: '+0d',
        autoclose: true
      });
  

  $(document).ready(function() {
      $('.selectagentbox').select2();
  });

  $('#selectagentform').on('submit', function(e){
    e.preventDefault();
    var agent_selected = $("[name='saagent_id']").val();
    var already_selected = '{{ (isset($selectedagentdetail->id)) ? $selectedagentdetail->id : '' }}';
    if(!$.isNumeric(agent_selected)){
       alert('Please select an Agent');
      return false;
    } else if (already_selected == agent_selected ){
      
      alert('Please select different agent');
      return false;
      
    }else {
      $('#selectagentform').unbind().submit();
     
    }
  });
</script>

<script type="text/javascript">
  var agentsdata       = [];
  var valid = 0;
  $( document ).ready(function() {
    
    $('#loadmoreagents').click(function(e){
      e.preventDefault();
      var limit = $(this).attr('title');
      loadagents(limit);
    });
    loadagents(0);
  });
  
  /*load proposal */
  function loadagents(limit) {

    $.ajax({
      url: "{{url('/agentadmin/')}}/profile/buyer/post/details/agents/get/"+limit+"/{{ $post->post_id }}/{{ $post->agents_user_id }}/{{ $post->agents_users_role_id }}",
      type: 'get',
      beforeSend: function(){$(".loadagents").show();},
          processData:true,
      success: function(result) { 
        var proppos   = result;
        $(".loadagents").hide();
        if(proppos.count !== 0){
          
          $.each( proppos.result, function( key, value ) {
          	
            agentsdata[value.id] = value;
            let date = timeDifference(new Date(), new Date(value.created_at));
            let photo = "";
            if(value.photo){
              photo = '<img class="rounded-x" src="{{ URL::asset("assets/img/profile/") }}/'+value.photo+'" alt="">';
            }else{
              photo = '<img class="rounded-x" src="{{ URL::asset("assets/img/testimonials/user.jpg") }}" alt="">';
            }
            let agent_desc = (value.description !== null)?value.description:"";
            let agent_experience = (value.years_of_expreience !== null) ? value.years_of_expreience : "0";
            var htmll = '<div class="col-sm-6 sm-margin-bottom-20" >'+
                          '<div class="profile-blog border-gre">'+photo+
                            '<div class="name-location">'+
                              '<strong><a target="_blank" href="{{ URL("/agentadmin/") }}/agents/view/'+value.details_id+'">'+value.name+'</a>'+
                              '  </strong>'+
                              '<span>Ex: <a class="color-green"> ' + agent_experience + ' </a>  </span>'+
                              '<span>  <i class="fa fa-clock-o"> </i> <a class="color-green"> '+date+'</a></span>'+
                            '</div>'+
                            '<div class="clearfix margin-bottom-20"></div>'+
                            '<p class="hidetext2line">'+agent_desc+'</p>'+
                            '<hr>'+
                            '<ul class="list-inline share-list">'+
                              '<li><i class="fa fa-share"></i><a  target="_blank" href="{{ URL("/agentadmin/") }}/agents/view/'+value.details_id+'"> Agent Details</a></li><li><i class="fa fa-comment"></i><a  target="_blank" href="{{ URL("/agentadmin/") }}/conversation/conversationdetails/'+value.connection_id+'"> Chat History</a></li><li><i class="fa fa-file"></i><a href="javascript:(0)" data-toggle="modal" data-target="#myModal" id="'+value.details_id+'" onclick="showdoc(this.id)"> Documents</a></li>';
                    htmll +='</ul>'+
                          '</div>'+
                        '</div>';

            $('#connectedagents-data').append(htmll);
          });
          if(proppos.next!=0){
            $('#loadmoreagents').removeClass('hide').attr('title',proppos.next);
          }else{
            $('#loadmoreagents').addClass('hide');
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
        }
        
      },
        error: function(data) 
        { $(".loadagents").hide();
          if(data.status=='500'){
          $('.loadagents').text(data.statusText).css({'color':'red'});
          }else if(data.status=='422'){
          $('.loadagents').text(data.responseJSON.image[0]).css({'color':'red'});
          }
        }
    });
  }
  function showdoc(id) {
    var userid = $("#userid").val();
    var postid = $("#postid").val();
    $.ajax({
      url:"{{ route('agentadmin.showdoc') }}",
      type:'get',
      dataType:'json',
      data:{'userid':userid,'postid':postid,'agentid':id},
      success:function(data){
        $(".modal-body").html('<embed src="'+data.attachments+'" type="application/pdf"   height="300px" width="100%" class="responsive">');
      }
    })
  }
</script> 
@stop