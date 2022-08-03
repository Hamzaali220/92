@extends('admin.master')
@section('title', 'dashboard')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/select2/select2.min.css') }}">
<style>
.select2-container{
	width:100% !important;
}
</style>
@stop
@section('content')
    <div class="content-wrapper">
   
	 
    <section class="content-header">
      <h1>
	  Seller/Buyer
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Seller/Buyer</a></li>
        <li class="active">Seller/Buyer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
      
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
			<li class="active"><a href="#settings" data-toggle="tab">Profile</a></li>
			<li><a href="#settings2" data-toggle="tab">Additional Info</a></li>
              <li class=""><a href="#activity" data-toggle="tab">Activity</a></li>
              <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
              
            </ul>
            <div class="tab-content">
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
              <div class=" tab-pane" id="activity">
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
               
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane active" id="settings">
			   {!! Form::open(array('url' => route('admin.saveAgent'),'class'=>'form-horizontal','role'=>'form')) !!}
              
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Full Name</label>

                    <div class="col-sm-10">
                      <input type="text"  name="name" class="form-control" id="inputName" placeholder="Full Name" value="{{(isset($result->name)?$result->name:''),old('name')}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" value="{{(isset($result->email)?$result->email:''),old('email')}}">
                   <input type="hidden" name="id" value="{{isset($result->id)?$result->id:''}}"> 
				   </div>
                  </div>
				  
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">address</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" name="address" id="inputExperience" placeholder="Address">{{(isset($result->address)?$result->address:''),old('address')}}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">address-2</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" name="address2" placeholder="Address-2">{{(isset($result->address2)?$result->address2:''),old('address2')}}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Phone</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="phone" id="inputSkills" placeholder="Phone" value="{{(isset($result->phone)?$result->phone:''),old('phone')}}">
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Phone(Home)</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="phone_home" id="inputSkills" placeholder="Phone(Home)" value="{{(isset($result->phone_home)?$result->phone_home:''),old('phone_home')}}">
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Phone(Work Place)</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="phone_work" id="inputSkills" placeholder="Phone(Work Place)"  value="{{(isset($result->phone_work)?$result->phone_work:''),old('phone_work')}}">
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Fax</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="fax_no" id="inputSkills" placeholder="Fax" value="{{(isset($result->fax_no)?$result->fax_no:''),old('fax_no')}}">
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">City</label>
                    <div class="col-sm-10">
					<select class="form-control" name="city" >
					<option value="">Please select city</option>
					@php $city_id =isset($result->city_id)?$result->city_id:''; @endphp
					@if(count($city)>0)
						@foreach($city as $key=>$value)
						<option value="{{$value->city_id}}" @if ($city_id == $value->city_id) selected="true" @endif @if (old('city') == $value->city_id) selected="true" @endif >{{ucwords(strtolower($value->city_name))}}</option>
						@endforeach
					@endif	
					</select>
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">State</label>
                    <div class="col-sm-10">
					<select class="form-control"  name="state">
					<option value="">Please Select State</option>
					@php $state_id =isset($result->state_id)?$result->state_id:''; @endphp
					@if(count($states)>0)
						@foreach($states as $key=>$value)
						<option value="{{$value->state_id}}"  @if ($state_id == $value->state_id) selected="true" @endif @if (old('state') == $value->state_id) selected="true" @endif >{{ucwords(strtolower($value->state_name))}}</option>
						@endforeach
					@endif	
					</select>
                      
                    </div>
                  </div>
                   <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Zip Code</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="zip_code" id="inputSkills" placeholder="Zip Code" value="{{(isset($result->zip_code)?$result->zip_code:''),old('zip_code')}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <a href="{{route('admin.agents')}}" class="btn btn-danger">Close</a>
                      <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </div>
                {{ Form::close() }}
              </div>
			  <div class="tab-pane" id="settings2">
              {!! Form::open(array('url' => route('admin.saveAgent'),'class'=>'form-horizontal','role'=>'form')) !!}
			  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">company</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" placeholder="company" name="company">
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">website</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" placeholder="website" name="website">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Area</label>
                    <div class="col-sm-10">
					<select class="form-control" name="area" id="areaId" multiple>
					<option value="">Please select area</option>
					@if(count($area)>0)
						@foreach($area as $key=>$value)
						<option value="{{$value->area_id}}" @if (old('area') == $value->area_id) selected="true" @endif >{{ucwords(strtolower($value->area_name))}}</option>
						@endforeach
					@endif	
					</select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>
                    <div class="col-sm-10">
					<select class="form-control" name="skill" id="skillsId" multiple>
					<option value="">Please select skills</option>
					@if(count($skills)>0)
						@foreach($skills as $key=>$value)
						<option value="{{$value->skill_id}}" @if (old('skill') == $value->skill_id) selected="true" @endif >{{ucwords(strtolower($value->skill))}}</option>
						@endforeach
					@endif	
					</select>
                    </div>
               </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Profile</label>
                    <div class="col-sm-10">
                      <input type="file" id="exampleInputFile" name="">
					 <span class="help-block" style="color:#d73925;">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                    </div>
                  </div>
                  
                 
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
					<a href="{{route('admin.agents')}}" class="btn btn-danger">Close</a>
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
<script type="text/javascript" src="{{ URL::asset('admin/plugins/select2/select2.full.min.js') }}"></script>
<script type="text/javascript">

$(document).ready(function() {
    $('#skillsId').select2();
	 $('#areaId').select2();
});
</script>
@stop