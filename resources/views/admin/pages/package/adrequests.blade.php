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
        Ad Requests
        <small>Ads List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.package')}}">Package</a></li>
        <li class="active">Ad Requests</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         

          <div class="box">
            
            
          
            <div class="box-body table-responsive">
             @if(session('c_status') && session('c_status') == 'success')
            <div class="alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> {{ session('c_message') }}
            </div>
            @endif

            @if(session('c_status') && session('c_status') == 'failed')
            <div class="alert alert-danger alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Failed!</strong> {{ session('c_message') }}
            </div>
            @endif

              <table id="DataList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Package Type</th>
				          <th>Title</th>
                  <th>Ad Link</th>
                  <th>Ad Banner</th>
                  <th>Clicks</th>
                  <th>Payment Receipt</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($adrequests as $i => $req)
        					<tr>
                    <td>{!! $i+1 !!}</td>
        						<td>{{ $req->title }}</td>
                    <td>{{ $req->ad_title }}</td>
        						<td><a href="{{ $req->ad_link }}" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> View Link</a></td>
                    <td><a href="{{ asset('storage/'.$req->ad_banner) }}" target="_blank"><i class="fa fa-picture-o" aria-hidden="true"></i> View Banner</a></td>
                    <td>{{ $req->clicks }}</td>
                    <td><a href='{{ $req->receipt_url }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> View Receipt</a></td>
        						<td>
                      @if($req->status == 0 || $req->status == 2)
                        <a href="{{ url('agentadmin/adaction/'.$req->id.'/1') }}" class="btn btn-success">Enable</a>
                        <!-- <a href="{{ url('agentadmin/adaction/'.$req->id.'/2') }}" class="btn btn-danger"></a> -->
                      @else 
                        <a href="{{ url('agentadmin/adaction/'.$req->id.'/2') }}" class="btn btn-danger">Disable</a>
                      @endif
                    </td>
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
