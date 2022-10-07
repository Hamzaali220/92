@extends('front.master')
@section('title', 'Home')

<!-- content start -->
@section('content')
<?php  $topmenu='Agents'; ?>
@include('front.include.sidebar')

<!-- Main Section -->
<section id="main">
    <!-- Title, Breadcrumb -->
    <div class="breadcrumb-wrapper">
        <div class="pattern-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <h2 class="title">Agent</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <div class="breadcrumbs pull-right">
                            <ul>
                                <li>You are Now on:</li>
                                <li><a href="{{url('/')}}">Home</a></li>

                                <li>Agent</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Title, Breadcrumb -->
    <!-- /Main Content -->
    <div class="content-about margin-top60" style="margin-bottom: 60px;">
        <div class="container">
            <div class="row">
                <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h2>Want to become one of the most-sought-after real estate agent? Welcome to 92
                        Agents.</h2>
                    <p>
                        We bring sellers and buyers looking for qualified agents on to a single platform. Get offers,
                        help them out and make earning easy.
                    </p>
                    <ul class="list icons list-unstyled">
                        <li><i class="fa fa-check"></i> Create your profile</li>
                        <li><i class="fa fa-check"></i> Get notified when sellers and buyers post their requirements
                        </li>
                        <li><i class="fa fa-check"></i> Impress them with what you’ve got</li>
                        <li><i class="fa fa-check"></i> Get hired</li>
                        <li><i class="fa fa-check"></i>Complete the job and make easy money</li>
                    </ul>


                </div>
                <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <img src="{{ URL::asset('front/img/agents.jpg') }}" alt="about" width="650">
                </div>
            </div>



            <!-- /Promo -->
        </div>
    </div>
    <div class="container">
        <div class="startNow">

            <p>Are you not interested to make a head start? Then, what are you waiting for?<br>
                Create your profile and make your first earning today!</p>
        </div>
    </div>
    <div class="content-about margin-top60" style="margin-bottom: 60px;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-5">
                    <img src="{{URL::asset('front/img/agent-single.png')}}" />
                </div>
                <div class="col-xs-12 col-md-7">
                    <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2>Perks you get only @92Agents:</h2>
                        {{-- <p>
                            Build your profile and write about your qualifications, previous work experience and other
                            skills that can impress your clients the most. Every business successful business deal will
                            enable you to earn positive comments and reviews. It will further make your profile weigh more
                            higher than other agents present in the market.
                        </p> --}}
                        <ul class="list icons list-unstyled">
                            <li><i class="fa fa-check"></i> <strong>No more running for leads:</strong> Instead of running for leads,
                                concentrate building your skills while we bring sellers and buyers to you.</li>
                            <li><i class="fa fa-check"></i> A Unique platform: Your profile will be visible to thousand of
                                sellers and buyers at a time. So, the probability of you getting hired is more.</li>
                            <li><i class="fa fa-check"></i> Meet genuine customers: We bring potential customers to you. So,
                                rest assured of making a quality business.</li>
                            <li><i class="fa fa-check"></i> Talk to them: We have personal chat feature so that you can talk
                                to your customer directly before closing any deal.</li>
                            <li><i class="fa fa-check"></i>24/7 support: Feel free to raise your issue to us at any time.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center" style="display: flex;justify-content:center">
                <a href="#" class="btn btn-color nesusersignup" data-target="modalagent" style="font-size: 20px;"><strong>Click here to get more clients &#10132; </strong></a>
            </div>


            <!-- /Promo -->
        </div>
    </div>
    <!-- /Main Content -->
</section>
<!-- /Main Section -->

@endsection
<!-- content end -->
