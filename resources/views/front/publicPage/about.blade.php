@extends('front.master')
@section('title', 'Home')

<!-- content start -->
@section('content')
    <?php $topmenu = 'About'; ?>
    @include('front.include.sidebar')
    <section id="mainabout" style="background-image: url('{{ asset('front/img/about/aboutheader.jpg')}}'">
        <div class="container">
            <div class="row">
                <div class="col-md-12 wow fadeInUp animated">
                    <div class="aboutcontent">
                        <h1 class="heading">Lorem Ipsum<br>What is Lorem Ipsum?</h1>
                    <p class="paragaraph">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        <br>
                        Lorem Ipsum has been the industry's standard dummy text
                        <br>
                        ever since the 1500s,
                    </p>
                    <button class="btn btn-warn">Learn More</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="lower">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 wow fadeInUp animated">
                    <p class="text-center heading" style="padding-top: 50px ">Lorem Ipsum is simply dummy text</p>
                    <p class="text-center paragaraph" style="padding-bottom: 50px ">Lorem Ipsum is simply dummy text of the
                        printing and typesetting industry. Lorem Ipsum has been the industry's standard the industry's the
                        industry's standard standard dummy text ever since the 1500s,</p>
                </div>
            </div>
        </div>
        <div class="container custom-container">
            <div class="row">
                <div class="col-md-6 wow fadeInLeft animated">
                    <p class="heading">Lorem Ipsum is simply dummy text of the printing<br></p>
                    <p class="paragaraph">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap into electronic</p>

                    <button class="btn btn-warn">Learn More</button>
                </div>

                <div class="col-md-6 wow fadeInRight animated">
                    <div class="img">
                        <img src="{{ URL::asset('front/img/about/about1.jpg') }}" alt="" srcset="">
                    </div>
                </div>
            </div>
        </div>
        <div class="container custom-container">
            <div class="row" style="margin-bottom: 60px">
                <div class="col-md-6 wow fadeInLeft animated">
                    <div class="img">
                        <img src="{{ URL::asset('front/img/about/about2.jpg') }}" alt="" srcset="">
                    </div>
                </div>
                <div class="col-md-6 wow fadeInRight animated">
                    <p class="heading">Lorem Ipsum is simply dummy text of the printing<br></p>
                    <p class="paragaraph">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap into electronic</p>

                    <button class=" btn btn-warn ">Learn More</button>
                </div>
            </div>
        </div>
        <div class="container custom-container">
            <div class="row" style="margin-bottom: 60px">
                <div class="col-md-6 wow fadeInLeft animated">
                    <p class="heading">Lorem Ipsum is simply dummy text of the printing<br></p>
                    <p class="paragaraph">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap into electronic</p>

                    <button class=" btn btn-warn ">Learn More</button>
                </div>

                <div class="col-md-6 wow fadeInRight animated">
                    <div class="img">
                        <img src="{{ URL::asset('front/img/about/about3.jpg') }}" alt="" srcset="">
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
<style>
    #mainabout{
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
.aboutcontent{
    height: 588px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    }
    .custom-container{
        padding: 60px 0px;
    }
    .btn-warn {
    color: #fff;
    background-color: #59ab02 !important;
    border-color: #fcf8e3 !important;
}
    .btn:hover {
        background-color: white;
        color: black;
    }

    .btn {
        background-color: #f09929;
        font-size: 19px;
        padding: 10px 20 10px;
    }


    .heading {
        font-size: 32px;
        line-height: 39px;
        font-weight: 600
    }

    .paragaraph {
        font-size: 16px;
        line-height: 22px;
        font-weight: 400
    }
</style>
<!-- content end -->
