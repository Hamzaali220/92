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
        City
        <small>City list</small>
      </h1>
      <ol class="breadcrumb">
	  	<li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.cities')}}">City</a></li>
        <li class="active">City list</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         

          <div class="box">
            <div class="box-header text-right">
				<h3 class="box-title"><a class="btn btn-success" href="{{route('admin.city')}}">	
					<i class="fa fa-plus fa-xs"></i> Add City</a>			
				</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="dataList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>City</th>
                  <th>Created</th>
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
 

  

 

  @endsection
@section('scripts')
<script type="text/javascript" src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script  type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript">
   
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
			"url": "{{ url('/agentadmin/getCitiesList') }}",
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
								url: "{{ url('/agentadmin/deleteCity') }}",
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
	
</script>
@stop