@extends('admin.master')
@section('title', 'dashboard')
@section('style')
@stop
@section('content')
    <div class="content-wrapper">

	   @php $state_name = isset($result->state_name)?$result->state_name:''; @endphp
	    @php $state_id = isset($result->state_id)?$result->state_id:''; @endphp
		@php $tag = isset($result->state_id)?'Edit':'Add'; @endphp
		 @php $state_code = isset($result->state_code)?$result->state_code:''; @endphp

    <section class="content-header">
      <h1>
	    {{$tag}} State
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.states')}}">State</a></li>
        <li class="active">{{$tag}} State</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

              <li class="active"><a class="active" href="#settings" data-toggle="tab">State</a></li>
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
               {!! Form::open(array('method' => 'POST','url' => route('admin.saveState'),'class'=>'form-horizontal','role'=>'form')) !!}
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name
                        <span class="mandatory">*</span>
                    </label>

                    <div class="col-sm-10">
						<input type="text" name="state_name" class="form-control" id="inputName" placeholder="State name" value="{{$state_name,old('state_name')}}">
						<input type="hidden" name="state_id" value="{{$state_id}}">
				   </div>
                  </div>

				  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Code
                        <span class="mandatory">*</span>
                    </label>

                    <div class="col-sm-10">
						<input type="text" name="state_code" class="form-control" id="inputName" placeholder="State code" value="{{$state_code,old('state_code')}}">
				   </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
					<a href="{{route('admin.states')}}" class="btn btn-danger">Close</a>
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
