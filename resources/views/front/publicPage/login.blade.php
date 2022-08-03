@extends('front.master')
@section('title', 'Login')

<!-- content start -->
<?php  $topmenu='Home'; ?>
@section('content')
@include('front.include.sidebar')
    <!-- Main Section -->
    <section id="main">
        <div class="breadcrumbs">
        	<div class="container">
        		<h1 class="text-center text-uppercase">Login to your Account</h1>
        	</div><!--/container-->
        </div>

       
        @if($usertype == '')

            <div class="container content">

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 text-center wow visibility-inherit fadeInLeft">
                        <div class="service-box padding-top30 padding-bottom40">
                            <div class="service-box-icon">
                                <a class="nesuserlogine cursor" data-target="modalseller"><img alt="Web Design" src="{{ URL::asset('front/img/seller.png') }}" width="150"></a>
                            </div>
                            <div class="service-box-info">
                               <a href="{{url('/login?usertype=seller')}}" class=""><h3 class="padding-top10 heading-md">LOGIN AS SELLER</h3></a>
                               <div class="text-center">If you don't have account on 92agents don't wait and signup now with few simple steps.</div>
                               <a href="{{url('/signup/seller')}}" class="text-uppercase text-center">Sign UP</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 text-center wow visibility-inherit fadeInUp">
                        <div class="service-box padding-top30 padding-bottom40">
                            <div class="service-box-icon">
                                <a class="nesuserlogine cursor" data-target="modalbuyer"><img alt="Email Marketing" src="{{ URL::asset('front/img/buyer.png') }}" width="150"></a>
                            </div>
                            <div class="service-box-info">
                                <a href="{{url('/login?usertype=buyer')}}" class=""><h3 class="padding-top10 heading-md">LOGIN AS BUYER</h3></a>
                                <div class="text-center">If you don't have account on 92agents don't wait and signup now with few simple steps.</div>
                                <a href="{{url('/signup/buyer')}}" class="text-uppercase text-center">Sign UP</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 text-center wow visibility-inherit fadeInRight">
                        <div class="service-box padding-top30 padding-bottom40">
                            <div class="service-box-icon">
                                <a class="nesuserlogine cursor" data-target="modalagent"><img alt="Corportate Solutions" src="{{ URL::asset('front/img/agent.png') }}" width="150"></a>
                            </div>
                            <div class="service-box-info">
                                <a href="{{url('/login?usertype=agent')}}" class=""><h3 class="padding-top10 heading-md">LOGIN AS AGENT</h3></a>
                                <div class="text-center">If you don't have account on 92agents don't wait and signup now with few simple steps.</div>
                                <a href="{{url('/signup/agent')}}" class="text-center text-uppercase">Sign UP</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        
        @else

            <div class="container content">
                <div class="row">
                    <div class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12 ">
                        <div class="panel panel-default">
                            
                            <div class="panel-body">
            					
            				    {!! Form::open(array('url' => url('/login'),'class'=>'','role'=>'form')) !!}

                                    @if($errors->has('check'))
                                    
                                        <div class="alert alert-danger text-center">{!! $errors->first('check') !!}</div>
                                    @endif

            						@if(@$activation_link)
            						
                                    	<div class="alert alert-{{$activation_link['class']}} text-center">{!! @$activation_link['msg'] !!}</div>
            						@endif

                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} col-md-12 col-sm-12 col-xs-12">
                                        <label for="loginemail">Email Address <span class="mandatory">*</span></label>
                                        <input type="email" class="form-control loginemail emptyclass" id="loginemail" name="email" placeholder="Email Address"  value="{{ old('email') }}" autofocus />
                                        @if ($errors->has('email'))
                                            <p class="error-text login-email-error" id="login-email-error">
                                                {{ $errors->first('email') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label for="loginpassword">Password <span class="mandatory">*</span></label>
                                        <input type="password" class="form-control loginpassword emptyclass" id="loginpassword" name="password"  placeholder="Password" value="{{ old('password') }}"/>
                                         @if ($errors->has('password'))
                                            <p class="error-text login-password-error" id="login-password-error">
                                                {{ $errors->first('password') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-12"> <!-- Remember Field -->
                                        <div class="checkbox">
                                            <label class="checkbox">
                                                <input name="remember" {{ old('remember') ? 'checked' : ''}} type="checkbox"/>
                                                Remember Me.
                                            </label>
                                             <p class="error-text hide user-remember-error" id="user-remember-error"></p>
                                        </div>
                                        <p><h4>Forgot your password ?</h4> No worries,<a href="{{ url('/password/reset') }}"> click here </a>to reset your password.</p>
                                    </div>

                                    <div class="form-group col-md-12">
                                        
                                        @if($usertype=="buyer")
                                            <input class="agents_users_role_id" type="hidden" name="agents_users_role_id" value="2">
                                        @elseif($usertype=="seller")
                                            <input class="agents_users_role_id" type="hidden" name="agents_users_role_id" value="3">
                                        @elseif($usertype=="agent")
                                            <input class="agents_users_role_id" type="hidden" name="agents_users_role_id" value="4">
                                        @endif

                                        <button type="submit" class="btn btn-color"   name="signup" value="Sign_up">Login</button>
                                    </div>


                                {{ Form::close() }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </section>

@endsection

@section('script')
<script type="text/javascript">
    <?php if(isset($_REQUEST['activation_link']) && !empty($_REQUEST['activation_link']) && $usertype!=''): ?>
        window.history.pushState('data',"Title", '{{ url("/login") }}?usertype={{ $usertype }}');
    <?php endif; ?>
</script> 
@stop