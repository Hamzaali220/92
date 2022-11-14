@extends('front.master')
@section('title', 'Home')

<!-- content start -->
@section('content')
<?php  $topmenu='Seller'; ?>
@include('front.include.sidebar')

<!-- Main Section -->
<section id="main">
    <!-- Title, Breadcrumb -->
    <div class="breadcrumb-wrapper">
        <div class="pattern-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <h2 class="title">Seller</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <div class="breadcrumbs pull-right">
                            <ul>
                                <li>You are Now on:</li>
                                <li><a href="{{url('/')}}">Home</a></li>

                                <li>Seller</li>
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
                    <h2>Why homes don’t sell?</h2>
                     <ul>
                         <li>Not Getting potential buyers</li>
                         <li>Having Slow Agents</li>
                         <li>Every agent does not have the expertise in dealing with various kind of properties.</li>
                     </ul>
                    {{-- <p>
                        You’ve got a home to sell but can’t find potential buyers. That’s because, your agents are too
                        slow. Want to meet quick-acting ones? Welcome to 92 Agents.
                    </p>
                    <p>
                        No home is imperfect, all it needs is the right kind of buyers who can adore it the way you do.
                        And that just does not just happen out of blue, agents do the job for you. They charge
                        reasonable commission but in return bring the desired buyers on to the table.
                    </p> --}}
                    <p>Where to find such skilled agents? Well, you’re at the right place! At 92 Agents, you will find a
                        lot of agents present just near to you!</p>
                    <a href="#" class="btn btn-color nesusersignup" data-target="modalseller" style="font-size: 1.8rem"><strong> Sell your house at 1% commision &#10132; </strong></a>
                </div>
                <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <img src="{{ URL::asset('img/home/worried.png') }}" alt="about">
                </div>
            </div>



            <!-- /Promo -->
        </div>
    </div>
    <hr width="100%">
    <div class="content-about margin-top60" style="margin-bottom: 60px;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <img src="{{URL::asset('front/img/seller_page.jpg')}}" >
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
                        <h2>Market your home in front of potential buyers in these Four simple steps.</h2>

                        <ul class="list icons list-unstyled">
                            <li><i class="fa fa-check"></i> Register yourself as a seller</li>
                            <li><i class="fa fa-check"></i> Start looking for agents close to you</li>
                            <li><i class="fa fa-check"></i> Choose the best one</li>
                            <li><i class="fa fa-check"></i> Choose the best one</li>
                            <li><i class="fa fa-check"></i> Get desired buyers visit to your doorstep</li>
                        </ul>
                    </div>
                </div>
                <hr width="100%">

                <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 25px;margin-top:25px;">
                    <h2>What you lose if you move out of 92 Agents?</h2>

                    <ul class="list icons list-unstyled">
                        <li><i class="fa fa-check"></i> Hiring potential agents would not be that easy</li>
                        <li><i class="fa fa-check"></i> You may never come to know about their true qualifications,
                            customer reviews and past work experience</li>
                        <li><i class="fa fa-check"></i> You may lose agents who are ready to prove themselves even at 1%
                            commission</li>
                        <li><i class="fa fa-check"></i> You may not able to sell your home within next 30 days</li>
                    </ul>
                </div>
                <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
                    <h2>Why 92 Agents?</h2>

                    <ul class="list icons list-unstyled">
                        <li><i class="fa fa-check"></i> Get to know about nearby professional agents in just 10 minutes
                        </li>
                        <li><i class="fa fa-check"></i> Compare them as per their qualification and expertise</li>
                        <li><i class="fa fa-check"></i> Use one to one chat feature to know them better</li>
                        <li><i class="fa fa-check"></i> Raise your query to all agents simultaneously</li>
                        <li><i class="fa fa-check"></i> Make the FAQs public on your dashboard to avoid repetitive
                            questions from agents</li>
                        <li><i class="fa fa-check"></i> Save time</li>
                        <li><i class="fa fa-check"></i> Make a great deal</li>
                    </ul>
                </div>
                <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
                    <h2> You save upto $10,000 when you choose 92Agents!</h2>
                    <a href="#" class="btn btn-color nesusersignup" data-target="modalseller" style="font-size: 1.8rem"><strong>Join to save your $10,000 &#10132; </strong></a>

                    {{-- <ul class="list icons list-unstyled">
                        <li><i class="fa fa-check"></i> So, what are you waiting for? Take your first step now!</li>
                        <li><i class="fa fa-check"></i> Register yourself as a seller and get ready for a better deal!
                        </li>
                        <li><i class="fa fa-check"></i> It takes hardly 10 minutes of your time.</li>
                        <li><i class="fa fa-check"></i> Still thinking? Act now before it gets too late!</li>
                        <li><i class="fa fa-check"></i> A whole world of agents is waiting for you this side!</li>

                    </ul> --}}
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
