@extends('admin.master')
@section('title', 'dashboard')
@section('style')
@stop
@section('content')
    <div class="content-wrapper">
   
	   @php $area_name = isset($result->area_name)?$result->area_name:''; @endphp
	    @php $area_id = isset($result->area_id)?$result->area_id:''; @endphp
		@php $tag = isset($result->area_id)?'Edit':'Add'; @endphp
	 
    <section class="content-header">
      <h1>
	  {{$tag}} Area
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.areas')}}">Area</a></li>
        <li class="active">{{$tag}} Area</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
        
              <li><a class="active" href="#settings" data-toggle="tab">Area</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
               
              <div class="tab-pane" id="settings">
              <div id="err_msg"></div>
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
          {!! Form::open(array('method' => 'POST','url' => route('admin.saveArea'),'class'=>'form-horizontal','role'=>'form','id'=> 'add_area')) !!}
            <div class="form-group">
              <label for="area_name" class="col-sm-2 control-label">Name <span class="mandatory">*</span></label>
              <div class="col-sm-10">
                <input type="text" name="area" class="form-control" id="area_name" placeholder="Area name" value="{{$area_name,old('area')}}">
                <input type="hidden" name="area_id" value="{{$area_id}}">
              </div>
            </div>
                  
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <a href="{{route('admin.areas')}}" class="btn btn-danger">Close</a>
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
<script>
$("#add_area").submit(function(){
  $('.alert.alert-success').fadeOut('fast');
  let ele_area_name = $("#area_name");

  let ele_errMsg = $("#err_msg");
  if(ele_area_name.val() == ""){
    ele_errMsg.html(`<div class="alert alert-danger text-center">Please enter name of area</div>`);
    ele_area_name.focus();
    return false;
  }
  else if(/^[a-z][a-z\s]*$/i.test(ele_area_name.val()) == false){
    ele_errMsg.html(`<div class="alert alert-danger text-center">Please enter valid name of area</div>`);
    ele_area_name.focus();
    return false;
  }
  else{
    ele_errMsg.html("");
  }

})
setTimeout(function() {
    $('.alert.alert-success').fadeOut('fast');
}, 3000);
</script>
@stop