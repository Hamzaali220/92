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
<script>
	function checkDocument(userId){
		$("#checkDocumentModal").modal();
		$.ajax({
		url: "{{ url('/agentadmin/checkDocument') }}",
		type: 'get',
		data: { userId: userId,tag:'Delete',_token :"{{csrf_token()}}" },
		success:function(data){
			var newData = JSON.parse(data);
			$("#docUserId").val(userId);
            document.getElementById('pdfFrame').src = newData[0]['statement_document'];
		}
		});
		
	}

	function changeContractDocStatus(status){
          var status = status;
          var userId = $('#docUserId').val();
          window.location = '<?php echo url('/agentadmin/agents/changeDocStatus'); ?>?userId='+userId+'&status='+status+'&_token={{csrf_token()}}';
	}
	</script>
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Agent
        <small>Agent list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.agents')}}">Agent</a></li>
        <li class="active">Agent list</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         

          <div class="box">
            <div class="box-header text-right">
				<!-- <h3 class="box-title"><a class="btn btn-success" href="{{route('admin.agent')}}">	
					<i class="fa fa-plus fa-xs"></i> Add Agent</a>			
				</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="dataList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Address</th>
				  <th>Phone</th>
				  <th>Closing Date Activity</th>
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


  <!-- Modal -->
<div id="checkDocumentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="top:0px;">
      <div class="modal-header">
        <button type="button" class="close" id="closemodal" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Signed Contract</h4>
      </div>
      <div class="modal-body">
      	<center>
        <div >
        	<iframe id="pdfFrame" style="width:100%; height:400px;" ></iframe>
        </div>
        <input type="hidden" id="docUserId" />
        <button onclick="changeContractDocStatus('2');" class="btn btn-primary">Accepted</button>
         <button onclick="changeContractDocStatus('0');" class="btn btn-danger">Rejected</button>
    </center>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
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
      "autoWidth": false,
      "responsive": true
    });
  });
  
  var table1 = $('#dataList').DataTable({ 	
		"processing": true, 	
		"serverSide": true,	
		"pageLength": 10,		
		"lengthMenu": [ [10, 25, 50,100], [10, 25, 50,100] ],
		"ordering": false, 
		"language": {	
		"processing": "<img width='50' src='{{ asset('/assets/ajax-loading-large.gif')}}' >"	
		},		
		"ajax": {	
			"url": "{{ url('/agentadmin/getAgentList') }}",
			"type": 'post',
			"headers": {
				       'X-CSRF-TOKEN': '{{ csrf_token() }}'
				    },
		},
		"fnDrawCallback": function(oSettings) {
			if (oSettings._iDisplayLength >= oSettings.fnRecordsDisplay()) {
				// $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
			}			
			if($("#dataList_wrapper").find(".row").eq(0).find(".col-sm-6").eq(0).find("#status_select").length == 0){
				$("#dataList_wrapper").find(".row").eq(0).find(".col-sm-6").eq(0).find("#dataList_length").append(`<span style="margin-left:40px">Status <select id='status_select' onchange="filter_status(this.value);" class="form-control input-sm"> <option value="1">All</option> <option value="2">Active</option> <option value="3">Deactive</option> </select></span>
				
				<span style="margin-left:40px">Verification <select id='verification_select' onchange="filter_verification(this.value);" class="form-control input-sm"> <option value="1">All</option> <option value="2">Verified</option> <option value="3">Not-Verified</option> <option value="4">Incomplete Profile</option> </select></span>
				`);
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
	
	function filter_status(val) {
		
		var table = $('#dataList').DataTable();
		if(val == 1) {
			table.columns(6).search('').draw();
		}
		if(val == 2) {
			table.columns(6).search('Active').draw();
		}
		if(val == 3) {
			table.columns(6).search('Deactive').draw();
		}
  	}

	function filter_verification(val) {
		var table = $('#dataList').DataTable();
		if(val == 1) {
			table.columns(7).search('').draw();
		}
		if(val == 2) {
			table.columns(7).search('verified').draw();
		}
		if(val == 3) {
			table.columns(7).search('not-verified').draw();
		}
		if(val == 4) {
			table.columns(7).search('incomplete-profile').draw();
		}
	}
	  
	  
	
	function confirm_function(id,messages)
	{
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
								url: "{{ url('/agentadmin/deleteAgent') }}",
								type: 'post',
								data: { id: id,tag:'Delete',_token :"{{csrf_token()}}" },
								success:function(data){
								var table = $('#dataList').DataTable();
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
	function status_change_function(id,value,messages)
	{
		var myCheckboxes=[];
	    BootstrapDialog.show({
			title: '<p style="color:white;" class="text-center">Action Confirmation </p>',
			message: messages,
			size: BootstrapDialog.SIZE_SMALL,
			buttons: [ {
						label: 'Ok',
						cssClass: 'btn-primary',
						action: function(dialogItself){
						dialogItself.close();
							$.ajax({
								url: "{{ url('/agentadmin/deleteAgent') }}",
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