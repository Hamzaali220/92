@extends('admin.master')
@section('title', 'dashboard')
@section('style')
@stop
@section('content')
    <div class="content-wrapper">
   
    @php $question = isset($result->question)?$result->question:''; @endphp
    @php $securty_question_id = isset($result->securty_question_id)?$result->securty_question_id:''; @endphp
	 
    <section class="content-header">
      <h1>
	  {{$tag}} Security Question
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.getsecurtyquestion')}}">Security Question</a></li>
        <li class="active">{{$tag}} Security Question</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
        
              <li class="active"><a class="active" href="#settings" data-toggle="tab">Security Question</a></li>
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
               {!! Form::open(array('method' => 'POST','url' => route('admin.savesecurtyquestion'),'class'=>'form-horizontal','role'=>'form')) !!}
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Question <span class="mandatory">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" name="question" class="form-control" id="inputName" placeholder="Question" value="{{$question,old('question')}}">
                   </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="securty_question_id" value="{{$securty_question_id}}">
                       <a href="{{route('admin.getsecurtyquestion')}}" class="btn btn-danger">Close</a>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </div>
              {{ Form::close() }}
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
@stop