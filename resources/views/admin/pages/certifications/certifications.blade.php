@extends('admin.master')
@section('title', 'dashboard')
@section('style')
@stop
@section('content')
    <div class="content-wrapper">

    @php $certifications_name = isset($result->certifications_name)?$result->certifications_name:''; @endphp
    @php $certifications_description = isset($result->certifications_description)?$result->certifications_description:''; @endphp
    @php $certifications_id = isset($result->certifications_id)?$result->certifications_id:''; @endphp

    <section class="content-header">
      <h1>
	  {{$tag}} Certifications
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.certifications')}}">Certifications</a></li>
        <li class="active">{{$tag}} Certifications</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

              <li class="active"><a class="active" href="#settings" data-toggle="tab">Certifications</a></li>
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
               {!! Form::open(array('method' => 'POST','url' => route('admin.savecertifications'),'class'=>'form-horizontal','role'=>'form', 'id'=>'add_certificate')) !!}
                  <div class="form-group">
                    <label for="cert_name" class="col-sm-2 control-label">Name <span class="mandatory">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" name="certifications_name" class="form-control" id="cert_name" placeholder="Certifications name" value="{{$certifications_name,old('certifications_name')}}">
                   </div>
                  </div>
                  <div class="form-group">
                    <label for="cert_desc" class="col-sm-2 control-label">Description <span class="mandatory">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" name="certifications_description" class="form-control" id="cert_desc" placeholder="Certifications description" value="{{$certifications_description,old('certifications_description')}}">
                   </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="certifications_id" value="{{$certifications_id}}">
                       <a href="{{route('admin.certifications')}}" class="btn btn-danger">Close</a>
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
$("#add_certificate").submit(function(){
  let ele_cert_name = $("#cert_name");
  let ele_cert_desc = $("#cert_desc");
  let ele_errMsg = $("#err_msg");
  if(ele_cert_name.val() == ""){
    ele_errMsg.html(`<div class="alert alert-danger text-center">Please enter name of certificate</div>`);
    ele_cert_name.focus();
    return false;
  }
  else if(ele_cert_desc.val() == ""){
    ele_errMsg.html(`<div class="alert alert-danger text-center">Please enter description of certificate</div>`);
    ele_cert_desc.focus();
    return false;
  }else{
    ele_errMsg.html("");
  }

})
</script>
@stop
