@extends('layouts.admin_default')
<?php define("PAGETITLE", " | Summary"); ?>
@section('page-header')
<script>
    window.onload = function() {
        setTimeout(function () {
            location.reload()
        }, 300000);
     };
</script>
<h3>Manage Summary</h3>
@stop
@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
        {{ Form::open(array('route' => array('admin.summary.destroy', $summary->idrut_config), 'method' => 'delete')) }} 		
        @if (!$summary->deleted_at and allowed('admin.summary.edit'))		
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('admin/summary/' . $summary->idrut_config) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>	
        @endif	
        {{ Form::close() }}		  	
	  	
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
        {{ Form::open(array('route' => array('admin.summary.destroy', $summary->idrut_config), 'method' => 'delete')) }}			
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
            @if (!$summary->deleted_at and allowed('admin.summary.edit'))	
				<li><a href="{{ URL::to('admin/summary/' . $summary->idrut_config) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
            @endif					
			</ul>
        {{ Form::close() }}				
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Station Details</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Station ID</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->Station_ID}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Station Name</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->Station_Name}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Serial Number</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->serial_no}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Alarm Status</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->alarm_status}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Latitude</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->gps_lat}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Longitude</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->gps_long}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Last Updated</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->LOG_DATE . ' ' . $timelog->LOG_TIME}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Battery Voltage</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->Bat_Voltage}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Solar Voltage</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->Solar_voltage}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">GSM Signal</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$timelog->GSM_Sig}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Sampling</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->sam_H}} hour(s) {{$summary->sam_M}} minute(s)</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Transfer</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->transfer_H}} hour(s) {{$summary->transfer_M}} minute(s)</p>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Server Details</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Server 1 IP</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->server1_ip . ' (' . translateStatus($summary->server1_enable) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Server 2 IP</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->server2_ip . ' (' . translateStatus($summary->server2_enable) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Server 3 IP</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->server3_ip . ' (' . translateStatus($summary->server3_enable) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Server 4 IP</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->server4_ip . ' (' . translateStatus($summary->server4_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Health IP</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->health_ip . ' (' . translateStatus($summary->health_en) . ')' }}</p>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">SMS Number Details</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 1</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_01 . ' (' . translateStatus($sms_no->SMS_01_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 2</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_02 . ' (' . translateStatus($sms_no->SMS_02_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 3</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_03 . ' (' . translateStatus($sms_no->SMS_03_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 4</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_04 . ' (' . translateStatus($sms_no->SMS_04_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 5</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_05 . ' (' . translateStatus($sms_no->SMS_05_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 6</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_06 . ' (' . translateStatus($sms_no->SMS_06_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 7</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_07 . ' (' . translateStatus($sms_no->SMS_07_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 8</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_08 . ' (' . translateStatus($sms_no->SMS_08_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 9</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_09 . ' (' . translateStatus($sms_no->SMS_09_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 10</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_10 . ' (' . translateStatus($sms_no->SMS_10_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 11</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_11 . ' (' . translateStatus($sms_no->SMS_11_en) . ')' }}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">SMS 12</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sms_no->SMS_12 . ' (' . translateStatus($sms_no->SMS_12_en) . ')' }}</p>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Sensor Details</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Rainfall 1 High</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sensor_setting->rf1_h}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Rainfall 1 Very High</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$sensor_setting->rf1_vh}}</p>
					</div>
				</div>
			</form>
		</div>
	</div>

@stop