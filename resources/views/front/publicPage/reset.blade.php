@extends('front.master')
@section('title', 'Home')

<!-- content start -->
@section('content')
<?php  $topmenu='Home'; ?>
@include('front.include.sidebar')

    <!-- Main Section -->
    <section id="main">
        <div class="breadcrumbs">
        	<div class="container">
        		<h1 class="text-center text-uppercase">Forgot your password</h1>
        	</div><!--/container-->
        </div>
        <div class="container content">
            <div class="row">
                <div class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
                    <div class="panel panel-default">                
                        <div class="panel-body">
        			    
                        {!! Form::open(array('url' => 'password/resetcodesend','class'=>'','role'=>'form')) !!}

                            @if($errors->has('check'))
                                <div class="alert alert-danger text-center">{!! $errors->first('check') !!}</div>
                            @endif

        					@if($errors->has('msg'))
            				    <div class="alert alert-success text-center">{!! $errors->first('msg') !!} </div>
        					@endif
                            
                            @if(!$errors->has('msg'))
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} col-md-12 col-sm-12 col-xs-12">
                                    <label for="resetemail">Email Address <span class="mandatory">*</span></label>
                                    <input type="email" class="form-control resetemail emptyclass" id="resetemail" name="email" placeholder="Email Address"  value="{{ old('email') }}" autofocus />
                                    @if ($errors->has('email'))
                                        <p class="error-text " >
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                </div>

                                @if(Session::has('email_right'))
                                    <div class="form-group {{ $errors->has('answer_1') ? ' has-error' : '' }} col-md-12 col-sm-12 col-xs-12">
                                        <label  for="answer_1">{{ @Session::get('userdata')->question1 }} <span class="mandatory">*</span></label>
                                        <input type="password" class="form-control answer_1 emptyclass" id="answer_1" name="answer_1" placeholder="Enter Answer 1"  value="{{ old('answer_1') }}" autofocus />
                                        @if ($errors->has('answer_1'))
                                            <p class="error-text " >
                                                {{ $errors->first('answer_1') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('answer_2') ? ' has-error' : '' }} col-md-12 col-sm-12 col-xs-12">
                                        <label  for="answer_2">{{ @Session::get('userdata')->question2 }} <span class="mandatory">*</span></label>
                                        <input type="password" class="form-control answer_2 emptyclass" id="answer_2" name="answer_2" placeholder="Enter Answer 2"  value="{{ old('answer_2') }}"  />
                                        @if ($errors->has('answer_2'))
                                            <p class="error-text " >
                                                {{ $errors->first('answer_2') }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <input  type="hidden" name="securty" value="1">
                                @endif

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-color"   name="submit" value="Send Password Reset Link">Send Password Reset Link</button>
                                   <p><a href="{{ url('/login') }}"> Login</a></p>
                                </div>
                            @endif
                            
                        {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Main Section -->
@endsection