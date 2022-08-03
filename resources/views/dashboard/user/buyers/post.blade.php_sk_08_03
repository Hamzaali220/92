@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
@stop
@section('title', 'Post')
@if($user->agents_users_role_id==2)
	@include('dashboard.user.buyers.post_buyer')
@elseif($user->agents_users_role_id==3)
	@include('dashboard.user.buyers.post_seller')
@endif