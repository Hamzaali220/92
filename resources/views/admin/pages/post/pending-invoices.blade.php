@extends('admin.master')
@section('title', 'dashboard')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<style>
.modal-content{
	border-radius:10px !important;
}

.pagination{
  float: right;
}

</style>
@stop
@section('content')
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post
        <small>Pending Invoices</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.getpost')}}">Post</a></li>
        <li class="active">Pending Invoices</li>
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
                  <th>Post</th>
                  <th>Seller's Name</th>
				          <th>Address</th>
                  <th>Sale Date</th>
                  <th>Sale Price</th>
                  <th>Payment Status</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($invoices as $i => $req)
        					<tr>
                    <td>{{ (($invoices->currentPage() - 1 ) * $invoices->perPage() ) + $loop->iteration }}</td>
        						<td>{{ $req->posttitle }}</td>
                    <td>{{ $req->sellers_name }}</td>
        						<td>{{ $req->address }}</td>
                    <td>{{ date('d-m-Y', strtotime($req->sale_date)) }}</td>
                    <td>{{ $req->sale_price }}</td>
                    
        						<td>
                      @if($req->payment_status == 1 )
                        Paid, <a href='{{ $req->receipt_url }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> View Receipt</a>
                      @else 
                        Unpaid
                      @endif
                    </td>
                  </tr>
                	@endforeach
                </tbody>                
              </table>
              <div class="col-md-12 pull-right">
                {{ $invoices->links() }}    
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
