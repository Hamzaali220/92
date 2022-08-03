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
        Employee
        <small> Employee list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.employee.employeelist')}}">Employee</a></li>
        <li class="active"> Employee list</li>
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
              	<div>
              		<table id="dataList" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th>Name</th>
		                  <th>Email</th>
        						  <th>Phone</th>
        						  <th>Created</th>
        						  <th>Status</th>
        						  <th>Action</th>
		                </tr>
		                </thead>
		                <tbody>
                      @foreach($employeelist as $employee)
                        <tr>
                          <td>{{ $employee->empname}}</td>
                          <td>{{ $employee->email}}</td>
                          <td>{{ $employee->mobile}}</td>
                          <td>{{ date('d-m-Y', strtotime($employee->created_at)) }}</td>
                          <td> 
                          @if(isset(session('user_access_data')->empchange) && session('user_access_data')->empchange == 1 OR session("userid") == 1)
                            @if($employee->status== 1)
                            <button class="btn btn-success" onclick="status_change_function('{{$employee->email}}',0)">Active</button>
                            @else
                              <button class="btn btn-danger" onclick="status_change_function('{{$employee->email}}',1)">Deactive</button>
                            @endif
                          @else
                            @if($employee->status== 1)
                              <button class="btn btn-success">Active</button>
                            @else
                              <button class="btn btn-danger">Deactive</button>
                            @endif
                          @endif
                            
                            </td>
                          <td><!-- <button class="btn btn-primary">View</button> -->
                          @if(isset(session('user_access_data')->empchange) && session('user_access_data')->empchange == 1 OR session("userid") == 1)
                            <a class="btn btn-danger" data-id="{{$employee->id}}" onclick="delete_employee(this)">Delete</a></td>
                          @else
                            No access
                          @endif
                        </tr>
                      @endforeach		                	
		                </tbody>
		              </table>
              	</div>
              	<!-- AddToAny BEGIN -->
				
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
        url:"{{ route('employee.changestatus')}}",
        type: 'get',
        dataType: 'json',
        data: {'email':id,'status':value},
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
<script type="text/javascript">
  function delete_employee(th){
    var id = $(th).data('id');
    var token ="{{ csrf_token() }}";
    
    if(confirm("Are sure you want to delete this employee?")){
      $.ajax({
        type  :'POST',
        url   :"{{ route('employee.delete_employee')}}",
        data  :{id:id,_token:token},
        success:function(data){
          //alert(data);
          location.reload();

        }
      })
    }
  }
</script>
@stop