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

.help-block{
    margin-top: 0px !important;
    margin-bottom: 0px !important;
}

</style>

	<!-- Main Section -->

    <section id="main">

        <!-- Slider -->

        <div class="fullwidthbanner-container tp-banner-container">

            <div class="fullwidthbanner rslider tp-banner">

                <ul>

                    <!-- THE FIRST SLIDE -->

                    <li data-transition="fade" data-slotamount="7" data-masterspeed="0" data-thumb="" data-delay="10000"  data-saveperformance="on">

                        <!-- MAIN IMAGE -->

                        <img
                        src="{{ URL::asset('front/img/dummy.png') }}"
                        alt="laptopmockup_sliderdy"
                        data-lazyload="{{ URL::asset('front/img/slider/slider4.png') }}"
                        data-bgposition="right top"
                        data-kenburns="on"
                        data-duration="12000"
                        {{-- data-ease="Power0.easeInOut"  --}}
                        data-bgfit="115" data-bgfitend="100"
                        data-bgpositionend="center bottom">

                        <!-- LAYER NR. 1 -->

                        <div class="tp-caption customin fadeout rs-parallaxlevel-10"

                            data-x="783"

                            data-y="146"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="2700"

                            data-easing="Power3.easeInOut"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 2;"><img src="{{ URL::asset('front/img/dummy.png') }}" alt="" data-lazyload="{{ URL::asset('front/img/redbg_big.png') }} ">

                        </div>

                        <!-- LAYER NR. 2 -->

                        <div class="tp-caption light_heavy_50 customin fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="797"

                            data-y="154"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="2850"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;">92agent

                        </div>

                        <!-- LAYER NR. 3 -->

                        <div class="tp-caption black_heavy_70 skewfromleftshort fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="550"

                            data-y="83"

                            data-speed="500"

                            data-start="2400"

                            data-easing="Power3.easeInOut"

                            data-splitin="chars"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;">Multipurpose

                        </div>

                        <!-- LAYER NR. 4 -->

                        <div class="tp-caption black_bold_40 skewfromrightshort fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="900"

                            data-y="232"

                            data-speed="500"

                            data-start="3200"

                            data-easing="Power3.easeInOut"

                            data-splitin="chars"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 5; max-width: auto; max-height: auto; white-space: nowrap;">Real Estate

                        </div>

                        <!-- LAYER NR. 5 -->

                        <div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="933"

                            data-y="300"

                            data-speed="300"

                            data-start="4000"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;">Seller

                        </div>

                        <!-- LAYER NR. 6 -->

                        <div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="902"

                            data-y="300"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="4000"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 7; max-width: auto; max-height: auto; white-space: nowrap;">&nbsp;

                        </div>

                        <!-- LAYER NR. 7 -->

                        <div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"

                            data-x="911"

                            data-y="306"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="4200"

                            data-easing="Power3.easeInOut"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 8;"><img src="{{ URL::asset('front/img/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ URL::asset('front/img/check.png') }}">

                        </div>

                        <!-- LAYER NR. 8 -->

                       <div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="933"

                            data-y="340"

                            data-speed="300"

                            data-start="4500"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;">Buyer

                        </div>

                        <!-- LAYER NR. 9 -->

                       <div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="902"

                            data-y="340"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="4500"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 10; max-width: auto; max-height: auto; white-space: nowrap;">&nbsp;

                        </div>

                        <!-- LAYER NR. 10 -->

                        <div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"

                            data-x="911"

                            data-y="347"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="4700"

                            data-easing="Power3.easeInOut"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 11;"><img src="{{ URL::asset('front/img/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ URL::asset('front/img/check.png') }}">

                        </div>

                        <!-- LAYER NR. 11 -->

                        <div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="933"

                            data-y="380"

                            data-speed="300"

                            data-start="5000"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 12; max-width: auto; max-height: auto; white-space: nowrap;">Agent

                        </div>

                        <!-- LAYER NR. 12 -->

                        <div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="902"

                            data-y="380"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="5000"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 13; max-width: auto; max-height: auto; white-space: nowrap;">&nbsp;

                        </div>

                        <!-- LAYER NR. 13 -->

                        <div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"

                            data-x="911"

                            data-y="386"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="5200"

                            data-easing="Power3.easeInOut"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 14;"><img src="{{ URL::asset('front/img/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ URL::asset('front/img/check.png') }}">

                        </div>

                    </li>

                    <!-- /THE FIRST SLIDE -->



                    <!-- /THE Seconde SLIDE -->

                    <li data-transition="fade" data-slotamount="1" data-masterspeed="300">

                        <img src="{{ URL::asset('front/img/slider/slider-6.png') }}" data-fullwidthcentering="on" alt="">

                        <div class="caption large_text sft"

                            data-x="10"

                            data-y="54"

                            data-speed="300"

                            data-start="800"

                            data-easing="easeOutExpo"  >Are you facing difficulty to find </div>

                        <div class="caption large_text sfr"

                            data-x="10"

                            data-y="100"

                            data-speed="300"

                            data-start="1100"

                            data-easing="easeOutExpo"  >dream home</div>

                        <!-- LAYER NR. 5 1 -->

                        <div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="40"

                            data-y="220"

                            data-speed="300"

                            data-start="1000"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;">Unique clients

                        </div>

                        <!-- LAYER NR. 6 1 -->

                        <div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="10"

                            data-y="220"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="1200"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 7; max-width: auto; max-height: auto; white-space: nowrap;">&nbsp;

                        </div>

                        <!-- LAYER NR. 7 1 -->

                        <div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"

                            data-x="18"

                            data-y="232"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="1500"

                            data-easing="Power3.easeInOut"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 8;"><img src="{{ URL::asset('front/img/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ URL::asset('front/img/check.png') }}">

                        </div>

                        <!-- LAYER NR. 5 1 -->

                        <div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="40"

                            data-y="260"

                            data-speed="300"

                            data-start="1500"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;">Professional real estate agents.

                        </div>

                        <!-- LAYER NR. 6 1 -->

                        <div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="10"

                            data-y="260"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="1700"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 7; max-width: auto; max-height: auto; white-space: nowrap;">&nbsp;

                        </div>

                        <!-- LAYER NR. 7 1 -->

                       <div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"

                            data-x="18"

                            data-y="272"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="2000"

                            data-easing="Power3.easeInOut"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 8;"><img src="{{ URL::asset('front/img/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ URL::asset('front/img/check.png') }}">

                        </div>

                        <!-- LAYER NR. 5 -->

                        <div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="40"

                            data-y="300"

                            data-speed="300"

                            data-start="2000"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;">Find agents ,buyers or sellers easily.

                        </div>

                        <!-- LAYER NR. 6 -->

                       <div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="10"

                            data-y="300"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="2000"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 7; max-width: auto; max-height: auto; white-space: nowrap;">&nbsp;

                        </div>

                        <!-- LAYER NR. 7 -->

                        <div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"

                            data-x="18"

                            data-y="306"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="2200"

                            data-easing="Power3.easeInOut"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 8;"><img src="{{ URL::asset('front/img/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ URL::asset('front/img/check.png') }}">

                        </div>

                        <!-- LAYER NR. 8 -->

                        <div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="40"

                            data-y="340"

                            data-speed="300"

                            data-start="2500"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;">92 agents provide solutions to buyers and sellers.

                        </div>

                        <!-- LAYER NR. 9 -->

                        <div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="10"

                            data-y="340"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="2500"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 10; max-width: auto; max-height: auto; white-space: nowrap;">&nbsp;

                        </div>

                        <!-- LAYER NR. 10 -->

                        <div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"

                            data-x="18"

                            data-y="347"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="2700"

                            data-easing="Power3.easeInOut"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 11;"><img src="{{ URL::asset('front/img/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ URL::asset('front/img/check.png') }}">

                        </div>

                        <!-- LAYER NR. 11 -->

                        <div class="tp-caption black_bold_bg_20 sfr fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="40"

                            data-y="380"

                            data-speed="300"

                            data-start="3000"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 12; max-width: auto; max-height: auto; white-space: nowrap;">92 Agents works only with top Agents in the Real Estate market.

                        </div>

                        <!-- LAYER NR. 12 -->

                        <div class="tp-caption greenbox30 customin fadeout tp-resizeme rs-parallaxlevel-10"

                            data-x="10"

                            data-y="380"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="3000"

                            data-easing="Power3.easeInOut"

                            data-splitin="none"

                            data-splitout="none"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 13; max-width: auto; max-height: auto; white-space: nowrap;">&nbsp;

                        </div>

                        <!-- LAYER NR. 13 -->

                        <div class="tp-caption arrowicon customin fadeout rs-parallaxlevel-10"

                            data-x="18"

                            data-y="386"

                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                            data-speed="300"

                            data-start="3200"

                            data-easing="Power3.easeInOut"

                            data-elementdelay="0.1"

                            data-endelementdelay="0.1"

                            data-endspeed="300"

                            style="z-index: 14;"><img src="{{ URL::asset('front/img/dummy.png') }}" alt="" data-ww="17" data-hh="17" data-lazyload="{{ URL::asset('front/img/check.png') }}">

                        </div>

                        <div class="caption lfl"

                            data-x="500"

                            data-y="290"

                            data-speed="300"

                            data-start="1600"

                            data-easing="easeOutExpo">

                             <a data-toggle="modal" data-target="#registrationModal" style="z-index: 99999;" class="cursor btn-special btn btn-color">Sign Up</a>

                            <!-- <img src="{{ URL::asset('front/img/slider/responsive-iphone.png') }}" alt="iPhone Responsive"> -->

                        </div>

                    </li>

                    <!-- THE RESPONSIVE SLIDE -->

                    <!-- /THE Thirde SLIDE -->

                    <li data-transition="fade" data-slotamount="1" data-masterspeed="300">

                        <img src="{{ URL::asset('front/img/slider/slider-5.png') }}" data-fullwidthcentering="off" alt="">

                        <div class="caption large_text sft"

                            data-x="10"

                            data-y="10"

                            data-speed="300"

                            data-start="800"

                            data-easing="easeOutExpo"  >Find your dream house</div>

                        <div class="caption large_text sfr"

                            data-x="370"

                            data-y="70"

                            data-speed="300"

                            data-start="1100"

                            data-easing="easeOutExpo"  >with us</div>

                        <!-- LAYER NR. 5 1 -->

                        <div style="z-index: 99999;" class="caption lfl"

                            data-x="472"

                            data-y="386"

                            data-speed="300"

                            data-start="1600"

                            data-easing="easeOutExpo">

                             <a data-toggle="modal" data-target="#registrationModal"  class="cursor btn-special btn btn-color">Sign Up</a>

                            <!-- <img src="{{ URL::asset('front/img/slider/responsive-iphone.png') }}" alt="iPhone Responsive"> -->

                        </div>

                    </li>

                </ul>

            </div>

        </div>

        <!-- /Slider -->

        <!-- Main Content -->

        <div class="main-content">

            <div class="container">

                <div class="row">

                    <div class="col-lg-4 col-md-4 col-sm-4 wow fadeIn">

                        <div class="content-box big ch-item bottom-pad-small myFavBoxShadow">

                            <div class="ch-info-wrap">

                                <div class="ch-info">

                                    <div class="ch-info-front ch-img-1"><i class=""> <img src="{{ URL::asset('front/img/seller.png') }}"> </i></div>

                                    <div class="ch-info-back">

                                        <i class="fa fa-rocket"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="content-box-info">

                                <h3>Wants to sell your home in 1% commission?  </h3>

                                <p>

                                   92 Agents assist home-based sellers in saving their money also! When agents compete on our structure for home sellers they would present the most adequately contested commission rates, services and more.
                                   <br>
                                </p>

                                <a class="nesusersignup cursor border-round-btn" data-target="modalseller"> Sell Now <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>

                            </div>



                        </div>

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 wow fadeIn">

                        <div class="content-box big ch-item bottom-pad-small myFavBoxShadow">

                            <div class="ch-info-wrap">

                                <div class="ch-info">

                                    <div class="ch-info-front ch-img-1"><i class=""><img src="{{ URL::asset('front/img/buyer.png') }}"></i></div>

                                    <div class="ch-info-back">

                                        <i class="fa fa-check"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="content-box-info">

                                <h3>Find your dream home only in less then 1 month!</h3>

                                <p>

                                    Having an agent on ground, the ability to tour open houses and offers are now easier and quicker respectively.<br> Don't be found wanting due to the fact that you waited to find an agent.
                                    <br>

                                </p>

                                <a class="nesusersignup cursor border-round-btn" data-target="modalbuyer"> Buy Now <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>

                            </div>



                        </div>

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 wow fadeIn">

                        <div class="content-box big ch-item myFavBoxShadow">

                            <div class="ch-info-wrap">

                                <div class="ch-info">

                                    <div class="ch-info-front ch-img-1"><i class=""><img src="{{ URL::asset('front/img/agent.png') }}"></i></div>

                                    <div class="ch-info-back">

                                        <i class="fa fa-tags"></i>

                                    </div>

                                </div>

                            </div>

                            <div class="content-box-info">

                                <h3>Sign Up as an Agent and get more deals in your city.</h3>

                                <p>

                                    Sign up as an agent today and instantly get the opportunity to find buyers and sellers in your city. Communicate with them and secure your first deal even in a few days. As an agent, you can get in contact with multiple buyers and sellers.

                                </p>

                                <a class="nesusersignup cursor border-round-btn" data-target="modalagent"> Signup Now <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>

                            </div>



                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- /Main Content -->

        <!-- Services -->

        <div id="" class="services margin-top5">

                <div class="container">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="padding-top40 text-center">

                                <h2 class="green-color wow fadeIn">We Provide Services</h2>

                                <p class="service-width wow fadeInRight">

                                    Are you facing difficulty finding your dream home? Have you been trying to sell your home on your own but failed to do so? Is your home on the market but you have been getting really low offers?

                                    92 Agent is an online platform providing people who want to buy or sell properties an opportunity to interact with professional real estate agents who will help get them the best deals possible.

                                    92 Agents provide their services to 3 types of clients; Buyers, Sellers, and Agents.

                                    Here are some common problems faced by Buyers, Sellers, and Agents respectively



                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-4 col-md-4 col-sm-4 text-center wow fadeInLeft">

                            <div class="service-box padding-top30 padding-bottom40">

                                <div class="service-box-icon">

                                    <a ><img alt="Web Design" src="{{ URL::asset('front/img/seller-icon.png') }}"></a>

                                </div>

                                <div class="service-box-info">

                                    <a >

                                        <h3 class="service-tittle padding-top25">Seller</h3>

                                    </a>

                                    <p>

                                        Evaluate commissions, services, stats and a whole lot from some of the best agents in your locality. By going through proposals made for you, you would be able to ascertain that you are in for an excellent agent as well as a perfect deal.

                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 text-center wow fadeInUp">

                            <div class="service-box padding-top30 padding-bottom40">

                                <div class="service-box-icon">

                                    <a ><img alt="Email Marketing" src="{{ URL::asset('front/img/buyer-icon.png') }}"></a>

                                </div>

                                <div class="service-box-info">

                                    <a >

                                        <h3 class="service-tittle padding-top25">Buyer</h3>

                                    </a>

                                    <p>

                                        Work w??th ????ur 92 Real E??t??t?? Agents to l????rn ??b??ut the h??m?? bu????ng process and your chosen market. 92 R????l Estate Agents l??v?? ??n ????ur ????mmun??t?? and kn??w it w??ll. Th????'r?? experts ??n everything from home valuations to school d????tr????t?? ??nd will w??rk w??th ????u each ??t???? of the w???? t?? secure ????ur homeownership dr????m??.

                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 text-center wow fadeInRight">

                            <div class="service-box padding-top30 padding-bottom40">

                                <div class="service-box-icon">

                                    <a ><img alt="Corportate Solutions" src="{{ URL::asset('front/img/agent-icon.png') }}"></a>

                                </div>

                                <div class="service-box-info">

                                    <a >

                                        <h3 class="service-tittle padding-top25">Agents</h3>

                                    </a>

                                    <p>

                                        Our ??g??nt?? ??nj???? some ??f the h??gh????t ????mm??????????n r??t???? ??n th?? m??rk??t ??nd ????ntr??l th????r b????k?? of bu????n??????. Our ??tr????ml??n??d ??????r??t????n?? ??ll??w us t?? reward ????u well w??th??ut ??????r??f??????ng customer value.

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

        </div>

        <!-- /services -->



        <!-- Main Content-->

        <div class="content-about margin-top80">

            <div class="container">

                <div class="row">

                    <!-- Left Section -->

                    <div class="posts-block col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <img src="{{ URL::asset('front/img/happy-customer.png') }}" alt="about">

                    </div>

                    <!-- /Left Section -->

                    <!-- welcome Section -->

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <h2 style="margin-top: -8px;">Some Word About 92Agent</h2>

                        <p>It's ??ur mission t?? d??l??v??r best-in-class br??k??r??g???? ????rv???????? t?? ??ur bu????r?? and sellers w??rldw??d?? </p>

                        <div class="content-box-about ch-item">

                            <div class="content-box-about-icon">

                                <div class="ch-info">

                                    <div class="ch-info-front ch-img-1"><img src="{{ URL::asset('front/img/seller.png') }}"></div>

                                </div>

                            </div>

                            <div class="content-box-about-info padding-top22">

                                <h4 class="margin0">Hire the top-rated Agents without overpaying</h4>



                            </div>

                        </div>

                        <div class="content-box-about ch-item">

                            <div class="content-box-about-icon">

                                <div class="ch-info">

                                    <div class="ch-info-front ch-img-1"><img src="{{ URL::asset('front/img/buyer.png') }}"></div>

                                </div>

                            </div>

                            <div class="content-box-about-info padding-top22">

                                <h4 class="margin0">Stress-free and smarter way for you to buy your dream home</h4>



                            </div>

                        </div>

                        <div class="content-box-about ch-item">

                            <div class="content-box-about-icon">

                                <div class="ch-info">

                                    <div class="ch-info-front ch-img-1"><img src="{{ URL::asset('front/img/agent.png') }}"></div>

                                </div>

                            </div>

                            <div class="content-box-about-info padding-top22">

                                <h4 class="margin0">Sign Up as an Agent and get more delals in your city</h4>



                            </div>

                        </div>

                    </div>

                    <!-- /welcome Section -->

                </div>

            </div>

        </div>

        <!-- /Main Content-->

        <!-- Star-->

        <div class="star">

            <div class="container">

                <div class="row text-center">

                    <div class="col-md-6 col-md-offset-3">

                        <div class="star-divider">

                            <div class="star-divider-icon">

                                <i class=" fa fa-star"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- /Star-->





        <!-- choose-us -->

        <div class="choose-us container">



            <div class="row">
 <h2 class="text-center">Why Choose 92 Agent</h2>
                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">



                    <!-- accordin -->

                    <div class="accordionMod panel-group">

                        <div class="accordion-item">

                            <h4 class="accordion-toggle">Want to Sell Your Home on only 1% Commission?</h4>

                            <section class="accordion-inner panel-body">

                                <p class="margin0">

                                    Selling a h??m?? t??d???? r????u??r???? ??k??ll ??nd expertise.

                                </p>

                                <p class="margin0">

                                    Most m??rk??t?? changed ????gn??f??????ntl?? during th?? l????t ????v??r??l years, ??nd th????'r?? ??h??ng??ng ??g????n. Y??u need t???? r????r??????nt??t????n t?? n??v??g??t?? t??d????'?? r????l ????t??t?? opportunities ??nd ??h??ll??ng????. A lot ??f  S??ll??r?? ??r?? f??????d with ??r??bl??m?? ??u??h as:

                                </p>

                                <ul>

                                    <li> N?? ????l??.</li>

                                    <li> L??w ??ff??r.</li>

                                    <li> No ??ff??r?? or ??n??u??r?????? ??r v??????t th????r h??m??. </li>

                                    <li> H??w t?? ?????? ????mm??????????n to th?? ??g??nt wh????h ???? a 3%+3%? </li>

                                    <li> H??w can I f??nd th?? b????t ??g??nt? </li>

                                    <li> Wh?? ???? th?? best ??g??nt wh?? ????n m??rk??t my ??r??????rt?? th?? best? </li>

                                    <li> Don't h??v?? money t?? f??x u?? th?? h??m?? f??r marketing. </li>

                                    <li> Th?? home w???? ??n th?? market f??r 90 d?????? on th?? listing ??x????r??d.</li>

                                    <li> I tr????d selling my own but didn't ????n ??ut.</li>

                                </ul>



                                <p class="margin0">

                                    S??ll??ng ???? a d??unt??ng t????k for any homeowner. It ??nv??lv???? ??r??????ng th?? house, d??t??rm??n??ng wh??th??r a buyer ???? ??u??l??f????d, creating ??nd ????????ng f??r advertising, ??h??w??ng th?? h??m?? t?? prospective bu????r??, und??r??t??nd??ng

                                    r????l ????t??t?? regulations, b????ng available wh??n??v??r a ????t??nt????l bu????r w??nt?? t?? view the ??r??????rt??, n??g??t????t??ng ??nd ??r??????r??ng ????ntr????t??, ??nd ??????rd??n??t??ng th?? d??t????l?? ??f a ??l??????ng.

                                    <br>It's n?? ??ur??r?????? th??t h??m???? sold b?? real ????t??t?? agents sell faster, m??r?? ??ff????????ntl??, ??nd f??r more m??n????.



                                    You d??n't n????d t?? worry any l??ng??r, 92 ??g??nt?? know your market, and is keen ??n h??m?? valuations, ????m????r??bl?? ????l????, and n??g??t????t????n??, ???? w??ll as m??rk??t??ng ??nd home staging. W??rk??ng t??g??th??r, ????u can ??l?????? ????ur home ??n th?? best light, and at th?? r??ght ??r??????, that w??ll have ????u ??????k??ng f??r your n??w home.
                                    <hr>
                                     <p>
                                         <a href="#" style="font-weight: 700;" data-toggle='modal' data-target='#registrationModal'>Cl????k h??r?? t?? ????gn up ??nd ????v?? money. <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> </a>
                                     </p>




                                </p>

                            </section>

                        </div>

                        <div class="accordion-item">

                            <h4 class="accordion-toggle">Find your dream home only in less then 1 month!</h4>

                            <section class="accordion-inner panel-body">

                                <p class="margin0">

                                    Bu????ng a h??m?? ???? l??k??l?? th?? m????t substantial ??nv????tm??nt ????u'll ever m??k??.



                                    Th?? process ????n be complicated ??? nothing th???? b??g ??r this ??m????rt??nt ???? often ???????? ??? ????t th?? r??w??rd?? ??r?? ??mm??n????. B??????nd financial appeal, ????ur home ???? ????ur ????n??tu??r??; ??t'?? wh??r?? life h????????n??, where ????u r???????? your f??m??l??, dr????m ??nd bu??ld f??r th?? futur??. Bu????r?? ??ft??n ??n????unt??r challenges such as th?????? in th????r quest f??r g????d h??m????:-

                                </p>

                                <ul>

                                    <li>How to ?????? ????mm??????????n 3%+3% </li>

                                    <li>How can I f??nd th?? r??ght ??g??nt?</li>

                                    <li>H??w can I f??nd foreclosed h??m????? </li>

                                    <li>H??w can I find th?? b????t d????l?? ??n th?? market? </li>

                                    <li>Wh?? ???? the b????t agent wh?? ????n ??h??w me th?? b????t possible homes? </li>

                                    <li> Wh?? ???? th?? ??g??nt who ????n charge me th?? l??????t ????mm??????????n? </li>

                                </ul>

                                <p class="margin0">

                                    Decisions l??k?? this shouldn't be left t?? f??t??. <br>

                                    Work w??th ????ur 92 Real E??t??t?? Agents to l????rn ??b??ut the h??m?? bu????ng process and your chosen market. 92 R????l Estate Agents l??v?? ??n ????ur ????mmun??t?? and kn??w it w??ll. Th????'r?? experts ??n everything from home valuations to school d????tr????t?? ??nd will w??rk w??th ????u each ??t???? of the w???? t?? secure ????ur homeownership dr????m??. <br>

                                    Let th?? conversation ??t??rt here, w??th 92 R????l Estate Ag??nt??. <br>

                                    S????r??h??ng for a specific ????mmun??t?? or neighborhood?
                                    <hr>
                                    <p>
                                     <a href="#" style="font-weight: 700;" data-toggle='modal' data-target='#registrationModal'>Cl????k h??r?? t?? sign up ??nd ????v?? ????ur????lf the Str??????. <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> </a>
                                    </p>



                                </p>

                            </section>

                        </div>

                        <div class="accordion-item">

                            <h4 class="accordion-toggle">Sign Up as an Agent and get more deals in your city.</h4>

                            <section class="accordion-inner panel-body">

                                <p class="margin0">

                                    Ar?? ????u a w??ll tr????n??d ??nd ??x????r????n????d Ag??nt, but f??????d with th?? reality ??f:-

                                </p>

                                <ul>

                                    <li> H??w ????n I find a buyer ??r ????ll??r? </li>

                                    <li> Wh??t is th?? ??h??????????t w???? t?? m??rk??t m??? </li>

                                    <li> H??w can I ????nt????t a bu????r ??r ????ll??r? </li>

                                    <li> How ????n I m??rk??t my services affordable? </li>

                                </ul>

                                <p class="margin0">

                                    W??rr?? no m??r??, we are ??ll r????d?? to help ????u get th?? d??????r??d d????l??

                                    A?? a 92 Ag??nt, ????u will???

                                    E??rn gr????t??r rewards f??r bu??ld??ng relationships.

                                    Our ??g??nt?? ??nj???? some ??f the h??gh????t ????mm??????????n r??t???? ??n th?? m??rk??t ??nd ????ntr??l th????r b????k?? of bu????n??????. Our ??tr????ml??n??d ??????r??t????n?? ??ll??w us t?? reward ????u well w??th??ut ??????r??f??????ng customer value.

                                    Save your ??l????nt?? m??r?? money.

                                    Our policies ??r?? issued ??n St??nd??rd C??m??r??h??n????v?? ISO Forms. Our h??m????wn??r'?? insurance ????l?????????? ??r?? set w??th ????m????t??t??v?? r??t????, not JUA r??t????.

                                    R????????v?? th?? r??????????t ????u deserve.

                                    In a ????m????t??t??v?? m??rk??t, w?? w??l????m?? useful ??g??nt?? w??th ??????n ??rm??. W?? look forward t?? ????ur success and w??ll ????l??br??t?? it w??th you!

                                    Interested?  B??????m?? ??n Ag??nt.
                                    <hr>
                                    <p>
                                        <a href="#" style="font-weight: 700;" data-toggle='modal' data-target='#registrationModal'>S??gn up ??nd g??t m??r?? d????l??. <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> </a>
                                    </p>


                                </p>

                            </section>

                        </div>

                        <div class="accordion-item">

                            <h4 class="accordion-toggle">What makes 92 Agents the leading platform providing real estate solutions</h4>

                            <section class="accordion-inner panel-body">

                                <p class="margin0">

                                   Here are a few our traits that put us above other websites:

                                </p>

                                <ul>

                                    <li>No other website allows buyers and sellers to actively interact with agents in order to select the one agent that they feel best to work with.</li>

                                    <li>Unlike other websites, 92 Agents works only with top Agents in the Real Estate market and so you are assured of getting the best results when you work with any of our listed agents. </li>

                                    <li>Using our system is easy and straightforward and it doesn't include any additional cost which is not stated. </li>

                                    <li>Unlike other websites which allows you to negotiate with random agents, 92 Agents allows you to personally negotiate rates with only trusted agents.</li>

                                    <li>Other websites may share/give your contact details without your permission. 92 Agents allows only you to determine when you will share your contact details.</li>

                                    <li>Other websites can connect you with agents who will offer you limited services at a discounted rate, but with 92 Agents you get full services from our agents without overpaying. </li>

                                    <li>Some other websites may just connect you with agents without any form of follow up so you can get the best services and sell or buy your house quickly. But our 92 Agent advisors, you can get a free professional consultation with regards to the process.</li>

                                    <li>With 92 Agents you are provided with many tools that will help you narrow down and quickly get you, agents, to buy or sell your property. Like the importance list which is made as sellers and buyer select agents based on a list of qualifications, for example; agents who charge the least commissions, agents who can guarantee sale in the fastest possible time, a way for your questions to be answered, a rating system for agents which will help you can make a side-by-side comparison and enable you to choose the best agent for you. And like earlier mentioned you are provided with a messaging system for communication between agents and different buyers or sellers.</li>

                                </ul>

                            </section>

                        </div>



                    </div>

                    <!-- /accordin -->

                </div>

                <div class="posts-block col-lg-4 col-md-4 col-sm-6 col-xs-12">

                    <div class="skills-wrap">

                       <img src="{{ URL::asset('front/img/whychooseus.png') }}" alt="about" style="float:right">

                    </div>

                </div>

            </div>

        </div>

        <!-- /choose-us -->



        <!-- BENEFIT -->

        <div class="BENEFIT margin-top80">

                <div class="container">

                    <div class="row">

                        <div class="padding-top40 col-lg-12 col-md-12 text-center">

                            <h2 class="light wow fadeIn">BENEFIT OF USING 92 AGENT</h2>

                            <p class="width">At this point, the Agent gets the contact information of the buyer or seller who is trying to hire him. Once this happens the Agent reaches out to the buyer or seller and signs a physical contract and moves forward with marketing the seller's property or finding buyers their dream home. </p>

                        </div>

                    </div>

                    <div class="row padding-bottom40 ">

                        <div class="padding-top25 light wow fadeInRight">

                            <ul class="benefit-ul">

                            <li>We allow buyers and sellers to post what they Want, search for agents and communicate with them.</li>

                            <li>Agents, in turn, get to search for buy and sell posts and contact buyers and sellers.</li>

                            <li>Sellers and buyers get to contact as many agents as they want and choose one agent who best meets their requirements based on qualifications, commissions paid and time guarantee of service delivery.</li>

                            <li>Buyers and sellers make a list of what's important to them and post on their dashboard. We will then ensure this information gets published to agents. From these posts, agents can raise questions and also answer any questions asked by buyers or sellers.</li>

                            <li>Buyers and sellers get to rate the contributions by agents in answering questions and general communication. These ratings together with agent experience in buying and selling properties is used in building an agent's qualification which buyers and sellers use in making side by side comparison thereby choosing the best most qualified agent to represent them.</li>

                        </div>

                    </div>

                </div>

        </div>

        <!-- BENEFIT -->



        <!-- Latest Posts -->

        @if($agents['count'] > 0)

        <div id="latest-posts" class="margin-top80">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12 col-md-12 text-center">

                        <h2 class="wow fadeIn">Latest Agents</h2>

                        <h4 class="wow fadeInRight">We regularly updates on our Agents. Feel free to join with our Agents!</h4>

                    </div>

                </div>

                <div class="row">

                    <div class="padding-top40">

                        @foreach($agents['result'] as $agent)



                            <!-- post item -->

                            <div class="col-lg-3 col-md-3 col-sm-6 post-item wow fadeInUp">

                                <div class="post-img">

                                    <a class="cursor registrationModalclick">

                                            @if($agent->photo)

                                            <img class="" width="262" height="262" src="{{ URL::asset('assets/img/profile/'.$agent->photo) }}" alt="">

                                            @else

                                            <img class="" width="262" height="262" src="{{ URL::asset('assets/img/testimonials/user.jpg') }}" alt="">

                                            @endif

                                    </a>

                                </div>

                                <div class="post-content blog-post-content">

                                    <h4><a  class="cursor registrationModalclick">{{ $agent->name }}</a></h4>

                                    <p><i class="fa fa-map-marker"></i> {{ $agent->state_name }}</p>

                                    <div class="hidetext3line">

                                        {!! $agent->description != null ? $agent->description : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' !!}

                                    </div>

                                </div>

                                <div class="meta post-meta">

                                    <div class="post-date post-meta-content">

                                        <i title="{{ date('M d, Y',strtotime($agent->created_at)) }}" class="fa fa-clock-o"></i> {{ date('M d, Y',strtotime($agent->created_at)) }}

                                    </div>

                                    <div class="post-comment post-meta-content">

                                        <a title="years of expreience" class="cursor registrationModalclick" >Ex: {{ $agent->years_of_expreience != null ? $agent->years_of_expreience : '0' }}</a>

                                    </div>

                                </div>

                            </div>

                            <!-- /post item -->

                        @endforeach



                    </div>

                </div>

            </div>

        </div>

        @endif

        <!-- /Latest Posts -->



         <!-- Slogan -->

        <div class="slogan margin-top80">

                <div class="container">

                    <div class="row">

                        <div class="slogan-content">

                            <div class="col-lg-12 col-md-12 wow fadeInLeft">

                                <div class="center"><h2 class="slogan-title">Found a reason to work with us? Lets's start!</h2><a data-toggle="modal" data-target="#registrationModal" class="cursor btn-special btn-grey my-box-shadow">Sign Up</a></div>

                            </div>

                            <!--<div class="col-lg-2 col-md-2 wow fadeInRight">

                                <div class="get-started">



                                </div>

                            </div>-->

                            <div class="clearfix"></div>

                        </div>

                    </div>

                </div>



        </div>

        <!-- Slogan -->

        <!-- Tab & Testimonials Widget -->
<div class="our-client">
        <div class="container bottom-pad-small">

            <div class="row">

                <div class="col-lg-12 col-md-12 text-center">

                    <h2 class="wow fadeIn">Whats our clients think</h2>

                    <h4 class="wow fadeInRight tagline">We regularly post updates on our blog. Feel free to join with our blog!</h4>

                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">



                        <div class="testimonials widget">

                            <div id="client-carousel" class="client-carousel carousel slide">

                                <div class="carousel-inner">

                                    <div class="item active">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                            <div class="testimonial item">

                                                <p>

                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type.

                                                </p>

                                                <div class="testimonials-arrow">

                                                </div>

                                                <div class="author">

                                                    <div class="testimonial-image "><img alt="" src="{{ URL::asset('front/img/testimonial/team-member-1.jpg') }}"></div>

                                                    <div class="testimonial-author-info">

                                                        <a ><span class="color">Monica Sing</span></a> FIFO Themes

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="item">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                            <div class="testimonial item">

                                                <p>

                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type.

                                                </p>

                                                <div class="testimonials-arrow">

                                                </div>

                                                <div class="author">

                                                    <div class="testimonial-image "><img alt="" src="{{ URL::asset('front/img/testimonial/team-member-2.jpg') }}"></div>

                                                    <div class="testimonial-author-info">

                                                        <a ><span class="color">Monzurul Haque</span></a> FIFO Themes

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="item">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                            <div class="testimonial item">

                                                <p>

                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type.

                                                </p>

                                                <div class="testimonials-arrow">

                                                </div>

                                                <div class="author">

                                                    <div class="testimonial-image "><img alt="" src="{{ URL::asset('front/img/testimonial/team-member-3.jpg') }}"></div>

                                                    <div class="testimonial-author-info">

                                                        <a ><span class="color">Carol Johansen</span></a> FIFO Themes

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wow fadeInUp animated" style="visibility: visible;">

                        <div class="carousel-controls text-center">

                            <a class="prev" href="#client-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>

                            <a class="next" href="#client-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>

                            <div class="clearfix"></div>

                        </div>

                </div>

            </div>

        </div>

        <!-- /Tab & Testimonials widget -->





             </div>

    </section>

    <!-- /Main Section -->



@endsection

<!-- content end -->
