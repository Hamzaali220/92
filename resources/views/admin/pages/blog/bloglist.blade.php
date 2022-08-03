@extends('admin.master')
@section('title', 'dashboard')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<style>
.modal-content{
	border-radius:10px !important;
}
</style>
@stop
@section('content')
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Blog
        <small> Blog list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.blog.bloglist')}}">Blog</a></li>
        <li class="active"> Blog list</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         

          <div class="box">
            <div class="box-header text-right">
				
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @if(isset($success))
                @if($success=='ok')
                <p class="alert alert-success">Data Updated Successfully</p>
                @endif
                @if($success=='no')
                  <p class="alert alert-success">No Changes have done</p>
                @endif
              @endif
              	<div class="table-responsive">
              		<table id="dataList" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th>Created Date</th>
		                  <th>Title</th>
        						  <th>Description</th>
        						  <th>Status</th>
        						  <th>Action</th>
		                </tr>
		                </thead>
		                <tbody>
                      @foreach($bloglist as $blog)
                        <tr>
                          <td>{{ date('d-m-Y', strtotime($blog->created_date)) }}</td>
                          <td>{{ $blog->title}}</td>
                          <td><?php echo $blog->description ?></td>
                          
                          <td> 
                            @if($blog->status==0)
                            <button class="btn btn-success" onclick="status_change_function('{{$blog->id}}',1)">Active</button>
                            @else
                              <button class="btn btn-danger" onclick="status_change_function('{{$blog->id}}',0)">Deactive</button>
                            @endif
                            
                            </td>
                          <td>
                              <a href="{{ url('agentadmin/blog/editblog/'.$blog->id) }}"><button class="btn btn-warning">Edit</button></a>
                          </td>
                        </tr>
                      @endforeach		                	
		                </tbody>
		              </table>
              	</div>
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
<script type="text/javascript" src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script  type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript">
  $(function () {
   // $("#example1").DataTable();
    var table = $('#dataList').DataTable({
      "paging": true,
      "responsive":true,
      "autoWidth": false,
      "ordering": false, 
    });
  });
  
  function status_change_function(id,value)
  {
    var conf = confirm("Are sure to change status");
    if(conf){
      $.ajax({
        url:"{{ route('blog.changestatus')}}",
        type: 'get',
        dataType: 'json',
        data: {'id':id,'status':value},
        success:function(data){
          if(data.success){
            location.reload();
            // $('#dataList').DataTable().ajax.reload();
          }
        }
      })
      
    }
  }
</script>
@stop