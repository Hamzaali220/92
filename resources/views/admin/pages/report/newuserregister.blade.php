@extends('admin.master')
@section('title', 'dashboard')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<style>
.modal-content{
	border-radius:10px !important;
}
@media only screen and (max-width: 600px) {
  #buyerSellerFilter {
    left: 50%;
    transform: translateX(-50%);
    top: 0%;
  }
}
</style>
@stop
@section('content')
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Recently Registered users
        <small> users list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Users</a></li>
        <li class="active"> Users list</li>
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
            	<div id="buyerSellerFilter"></div>
              	<div class="table-responsive">
              		<table id="dataList" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th>No</th>
		                  <th>Name</th>
		                  <th>Email</th>
		                  <th>Address</th>
						  <th>Phone</th>
						  <th>Created</th>
						  <th>Role</th>
						  <th>Status</th>
						  <th>Action</th>
		                </tr>
		                </thead>
		                <tbody>
		                </tbody>
		                <tfoot>
			                <tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
			                </tr>
		                </tfoot>
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
    $('#example22').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
  
  var table1 = $('#dataList').DataTable({ 	
		"processing": true, 	
		"serverSide": true,	
		"pageLength": 10,		
		"lengthMenu": [ [10, 25, 50,100], [10, 25, 50,100] ],
		"ordering": true, 
		"language": {	
		"processing": "<img width='50' src='{{ asset('/assets/ajax-loading-large.gif')}}' >"	
		},		
		"ajax": {	
			"url": "{{ url('/agentadmin/newSellerbuyerList') }}",
			"type": 'post',
			"headers": {
				       'X-CSRF-TOKEN': '{{ csrf_token() }}'
				    },
		},
		"fnDrawCallback": function(oSettings) {
			if (oSettings._iDisplayLength >= oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			}
		},
		"bStateSave": true,
		"fnStateSave": function (oSettings, oData) {
			localStorage.setItem('offersDataTables', JSON.stringify(oData));
		},
		"fnStateLoad": function (oSettings) {
			return JSON.parse(localStorage.getItem('offersDataTables'));
		}		
	});

  $('#buyerSellerFilter').each(function() {
	  var title = $(this).text();
	  var all = 0;
	  $(this).html(
	  	'Seller/Buyer <select onchange="myfun(this.value);"> <option value="1">All</option> <option value="2">Seller</option> <option value="3">Buyer</option> </select>'
	  	);
	});

  function myfun(val) {
  	var table = $('#dataList').DataTable();
  	if(val == 1) {
    	table.search('').draw();
    }
    if(val == 2) {
    	table.search('seller').draw();
    }
    if(val == 3) {
    	table.search('buyer').draw();
    }
  }

	function confirm_function(id,messages) {
		var myCheckboxes=[];
	    BootstrapDialog.show({
			title: '<p style="color:white;" class="text-center">Delete Confirmation </p>',
			message: messages,
			size: BootstrapDialog.SIZE_SMALL,
			buttons: [{
						label: 'Ok',
						cssClass: 'btn-primary',
						action: function(dialogItself){
							dialogItself.close();
							$.ajax({
								url: "{{ url('/agentadmin/deleteSellerbuyer') }}",
								type: 'post',
								data: { id: id,tag:'Delete',_token :"{{csrf_token()}}" },
								success:function(data){
								var table = $('#dataList').DataTable();
									table.ajax.reload();
									}
							});							
						}
					}, 
					{
						label: 'Close',	cssClass: 'btn-primary',
						action: function(dialogItself){
						dialogItself.close();
						return false;
					}
				}]
			});
			//return false;
	}


	function status_change_function(id,value,messages) {
		var myCheckboxes=[];
	    BootstrapDialog.show({
			title: '<p style="color:white;" class="text-center">Delete Confirmation </p>',
			message: messages,
			size: BootstrapDialog.SIZE_SMALL,
			buttons: [ {
						label: 'Ok',
						cssClass: 'btn-primary',
						action: function(dialogItself){
						dialogItself.close();
							$.ajax({
								url: "{{ url('/agentadmin/deleteSellerbuyer') }}",
								type: 'post',
								data: { id: id, value : value, tag:'status',_token :"{{csrf_token()}}" },
								success:function(data){
								var table = $('#dataList').DataTable();
									table.ajax.reload();
									}
								});							
						}
					}, {
						label: 'Close',						cssClass: 'btn-danger',
						action: function(dialogItself){
						dialogItself.close();
						return false;
					}
				}]
			});
			//return false;
	}	
</script>
@stop