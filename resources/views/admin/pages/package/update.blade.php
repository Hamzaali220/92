@extends('admin.master')
@section('title', 'dashboard')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/summernote/css/summernote.css') }}">
<style>
.note-btn-group .btn{
  color:#000 !important;
}
.btn-group {
    display: inline-table;
}
</style>
@stop
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Package
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.package')}}">Package</a></li>
        <li class="active">Update Package</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content profile">

      <div class="row">
        <div class="col-md-12">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

            {!! Form::open(array('method' => 'POST','url' => route('admin.updatepackage'),'class'=>'form-horizontal','role'=>'form','id'=>'update_package')) !!}

                <div class="col-md-12">

                  <h5><strong>Package Details</strong></h5>

                  <div id="err_msg"></div>

                  <div class="col-md-12">
                      <label>Title</label>
                      <input type="hidden" name="package_id" value="{{ $package->package_id }}">
                      <input type="text" name="title" id="title" class="form-control text-uppercase" placeholder="Blog Title" value="{{ $package->title }}">
                  </div>
                  <div class="col-md-6">
                      <label>Select Category</label>
                      <select name="cat_id" class="form-control">
                        <option value="{{ $package->package_type }}">{{ $package->package_type }}</option>
                      </select>
                  </div>
                  <div class="col-md-6">
                      <label>Price</label>
                      <input type="text" name="price" id="price" class="form-control text-uppercase" placeholder="250" value="{{ $package->price }}">
                  </div>
                  <div class="col-md-12">
                      <label>Description</label>
                      <textarea id="summernote" class="form-control" name="details" >{{ $package->details }}</textarea>
                  </div>
                </div>
                <div class="col-md-12 text-center">
                  <button class="btn-u btn-u-success">Submit</button>
                </div>
              {{ Form::close() }}
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
<script src="{{ URL::asset('assets/plugins/summernote/js/summernote.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
  var agentsdata       = [];
  var valid = 0;
  $('#summernote').summernote(); 
  
  $("#update_package").submit(function(){
    let ele_title = $("#title");
    let ele_price = $("#price");
    let ele_description = $("#summernote");
    let ele_errMsg = $("#err_msg");
    if(ele_title.val() == ""){
      ele_errMsg.html(`<div class="alert alert-danger text-center">Please enter title</div>`);
      ele_title.focus();
      return false;
    }
    else if(ele_price.val() == ""){
      ele_errMsg.html(`<div class="alert alert-danger text-center">Please enter price value</div>`);
      ele_price.focus();
      return false;
    }else if(/^\d+$/.test(ele_price.val()) == false){
      ele_price.val("0");
      ele_errMsg.html(`<div class="alert alert-danger text-center">Please enter price value in numbers</div>`);
      ele_price.focus();
      return false;
    }else if(ele_description.val() == ""){
      ele_errMsg.html(`<div class="alert alert-danger text-center">Please enter description</div>`);
      ele_description.focus();
      return false;
    }
    else{
      ele_errMsg.html("");
    }

  })
</script> 
@stop