@extends('layouts.admin_default')
<?php define("PAGETITLE", " | Summary"); ?>
@section('page-header')
<script>
	window.onload = function() {
		setTimeout(function() {
			location.reload()
		}, 300000);
	};
</script>
<h3>Detailed Information</h3>
@stop
@section('content')
<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif
<!-- will be used to show any messages -->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<div class="clearfix">
	<div class="visible-md-block visible-lg-block">
		@if (allowed('admin.summary.edit'))
		<a type="button" class="btn btn-primary" href="{{ URL::to('admin/summary/' . $summary->idrut_config) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		@endif
		@if (allowed('admin.summary.export'))
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-export"></span>&nbsp;Download</button>
		@endif
		<div style="margin-top:8px;"></div>
	</div>

	<div class="visible-xs-block visible-sm-block dropdown">
		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
		<div style="margin-top:8px;"></div>
		<ul class="dropdown-menu" role="menu">
			@if (allowed('admin.summary.edit'))
			<li><a href="{{ URL::to('admin/summary/' . $summary->idrut_config) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
			@endif
			@if (allowed('admin.summary.export'))
			<li><a href="#" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-export"></span> Download</a></li>
			@endif
		</ul>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Station Details</h3>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<label for="inputTypeDescription" class="col-sm-3 control-label">Station Code</label>
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

					@if ($timelog->alarm_status == "A1")
					<p class="form-control-static">{{$timelog->alarm_status}} - Rainfall Alarm</p>
					@elseif($timelog->alarm_status == "A2") 
					<p class="form-control-static">{{$timelog->alarm_status}} - Water Level Alarm</p>
						@elseif($timelog->alarm_status == "A3") 
						<p class="form-control-static">{{$timelog->alarm_status}} - Rainfall & Water Level Alarm</p>
						@elseif($timelog->alarm_status == "N") 
						<p class="form-control-static">{{$timelog->alarm_status}} - Normal</p>
							@else
							<p class="form-control-static">{{$timelog->alarm_status}}</p>
							@endif

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
					@if ($timelog->Bat_Voltage >= 12.6 && $timelog->Bat_Voltage <= 14.4) <p class="form-control-static">{{$timelog->Bat_Voltage}} Volt (Charging)</p>
						@elseif($timelog->Bat_Voltage >= 11.0 && $timelog->Bat_Voltage < 12.6) <p class="form-control-static">{{$timelog->Bat_Voltage}} Volt (Good)</p>
							@elseif($timelog->Bat_Voltage >= 9.0 && $timelog->Bat_Voltage < 11.0) <p class="form-control-static">{{$timelog->Bat_Voltage}} Volt (Weak)</p>
								@else
								<p class="form-control-static">{{$timelog->Bat_Voltage}} Volt</p>
								@endif
				</div>
			</div>
			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">Solar Voltage</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$timelog->Solar_voltage}} Volt</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">GSM Signal</label>
				<div class="col-sm-5">
					@if ($timelog->GSM_Sig > -60)
					<p class="form-control-static">{{$timelog->GSM_Sig}} dBm (Excellent)</p>
					@elseif($timelog->GSM_Sig >= -89 && $timelog->GSM_Sig <= -60) <p class="form-control-static">{{$timelog->GSM_Sig}} dBm (Good)</p>
						@elseif($timelog->GSM_Sig >= -99 && $timelog->GSM_Sig <= -90) <p class="form-control-static">{{$timelog->GSM_Sig}} dBm (Fair)</p>
							@else
							<p class="form-control-static">{{$timelog->GSM_Sig}} dBm (Weak)</p>
							@endif
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
				<div class="col-sm-3">
					<p class="form-control-static">{{$summary->server1_ip . ' (' . translateStatus($summary->server1_enable) . ')' }}</p>
				</div>
				<label for="inputTypeCode" class="col-sm-2 control-label">Last Updated</label>
				<div class="col-sm-3">
					<p class="form-control-static">{{$server1->LOG_DATE . ' ' . $server1->LOG_TIME}}</p>
				</div>
			</div>

			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">Server 2 IP</label>
				<div class="col-sm-3">
					<p class="form-control-static">{{$summary->server2_ip . ' (' . translateStatus($summary->server2_enable) . ')' }}</p>
				</div>
				<label for="inputTypeCode" class="col-sm-2 control-label">Last Updated</label>
				<div class="col-sm-3">
					<p class="form-control-static">{{$server2->LOG_DATE . ' ' . $server2->LOG_TIME}}</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">Server 3 IP</label>
				<div class="col-sm-3">
					<p class="form-control-static">{{$summary->server3_ip . ' (' . translateStatus($summary->server3_enable) . ')' }}</p>
				</div>
				<label for="inputTypeCode" class="col-sm-2 control-label">Last Updated</label>
				<div class="col-sm-3">
					<p class="form-control-static">{{$server3->LOG_DATE . ' ' . $server3->LOG_TIME}}</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">Server 4 IP</label>
				<div class="col-sm-3">
					<p class="form-control-static">{{$summary->server4_ip . ' (' . translateStatus($summary->server4_en) . ')' }}</p>
				</div>
				<label for="inputTypeCode" class="col-sm-2 control-label">Last Updated</label>
				<div class="col-sm-3">
					<p class="form-control-static">{{$server4->LOG_DATE . ' ' . $server4->LOG_TIME}}</p>
				</div>
			</div>
			<!-- <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Health IP</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->health_ip . ' (' . translateStatus($summary->health_en) . ')' }}</p>
					</div>
				</div> -->
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
		<h3 class="panel-title">Sensor Threshold Details</h3>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">Rainfall 1 High</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$sensor_setting->rf1_h}} mm</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">Rainfall 1 Very High</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$sensor_setting->rf1_vh}} mm</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">Water Level Alert</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$sensor_setting->as1_A}} m</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">Water Level Warning</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$sensor_setting->as1_W}} m</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputTypeCode" class="col-sm-3 control-label">Water Level Danger</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$sensor_setting->as1_D}} m</p>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade btn-search" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
					Download Data
				</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(["role" => "form", "class" => "form-horizontal", "id"=>"form_export", "name"=>"form_export", "url" => "admin/summary/export"]) }}
				<div class="form-group">
					<label class="col-sm-3 control-label">Begin Date</label>
					<div class="col-sm-5">
						<div class="input-group date">
							<input id="begin_date" name="begin_date" type="text" class="form-control" readonly>
							<span class="input-group-addon">
								<i class="glyphicon glyphicon-calendar" onclick="selectDate();"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">End Date</label>
					<div class="col-sm-5">
						<div class="input-group date">
							<input id="end_date" name="end_date" type="text" class="form-control" readonly>
							<span class="input-group-addon">
								<i class="glyphicon glyphicon-calendar" onclick="selectDate();"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="report_format1" class="col-sm-3 control-label">Report Format</label>
					<fieldset id="report_format1" class="col-sm-5">
						<label class="radio-inline">
							{{ Form::radio('report_format', 'ftp', false) }} FTP
						</label>
						<label class="radio-inline">
							{{ Form::radio('report_format', 'tideda', true) }} TIDEDA
						</label>
					</fieldset>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@stop