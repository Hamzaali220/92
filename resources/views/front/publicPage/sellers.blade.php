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
    <section id="home_made">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>why homes don’T sell?</h2>
                    <ul class="home_selling">
                        <li>Not getting potential buyers</li>
                        <li>Having slow agents</li>
                        <li>Every agent does not have the expertise in dealing with various
                            kind of properties
                            Where to find such skilled agents? Well, you’re at the right place!
                            At 92 Agents, you will find a lot of agents present just near to yu!</li>
                    </ul>
                    <a href="#" class="sell_house">SELL YOUR HOUSE AT 1% COMMISSION &gt;</a>
                </div>
                <div class="col-md-6">
                    <div class="busness_man">
                        <img class="img-fluid" src="{{asset('/img/home/business-man-co.png')}}" alt="business man">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="comparison">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="comparisontable">
                        <table style="width:100%" class="comparison_table">
                            <tr>
                                <th style="background-color: #fff;">
                                    <span class="d-flex">COMPARISON SHEET</span>
                                    <p>Commission</p>
                                </th>
                                <th>
                                    <span class="d-flex"
                                        style="background-image: linear-gradient(#8aaeef, #475d87);">SUB
                                        TOPIC</span>
                                    <p>Commission</p>
                                </th>
                                <th>
                                    <span class="d-flex"
                                        style="background-image: linear-gradient(#c5c5c5, #908BE3);">AGENT 1</span>
                                    <p>1%</p>
                                </th>
                                <th>
                                    <span class="d-flex"
                                        style="background-image: linear-gradient(#dc61af, #cf7ec1);">AGENT 2</span>
                                    <p>1.5%</p>
                                </th>
                                <th>
                                    <span class="d-flex"
                                        style="background-image: linear-gradient(#b45981, #5F213C);">AGENT 3</span>
                                    <p>3%</p>
                                </th>
                                <th>
                                    <span class="d-flex"
                                        style="background-image: linear-gradient(#f14822, #FE6948);">AGENT 4</span>
                                    <p>4%</p>
                                </th>
                                <th>
                                    <span class="d-flex"
                                        style="background-image: linear-gradient(#28da40, #6FD37C);">AGENT 5</span>
                                    <p>5%</p>
                                </th>
                            </tr>
                            <tr class="odd">
                                <td>Guarantee or NO Commission</td>
                                <td>
                                    <p>15 day BUY Guarantee</p>
                                    <p>30 day BUY Guarantee</p>
                                </td>
                                <td>
                                    <p>yes</p>
                                    <p>yes</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>Online Marketing</td>
                                <td>No of ways to market</td>
                                <td>MLS + 64ways</td>
                                <td>MLS + 48ways</td>
                                <td>MLS + 30ways</td>
                                <td>MLS + 20ways</td>
                                <td>MLS ONLY</td>
                            </tr>
                            <tr class="odd">
                                <td>Guarantee or NO Commission</td>
                                <td>
                                    <p>15 day BUY Guarantee</p>
                                    <p>30 day BUY Guarantee</p>
                                </td>
                                <td>
                                    <p>yes</p>
                                    <p>yes</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>Online Marketing</td>
                                <td>No of ways to market</td>
                                <td>MLS + 64ways</td>
                                <td>MLS + 48ways</td>
                                <td>MLS + 30ways</td>
                                <td>MLS + 20ways</td>
                                <td>MLS ONLY</td>
                            </tr>
                            <tr class="odd">
                                <td>Guarantee or NO Commission</td>
                                <td>
                                    <p>15 day BUY Guarantee</p>
                                    <p>30 day BUY Guarantee</p>
                                </td>
                                <td>
                                    <p>yes</p>
                                    <p>yes</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>Online Marketing</td>
                                <td>No of ways to market</td>
                                <td>MLS + 64ways</td>
                                <td>MLS + 48ways</td>
                                <td>MLS + 30ways</td>
                                <td>MLS + 20ways</td>
                                <td>MLS ONLY</td>
                            </tr>
                            <tr class="odd">
                                <td>Guarantee or NO Commission</td>
                                <td>
                                    <p>15 day BUY Guarantee</p>
                                    <p>30 day BUY Guarantee</p>
                                </td>
                                <td>
                                    <p>yes</p>
                                    <p>yes</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>Online Marketing</td>
                                <td>No of ways to market</td>
                                <td>MLS + 64ways</td>
                                <td>MLS + 48ways</td>
                                <td>MLS + 30ways</td>
                                <td>MLS + 20ways</td>
                                <td>MLS ONLY</td>
                            </tr>
                            <tr class="odd">
                                <td>Guarantee or NO Commission</td>
                                <td>
                                    <p>15 day BUY Guarantee</p>
                                    <p>30 day BUY Guarantee</p>
                                </td>
                                <td>
                                    <p>yes</p>
                                    <p>yes</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                                <td>
                                    <p>no</p>
                                    <p>no</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="among" style="padding-bottom: 20px; background:#D5D8DF;">
        <div style="background: #59AB02">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="w-50">AMONG MANY AGENTS WHO IS THE BEST AGENT FOR YOU? LOWEST<br> COMMISSION / QUICKEST BUY / BEST GUARANTEE...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="connect">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 p-0">
                <div class="connects">
                    <img class="img-fluid w-100" src="{{asset('/img/home/connect.PNG')}}" alt="Connect with us">
                </div>
            </div>
            <div class="col-md-6" style="background: #59AB02;">
                <div class="content">
                    <span style="text-align: center;">
                        <strong style="color: #fff;">Connect with 1000+ agents close to you
                            in just 10 minutes and that too in five
                            simple steps</strong>
                    </span>
                    <ul>
                        <li>Register yourself as a buyer</li>
                        <li>Post your requirements</li>
                        <li>Choose the best one</li>
                        <li>Our agents will connect with you</li>
                        <li>Hire the one of your choice</li>
                        <li>Engage them to buy home</li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </section>
    <section id="agent">
        <h3 class="text-center py-5 text-uppercase">Why 92 Agents?</h3>
        <div class="container">
            <div class="row custom_row" style="justify-content: center;">
                <div class="col-md-4">
                    <div class="my_agent">
                        <img class="img-fluid" src="{{asset('/img/home/Layer 23.png')}}" alt="">
                    </div>
                    <p class="text-center py-3">Get to know about nearby professional agents in just 10 mins.</p>
                </div>
                <div class="col-md-4">
                    <div class="my_agent">
                        <img class="img-fluid" src="{{asset('/img/home/help.png')}}" alt="">
                    </div>
                    <p class="text-center py-3">Compare them as per their qualification and expertise</p>
                </div>
                <div class="col-md-4">
                    <div class="my_agent">
                        <img class="img-fluid" src="{{asset('/img/home/1380370.png')}}" alt="">
                    </div>
                    <p class="text-center py-3">Use one to one chat feature to know them better</p>
                </div>
                <div class="col-md-4">
                    <div class="my_agent">
                        <img class="img-fluid" src="{{asset('/img/home/ask-a-question-.png')}}" alt="">
                    </div>
                    <p class="text-center py-3">Raise your query to all agents simultaneously</p>
                </div>
                <div class="col-md-4">
                    <div class="my_agent">
                        <img src="{{asset('/img/home/faq.png')}}" alt="">
                    </div>
                    <p class="text-center py-3">Make the FAQs public on your dashboard to avoid repetitive ques</p>
                </div>
                <div class="col-md-4">
                    <div class="my_agent">
                        <img src="{{asset('/img/home/time.png')}}" alt="">
                    </div>
                    <p class="text-center py-3">Save time. Make a great deal</p>
                </div>
            </div>
        </div>
    </section>
    <section id="newsletter">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="sign_up position-relative" style="position: relative;">
                <div class="position-absolute w-75 newss">
                    <p class="text-uppercase" style="color: #fff; font-weight:bold;">
                    <p class="text-uppercase" style="color: #fff; font-weight:bold;">YOU SAVE UPTO $10,000 WHEN YOU<br> CHOOSE 92 AGENTS!</p>
                      <a style="width: auto" class="read_more text-center d-block my-3" style="border: none;" href="#">JOIN TO SAVE YOUR $10,000</a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>
 @endsection

<!-- content end -->
