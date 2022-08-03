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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$types}}er Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.sellerbuyers')}}">{{$types}}er</a></li>
        <li class="active">{{$userdetails->name}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="@if($userdetails->photo != '') {{ url('/assets/img/profile/5Z5t-BtF_400x400.jpg') }} @else {{ url('/assets/img/profile/5Z5t-BtF_400x400.jpg') }} @endif" alt="User profile picture">

              <h3 class="profile-username text-center">{{$userdetails->name}}</h3>

              <p class="text-muted text-center">{!! $userdetails->description !!}</p>
              
               <a class="btn btn-info reset_button" href= {{url('/password/')}}/resetcodesendbyadmin/{{$userdetails->email}}> Send Reset Link </a> 
                 <div class="text-center">
                {{ session()->get('msg') }}
                </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#Profile" data-toggle="tab">Profile</a></li>
              <li><a href="#Personal" data-toggle="tab">{{$types}} Details</a></li>
              <li><a href="#Questions" data-toggle="tab">Questions</a></li>
              <!-- <li><a href="#Proposals" data-toggle="tab">Proposals</a></li> -->
              <li><a href="#Documents" data-toggle="tab">Documents</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="Profile">
                <table class="table">
                
                <tr>
                  <td>                      
                    <strong> Name  </strong>
                  </td>
                  <td>
                    <span class="text-muted">
                      {{ $userdetails->name }}
                    </span>
                  </td>
                </tr>
                
                <tr>
                  <td>
                    <strong> Address line 1  </strong>
                  </td>
                  <td>
                    <span class="text-muted">
                      {{ $userdetails->address }}
                    </span>
                  </td>
                </tr>
                
                <tr>
                    <td>
                      <strong> Address line 2  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->address2 }}
                      </span>
                    </td>
                </tr>
                <tr>
                    <td>
                      <strong> Phone No.  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->phone }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Home Phone No.  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->phone_home }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Work Phone No.  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->phone_work }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> State  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->state_name }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> City  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->city_name }}
                      </span>
                   </td>
                </tr>
                <tr>
                  <td>
                    <strong> Suburb / Neighborhood  </strong>
                  </td>
                  <td>
                    <span class="text-muted">
                      @if(!empty($userdetails->area))
                      @foreach($userdetails->area as $area)
                        <span skey="{{$area->area_id}}">{{$area->area_name}},</span>
                      @endforeach
                      @endif
                    </span>
                  </td>
                </tr>
                <tr>
                    <td>
                      <strong> Fax No  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->fax_no }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Zip Code  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->zip_code }}
                      </span>
                   </td>
                </tr>
               </table>

              </div>
              <div class=" tab-pane" id="Personal">
                <table class="table">
                
                <tr>
                  <td>                      
                    <strong> When U Want To {{$types}}  </strong>
                  </td>
                  <td>
                    <span class="text-muted">
                      {{  str_replace('_',' ',$userdetails->when_u_want_to_buy) }}
                    </span>
                  </td>
                </tr>
                <tr>
                    <td>
                      <strong> Price Range  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{  str_replace('_',' ',$userdetails->price_range) }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Property type  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{  str_replace('_',' ',$userdetails->property_type) }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Are you a firsttime home {{$types}}er ?  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->firsttime_home_buyer==1 ? 'yes' : 'no' }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Specific requirements  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->specific_requirements }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Do u have a home to {{$types}}  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                         {{ $userdetails->do_u_have_a_home_to_sell==1 ? 'yes' : 'no' }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> if so do you need help {{$types}}ing ?  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                         {{ $userdetails->if_so_do_you_need_help_selling==1 ? 'yes' : 'no' }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Are you interested in {{$types}}ing a foreclosed , short sale or junker  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                         {{ $userdetails->interested_buying==1 ? 'yes' : 'no' }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> do u want the bids emailed 1ce a day or as it arrives  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{  str_replace('_',' ',$userdetails->bids_emailed) }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Do you need financing?. If so amount  </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->do_you_need_financing }}
                      </span>
                   </td>
                </tr>
                <tr>
                    <td>
                      <strong> Need Cash back/Negotiate Commision </strong>
                    </td>
                    <td>
                      <span class="text-muted">
                        {{ $userdetails->need_Cash_back==1 ? 'yes' : 'no' }}
                      </span>
                   </td>
                </tr>
               </table>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="Questions">
                <div class="tab-v1">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#default-answers" data-toggle="tab">Admin asked question with answers</a></li>
                    <li><a href="#questions-ask" data-toggle="tab">{{ $userdetails->name }} uploaded questions</a></li>
                  </ul>
                  <div class="tab-content">
                    <!-- Default Questions Answers -->
                    <div class="profile-edit tab-pane fade in active" id="default-answers">
                      <div id="enters-default-answers" class="sky-form">
                        <header>  </i> Admin Questions with Answers</header>

                        
                      </div>
                      <div class="body-overlay_default body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
                    </div>
                    <!-- End Default Questions Answers -->
                    <!-- agents -->
                    <div class="profile-edit tab-pane fade " id="questions-ask">
                      <div id="enters-questions-to-ask" class="sky-form">
                        <header>  {{ $userdetails->name }} uploaded questions For Agents </header>
                        <br>
                        
                      </div>
                      <div class="body-overlay_questions body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
                    </div>
                    <!-- end agents ask question -->
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="Documents">
                <div class="row">              
                  <div id="append-uploadshares-ajax"></div>
                  <div id="loaduploadshare" class="col-md-12 center loder loaduploadshare"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
                  <div class="center col-md-12 btn-buy animated fadeInRight">
                    <a  id="loaduploadandshare" class="cursor hide"><i class="fa fa-spinner"> </i> load more </a>
                  </div>
                </div>
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
  <!-- docs open -->
  <div class="modal fade bs-example-modal-lg" id="open-docs-popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content not-top">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body src-ifram">
          
        </div>
      </div>
    </div>
  </div>
  
  <!-- documents -->
  <div class="modal fade" id="uploadsharedeleteconfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content not-top">
        <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>
          </div>
          <div class="modal-body">
            <br>
            <div class="upload-delete-msg"> </div>
            <p>Are you sure this file delete?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-u btn-u-primary" id="delete">Delete</button>
            <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="open-uploadshare-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content not-top">
        <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>
          </div>
          <div class="modal-body uploadshare-src-ifram">
            
          </div>
      </div>
    </div>
  </div>

@endsection
@section('scripts')
<script type="text/javascript">
  
  function showdocs(url,type) {
    $('#open-docs-popup').modal('show');
    if(type=='img'){
      var htmll ='<img   src="'+url+'" frameborder="0" scrolling="no" width="100%" height="500">';
    }else{
      var htmll ='<iframe  src="'+url+'" frameborder="0" scrolling="no" width="100%" height="500"></iframe>';
    }
    $('.src-ifram').html(htmll);
  }
  
  var proposale_data  = [];
  var shared_proposal_connected_user_list  = [];
  var uploadshare_data = [];
  var shared_document_connected_user_list  = [];

  $( document ).ready(function() { 
  
    /* upload and share */
    $('#loaduploadandshare').click(function(e){
      e.preventDefault();
      var limit = $(this).attr('title');
      loaduploadandshare(limit);
    });
    loaduploadandshare(0);  

    /* question and ans  */
    $.ajax({
      url: "{{url('/agentadmin/')}}/question/get",
      type: 'POST',
      data: {question_type:'{{ $user->agents_users_role_id }}',add_by:1,add_by_role:1,_token : '{{ csrf_token() }}',from_id: '{{ $user->id }}',from_role : '{{ $user->agents_users_role_id }}'},
      beforeSend: function(){$(".body-overlay_default").show();},
      success: function(result) { 
        $(".body-overlay_default").hide();
        $.each( result[0], function( key, val ) {
          var htm = ''+
                '<fieldset>'+
                  '<section>'+
                    '<label><b>Q.'+(key+1)+') '+val.question+'</b></label>'+
                    '<label class="textarea ">';
                      if(result[1][val.question_id] && result[1][val.question_id] !=''){
                        htm +='Ans. '+result[1][val.question_id];
                      }else{
                        htm +='Ans. No Answer';
                      }
              htm +='</label>'+
                  '</section>'+
                '</fieldset><hr>'+
              '';
          $('#enters-default-answers').append(htm);
        });
      }
    });
    /* question and ans  */
    $.ajax({
      url: "{{url('/agentadmin/')}}/question/get/only/user",
      type: 'POST',
      data: {_token : '{{ csrf_token() }}',add_by : '{{ $user->id }}',add_by_role : '{{ $user->agents_users_role_id }}'},
      beforeSend: function(){$(".body-overlay_questions").show();},
      success: function(result) { 
        $(".body-overlay_questions").hide();
        var az =1;
        $.each( result, function( key, val ) {
          if(val.question_type==4){
            key = az;
            az = 1+az;
            var utyp = 'agents';
          var apen = $('#enters-questions-to-ask');
          }
          
          var htm = '<fieldset class="askquestioncount_'+utyp+'">'+
                '<div class="panel-group acc-v1 " id="accordion-'+utyp+'-'+key+'">'+
                  '<div class="panel panel-default">'+
                    '<div class="panel-heading">'+
                      '<h4 class="panel-title">'+
                        '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-'+utyp+'-'+key+'" href="#collapse-'+utyp+'-'+key+'">'+
                          '<b>'+(key)+') <span class="q-s-'+val.question_id+'">'+val.question+'<span></b>'+
                          ' <span href="#" class="sitegreen pull-right"> <i class="fa fa-edit  marginediticon"> </i> <small> Edit </small></span>';
                          // htm +='<span class="clickimportance_'+val.question_id+'">';
                          // if(val.importance==0){
                          //   htm +='<span href="#" class="green pull-right" onclick="importance('+val.question_id+');"> <i class="fa fa-check-circle-o"> </i> <small>Importance</small> | </span>';
                          // }else{
                          //   htm +='<span href="#" class="red pull-right" onclick="importanceremove('+val.question_id+');"> <i class="fa fa-times-circle-o"> </i> <small>Importance</small> | </span>';
                          // }
                          // htm +='</span><span class="clicksurvey_'+val.question_id+'">';
                          // if(val.survey==0){
                          //   htm +='<span href="#" class="green pull-right" onclick="survey('+val.question_id+');"> <i class="fa fa-check-circle-o"> </i> <small>Survey</small> | </span>';
                          // }else{
                          //   htm +='<span href="#" class="red pull-right" onclick="surveyremove('+val.question_id+');"> <i class="fa fa-times-circle-o"> </i> <small>Survey</small> | </span>';
                          // } 
                          // htm +='</span>';
                        htm +='</a>'+
                      '</h4>'+
                    '</div>'+
                    '<div id="collapse-'+utyp+'-'+key+'" class="panel-collapse collapse">'+
                      '<div class="panel-body">'+
                        '<div class="row">'+
                          '{!! Form::open(array("url" => "#","class"=>"sky-form enters-questions-to-ask")) !!}'+
                          '<fieldset>'+
                            '<div class="hide question-ask-msg-'+val.question_id+'"></div>'+
                            '<section>'+
                              '<label class="textarea ">'+
                                '<textarea rows="2" class="field-border" name="questions_to_ask_'+key+'" id="question_default_'+key+'" placeholder="Enter Question">'+val.question+'</textarea>'+
                                '<b class="error-text" id="questions_to_ask_'+key+'_error" style="text-transform:none !important;"></b>'+
                              '</label>'+
                            '</section>'+
                            '<input type="hidden" name="question_id" value="'+val.question_id+'">'+
                            '<button type="submit" class="btn-u pull-right">Change</button>'+
                          '</fieldset>'+
                          '{!!Form::close()!!}'+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>'+
              '</fieldset>';
          
          apen.append(htm);
        });
      }
    });
    $('#enters-questions-to-ask').submit(function(e){
      e.preventDefault();
      var question = e.target[2].value;
      var question_id = e.originalEvent.srcElement[3].value;
      var fieldname = e.originalEvent.srcElement[2].name;
      var esmsg = $(".question-ask-msg-"+question_id);

      $.ajax({
        url: "{{url('/agentadmin/')}}/updatequestion",
        type: 'POST',
        data: {question_id:question_id,question:question,_token : '{{ csrf_token() }}',add_by : '{{ $user->id }}',add_by_role : '{{ $user->agents_users_role_id }}'},
        success: function(result) { 
          $('.error-text').text('');
          $('.field-border').removeClass('error-border');
          if(typeof result.error !='undefined' && result.error !=null){
            $.each( result.error, function( key, value ) {
              $('#'+fieldname+'_error').removeClass('success-text').addClass('error-text').text(value);
              $('#'+fieldname).addClass('error-border');
            });
            esmsg.text('').addClass('hide');
          }
          if(typeof result.msg !='undefined' && result.msg !=null){
            
            esmsg.text('').css({'color':'green'});
            esmsg.removeClass('hide').addClass('show alert alert-success text-center').text(result.msg);
            // setTimeout(location.reload(),5000);
            $('.q-s-'+question_id).text(question);
              setInterval(function() { esmsg.text('').addClass('hide').removeClass('show alert-success') },5000);
          }
        },
          error: function(data) 
          { 
            if(data.status=='500'){
            esmsg.text(data.statusText).css({'color':'red'}).removeClass('hide').addClass('show');
            }else if(data.status=='422'){
            esmsg.text(data.responseJSON.image[0]).css({'color':'red'}).removeClass('hide').addClass('show');
            }
            setInterval(function() { esmsg.text('').addClass('hide').removeClass('show') },5000);
          }
      });
    });

  });

  
  /*load uploadandshare */
  function loaduploadandshare(limit) {

    $.ajax({
      url: "{{url('/agentadmin/')}}/uploadshare/get/ten/"+limit+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",
      type: 'get',
      beforeSend: function(){$(".loaduploadshare").show();},
          processData:false,
          contentType: false,
      success: function(result) { 
        $(".loaduploadshare").hide();
        // console.log(result);
        if(result.count !== 0){
          $.each( result.result, function( key, value ) {
            uploadshare_data[value.upload_share_id] = value;
            var extension = value.attachments.substr( (value.attachments.lastIndexOf('.') +1) );
              extension = extension.toLowerCase();
            var docs = '';
              if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){
                docs ='<img     class="documen document_'+value.upload_share_id+'" src="'+value.attachments+'" frameborder="0" scrolling="no"  width="225" height="142">';
              }else{
                docs ='<iframe  class="documen document_'+value.upload_share_id+'" src="https://docs.google.com/viewer?url='+value.attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';
              }
            var htmll = '<div class="col-md-4">'+
                    '<div class="thumbnails thumbnail-style thumbnail-kenburn">'+
                      '<div class="cbp-caption thumbnail-img">'+
                        '<div class="overflow-hidden cbp-caption-defaultWrap">'+docs+'</div>'+
                        '<div class="removehover cbp-caption-activeWrap">'+
                          '<div class="cbp-l-caption-alignCenter">'+
                            '<div class="cbp-l-caption-body">'+
                              '<ul class="link-captions no-bottom-space">'+
                                '<li><a class="cursor" title="View" onclick="openuploadshare('+value.upload_share_id+')"><i class="rounded-x fa fa-eye"></i></a>'+
                                '<li><a class="cursor" title="Remove" onclick="removeuploadshare('+value.upload_share_id+')"><i class="rounded-x fa fa-trash-o"></i></a>'+
                              '</ul>'+
                            '</div>'+
                          '</div>'+   
                        '</div>'+
                      '</div>'+
                    '</div>'+
                  '</div>';
            $('#append-uploadshares-ajax').append(htmll);
          });
          if(result.next!=0){
            $('#loaduploadandshare').removeClass('hide').attr('title',result.next);
          }else{
            $('#loaduploadandshare').addClass('hide');
          }
        } else {
          var htmll = '<div class="col-md-12">'+
                   '<i>No documents uploaded/available for the Profile.</i>' +
                  '</div>';
            $('#append-uploadshares-ajax').append(htmll);
        }
        
      },
        error: function(data) 
        { $(".loaduploadshare").hide();
          if(data.status=='500'){
          $('.loaduploadshare').text(data.statusText).css({'color':'red'});
          }else if(data.status=='422'){
          $('.loaduploadshare').text(data.responseJSON.image[0]).css({'color':'red'});
          }
        }
    });
  }
  function openuploadshare(el) {
    var src = uploadshare_data[el].attachments;
    var extension = uploadshare_data[el].attachments.substr( (uploadshare_data[el].attachments.lastIndexOf('.') +1) );
      extension = extension.toLowerCase();
    var docs='';
    if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){
      docs ='<img     class="documen document_uploadfiles_'+uploadshare_data[el].upload_share_id+'" src="'+uploadshare_data[el].attachments+'" frameborder="0" scrolling="no" width="100%" height="300">';
    }else{
      docs ='<iframe  class="documen document_uploadfiles_'+uploadshare_data[el].upload_share_id+'" src="https://docs.google.com/viewer?url='+uploadshare_data[el].attachments+'&embedded=true" frameborder="0" scrolling="no" width="100%" height="300"></iframe>';
    }
    $('.uploadshare-src-ifram').html(docs);
    $('#open-uploadshare-popup').modal('show');
  }
  function removeuploadshare(el) {
    
    $('#uploadsharedeleteconfirm')
          .modal({ backdrop: 'static', keyboard: false })
          .one('click', '#delete', function (e) {
        
            $.ajax({
        url: "{{url('/agentadmin/')}}/uploadshare/delete/"+el,
        type: 'get',
        beforeSend: function(){$(".body-overlay").show();},
            processData:false,
        success: function(result) { 
          $(".body-overlay").hide();
          if(result.status=='error'){
            $('.upload-delete-msg').addClass('alert alert-danger text-center').text(result.msg);
          }else{
            $('.upload-delete-msg').addClass('alert alert-success text-center').text(result.msg);
          }
          setTimeout(location.reload(),7000);
        },error: function(data) { $(".body-overlay").hide();  }
          
      });
        
        });

  }

</script> 
@stop