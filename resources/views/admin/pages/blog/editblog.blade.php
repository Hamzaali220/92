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
        Update Blog
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.blog.bloglist')}}">Blog</a></li>
        <li class="active">Update Blog</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content profile">

      <div class="row">
        <div class="col-md-12">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              @if(isset($success))
              <p class="alert alert-success">{{ $success }}</p>
              @endif
              {!! Form::open(array('method' => 'POST','url' => route('admin.updateblog'),'class'=>'form-horizontal','role'=>'form')) !!}

                <div class="col-md-12">
                  <h5><strong>Blog Details</strong></h5>
                  <div class="col-md-12">
                      <label>Title</label>
                      <input type="hidden" name="id" value="{{ $blog->id }}">
                      <input type="text" name="title" class="form-control text-uppercase" placeholder="Blog Title" required value="{{ $blog->title }}">
                  </div>
                  <div class="col-md-12">
                      <label>Select Category</label>
                      <select name="cat_id" class="form-control" required="">
                        <option value="">--------------------</option>
                        @foreach($category as $cat)
                          <option value="{{ $cat->id }}" <?php echo ($cat->id===$blog->cat_id)? 'selected':'' ?>>{{ $cat->cat_name }}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="col-md-12">
                      <label>Description</label>
                      <textarea id="summernote" class="form-control" name="description" required>{{ $blog->description }}</textarea>
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
  $( document ).ready(function() {
    
    
    
  });

  
  
</script> 
@stop