@extends('front.master')

@section('title', 'Home')



<!-- content start -->

@section('content')

<?php  $topmenu='Home'; ?>

@include('front.include.sidebar')

<style>
    input[type=number]::-webkit-inner-spin-button {

        -webkit-appearance: none;

    }

    input[type=number] {

        -moz-appearance: textfield;

    }

    .help-block {
        margin-top: 0px !important;
        margin-bottom: 0px !important;
    }
</style>

<div class="wrapper">
    <section>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
              <h3 id="slidetext"></h3>
              <div class="rt">
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="fa fa-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="fa fa-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
              <div class="carousel-inner">

                <div class="carousel-item active">
                  <img class="d-block w-100" src="{{asset('img/home/bg_image_banner.png')}}" alt="First slide">
                  <div class="carousel-caption">
                    <h5>How fast can you sell ? 3 days or less</h5>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{asset('img/home/bg_image_banner.png')}}" alt="First slide">
                  <div class="carousel-caption">
                    <h5>How fast can you sell ? 3 days or less</h5>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{asset('img/home/bg_image_banner.png')}}" alt="First slide">
                  <div class="carousel-caption">
                    <h5>How fast can you sell ? 3 days or less</h5>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{asset('img/home/bg_image_banner.png')}}" alt="First slide">
                  <div class="carousel-caption">
                    <h5>How fast can you sell ? 3 days or less</h5>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{asset('img/home/bg_image_banner.png')}}" alt="First slide">
                  <div class="carousel-caption">
                    <h5>How fast can you sell ? 3 days or less</h5>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{asset('img/home/bg_image_banner.png')}}" alt="First slide">
                  <div class="carousel-caption">
                    <h5>How fast can you sell ? 3 days or less</h5>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </section>
    <section id="offer">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="d-flex offer">
              <span class="icon-img">
                <img src="./images/Layer 12.png" alt="" srcset="">
              </span>
              <div>
                <h4>what we can offer you</h4>
                <p>Finding the right agent for fastest sale, one who can guarantee</p>
              </div>
            </div>
            <div class="agent_sba">
              <div class="overlay">
                <div class="agent1">
                  <strong><span>seller</span></strong>
                  <p class="text"> Sell your home in 3 days or less</p>
                </div>
              </div>
              <div class="overlay2">
                <div class="agent2">
                  <strong><span>buyer</span></strong>
                  <div>
                    <p class="text"> - Expert agent who helped 50+ buyers this year
                      vs ag agent whose sign you just saw.</p>

                    <p class="text">- An agent who can locate a home to the envy
                      of your friends who can put your interest first</p>

                    <p class="text">- Can you make money while buying your home?</p>

                    <p class="text">- You are buying your most expensive asset.
                      Who will be the best agents for you?</p>

                    <p class="text">- All our services are absolutely free for ever</p>
                  </div>
                  <a href="#" class="text-uppercase">sell now</a>
                </div>
              </div>
              <div class="overlay">
                <div class="agent3">
                  <strong><span>seller</span></strong>
                  <p class="text"> Sell your home in 3 days or less</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="about-us">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="about-us">
              <div class="vertical"></div>
              <span><i class="fa fa-user" aria-hidden="true"></i></span>
            </div>
            <div class="about_text w-50">
              <strong><span class="text-uppercase">about us</span></strong>
              <p>92 agents is an online platform providing people who want to buy or sell properties
                an opportunity to interact with professional real estate agents
                who will help get them the best deals possible</p>
            </div>
            <strong><span class="d-block text-uppercase text-center" style="color: #fff;">we provide all kinds of
                property solutions to</span></strong>

          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="provider">
              <span class="img-span"><img src="./images/144729-200.png" alt="" srcset=""></span>
              <span class="text">sellers</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="provider">
              <span class="img-span"><img src="./images/download.png" alt="" srcset=""></span>
              <span class="text">buyers</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="provider">
              <span class="img-span"><img src="./images/realty-buyer-fl.png" alt="" srcset=""></span>
              <span class="text">agents</span>
            </div>
          </div>
          <a class="read_more" href="#">read more</a>
        </div>
      </div>
    </section>
    <section id="services">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="d-flex offer">
              <span class="icon-img">
                <img src="./images/star.png" alt="" srcset="">
              </span>
              <div>
                <h4>services we provide</h4>
                <p>At 92 Agents we understand the difficulties faced by buyers, sellers and agents in the real estate
                  industry,
                  and it is our mission to provide solutions to those problems. We provide services to 3 types of
                  clients buyers, sellers and agents.</p>
              </div>
            </div>
            <div class="circle_agent">
              <span>SELLER</span>
              <div class="serv_agent_img">
                <img class="img-fluid" src="./images/useragent.png" alt="" srcset="">
              </div>
              <div class="serv_agent_content">
                <h5 style="font-weight: 600;">Hire the top-rated Agents without overpaying</h5>
                <span class="solid"></span>
                <p>Getting in touch to lots of skilled agents for the kind of home you want
                  is just the start. In addition to this, you’ll be able to compare commission
                  rates, services, stats and a whole lot from some of the best agents in your
                  locality. At the end of the day, you’ll not only get the best prices but also
                  exactly the kind of home you want in its best condition.</p>
              </div>
            </div>
            <div class="circle_agent">
              <span>BUYER</span>
              <div class="serv_agent_img">
                <img class="img-fluid" src="./images/useragent.png" alt="" srcset="">
              </div>
              <div class="serv_agent_content">
                <h5 style="font-weight: 600;">Stress-free and smarter way for you to buy your dream home</h5>
                <span class="solid"></span>
                <p>Work wіth уоur 92 Real Eѕtаtе Agents to lеаrn аbоut the hоmе buуіng process
                  and your chosen market. 92 Rеаl Estate Agents lіvе іn уоur соmmunіtу and
                  know it wеll. Thеу'rе experts оn everything from home valuations to school
                  dіѕtrісtѕ аnd will wоrk wіth уоu each ѕtер of the wау tо secure уоur
                  homeownership drеаmѕ.</p>
              </div>
            </div>
            <div class="circle_agent">
              <span>AGENT</span>
              <div class="serv_agent_img">
                <img class="img-fluid" src="./images/useragent.png" alt="" srcset="">
              </div>
              <div class="serv_agent_content">
                <h5 style="font-weight: 600;">Sign Up as an Agent and get more deals in your city</h5>
                <span class="solid"></span>
                <p>Our аgеntѕ еnjоу some оf the hіghеѕt соmmіѕѕіоn rаtеѕ іn thе mаrkеt аnd соntrоl
                  thеіr bооkѕ of buѕіnеѕѕ. Our ѕtrеаmlіnеd ореrаtіоnѕ аllоw us tо reward уоu well
                  wіthоut ѕасrіfісіng customer value. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="choose">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="about-us">
              <div class="vertical"></div>
              <span style="padding: 0.7rem;"><img class="img-fluid" src="./images/why-us-vector-i.png" alt=""
                  srcset=""></span>
            </div>
            <strong><span class="d-block text-uppercase text-center py-3" style="color: #fff">why choose 92
                Agents</span></strong>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="d-flex">
        <div class="seller" style="background-color: #676767;">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="why-choose-list-heading">
                  <strong><span>SELLER</span></strong>
                </div>
                <ol class="why-choose-list">
                  <li>Which agent can market a in 100 different ways or one who just posts just in MLS
                    and forgets you.More exposure, more chances of finding a buyer do you agree ?</li>
                  <li>Can any agent give a guaranteed sale?</li>
                  <li>Tried FSBO, Other agents</li>
                  <li>Agent who can give such a good proposal that you can’t refuse</li>
                  <li>A sweet talking agent vs one who sold more homes that any other</li>
                  <li>What it takes to make the fastest sale?.. A home sitting in the market for 90days
                    looses $$$ every month. Mortgage, Insurance, Utilities, Upkeep</li>
                  <li>All agents are not made the same. Some know about foreclosure, some will do free
                    staging, some will market your blessed home 150+ ways, some will sell real quick
                    only a few can do all. where is that Agent</li>
                  <li>Foreclosure, short sale, scale-up, scale down what ever you need there are good
                    agents out there</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="buyer" style="background-color: #919191;">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="why-choose-list-heading">
                  <strong><span>BUYER</span></strong>
                </div>
                <ol class="why-choose-list">
                  <li>Are you sure that the agent you chose will be able to: Find quality sellers in a short time span?
                  </li>
                  <li> Put your interests above his? Have clear, understandable communication skills
                    and give you frequent updates instead of just ignoring you?</li>
                  <li> analyze a house and find every single disadvantage that a house may
                    have? Understand exactly what you are looking for?</li>
                  <li>Do you know: How the structural build of a house is going to affect you in the long
                    run? How to analyze sellers to determine if they are trustworthy?</li>
                  <li>How to determine if a house is foreclosed or vacant? How to choose the best
                    location for your home in relation to your work, schools, and other important places?</li>
                  <li>What the state of the market is at certain times and how that affects your situation?</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a class="read_more text-center d-block my-3" href="#">SIGN UP</a>
    </section>
    <section id="team">
      <div class="container">
        <div class="row">
          <div class="d-flex offer">
            <span class="icon-img">
              <img src="./images/user9.png" alt="" srcset="">
            </span>
            <div>
              <h4>OUR AGENTS</h4>
              <p>We regularly updates on our Agents. Feel free to join with our Agents!</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
             <div class="d-flex">
              <div class="team mt-4">
                <img src="./images/agent_1.PNG" alt="" srcset="">
                <span class="team_role">FORECLOSURE EXPERTS</span>
              </div>
            <!-- </div> -->
            <!-- <div class="col-md-4"> -->
              <div class="team mt-2">
                <img src="./images/agent_2.PNG" alt="" srcset="">
                <span class="team_role" style="background: rgba(116, 197, 44, 1);">AGENT QUALITY NO. 2</span>
              </div>
            <!-- </div> -->
            <!-- <div class="col-md-4"> -->
              <div class="team">
                <img src="./images/agent_3.PNG" alt="" srcset="">
                <span class="team_role">AGENT QUALITY NO. 3</span>
              </div>
             </div>
          </div>
        </div>
      </div>
    </section>
    <section id="testimonial">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="about-us">
              <div class="vertical"></div>
              <span class="quote"><i class="fa fa-quote-right" aria-hidden="true"></i></span>
              <p style="margin-left: 50px; color:#fff">PEOPLE TALKING ABOUT US</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
           <div class="testimonial d-flex">
            <div>
              <img src="./images/testimonial.png" alt="">
            </div>
            <div class="test_content">
              <span>Testimonial client 1</span>
              <span>-ABC</span>
            </div>
           </div>
          </div>
          <div class="col-md-4">
           <div class="testimonial d-flex">
            <div>
              <img src="./images/testimonial.png" alt="">
            </div>
            <div class="test_content">
              <span>Testimonial client 2</span>
              <span>-XYZ</span>
            </div>
           </div>
          </div>
          <div class="col-md-4">
           <div class="testimonial d-flex">
            <div>
              <img src="./images/testimonial.png" alt="">
            </div>
            <div class="test_content">
              <span>Testimonial client 3</span>
              <span>-DFG</span>
            </div>
           </div>
          </div>
        </div>
      </div>
    </section>
    <section id="newsletter">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="sign_up position-relative">
              <div class="position-absolute w-75 newss">
                  <p class="text-uppercase" style="color: #fff;">Found a reason to work with us?
                    <span class="d-block">Let's start!</span></p>
                    <a class="read_more text-center d-block my-3" style="border: none;" href="#">SIGN UP</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>



  <script>
    var total = $('.carousel-item').length;
    var currentIndex = $('div.active').index() + 1;
    $('#slidetext').html(currentIndex + '/' + total);

    // This triggers after each slide change
    $('.carousel').on('slid.bs.carousel', function () {
      currentIndex = $('div.active').index() + 1;

      // Now display this wherever you want
      var text = currentIndex + '/' + total;
      $('#slidetext').html(text);
    });
  </script>
 @endsection

<!-- content end -->
