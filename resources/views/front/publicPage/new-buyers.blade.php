@extends('front.master')
@section('title', 'Home')

<!-- content start -->
@section('content')
<?php  $topmenu='Buyer'; ?>
<style>
   
   .newlink{
      z-index:1000;
   }
   .header_title_image{
      position:relative;
      background:none
   }
   .header_title_image::before {
      content: "";
      position: absolute;
      background-color: rgba(0, 0, 0, 0.7);
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 0;
   }
   .header_background_img{
      background: url('../img/svg2/young-couple-holding-white-miniature-house-living-room (1).webp') 80% 0 no-repeat;
      height:auto;
      min-height: 50vh;
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      display: flex;
      align-items: center;
      padding-left: 11.5%;
   }
   .svg-container svg{
      position: absolute;
      left: 0;
      bottom: -5px;
      z-index: 2;
   }
   .header_background_img .title{
      margin : 0 !important;
      font-size: 48px;
      font-weight: 900;
      line-height: 60px;
   }
   .header_background_img .breadcrumbs{
      margin : 0 !important;
      text-transform: uppercase;
      margin-bottom:24px !important;
   }
   .header-title{
      color: #74c42b;
   }
   .img-tick{
      width: 36px;
      box-shadow: 3px 6px 8px rgb(0,0,0,0.1);
      border-radius: 50%;
   }
   .sub-points{
      display:flex;
      flex-direction:row;
      /* align-items:center; */
   }
   .sub-points .img-span{
      width:10%;
   }
   .sub-points .content-span{
      width: 90%;
      margin-bottom: 14px;
      color: #7781A0 !important;
      line-height: 1.5;
   }
   .header-divider{
      width: 35px;
      height: 3px;
      background: rgba(89, 171, 2, 0.75);
      margin-bottom:36px;
   }
   .fake-border{
      
      border: 2px solid #74c42b;
      width: 520px;
      height: 466px;
      position: absolute;
      top: -36px;
      left: -20px;
      z-index: 1;
   }

   .fake-border-reverse{  
      border: 2px solid #74c42b;
      width: 520px;
      height: 466px;
      position: absolute;
      top: -30px;
      left: 26px;
      z-index: 1;
   }
   .new-btn-design{
      margin-top: 36px;
      border-radius: 4px !important;
      text-transform: uppercase;
      font-weight: 600;
      height: 48px;
      width: auto;
      line-height: 2;
   }
   </style>
