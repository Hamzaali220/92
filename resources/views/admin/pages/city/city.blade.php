@extends('admin.master')
@section('title', 'dashboard')
@section('style')
@stop
@section('content')
    <div class="content-wrapper">
    <?php
    $state_id = isset($result->state_id)?$result->state_id:"";
    $city_name = isset($result->city_name)?$result->city_name:'';
    $city_id = isset($result->city_id)?$result->city_id:'';
    $tag = isset($result->city_id)?'Edit':'Add';
    use App\Models\State;
		$s = new State;
    $state= $s->getStateByAny(array('is_deleted' => '0'));
    ?>
    <section class="content-header">
      <h1>
	  {{$tag}} City
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.cities')}}">City</a></li>
        <li class="active">{{$tag}} City</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

              <li class="active"><a class="active" href="#settings" data-toggle="tab">City</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">

              <div class="tab-pane" id="settings">
			  @if (isset($errors) && count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
                <li>{!! str_replace("id","",$error) !!}</li>
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
               {!! Form::open(array('method' => 'POST','url' => route('admin.saveCity'),'class'=>'form-horizontal','role'=>'form')) !!}

               <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">State <span class="mandatory">*</span></label>

                    <div class="col-sm-10">
			<select class="form-control cityemptyclass" id="state" name="state" placeholder="Select City">
                        	<option value="">Select State</option>
                                 @if(!empty($state))
                                    @foreach($state as $stated)
                                    <?php
                                      $selected = "";
                                      if($state_id !== ""):
                                        if($state_id == $stated->state_id):
                                          $selected = "selected";
                                        endif;
                                      endif;
                                      ?>
                                        <option {{$selected}} value="{{ $stated->state_id }}">{{ ucfirst($stated->state_name) }}</option>
                                    @endforeach
                                @endif
                        </select>
				   </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name <span class="mandatory">*</span></label>

                    <div class="col-sm-10">
						<input type="text" name="city_name" class="form-control" id="inputName" placeholder="City name" value="{{$city_name,old('city_name')}}">
						<input type="hidden" name="city_id" value="{{$city_id}}">
				   </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
					<a href="{{route('admin.cities')}}" class="btn btn-danger">Close</a>
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
