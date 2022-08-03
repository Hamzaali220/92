@extends('admin.master')
@section('title', 'Change Password')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-Change Password"></i> Home</a></li>
        <li class="active">Change Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
        
              <li class="active"><a class="active" href="#settings" data-toggle="tab">Change Password</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
               
              <div class="tab-pane" id="settings">
                @if (isset($errors) && count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

              @if(Session::has('success'))
                <div class="alert alert-success  text-center"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success') !!}</em></div>
              @endif

              @if(Session::has('dbError'))
                <div class="alert alert-danger text-center"> {!! session('dbError') !!}</div>
              @endif
              <div class="message-password"> </div>
              <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
                
              {!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'edit-password')) !!}
                <div class="modal-body">
                  <dl class="dl-horizontal">
                    <dt>Enter Old Password</dt>
                    <dd>
                      <section>
                        <label class="input">
                          <i class="icon-append fa fa-lock"></i>
                          <input type="password" id="oldpassword" name="oldpassword"  data-toggle="tooltip" data-placement="top" placeholder="Old Password">
                          <b class="error-text" id="oldpassword_error"></b>
                        </label>
                      </section>
                    </dd>
                    <dt>Enter New Password</dt>
                    <dd>
                      <section>
                        <label class="input">
                          <i class="icon-append fa fa-lock"></i>
                          <input type="password" id="password" name="password"  data-toggle="tooltip" data-placement="top" placeholder="Password">
                          <b class="error-text" id="password_error"></b>
                        </label>
                      </section>
                    </dd>
                    <dt>Confirm New Password</dt>
                    <dd>
                      <section>
                        <label class="input">
                          <i class="icon-append fa fa-lock"></i>
                          <input type="password" name="password_confirmation" id="password_confirmation" data-toggle="tooltip" data-placement="top" placeholder="Confirm password">
                          <b class="error-text" id="password_confirmation_error"></b>
                        </label>
                      </section>
                    </dd>
                  </dl>
                  <br>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="id" value="{{$user->id}}">
                  <a type="button" href="{{route('admin.dashboard')}}" class="btn-u btn-u-default" data-dismiss="modal">Close</a>
                  <button class="btn-u" type="submit">Save</button>
                </div>
              {!!Form::close()!!}

              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
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
    $( document ).ready(function() {
      /* edit password*/
      $('#edit-password').submit(function(e){
        e.preventDefault();
        var $form = $(e.target),esmsg = $('.message-password');
        
        $.ajax({
          
          url: "{{url('/agentadmin/')}}/password/changepassword",
          type: 'POST',
          data: $form.serialize(),
          beforeSend: function(){$(".body-overlay").show();},
              processData:false,
          success: function(result) { 
            console.log(result);
            $(".body-overlay").hide();
            $('.error-text').text('');
            $('input[type="password"]').removeClass('error-border');

            if(typeof result.error !='undefined' && result.error !=null){
              
              $.each( result.error, function( key, value ) {
                 $('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
                 $('#'+key).addClass('error-border');
                });
              esmsg.text('');
            
            }

            if(typeof result.msg !='undefined' && result.msg !=null){
              esmsg.addClass('alert alert-success text-center').html(result.msg);
              setInterval(function() { esmsg.removeClass('alert alert-success text-center').html(''); },10000);
              $('input[type="password"]').val('');
            }
          },
            error: function(data) 
            { 
              console.log(data);
              if(data.status=='500'){
              esmsg.text(data.statusText).css({'color':'red'});
              }else if(data.status=='422'){
              esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
              }
              $(".body-overlay").hide();
            }   

        });
      });
      /* edit password*/
    });
  </script> 
@stop