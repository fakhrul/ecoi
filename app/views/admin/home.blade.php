@extends('layouts.admin_default')
<?php define("PAGETITLE", " | Admin Home"); ?>
@section('page-header')
<script>
	window.onload = function() {
		setTimeout(function() {
			location.reload()
		}, 300000);
	};
</script>
<h3>Dashboard</h3>
@stop
@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@else
Welcome to {{ Config::get('app.fullname') }} {{-- Auth::user()->name ? Auth::user()->name .' - '. Session::get('branch_name') : Config::get('app.fullname') --}}
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
		<h3 class="panel-title">Details</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive col-md-16 clearfix">
			<table class="table table-hover table-striped">
				<tr>
					<td style="text-align:center;font-weight:bold;" class="col-sm-2 control-label">Station Code</td>
					<td style="text-align:center;">{{$summary->Station_ID}}</td>
					<td style="text-align:center;font-weight:bold;" class="col-sm-2 control-label">Station Name</td>
					<td style="text-align:center;">{{$summary->Station_Name}}</td>
				</tr>
				<tr>
				<td style="text-align:center;font-weight:bold;" class="col-sm-2 control-label">Alarm Status</td>

				@if ($timelog->alarm_status == "A1")
				<td style="text-align:center;">{{$timelog->alarm_status}} - Rainfall Alarm</td>
					@elseif($timelog->alarm_status == "A2") 
					<td style="text-align:center;">{{$timelog->alarm_status}} - Water Level Alarm</td>
						@elseif($timelog->alarm_status == "A3") 
						<td style="text-align:center;">{{$timelog->alarm_status}} - Rainfall & Water Level Alarm</td>
						@elseif($timelog->alarm_status == "N") 
						<td style="text-align:center;">{{$timelog->alarm_status}} - Normal</td>
							@else
							<td style="text-align:center;">{{$timelog->alarm_status}}</td>
							@endif

					<td style="text-align:center;font-weight:bold;" class="col-sm-2 control-label">Last Updated</td>
					<td style="text-align:center;">{{$timelog->LOG_DATE . ' ' . $timelog->LOG_TIME}}</td>
				</tr>
			</table>
		</div>
		<div style="padding-top:50px;" class="table-responsive col-md-4 clearfix">
			<table class="table table-hover table-striped">
				<tr>
					<td style="text-align:center;font-weight:bold;" class="col-sm-4 control-label">Maximun Daily Rainfall</td>
					<td style="text-align:center;" class="col-sm-4">{{$max_daily_rainfall->RF1_DAILY . ' mm '}}
						<p> {{$max_daily_rainfall->LOG_DATE }}
					</td>
				</tr>
			</table>
			<table class="table table-hover table-striped">
				<tr>
					<td style="text-align:center;font-weight:bold;" class="col-sm-4 control-label">Daily Rainfall</td>
					<td style="text-align:center;" class="col-sm-4">{{$timelog->RF1_DAILY . ' mm'}}</td>
				</tr>
			</table>
			<table class="table table-hover table-striped">
				<tr>
					<td style="text-align:center;font-weight:bold;" class="col-sm-4 control-label">Yearly Rainfall</td>
					<td style="text-align:center;" class="col-sm-4">{{$max_daily_rainfall->RF1_YEARLY . ' mm'}}</td>
				</tr>
			</table>

			<table class="table table-hover table-striped">
				<tr>
					<td style="text-align:center;font-weight:bold;" class="col-sm-4 control-label">Current Water Level</td>
					<td style="text-align:center;" class="col-sm-4">{{number_format($timelog->AI1, 3, '.', '') . ' m'}}</td>
				</tr>
			</table>
		</div>

		<div class="table-responsive col-md-8 clearfix">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<td colspan="6" style="text-align:center;font-weight:bold;">Previous Hourly Rainfall Details</td>
					</tr>
				</thead>
				<tbody>
					<!-- <tr>
							<td>Last 12 Hourly</td>
							<td>{{$timelog->last12h}}</td>
							<td>mm</td>							 
							<td>Last 6 Hourly</td>
							<td>{{$timelog->last6h}}</td>
							<td>mm</td>	
						</tr>-->
					<tr>
						<!-- <td>Last 7 Hourly</td>
							<td>{{$timelog->last7h}}</td>
							<td>mm</td>								 -->
						<td>Last 1 Hourly</td>
						<td>{{$timelog->last1h}}</td>
						<td>mm</td>
					</tr>
					<tr>
						<!-- <td>Last 8 Hourly</td>
							<td>{{$timelog->last8h}}</td>
							<td>mm</td>								 -->
						<td>Last 2 Hourly</td>
						<td>{{$timelog->last2h}}</td>
						<td>mm</td>
					</tr>
					<tr>
						<!-- <td>Last 9 Hourly</td>
							<td>{{$timelog->last9h}}</td>
							<td>mm</td>	 -->
						<td>Last 3 Hourly</td>
						<td>{{$timelog->last3h}}</td>
						<td>mm</td>
					</tr>
					<tr>
						<!-- <td>Last 10 Hourly</td>
							<td>{{$timelog->last10h}}</td>
							<td>mm</td>								 -->
						<td>Last 4 Hourly</td>
						<td>{{$timelog->last4h}}</td>
						<td>mm</td>
					</tr>
					<tr>
						<!-- <td>Last 11 Hourly</td>
							<td>{{$timelog->last11h}}</td>
							<td>mm</td>	 -->
						<td>Last 5 Hourly</td>
						<td>{{$timelog->last5h}}</td>
						<td>mm</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</div>

@stop