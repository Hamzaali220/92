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
        Bad Content
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.getpost')}}">Post</a></li>
        <li class="active">Bad Content</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content profile">

      <div class="row">
        <div class="col-md-12">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <div id="err_msg"></div>
              @if(isset($success))
              <p class="alert alert-success">Updated Successfully</p>
              @endif
              {!! Form::open(array('method' => 'POST','url'=>route('admin.postupdate'),'class'=>'form-horizontal','role'=>'form','id'=>'bad_content_verify')) !!}
              <div class="form-group col-md-12">
                <label>Content to Validate Post <small style="color: red">(seperate words with ',' [COMMA] )</small></label>
                <textarea class="form-control" rows="5" id="words" name="words">{{ $words->words}}</textarea>
              </div>
                <div class="form-group col-md-12">
                  <button type="submit" class="btn-u btn-u-primary">Update</button>
                </div>
              {{ Form::close() }}

              <h3 class="profile-username text-center"></h3>

              <p class="text-muted text-center"></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

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
  var agentsdata       = [];
  var valid = 0;
  $( document ).ready(function() {  
  });

  $("#bad_content_verify").submit(function(){
    let ele_words = $("#words");
    let ele_err_msg = $("#err_msg");
    
    if($.trim(ele_words.val()) == ""){
      ele_err_msg.html(`<div class="alert alert-info">Empty value not allowed need some words to filter</div>`);
      ele_words.focus();
      return false;
      let confirm_msg = confirm("Are you sure to remove all filter words");
      if(confirm_msg == false){
        return false;
      }else{
        ele_err_msg.html("");
      }
    }
  });
  
  
</script> 
@stop