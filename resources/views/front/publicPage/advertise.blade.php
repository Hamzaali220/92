@extends('front.master')
@section('title', 'Home')

<!-- content start -->
@section('content')
<?php  $topmenu='advertise'; ?>
@include('front.include.sidebar')
    <!-- Main Section -->
    <section id="main">
        <!-- Title, Breadcrumb -->
        <div class="breadcrumb-wrapper">
            <div class="pattern-overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                            <h2 class="title">Advertise</h2>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                            <div class="breadcrumbs pull-right">
                                <ul>
                                    <li>You are Now on:</li>
                                    <li><a href="{{url('/')}}">Home</a></li>

                                    <li>Advertise</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Title, Breadcrumb -->
        <!-- /Main Content -->
        <div class="main-content">

            <div class="container">

                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 5rem;text-align: center;">
                        <h2 class="text-center">Our Package</h2>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 wow fadeIn animated" style="visibility: visible;">

                        <div class="content-box big ch-item bottom-pad-small">

                            <div class="ch-info-wrap">

                                <div class="ch-info">

                                    <div class="ch-info-front ch-img-1"><i class=""> <img src="http://13.234.167.168/front/img/small.png"> </i></div>

                                    <div class="ch-info-back">

                                        <i class="fa fa-rocket"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="content-box-info"  style="text-align: left">

                                <h3 class="text-center">{{ $packages[0]->title }}</h3>
                                <h3 class="text-center">Price $ {{ $packages[0]->price }}</h3>

                                <p class="text-left"><?php echo $packages[0]->details ?></p>

                                <center>
                                    <a class="cursor" data-toggle="modal" data-target="#loginModal"> Buy Now <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
                                </center>

                            </div>

                            

                        </div>

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 wow fadeIn animated" style="visibility: visible;">

                        <div class="content-box big ch-item bottom-pad-small">

                            <div class="ch-info-wrap">

                                <div class="ch-info">

                                    <div class="ch-info-front ch-img-1"><i class=""><img src="http://13.234.167.168/front/img/medium.png"></i></div>

                                    <div class="ch-info-back">

                                        <i class="fa fa-check"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="content-box-info"  style="text-align: left">

                                <h3 class="text-center">{{ $packages[1]->title }}</h3>
                                <h3 class="text-center">Price $ {{ $packages[1]->price }}</h3>

                                <p class="text-left"><?php echo $packages[1]->details ?></p>

                                <center>
                                    <a class="cursor" data-toggle="modal" data-target="#loginModal"> Buy Now <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
                                </center>

                            </div>

                           

                        </div>

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 wow fadeIn animated" style="visibility: visible;">

                        <div class="content-box big ch-item">

                            <div class="ch-info-wrap">

                                <div class="ch-info">

                                    <div class="ch-info-front ch-img-1"><i class=""><img src="http://13.234.167.168/front/img/large.png"></i></div>

                                    <div class="ch-info-back">

                                        <i class="fa fa-tags"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="content-box-info" style="text-align: left">

                                <h3 class="text-center">{{ $packages[2]->title }}</h3>
                                <h3 class="text-center">Price $ {{ $packages[2]->price }}</h3>

                                <p ><?php echo $packages[2]->details ?></p>

                                <center>
                                    <a class="cursor" data-toggle="modal" data-target="#loginModal"> Buy Now <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
                                </center>

                            </div>

                            

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <!-- /Main Content -->                                                              
     
    </section>
    <!-- /Main Section -->
@endsection
<!-- content end -->