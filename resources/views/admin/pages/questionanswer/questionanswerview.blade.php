@extends('admin.master')
@section('title', 'dashboard')
@section('style')
<link href="cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<style>
.modal-content{
  border-radius:10px !important;
}
.user-block .username{
  font-size: 14px !important;
  font-weight: 300 !important;
}
.user-block .description{
  font-size: 11px !important;
}
</style>
@stop
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Question With Answer
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.getQuestionAnswers')}}">Questions</a></li>
        <li class="active">Answer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="sky-form">
                <header> <i class="fa fa-question" aria-hidden="true"> </i> Question and user replied Answer </header>
                  <fieldset>
                    <section>
                      <label><h4>Q.1) {{$question->question}}</h4></label>
                      <label class="textarea "> 
                        @if(count($answers) !=0)
                        @foreach($answers as $answerss) 

                          <div class="post">
                            <div class="user-block">
                              <img class="img-circle img-bordered-sm" src="@if($answerss->photo != '') {{ url('/assets/img/profile/'.$answerss->photo) }} @else {{ url('/assets/img/profile/5Z5t-BtF_400x400.jpg') }} @endif" alt="user image">
                                <span class="username">
                                  <a href="#">{{$answerss->name}}<small>({{$answerss->role_name}})</small></a>
                                </span>
                                <span class="description">Replied - {{date('H:i a M d Y',strtotime($answerss->created_at))}}</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                              <b>Ans.</b> {!! $answerss->answers !!}
                            </p>
                          </div>
                        @endforeach
                        @else
                        <p>
                          <b>Ans.</b> No any user reply.
                        </p>
                        @endif
                      </label>
                    </section>
                  </fieldset>
                <!-- Post -->          
                <!-- /.post -->
              </div>
            </div>
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

</script> 
@stop