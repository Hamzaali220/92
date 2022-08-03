@extends('front.master')
@section('title', 'Home')

<!-- content start -->
@section('content')
<?php  $topmenu='Buyer'; ?>
@include('front.include.sidebar')

<!-- Main Section -->
<section id="main">
    <!-- Title, Breadcrumb -->
    <div class="breadcrumb-wrapper">
        <div class="pattern-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <h2 class="title">Buyer</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <div class="breadcrumbs pull-right">
                            <ul>
                                <li>You are Now on:</li>
                                <li><a href="{{url('/')}}">Home</a></li>

                                <li>Buyer</li>
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
            <div class="row ">
                <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h2>Buying dream home made easy</h2>
                    <p>
                        Owning a home makes you feel proud of yourself but finding an ideal one is not that easy.
                    </p>
                    <p>
                        That’s where you consider hiring agents but again, not every agent is skilful to find you a home
                        of your choice. Sometimes, the commission goes high and sometimes, they just take too long to
                        act.
                    </p>
                    <p>If you are tired of looking for agents who can help you to find your dream home, you are at the
                        right place.</p>
                        <a href="#" class="btn btn-color nesusersignup" data-target="modalbuyer" style="font-size: 20px;"><strong>Join to get your dream house &#10132; </strong></a>

                </div>
                <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <img src="{{ URL::asset('front/img/buyer.jpg') }}" alt="about" width="650">
                </div>
            </div>



            <!-- /Promo -->
        </div>
    </div>
    <hr width="100%">
    <div class="content-about margin-top60" style="margin-bottom: 60px;">
        <div class="container">
            <div class="row d-flex align-items-center align-content-center" style="display:flex;align-items:center">
                    <div class="posts-block col-md-5 col-xs-12" style="margin-bottom: 25px;">
                        <h2>Connect with 1000+ agents close to you in just 10 minutes and that
                            too in five simple steps;</h2>

                        <ul class="list icons list-unstyled">
                            <li><i class="fa fa-check"></i> Register yourself as a seller</li>
                            <li><i class="fa fa-check"></i> Post your requirements</li>
                            <li><i class="fa fa-check"></i> Our agents will connect with you</li>
                            <li><i class="fa fa-check"></i> Hire the one of your choice</li>
                            <li><i class="fa fa-check"></i> Engage them to sell your home</li>
                        </ul>
                    </div>
                <div class="col-xs-12 col-md-7">
                    <img src="{{URL::asset('img/home/agent_12.png')}}">
                </div>
            </div>
            <div class="row d-flex-align-items-center" style="margin: 25px 0px 25px;display:flex;align-items:center">
                <div class="col-xs-12 col-md-7">
                    <img src="{{URL::asset('img/home/seller_poster.png')}}">
                </div>
                <div class="col-xs-12 col-md-5">
                    <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
                        <h2>Why 92 Agents?</h2>

                        <ul class="list icons list-unstyled">
                            <li><i class="fa fa-check"></i> Get to see 100+ agents near to you</li>
                            <li><i class="fa fa-check"></i> Access their bio including qualification, experience and
                                customer reviews</li>
                            <li><i class="fa fa-check"></i> Do Live chat with them</li>
                            <li><i class="fa fa-check"></i> Make your requirements public to all agents through a unique
                                dashboard</li>
                            <li><i class="fa fa-check"></i> Get 24/7 customer support from our side</li>
                        </ul>
                        <a href="#" class="btn btn-color nesusersignup" data-target="modalbuyer" style="font-size: 20px;"><strong>Join now &#10132; </strong></a>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
                    <h2>Top benefits:</h2>

                    <ul class="list icons list-unstyled">
                        <li><i class="fa fa-check"></i> Time Saving: No more hassle for looking qualified agents. 92
                            Agents will bring them to your doorstep.</li>
                        <li><i class="fa fa-check"></i> Get rid of unwanted calls: No more hectic enquiries from listed
                            agents. Only the agent of your choice will show up at your address.</li>
                        <li><i class="fa fa-check"></i> Compare agents: You will come to know about their qualification,
                            past experience and what other people say about them.</li>
                        <li><i class="fa fa-check"></i> Get to know about their commission beforehand: Each agent’s
                            profile will have their commission listed above. Even, you can come to know about agents who
                            are willing to work at 1% of commission.</li>
                        <li><i class="fa fa-check"></i> So what are you waiting for? Don’t you want to buy your dream
                            home in just 30 days?</li>

                        <li><i class="fa fa-check"></i> Then act now!</li>
                        <li><i class="fa fa-check"></i> Register yourself as a buyer and access thousand agents profile
                            in next 10 minutes.</li>
                    </ul>
                </div>
            </div>
            <!-- /Promo -->
        </div>
    </div>

</section>

@endsection
<!-- content end -->
