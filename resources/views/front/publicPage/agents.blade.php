@extends('front.master')
@section('title', 'Home')

<!-- content start -->
@section('content')
<?php  $topmenu='Agents'; ?>
@include('front.include.sidebar')
<section id="main" style="padding: 70px 0px;">
    <div class="container" style="padding: 30px 0px">
        <div class="row">

            <div class="col-md-6">
                <img src="{{ URL::asset('front/img/agent/broker-giving-keys_11zon.jpg') }}" style="width: 500px; height: 400px; padding-top: 45px; ">
            </div>

            <div class="col-md-6">
                <h1 style="font-size: 36px">What is Lorem Ipsum?</h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book.</p>
                <ul class="bullet-points list-unstyled">
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                </ul>
                <a href="#" class="btn-outline "><span>More Details</span></a>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 40px">
        <div class="row">

            <div class="col-md-6">
                <h1 style="font-size: 36px">What is Lorem Ipsum?</h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book.</p>
                <ul class="bullet-points list-unstyled">
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                    <li>Lorem Ipsum is simply dummy</li>
                </ul>
                <a href="#" class="btn-outline"><span>More Details</span></a>
            </div>

            <div class="col-md-6"><img class="img-fluid" src="{{ URL::asset('front/img/agent/agent3.jpg') }}"></div>
        </div>
    </div>
    <div class="Lower-banner container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center">What is Lorem Ipsum?</h1>
                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a type specimen book.</p>
                <div class="text-center"><img class="img-fluid" src="{{ URL::asset('front/img/agent/agent4.jpg') }}"></div>
            </div>
        </div>
    </div>
</section>

@endsection
<style>
    body{
        font-family: 'Poppins' !important;
    }
    .Lower-banner h1{margin-bottom: 0px; margin-top: 40px;}
    .bullet-points {
        position: relative;
        font-size: 18px;
        line-height: 22px;
        margin: 0 0 35px;
        font-weight: 500;
    }

    ul {
        display: block;
        list-style-type: disc;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;
    }

    .bullet-points li::before {
        content: "";
        width: 10px;
        height: 10px;
        border: 2px solid #fff;
        border-radius: 100%;
        background: #59ab02;
        position: absolute;
        left: -4px;
    }

    li {
        margin-left: 20px;
    }

    .bullet-points:before {
        content: "";
        width: 2px;
        background: #59ab02;
        position: absolute;
        left: 0;
        top: 0;
        bottom: 13px;
    }

    p {
        line-height: 29px;
    }

    p {
        margin: 0 0 30px;
    }

    .Lower-banner p {
    font-size: 16px;
    color: #393939;
    font-weight: 300;
    width: 75%;
    margin: auto;
    padding: 35px 0px;
    }

    ul.bullet-points.list-unstyled li {
        font-size: 18px;
        line-height: 22px;
        margin: 0 30px 28px;
        font-weight: 600;
    }

    .btn-outline {
        color: #000;
    }

    .btn-outline {
        font-size: 20px;
        line-height: 24px;
        border: 1px solid #59ab02;
        background: none;
        padding: 13px 30px 7px;
        border-radius: 4px;
    }

    a {
        cursor: pointer;
    }

    .Lower-banner {

        background: url('./house-1867187_960_720.jpg');
        background-size: 100%;
        background-attachment: fixed;
    }

    a:hover {
        text-decoration: none;
        color: black;
    }
</style>
<!-- content end -->
