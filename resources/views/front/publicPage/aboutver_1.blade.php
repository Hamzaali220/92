@extends('front.master')
@section('title', 'Home')

<!-- content start -->
@section('content')
<?php  $topmenu='About'; ?>
@include('front.include.sidebar')
    <!-- Main Section -->
    <section id="main">
        <!-- Title, Breadcrumb -->
        <div class="breadcrumb-wrapper">
            <div class="pattern-overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                            <h2 class="title">About Us</h2>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                            <div class="breadcrumbs pull-right">
                                <ul>
                                    <li>You are Now on:</li>
                                    <li><a href="{{url('/')}}">Home</a></li>

                                    <li>About Us</li>
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
                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h2>We Provide All Kinds of Property Solutions</h2>
                        <p>
                            92 Agents, helping searchers to save time and money 
                        </p>
                        <p>
                            92 Agents, the leading platform providing real estate solutions. At 92 Agents we understand the difficulties faced by buyers, sellers and agents in the real estate industry, and it is our mission to provide resolutions to those problems. We strive to provide buyers and sellers of properties with an efficient, straightforward and a more cost-effective way to compare and enlist the help of real estate agents who will help you with your real estate needs.
                        </p>
                        
                        
                    </div>
                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                         <img src="{{ URL::asset('front/img/istock-real-estate.jpg') }}" alt="about">
                    </div>
                    <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p>
                            At 92 Agents, our team is committed to creating the number one online platform and rendering impeccable services to buyers, sellers and agents. Making a difference in the real estate industry.
                        </p>
                        <p>
                            We know it is not so easy for sellers to on their own, find buyers for their property. That is why we created this platform where sellers and buyers can hire real estate agents to either market their property or find them their dream house. Without spending a whole lot of money, you get to sell or buy properties fast and easily. Both Buyers, sellers, and agents get to benefit as agents give them the best deals as our system makes it needless for agents to spend time and money in qualifying leads since agents get the opportunity to directly connect with buyers or sellers.
                        </p>
                        <p>
                            We provide all-round customer service, and your satisfaction is of utmost importance to us. That is why we always strive to provide you better and faster real estate solutions.
                        </p>
                        <p>
                            What are you waiting for? Get started today and immediately get connected with either buyers, sellers or agents.<br>
                        </p>
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