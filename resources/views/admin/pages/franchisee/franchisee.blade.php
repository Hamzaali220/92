@extends('admin.master')
@section('title', 'dashboard')
@section('style')
@stop
@section('content')
    <div class="content-wrapper">
   
	   @php $franchise_name = isset($result->franchise_name)?$result->franchise_name:''; @endphp
	    @php $franchise_id = isset($result->franchise_id)?$result->franchise_id:''; @endphp
		@php $tag = isset($result->franchise_id)?'Edit':'Add'; @endphp
	 
    <section class="content-header">
      <h1>
	  {{$tag}} Franchisee
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.Franchisees')}}">Franchisee</a></li>
        <li class="active">{{$tag}} Franchisee</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
        
              <li><a class="active" href="#settings" data-toggle="tab">Franchisee</a></li>
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
               {!! Form::open(array('method' => 'POST','url' => route('admin.saveFranchisee'),'class'=>'form-horizontal','role'=>'form')) !!}
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name <span class="mandatory">*</span></label>

                    <div class="col-sm-10">
						<input type="text" name="franchise_name" class="form-control" id="inputName" placeholder="Franchisee name" value="{{$franchise_name,old('area')}}">
						<input type="hidden" name="franchise_id" value="{{$franchise_id}}">
				   </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
					<a href="{{route('admin.Franchisees')}}" class="btn btn-danger">Close</a>
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