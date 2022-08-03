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
        Conversation
        <small>Conversation list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Conversation</a></li>
        <li class="active">Conversation list</li>
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
            <div class="box-body table-responsive">
              <table id="dataList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Post</th>
                  <th>Sender</th>
                  <th>Receiver</th>
				  <th>Closing Date Activity</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
				@foreach($conversation as $con)
					<tr>
						<td>{{ $i }}</td>
						<td>{{ $con->posttitle }}</td>
						<td>{{ $con->sender }} <b> ({{ $con->sender_role }}) </b> </td>
						<td>{{ $con->receiver }} <b> ({{ $con->receiver_role }}) </b></td>
						<td>{{ date('d-m-Y', strtotime($con->updated_at)) }}</td>
						<td>
							<a href="{{ url('agentadmin/conversation/conversationdetails/'.$con->conversation_id) }}"  class="btn btn-info" title="View Details">view</a> 
						</td>
					</tr>
					<?php $i++; ?>
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
@section('scripts')
<script type="text/javascript" src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script  type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript">
	$(function () {
   // $("#example1").DataTable();
    $('#dataList').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true
    });
  });
  
  
</script>
@stop