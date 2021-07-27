@extends('layouts.admin_default')
<?php define("PAGETITLE", " | Edit Summary"); ?>
@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#update_summary, #back_to_summary").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
	});
</script>
<h3>Edit Summary</h3>
@stop
@section('content')
<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

<!-- action button start -->
<div class="clearfix">
	<div class="visible-md-block visible-lg-block">
		<a id="back_to_summary" type="button" class="btn btn-primary" href="{{ URL::to('admin/summary') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
		<div style="margin-top:8px;"></div>
	</div>
	<div class="visible-xs-block visible-sm-block dropdown">
		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
		<div style="margin-top:8px;"></div>
		<ul class="dropdown-menu" role="menu">
			<li><a id="back_to_summary" href="{{ URL::to('admin/summary') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
		</ul>
	</div>
</div>
<!-- action button end -->

{{ Form::model($summary, array('route' => array('admin.summary.update', $summary->idrut_config), 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'form_summary')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Station Details</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				{{ Form::label('Station_ID', 'Station ID', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('Station_ID', Input::old('Station_ID'), array('class' => 'form-control')) }}
				</div>
				{{ Form::label('Station_Name', 'Station Name', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('Station_Name', Input::old('Station_Name'), array('class' => 'form-control')) }}
				</div>	
			</div>
                                    
            <div class="form-group">
				{{ Form::label('serial_no', 'Serial Number', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('serial_no', Input::old('serial_no'), array('class' => 'form-control', 'readonly')) }}
				</div>
				{{ Form::label('alarm_status', 'Alarm Status', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('alarm_status', $timelog->alarm_status, array('class' => 'form-control', 'readonly')) }}
				</div>	
			</div>
			
			<div class="form-group">
				{{ Form::label('gps_lat', 'Latitude', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('gps_lat', $timelog->gps_lat, array('class' => 'form-control', 'readonly')) }}
				</div>
				{{ Form::label('gps_long', 'Longitude', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('gps_long', $timelog->gps_long, array('class' => 'form-control', 'readonly')) }}
				</div>	
			</div>
			
			<div class="form-group">
				{{ Form::label('last_updated', 'Last Updated', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('last_updated', $timelog->LOG_DATE . ' ' . $timelog->LOG_TIME, array('class' => 'form-control', 'readonly')) }}
				</div>
				{{ Form::label('Bat_Voltage', 'Battery Voltage', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('Bat_Voltage', $timelog->Bat_Voltage, array('class' => 'form-control', 'readonly')) }}
				</div>	
			</div>
			
			<div class="form-group">
				{{ Form::label('Solar_voltage', 'Solar Voltage', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('Solar_voltage', $timelog->Solar_voltage, array('class' => 'form-control', 'readonly')) }}
				</div>	
				{{ Form::label('GSM_Sig', 'GSM Signal', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					{{ Form::text('GSM_Sig', $timelog->GSM_Sig, array('class' => 'form-control', 'readonly')) }}
				</div>	
			</div>
			
			<div class="form-group">
				{{ Form::label('sampling', 'Sampling', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">
					<div class="input-group">
						{{ Form::text('sam_H', Input::old('sam_H'), array('class' => 'form-control', 'id' => 'BI16')) }} 	
						<span class="input-group-addon">Hours</span>
					</div>
				 </div>	
				 
				 <div class="col-sm-2"></div>	
				 
				 <div class="col-sm-3">
					<div class="input-group">
						{{ Form::text('sam_M', Input::old('sam_M'), array('class' => 'form-control')) }}
						<span class="input-group-addon">Minutes</span>
					</div>
				 </div>	
			</div>
			
			<div class="form-group">
				{{ Form::label('transfer', 'Transfer', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">
					<div class="input-group">
						{{ Form::text('transfer_H', Input::old('transfer_H'), array('class' => 'form-control')) }}
						<span class="input-group-addon">Hours</span>
					</div>
				 </div>	
				 
				 <div class="col-sm-2"></div>	
				 
				 <div class="col-sm-3">
					<div class="input-group">
						{{ Form::text('transfer_M', Input::old('transfer_M'), array('class' => 'form-control')) }}
						<span class="input-group-addon">Minutes</span>
					</div>
				 </div>	
			</div>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Server Details</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				{{ Form::label('Server_1', 'Server 1', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('server1_enable',null,$summary->server1_enable, array('id'=>'server1_enable')) }}
					IP: {{ Form::text('server1_ip', Input::old('server1_ip'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Username: {{ Form::text('server1_user', Input::old('server1_user'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Password: {{ Form::text('server1_pass', Input::old('server1_pass'), array('class' => 'form-control')) }}
				</div>
			</div>
            
            <div class="form-group">
				{{ Form::label('Server_2', 'Server 2', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('server2_enable',null,$summary->server2_enable, array('id'=>'server2_enable')) }}
					IP: {{ Form::text('server2_ip', Input::old('server2_ip'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Username: {{ Form::text('server2_user', Input::old('server2_user'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Password: {{ Form::text('server2_pass', Input::old('server2_pass'), array('class' => 'form-control')) }}
				</div>
			</div>
                                    
			<div class="form-group">
				{{ Form::label('Server_3', 'Server 3', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('server3_enable',null,$summary->server3_enable, array('id'=>'server3_enable')) }}
					IP: {{ Form::text('server3_ip', Input::old('server3_ip'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Username: {{ Form::text('server3_user', Input::old('server3_user'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Password: {{ Form::text('server3_pass', Input::old('server3_pass'), array('class' => 'form-control')) }}
				</div>
			</div>
			
			<div class="form-group">
				{{ Form::label('Server_', 'Server 4', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('server4_en',null,$summary->server4_en, array('id'=>'server4_en')) }}
					IP: {{ Form::text('server4_ip', Input::old('server4_ip'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Username: {{ Form::text('server4_user', Input::old('server4_user'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Password: {{ Form::text('server4_pass', Input::old('server4_pass'), array('class' => 'form-control')) }}
				</div>
			</div>
			
			<!-- <div class="form-group">
				{{ Form::label('health_server', 'Health Server', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('health_en',null,$summary->health_en, array('id'=>'health_en')) }}
					IP: {{ Form::text('health_ip', Input::old('health_ip'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Username: {{ Form::text('health_user', Input::old('health_user'), array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-3 form-inline">
					Password: {{ Form::text('health_pass', Input::old('health_pass'), array('class' => 'form-control')) }}
				</div>
			</div>		 -->
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">SMS Number Details</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				{{ Form::label('SMS_01', 'SMS 1', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_01_en',null,$sms_no->SMS_01_en, array('id'=>'SMS_01_en')) }}
					{{ Form::text('SMS_01', $sms_no->SMS_01, array('class' => 'form-control')) }}
				</div>
				{{ Form::label('SMS_02', 'SMS 2', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_02_en',null,$sms_no->SMS_02_en, array('id'=>'SMS_02_en')) }}
					{{ Form::text('SMS_02', $sms_no->SMS_02, array('class' => 'form-control')) }}
				</div>
			</div>
            
			<div class="form-group">
				{{ Form::label('SMS_03', 'SMS 3', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_03_en',null,$sms_no->SMS_03_en, array('id'=>'SMS_03_en')) }}
					{{ Form::text('SMS_03', $sms_no->SMS_03, array('class' => 'form-control')) }}
				</div>
				{{ Form::label('SMS_04', 'SMS 4', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_04_en',null,$sms_no->SMS_04_en, array('id'=>'SMS_04_en')) }}
					{{ Form::text('SMS_04', $sms_no->SMS_04, array('class' => 'form-control')) }}
				</div>
			</div>
            
			<div class="form-group">
				{{ Form::label('SMS_05', 'SMS 5', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_05_en',null,$sms_no->SMS_05_en, array('id'=>'SMS_05_en')) }}
					{{ Form::text('SMS_05', $sms_no->SMS_05, array('class' => 'form-control')) }}
				</div>
				{{ Form::label('SMS_06', 'SMS 6', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_06_en',null,$sms_no->SMS_06_en, array('id'=>'SMS_06_en')) }}
					{{ Form::text('SMS_06', $sms_no->SMS_06, array('class' => 'form-control')) }}
				</div>
			</div>
            
			<div class="form-group">
				{{ Form::label('SMS_07', 'SMS 7', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_07_en',null,$sms_no->SMS_07_en, array('id'=>'SMS_07_en')) }}
					{{ Form::text('SMS_07', $sms_no->SMS_07, array('class' => 'form-control')) }}
				</div>
				{{ Form::label('SMS_08', 'SMS 8', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_08_en',null,$sms_no->SMS_08_en, array('id'=>'SMS_08_en')) }}
					{{ Form::text('SMS_08', $sms_no->SMS_08, array('class' => 'form-control')) }}
				</div>
			</div>
            
			<div class="form-group">
				{{ Form::label('SMS_09', 'SMS 9', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_09_en',null,$sms_no->SMS_09_en, array('id'=>'SMS_09_en')) }}
					{{ Form::text('SMS_09', $sms_no->SMS_09, array('class' => 'form-control')) }}
				</div>
				{{ Form::label('SMS_10', 'SMS 10', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_10_en',null,$sms_no->SMS_10_en, array('id'=>'SMS_10_en')) }}
					{{ Form::text('SMS_10', $sms_no->SMS_10, array('class' => 'form-control')) }}
				</div>
			</div>
			
			<div class="form-group">
				{{ Form::label('SMS_11', 'SMS 11', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_11_en',null,$sms_no->SMS_11_en, array('id'=>'SMS_11_en')) }}
					{{ Form::text('SMS_11', $sms_no->SMS_11, array('class' => 'form-control')) }}
				</div>
				{{ Form::label('SMS_12', 'SMS 12', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3 form-inline">
					{{ Form::checkbox('SMS_12_en',null,$sms_no->SMS_12_en, array('id'=>'SMS_12_en')) }}
					{{ Form::text('SMS_12', $sms_no->SMS_12, array('class' => 'form-control')) }}
				</div>
			</div>
            		
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Sensor Threshold Details</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				{{ Form::label('rf1_h', 'Rainfall 1 High', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">	
					<div class="input-group">
						{{ Form::text('rf1_h',  $sensor_setting->rf1_h, array('class' => 'form-control')) }}
						<span class="input-group-addon">mm</span>
					</div>
				</div>
				{{ Form::label('rf1_vh', 'Rainfall 1 Very High', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					<div class="input-group">
						{{ Form::text('rf1_vh',  $sensor_setting->rf1_vh, array('class' => 'form-control')) }}
						<span class="input-group-addon">mm</span>
					</div>
				</div>	
			</div>	
			<div class="form-group">
				{{ Form::label('as1_A', 'Water Level Alert', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">	
					<div class="input-group">
						{{ Form::text('as1_A',  $sensor_setting->as1_A, array('class' => 'form-control')) }}
						<span class="input-group-addon">m</span>
					</div>
				</div>
				{{ Form::label('as1_W', 'Water Level Warning', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">		
					<div class="input-group">
						{{ Form::text('as1_W',  $sensor_setting->as1_W, array('class' => 'form-control')) }}
						<span class="input-group-addon">m</span>
					</div>
				</div>	
			</div>	
			<div class="form-group">
				{{ Form::label('as1_D', 'Water Level Danger', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-3">	
					<div class="input-group">
						{{ Form::text('as1_D',  $sensor_setting->as1_D, array('class' => 'form-control')) }}
						<span class="input-group-addon">m</span>
					</div>
				</div>
				<div class="col-sm-3">		
				</div>	
			</div>	
		</div>
		
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				 <button id="update_summary" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>		 
			</div>	
		</div>	
		
	</div>
	
{{ Form::close() }}
@stop