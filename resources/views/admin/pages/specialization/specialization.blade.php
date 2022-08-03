@extends('admin.master')
@section('title', 'dashboard')
@section('style')
@stop
@section('content')
    <div class="content-wrapper">
   
	   @php $skill = isset($result[0]->skill)?$result[0]->skill:''; @endphp
	    @php $skill_id = isset($result[0]->skill_id)?$result[0]->skill_id:''; @endphp
		@php $tag = isset($result[0]->skill)?'Edit':'Add'; @endphp
	 
    <section class="content-header">
      <h1>
	  {{$tag}} Skills & Specialization
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.specializations')}}">Skills & Specialization</a></li>
        <li class="active">{{$tag}} Skills & Specialization</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
        
              <li class="active"><a class="active" href="#settings" data-toggle="tab">Skills & Specialization</a></li>
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
               {!! Form::open(array('method' => 'POST','url' => route('admin.saveSpecialization'),'class'=>'form-horizontal','role'=>'form')) !!}
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
						<input type="text" name="skill" class="form-control" id="inputName" placeholder="Skills/Specialization name" value="{{$skill,old('skill')}}">
						<input type="hidden" name="skill_id" value="{{$skill_id}}">
				   </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
					<a href="{{route('admin.specializations')}}" class="btn btn-danger">Close</a>
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