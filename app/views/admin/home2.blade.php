@extends('layouts.admin_default')
<?php define("PAGETITLE", " | Dashboard"); ?>
@section('page-header')


<h3>Dashboard</h3>
@stop

@section('content')
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@if ($errors->all())
  <div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@else
Welcome to {{ Auth::user()->channel ? Auth::user()->channel->name .' - '. Session::get('branch_name') : Config::get('app.fullname') }}
@endif
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
			
	  	
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
						
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Rainfall Details</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Daily Rainfall</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->RF1_DAILY}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last Updated</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->LOG_DATE . ' '. $timelog->LOG_TIME }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Maximun Daily Rainfall</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$max_daily_rainfall->RF1_DAILY . ' (' .$max_daily_rainfall->LOG_DATE . ' '. $max_daily_rainfall->LOG_TIME .')'}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Yearly Rainfall</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$max_daily_rainfall->RF1_YEARLY}}</p>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Previous Hourly Rainfall Details</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 12 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last12h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 11 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last11h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 10 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last10h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 9 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last9h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 8 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last8h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 7 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last7h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 6 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last6h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 5 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last5h}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 4 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last4h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 3 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last3h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 2 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last2h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Last 1 Hourly</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->last1h}}</p>
					</div>
				</div>
			</form>
		</div>
	</div>
		
@stop
		
@stop