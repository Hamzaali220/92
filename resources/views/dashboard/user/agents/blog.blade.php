@extends('dashboard.master')

@section('title', 'home page')

@section('style')

	 

	

@stop

@section('content')

<?php  $topmenu='Home'; ?>

<?php $activemenu = 'blog'; ?>

@include('dashboard.include.sidebar')



    <div class="container content profile">

		<div class="row">

			<!--Left Sidebar-->

			@include('dashboard.user.agents.include.sidebar')

			@include('dashboard.user.agents.include.sidebar-dashbord')

			<!--End Left Sidebar-->



			<!-- Profile Content -->

			<div class="col-md-9">

				<!-- <div class="box-shadow-profile margin-bottom-40">

					

					<div class="panel-profile">

						<div class="panel-heading overflow-h air-card">

							<h2 class="heading-sm pull-left"> Find Interesting Posts </h2>

						</div>

						<div class="panel-body row find-post-home">

						    <div class="penal-home">

								<a href="{{ url('/post') }}"><img src="{{ url('/assets/img/no-results.svg') }}"></a>

							    <p>Fine post more quickly and easily - run and save a search to see interesting post here.</p>

							</div>

						</div>

						

					</div>

					

				</div>-->

				<h1 class="margin-bottom-40">Welcome to your Dashboard.</h1>

				

				

				<div class="box-shadow-profile hide homedata homedatanotes margin-bottom-40">

					<!-- Default Proposals -->

					<div class="panel-profile">

						<div class="panel-heading overflow-h air-card">

							<h2 class="panel-title heading-sm pull-left"><i class="fa fa-commenting"></i>Notes</h2>

							<a href="{{url('/'.str_replace(' ','',$userdetails->name).'/notes/')}}" class="cursor pull-right ">See All</a>

						</div>

						<div id="scrollbar" class="panel-body no-padding mCustomScrollbar" data-mcs-theme="minimal-dark">									

						</div>

						<input type="hidden" name="notes-more-load" id="notes-more-load">

						<div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop notes-loader" width="40px" height="40px"/></div>

					</div>

					<!-- Default Proposals -->

				</div>



				<div class="box-shadow-profile hide homedata homedataBookmark margin-bottom-40">

					<!-- Default Proposals -->

					<div class="panel-profile">

						<div class="panel-heading overflow-h air-card">

							<h2 class="panel-title heading-sm pull-left"><i class="fa fa-star"></i>Bookmark List</h2>

							<a href="{{url('/'.str_replace(' ','',$userdetails->name).'/bookmark/')}}" class="cursor pull-right ">See All</a>

						</div>

						<div id="scrollbar2" class="panel-body no-padding mCustomScrollbar" data-mcs-theme="minimal-dark" >

						</div>

						<input type="hidden" name="bookmark-more-load" id="bookmark-more-load">

						<div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop bookmark-loader" width="40px" height="40px"/></div>

					</div>

					<!-- Default Proposals -->

				</div>



				<div class="box-shadow-profile hide homedata homedataposts ">

					<!-- Default Proposals -->

					<div class="panel-profile">

						<div class="panel-heading overflow-h air-card">

							<h2 class="panel-title heading-sm pull-left"><i class="fa fa-newspaper-o"></i>list of selected posts.</h2>

						</div>

						<div id="scrollbar3" class="panel-body no-padding mCustomScrollbar" data-mcs-theme="minimal-dark">									

						</div>

						<input type="hidden" name="selectedagent-more-load" id="selectedagent-more-load">

						<div class="center"><img src="{{ url('/assets/img/loder/loading.gif') }}" class="messageloadertop selectedagent-loader" width="40px" height="40px"/></div>

					</div>

					<!-- Default Proposals -->

				</div>



			</div>

			<!-- End Profile Content -->

		</div>

	</div>	

	<!-- survey popup -->

	<div class="modal fade" id="deletefromnb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content not-top">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

						<h4 class="modal-title-text"></h4>

					</div>

					<div class="modal-body">

						<br>

						<div class="body-overlay body-overlay-nb"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

						<p class="model-bodu-text">Are you sure remove?</p>

					</div>

					<div class="modal-footer foote-nb">

						<button type="button" class="btn-u btn-u-primary delete">Sure</button>

						<button type="button" class="btn-u btn-u-default" data-dismiss="modal">No</button>

					</div>

			</div>

		</div>

	</div>

@endsection