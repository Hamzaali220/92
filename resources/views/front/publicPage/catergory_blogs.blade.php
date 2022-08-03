@extends('front.master')
@section('title', 'Blog')

<!-- content start -->
@section('content')
<?php  $topmenu='Blog'; ?>
@include('front.include.sidebar')
    <!-- Main Section -->
    <section id="main">
        <!-- Title, Breadcrumb -->
        <div class="breadcrumb-wrapper">
            <div class="pattern-overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                            <h2 class="title">{{ strtoupper($title) }}</h2>

                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                            <div class="breadcrumbs pull-right">
                                <ul>
                                    <li>You are Now on:</li>
                                    <li><a href="{{url('/')}}">Home</a></li>

                                    <li><a href="{{url('/blogs')}}">Blogs</a></li>
                                    <li>Blog Info</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Title, Breadcrumb -->
        <!-- /Main Content -->
        <div class="content-about margin-top60">
            <div class="container">
                
                <div class="row">
                    <div class="posts-block col-lg-8 col-md-8 col-sm-8 col-xs-12">
                       @foreach($blogs as $blog)
                        <div>
                            <h2>{{ strtoupper($blog->title) }}</h2>
                            <p><i class="fa fa-calendar"></i> {{ date('d-m-Y', strtotime($blog->created_date))}} &nbsp; &nbsp;<i class="fa fa-eye"></i> {{ $blog->view }} &nbsp; &nbsp;<i class="fa fa-user"></i> <b>{{ $blog->name }}</b>  &nbsp; &nbsp;Role: <b>{{ $blog->role_name }}</b></p>
                            <p><a href="{{ url('/blogs') }}/{{$blog->id}}/{{$blog->title}}" class="btn btn-success" >Read More...</a></p>
                        </div>
                        @endforeach
                        <?php if(sizeof($blogs)==0) echo '<h3 style="color:red">No blogs in this Category</h3>'; ?>
                    </div>
                    <div class="posts-block col-lg-4 col-md-4 col-sm-4 col-xs-12">
                         <div class="">
                            <h3>Category List</h3>
                            <ul class="list-group sidebar-nav-v1" id="sidebar-nav-1" style="list-style: none;">       
                                @foreach($category as $cat)
                                <li class="list-group-item1 border1-bottom text-left" style="background:{{ ($id==$cat->id)? '#569314':'#74c52c' }};padding: 5px 15px;border-bottom: 1px solid #ddd">
                                    <a href="{{ url('/blogs/category')}}/{{$cat->id}}/{{$cat->cat_name}}" style="padding: 5px 10px;color: #fff;display: block;font-size: 16px;font-weight: 600;"><i class="fa fa-angle-right"></i> {{ $cat->cat_name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- /Promo -->
            </div>
        </div>
        <!-- /Main Content -->                                                              
     
    </section>
    <!-- /Main Section -->
@endsection
<!-- content end -->