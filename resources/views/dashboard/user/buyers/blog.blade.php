@extends('dashboard.master')
@section('title', 'home page')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/summernote/css/summernote.css') }}">

<style>

</style>
@stop
@section('content')
<?php  $topmenu='Home'; ?>
<?php $activemenu = 'Blog'; 
//dd($user);

?>

@include('dashboard.include.sidebar')


    <div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			
			@include('dashboard.user.buyers.include.sidebar')
			 <?php 
			  //dd($user); 
			 ?> 
			

			@include('dashboard.user.buyers.include.sidebar-dashbord')


			<!--End Left Sidebar-->
			<!-- Profile Content -->
			<div class="col-md-9">
				<h1 class="margin-bottom-40">Your Blog List</h1>
				<div class="box-shadow-profile homedata homedataposts ">
					<!-- Default Proposals -->
					<div class="panel-profile">
						<div class="panel-heading overflow-h air-card">
							<h2 class="panel-title heading-sm pull-left"><i class="fa fa-newspaper-o"></i>Blogs. </h2>
							<span class="btn btn-success float-right" data-toggle="modal" data-target="#addblog">Add Blog</span>
						</div>
						<div class="panel-body">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Sr.No.</th>
										<th>Blog Title</th>
										<th>Category</th>
										<th>Added Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody><?php $i=1; ?>
									@foreach($blogs as $blog)
									
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $blog->title }}</td>
											<td>{{ $blog->cat_name }}</td>
											<td>{{ date('d-m-Y', strtotime($blog->created_date)) }}</td>
											<td>
												<a href="{{ url('/blogs') }}/{{ $blog->id}}/{{$blog->title}}" target="_blank" class="btn btn-success"  ><i style="color: #fff !important" class="fa fa-eye"></i></a>
												<button class="btn btn-primary edit-post-js" data-id="{{ $blog->id }}" style="color: #fff"><i class="fa fa-edit"></i></button>
												<button class="btn btn-danger" id="{{ $blog->id }}" style="color: #fff" onclick="delblog(this.id)"><i class="fa fa-trash"></i></button>
												
											</td>
										</tr>
										<?php $i++; ?>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<!-- Default Proposals -->
				</div>
			</div>
			<!-- End Profile Content -->
		</div>
	</div>	
	<!-- survey popup -->
	<div class="modal fade" id="addblog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content not-top">
					<div class="modal-header">
						<h4>Add Blog</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title-text"></h4>
					</div>
					<div class="modal-body">
						{!! Form::open(array('method' => 'POST','url' => route('blog.addblog'),'class'=>'form-horizontal','role'=>'form')) !!}

		                <div class="row">
		                  <div class="col-md-12">
		                      <label>Title</label>
		                      <input type="text" name="title" class="form-control text-uppercase" placeholder="Blog Title" required>
		                  </div>
		                  <div class="col-md-12">
		                      <label>Select Category</label>
		                      <select name="cat_id" class="form-control" required="">
		                        <option value="">--------------------</option>
		                        @foreach($category as $cat)
		                          <option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
		                        @endforeach
		                      </select>
		                  </div>
		                  <div class="col-md-12">
		                      <label>Description</label>
		                      <textarea id="summernote" class="form-control" name="description" required></textarea>
		                  </div>
		                </div>
		                <div class="col-md-12 text-center" style="margin-top: 15px;">
		                  <button class="btn-u btn-u-success">Submit</button>
		                </div>
		              {{ Form::close() }}
					</div>
					<div class="modal-footer foote-nb">
					
					</div>
			</div>
		</div>
	</div>

	
	<div class="modal fade" id="editBlog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content not-top">
					<div class="modal-header">
						<h4>Update Blog</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title-text"></h4>
					</div>
					<div class="modal-body">
						{!! Form::open(array('method' => 'POST','url' => route('blog.update'),'class'=>'form-horizontal','role'=>'form','id'=>'editBlogForm')) !!}

		                <div class="row">
		                  <div class="col-md-12">
		                      <label>Title</label>
		                      <input type="text" id="blog_title" name="title" class="form-control text-uppercase" placeholder="Blog Title" required>
		                  </div>
		                  <div class="col-md-12">
		                      <label>Select Category</label>
		                      <select id="blog_cat_id" name="cat_id" class="form-control" required="">
		                        <option value="">--------------------</option>
		                        @foreach($category as $cat)
		                          <option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
		                        @endforeach
		                      </select>
		                  </div>
		                  <div class="col-md-12">
		                      <label>Description</label>
		                      <textarea id="summernote2" class="form-control" id="blog_description" name="description" required></textarea>
		                  </div>
		                </div>
		                <div class="col-md-12 text-center" style="margin-top: 15px;">
							<input type="hidden" name="id" id="blog_id">
		                  <button class="btn-u btn-u-success">Submit</button>
		                </div>
		              {{ Form::close() }}
					</div>
					<div class="modal-footer foote-nb">
					
					</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('assets/plugins/summernote/js/summernote.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
  $('#summernote').summernote(); 
	$(document).on('click','.edit-post-js',function(){
		let ele = $(this);
		let post_id = ele.data("id");
		
		$.ajax({
			url: '{{ url("/buyer/get/blog/") }}/'+post_id,
			type: 'GET',
			data: '',
			async:false,
			success:function(data){
				try{
					let res = JSON.parse(data);
					$("#blog_id").val(res.id);
					$("#blog_title").val(res.title);
					$("#blog_cat_id").val(res.cat_id);
					$("#summernote2").summernote("code", res.description);
					$("#editBlog").modal("show");
				}catch(e){
					alert('Blog not found');
				}
				
			},error: function(err){
				alert('Blog not found');
			}
		})	
	});

	$("#editBlogForm").submit(function(e){
		e.preventDefault();
		let this_form = $(this);
		let data = this_form.serialize();
		
		let action = this_form.attr("action");
		$.ajax({
			url: action,
			type: 'POST',
			data: data,
			success:function(data){
				if(data){
					alert('Blog updated successfully');
					setTimeout(()=>{
						window.location.reload();
					},1500)
				}
			}
		})
			
	});
	
	function delblog(id) {
		if (confirm("Are you sure?")) {
			$.ajax({
				url: '{{ url("/buyer/blog/") }}/'+id,
				type: 'GET',
				dataType: 'html',
				success:function(data){
					alert('Blog deleted successfully');
					window.location.reload();
				}
			})
		}
		
	}
</script> 
@stop