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
  	position: unset;
  	display: inline-block;
  }
  #activeInactiveFilter{
  	position: unset;
  	display: inline-block;
  }
}
</style>
@stop
@section('content')
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post
        <small>Post list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.getpost')}}">Post</a></li>
        <li class="active">Post list</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header text-right">
            </div>

            <p class="success-message text-center" style="position: absolute; left: 0; right: 0; top: -61px;"></p>
            <!-- /.box-header -->
            <div class="box-body">
            	<div id="buyerSellerFilter"></div>
            	<div id="activeInactiveFilter"></div>
              <div class="table-responsive">
              	<table id="AreaList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Title</th>
                  <th>Address</th>
                  <th>Added By Name</th>
                  <th>Added By Type</th>
                  <th>Created</th>
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
  
  var table1 = $('#AreaList').DataTable({	
  	    
		"processing": true, 	
		"serverSide": true,	
		"pageLength": 10,		
		"lengthMenu": [ [10, 25, 50,100], [10, 25, 50,100] ],
		"ordering": true, 
		"language": {	
		"processing": "<img width='50' src='{{ asset('/assets/ajax-loading-large.gif')}}' >"	
		},
		"ajax": {	
			"url": "{{ url('/agentadmin/getpostlist') }}",
			"type": 'post',
			"headers": {
				       'X-CSRF-TOKEN': '{{ csrf_token() }}'
				    },
		},
		"fnDrawCallback": function(oSettings) {
			if (oSettings._iDisplayLength >= oSettings.fnRecordsDisplay()) {
				$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			}
			else{
								$(oSettings.nTableWrapper).find('.dataTables_paginate').show();

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
	  	'Seller/Buyer <select id="user_type" onchange="myfun(this.value);"> <option value="1">All</option> <option value="2">Seller</option> <option value="3">Buyer</option> </select>'
	  	);
	});

  $('#activeInactiveFilter').each(function() {
	  var title = $(this).text();
	  var all = 1;
	  $(this).html(
	  	'Active/Deactive <select id="user_active_status" style="width:80px !important" onchange="myfun(this.value);"> <option value="4">All</option> <option value="5">Active</option> <option value="6">Deactive</option> </select>'
	  	);
	});
  
	
	
	function myfun(val) {	
		let table = $('#AreaList').DataTable();
		let seller_buyer_search = $("#user_type").val();
		let seller_or_buyer = "";
		if(seller_buyer_search == 2){
			seller_or_buyer = "seller";
		}else if(seller_buyer_search == 3){
			seller_or_buyer = "buyer";
		}

		let seller_buyer_active = $("#user_active_status").val();
		let active_or_inactive = "";
		if(seller_buyer_active == 5){
			active_or_inactive = "active";
		}else if(seller_buyer_active == 6){
			active_or_inactive = "deactive";
		}

		

		if(val == 1) {
			table.columns(4).search('').draw();
		}
		if(val == 2) {
			table.columns(4).search('seller').draw();
			// table.search('seller').draw();
		}
		if(val == 3) {
			table.columns(4).search('buyer').draw();
			// table.search('buyer').draw();
		}
		if(val == 4) {
			table.columns(6).search('').draw();
			// table.search('').draw();
		}
		if(val == 5) {
			// table.search('active').draw();
			table.columns(6).search('active').draw();
		}
		if(val == 6) {
			// table.search('deactive').draw();
			table.columns(6).search('deactive').draw();
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
								url: "{{ url('/agentadmin/deletepost') }}", 
								type: 'post',
								data: { id: id,tag:'Delete',_token :"{{csrf_token()}}" },
								success:function(data){
								var table = $('#AreaList').DataTable();
									table.ajax.reload();
									$(".success-message").html("Record deleted successfully");
									$(".success-message").addClass("alert alert-success");
									$(".success-message").css({"width":"50%", "margin":"auto"});
									$(".success-message").delay(1500).fadeOut();
									}
							});
						}
					}, {
						label: 'Close',	cssClass: 'btn-primary',
						action: function(dialogItself){
						dialogItself.close();
						return false;
					}
				}]
			});
	}	


	function status_change_function(id,value,messages) {
		var myCheckboxes=[];
	    BootstrapDialog.show({
			title: '<p style="color:white;" class="text-center">Change Status Confirmation </p>',
			message: messages,
			size: BootstrapDialog.SIZE_SMALL,
			buttons: [ {
						label: 'Ok',
						cssClass: 'btn-primary',
						action: function(dialogItself){
						dialogItself.close();
							$.ajax({
								url: "{{ url('/agentadmin/deletepost') }}",
								type: 'post',
								data: { id: id, value : value, tag:'status',_token :"{{csrf_token()}}" },
								success:function(data){
								var table = $('#AreaList').DataTable();
									table.ajax.reload();
									}
								});							
						}
					}, {
						label: 'Close',	cssClass: 'btn-primary',
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