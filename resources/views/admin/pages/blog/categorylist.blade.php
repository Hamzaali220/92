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
        Category
        <small> Category list</small>
      </h1>
      <ol class="breadcrumb">
	  	<li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.blog.bloglist')}}">Blog</a></li>
        <li class="active"> Category list</li>
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
              		<button class="btn-primary float-right" type="button" data-toggle="modal" data-target="#myModal">Add Category</button>
              		<table id="dataList" class="table table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th>Sr No.</th>
		                  <th>Category Name</th>
		                  <th>Created at</th>
		                  <th>Action</th>
		                </tr>
		                </thead>
		              	<tbody>
		              	<?php $i=1; foreach($catlist as $cat){ ?>
		              			<tr>
		              				<td>{{ $i }}</td>
		              				<td>{{ $cat->cat_name }}</td>
		              				<td>{{ date('d-m-Y', strtotime($cat->created_at)) }}</td>
		              				<td>
		              					<button type="button" class="btn btn-success" id="{{ $cat->id }}" value="{{ $cat->cat_name }}" onclick="editcat(this.id,this.value)">Edit</button>
		              					<a class="btn btn-danger" data-id="{{ $cat->id }}" onclick="deletecat(this)">Delete</a>
		              				</td>
		              			</tr>
		              		<?php $i++;} ?>
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
    <div class="modal bootstrap-dialog fade" id="myModal">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">

	      <!-- Modal Header -->
	      <div class="modal-header">
	        <h4 class="modal-title">Add Category</h4>
	        <button type="button" class="close" data-dismiss="modal" style="color: red">&times;</button>
	      </div>

	      <!-- Modal body -->
	      <div class="modal-body">
	        <form method="post" id='addcat' action="javascript:(0)">
	        	<div class="row">
	        		<div class="col-md-12 form-group">
	        			<p id="msg" class="alert"></p>
	        			<label>Enter Category Name</label>
	        			{{ csrf_field() }}
	        			<input type="text" name="cat_name" id="cat_name" class="form-control" required>
	        		</div>
	        		<center><button class="btn-u btn-u-success">Add</button></center>
	        	</div>
	        </form>
	      </div>


	    </div>
	  </div>
	</div>

	<div class="modal bootstrap-dialog fade" id="updatemodal">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">

	      <!-- Modal Header -->
	      <div class="modal-header">
	        <h4 class="modal-title">Edit Category</h4>
	        <button type="button" class="close" data-dismiss="modal" style="color: red">&times;</button>
	      </div>

	      <!-- Modal body -->
	      <div class="modal-body">
	        <form method="post" id='updatecat' action="javascript:(0)">
	        	<div class="row">
	        		<div class="col-md-12 form-group">
	        			<p id="msg1" class="alert"></p>
	        			<label>Enter Category Name</label>
	        			{{ csrf_field() }}
                        <input type="hidden" name="hid" id="hid" value="">
	        			<input type="text" name="cat_name" id="cat_nam" class="form-control" required>
	        		</div>
	        		<center><button class="btn-u btn-u-success">Update</button></center>
	        	</div>
	        </form>
	      </div>


	    </div>
	  </div>
	</div>
    <!-- /.content -->
  </div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script  type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/js/bootstrap-dialog.min.js"></script>
<script type="text/javascript">
	$(function () {
	  	$("#msg,#msg1").hide();
	    // $("#example1").DataTable();
	    var table = $('#dataList').DataTable({
	      "paging": true,
	      "responsive":true,
	      "autoWidth": false
	    });
	    $('.close').click(function(e){
	    	location.reload();
	    });
	});
  
  	$("#updatecat").submit(function(event) {
  		$.ajax({
	        url:"{{ route('employee.updatecat')}}",
	        type: 'put',
	        dataType: 'json',
	        data: $("#updatecat").serialize(),
	        success:function(result){
	        	if (result.success=='ok') {
	        		$("#msg1").addClass('alert-success').removeClass('alert-danger').text('Category Updated Successfully').show();
	        	}
	        	else{
	        		$("#msg1").addClass('alert-danger').removeClass('alert-success').text('No changes done').show();
	        	}
	        	window.location.reload(true);
	          	return false;
	        }
      	})
  	});

  	$("#addcat").submit(function(event) {
  		$.ajax({
	        url:"{{ route('employee.addcat')}}",
	        type: 'post',
	        dataType: 'json',
	        data: $("#addcat").serialize(),
	        success:function(result){
	        	if (result.success=='ok') {
	        		$("#msg").addClass('alert-success').removeClass('alert-danger').text('Category Added Successfully').show();
	        		 


	        	}
	        	else{
	        		$("#msg").addClass('alert-danger').removeClass('alert-success').text('Category Exist').show();
	        	}
	        	window.location.reload(true);
	          	return false;
	        }	

      	})
  	});

  	function editcat(id,value) {
  		$("#hid").val(id);
  		$("#cat_nam").val(value);
  		$("#updatemodal").modal('show');
  	}

  	
  
</script>
<script type="text/javascript">
  function deletecat(th){
    var id = $(th).data('id');
    var token ="{{ csrf_token() }}";
    
    if(confirm("Are sure you want to delete this category?")){
      $.ajax({
        type  :'POST',
        url   :"{{ route('employee.deletecat')}}",
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