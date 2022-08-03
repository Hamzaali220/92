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
        Package
        <small>Package list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.package')}}">Package</a></li>
        <li class="active">Package list</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         

          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              @if(isset($success))
              <p class="alert alert-success">{{ $success }}</p>
              @endif
              <table id="DataList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Package Type</th>
				          <th>Title</th>
                  <th>Price (in $)</th>
                  <th>Details</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($package as $pack)
        					<tr>
        						<td>{{ $pack->package_id }}</td>
        						<td>{{ ucwords($pack->package_type) }}</td>
        						<td>{{ $pack->title }}</td>
                    <td><?php echo $pack->price ?></td>
        						<td><?php echo $pack->details; ?></td>
        						<td><a href="{{ url('agentadmin/package/'.$pack->package_id) }}" class="btn btn-success">Edit</a></td>
        					</tr>
                	@endforeach
                </tbody>                
              </table>
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
