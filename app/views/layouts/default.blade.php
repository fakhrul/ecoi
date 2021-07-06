<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!--  Mobile Viewport Fix -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<title>
			@section('title')
			{{ Config::get('app.name') }}
			@show
		</title>
        
        <!-- jQuery multisleect -->
        <link href="{{ URL::asset('assets/css/jquery.multiselect.css') }}" rel="stylesheet" />
        
        <!-- select2 -->
        <link href="{{ URL::asset('assets/css/select2.css') }}" rel="stylesheet" />
        
        <!-- map here -->
        <link href="{{ URL::asset('assets/css/styleMap.css') }}" rel="stylesheet">	

		<!-- CSS -->
		<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">			
		<!--<link href="{{ URL::asset('assets/css/sticky-footer-navbar.css') }}" rel="stylesheet">-->
		<link href="{{ URL::asset('assets/css/main.css') }}" rel="stylesheet">	

		<link href="{{ URL::asset('assets/css/datepicker3.css') }}" rel="stylesheet">
		<link href="{{ URL::asset('assets/css/bootstrap.customize.css') }}" rel="stylesheet">	
		<style>    	
			@section('styles')			
			@show
		</style>

		<!-- JS -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script src="{{ URL::asset('assets/css/bootstrap.min.js') }}"></script>	
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->
		<script src="{{ URL::asset('assets/js/general.js') }}"></script>	
		<script src="{{ URL::asset('assets/js/jquery.blockUI.min.js') }}"></script>	

		<script src="{{ URL::asset('assets/js/bootstrap-datepicker.js') }}"></script>
		<script src="{{ URL::asset('assets/js/payment.js') }}"></script>		

		<!-- ANGULAR -->
		<!-- all angular resources will be loaded from the /public folder -->
		<!--<script src="js/controllers/mainCtrl.js"></script>
		<script src="js/services/channelService.js"></script>-->
        <script src="{{ URL::asset('js/app.js') }}"></script> <!-- load our application -->
        
        <!-- select2 -->
        <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
        
        <!-- jQuery multisleect -->
        <script src="{{ URL::asset('assets/js/jquery.multiselect.js') }}"></script>
	</head>
    <body>
        @if(!empty(Auth::user()->channel_id))
			@include('layouts.header') 
		@else
			@include('layouts.header_default')
		@endif
		<div class="container">
			@if (isset($breadcrumbs))
			<ol class="breadcrumb">
	          	@foreach($breadcrumbs as $key => $value)
	          		<li class="active">{{ $key }}</li>
	          	@endforeach	          
			</ol>
			@endif

			{{-- 
			<div class="pull-right" >
				<strong>{{ Auth::user()->username }}</strong>
				<a class="btn btn-small btn-warning" href="{{ URL::to('logout') }}">Logout</a>
			</div>  
			--}}	
		
			@section("page-header")
  			<h3>{{ Auth::user()->channel ? Auth::user()->channel->name .' ('. Auth::user()->channel->channel_id .') - '.Session::get('branch_name') : Config::get('app.name') }}</h3>
  			@show

			@yield('content')
		</div>	
		@include('layouts.footer')		
    </body>
</html>