@include('front.include.sidebar')

    <!-- Main Section -->
    <section id="main">
        <!-- Title, Breadcrumb -->
        <div class="header_title_image">
            <div class="header_background_img">
                <span class="svg-container hidden-sm hidden-xs">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1920 276" style="enable-background:new 0 0 1920 276;" xml:space="preserve">
                    <style type="text/css">
                    .st0{fill:#FFFFFF;}
                    </style>
                    <path class="st0" d="M0.5,269.5h1289.08c139.95,0,276.91-40.51,394.35-116.64L1920.5-0.5v277H0.5V269.5z"></path>
                    </svg>
                </span>
                <div class="">
                    <div class="container">
                        <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <div class="breadcrumbs">
                                <ul>
                                    <li></li>
                                    <li><a href="{{url('/')}}">Home</a></li>
                                    <li>Buyer</li>
                                </ul>
                            </div>
                        </div>
                            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                                <h2 class="title" style=""><span class="header-title">Everyone</span> Deserves the Opportunity of <span class="header-title">Home.</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- /Title, Breadcrumb -->
        <!-- /Main Content -->
        <div class="content-about" style="margin-bottom: 120px;margin-top: 120px;">
            <div class="container">
                <div class="row">
                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div style="position:relative;z-index:10;">
                            <img src="{{ URL::asset('img/agents/agent1.webp') }}" alt="about" width="500">
                        </div>
                        <div class="fake-border">&nbsp;</div>    
                    </div>
                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h2>Buying dream home made easy</h2>
                        <span><div class="header-divider">&nbsp;</div></span>

                        <div class="sub-points">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                                Owning a home makes you feel proud of yourself but finding an ideal one is not that easy.                     
                            </span>
                        </div>
                        <div class="sub-points">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                                That’s where you consider hiring agents but again, not every agent is skilful to find you a home of your choice. Sometimes, the commission goes high and sometimes, they just take too long to act.                    
                            </span>
                        </div>
                        <div class="sub-points">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                                If you are tired of looking for agents who can help you to find your dream home, you are at the right place.
                            </span>
                        </div>
                        <a data-toggle="modal" data-target="#registrationModal" style="z-index: 99999;" class="cursor btn-special btn btn-color new-btn-design">Learn More</a>
                    </div>
                    
                </div>
                
                
                
                <!-- /Promo -->
            </div>
        </div>

        <div class="content-about" style="margin-bottom: 150px;margin-top: 150px;">
            <div class="container">
                <div class="row">
                    
                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h2>Connected with 1000+ agents</h2>
                        <span><div class="header-divider">&nbsp;</div></span>

                        <div class="sub-points" style="margin-bottom: 12px;">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                                Register yourself as a seller
                            </span>
                        </div>
                        <div class="sub-points" style="margin-bottom: 12px;">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                                Post your requirements          
                            </span>
                        </div>
                        <div class="sub-points" style="margin-bottom: 12px;">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                                Our agents will connect with you
                            </span>
                        </div>

                        <div class="sub-points" style="margin-bottom: 12px;">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                                Hire the one of your choice
                            </span>
                        </div>
                        <div class="sub-points" style="margin-bottom: 12px;">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                                Engage them to sell your home
                            </span>
                        </div>
                        <a data-toggle="modal" data-target="#registrationModal" style="z-index: 99999;" class="cursor btn-special btn btn-color new-btn-design">Learn More</a>
                    </div>

                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div style="position:relative;z-index:10;">
                            <img src="{{ URL::asset('img/agents/agent2.webp') }}" alt="about" width="500">
                        </div>
                        <div class="fake-border-reverse">&nbsp;</div>    
                    </div>
                </div>
                <!-- /Promo -->
            </div>
        </div>

        <div class="content-about" style="margin-bottom: 120px;margin-top: 120px;">
            <div class="container">
                <div class="row">
                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div style="position:relative;z-index:10;">
                            <img src="{{ URL::asset('img/agents/agent3.webp') }}" alt="about" width="500">
                        </div>
                        <div class="fake-border">&nbsp;</div>    
                    </div>
                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h2>Why 92 Agents?</h2>
                        <span><div class="header-divider">&nbsp;</div></span>

                        <div class="sub-points" style="margin-bottom: 12px;">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Get to see 100+ agents near to you           
                            </span>
                        </div>
                        <div class="sub-points" style="margin-bottom: 12px;">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Access their bio including qualification, experience and customer reviews            
                            </span>
                        </div>
                        <div class="sub-points" style="margin-bottom: 12px;">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Do Live chat with them
                            </span>
                        </div>
                        <div class="sub-points">
                            <span class="img-span" style="margin-bottom: 12px;">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Make your requirements public to all agents through a unique dashboard           
                            </span>
                        </div>
                        <div class="sub-points" style="margin-bottom: 12px;">
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Get 24/7 customer support from our side
                            </span>
                        </div>
                        <a data-toggle="modal" data-target="#registrationModal" style="z-index: 99999;" class="cursor btn-special btn btn-color new-btn-design">Learn More</a>
                    </div>
                    
                </div>
                
                
                
                <!-- /Promo -->
            </div>
        </div>

        <div class="content-about" style="margin-bottom: 150px;margin-top: 150px;">
            <div class="container">
                <div class="row">
                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h2>Top benefits</h2>
                        <span><div class="header-divider">&nbsp;</div></span>

                        <div class="sub-points" >
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Time Saving: No more hassle for looking qualified agents. 92 Agents will bring them to your doorstep.
                            </span>
                        </div>
                        <div class="sub-points" >
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Get rid of unwanted calls: No more hectic enquiries from listed agents. Only the agent of your choice will show up at your address.   
                            </span>
                        </div>
                        <div class="sub-points" >
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Compare agents: You will come to know about their qualification, past experience and what other people say about them.
                            </span>
                        </div>

                        <div class="sub-points" >
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Get to know about their commission beforehand: Each agent’s profile will have their commission listed above. Even, you can come to know about agents who are willing to work at 1% of commission.
                            </span>
                        </div>
                        <div class="sub-points" >
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            So what are you waiting for? Don’t you want to buy your dream home in just 30 days?
                            <br />
                            Then act now!
                            </span>
                        </div>
                        
                        <div class="sub-points" >
                            <span class="img-span">
                                <img src="{{ URL::asset('img/svg2/tick-icon.svg') }}" class="img-tick" >
                            </span>
                            <span class="content-span">
                            Register yourself as a buyer and access thousand agents profile in next 10 minutes.
                            </span>
                        </div>
                        <a data-toggle="modal" data-target="#registrationModal" style="z-index: 99999;" class="cursor btn-special btn btn-color new-btn-design">Learn More</a>
                    </div>

                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div style="position:relative;z-index:10;">
                            <img src="{{ URL::asset('img/agents/agent2.webp') }}" alt="about" width="500">
                        </div>
                        <div class="fake-border-reverse">&nbsp;</div>    
                    </div>
                </div>
                <!-- /Promo -->
            </div>
        </div>

		
    </section>

@endsection
<!-- content end -->