@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#delete_summary, #restore_summary, #restore_summary").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
		
	});
</script>
<h3>View Summary</h3>
@stop
<?
define("PAGETITLE", " | View Summary");
?>
@section('content')
@if (Session::has("message"))
	<div class="alert alert-info">{{ Session::get("message") }}</div>
@endif
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
        {{ Form::open(array('route' => array('admin.summary.destroy', $summary->id), 'method' => 'delete')) }}
            <a id="restore_summary" type="button" class="btn btn-primary" href="{{ URL::to('admin/summary') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a> 		
        @if (!$summary->deleted_at and allowed('admin.summary.edit'))		
		  	<!--<a type="button" class="btn btn-primary" href="{{ URL::to('admin/summary/' . $summary->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		  	<button id="delete_summary" type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</button>-->	
        @endif
        @if ($summary->deleted_at and allowed('admin.summary.destroy'))			  	
		  	<!--<a id="restore_summary" type="button" class="btn btn-primary" href="{{ URL::to('admin/summary/restore?id=' . $summary->id) }}"><span class="glyphicon glyphicon-repeat"></span>&nbsp;Restore</a>-->		  
        @endif	
        {{ Form::close() }}		  	
	  	
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
        {{ Form::open(array('route' => array('admin.summary.destroy', $summary->id), 'method' => 'delete')) }}			
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a id="restore_summary" href="{{ URL::to('admin/summary') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
            @if (!$summary->deleted_at and allowed('admin.summary.edit'))	
				<!--<li><a href="{{ URL::to('admin/summary/' . $summary->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>									
				<li><a id="delete_summary" href="javascript:" onclick="parentNode.parentNode.parentNode.submit();"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>-->	
            @endif			
            @if ($summary->deleted_at and allowed('admin.summary.destroy'))					
				<!--<li><a id="restore_summary" href="{{ URL::to('admin/summary/restore?id=' . $summary->id) }}"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>-->
            @endif					
			</ul>
        {{ Form::close() }}				
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Station Code</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->station_code}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Station ID</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->station_ids}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Station Name</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->station_name}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Station State</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->state->name}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Station District</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->district->name}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Latitude</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->latitude}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Longtitude</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->longtitude}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Last Updated</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->last_updated}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Station Status</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->station_status	 . ' (' .$summary->station_status_description .')'}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Battery Voltage</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->battery_voltage}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Internal Battery Voltage</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->internal_battery_voltage}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Solar Output</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->solar_output}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Siren Alert Threshold</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->siren_alert_threshold}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Siren Danger Threshold</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->siren_danger_threshold}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Rainfall Alert Threshold</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->rainfall_alert_threshold}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Rainfall Danger Threshold</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->rainfall_danger_threshold}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Water Level Alert Threshold</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->water_level_alert_threshold}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Water Level Warning Threshold</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->water_level_warning_threshold}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Water Level Danger Threshold	</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->water_level_danger_threshold}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Siren</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->siren_code	 . ' (' .$summary->siren .')'}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Daily Accumulative Rainfall</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->daily_accumulative_rainfall}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Yearly Cumulative Rainfall</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->yearly_cumulative_rainfall}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Water Level Para 1</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->water_level_para1}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Water Level Para 2</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->water_level_para2}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Flow Sensor Para 1</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->flow_sensor_para1}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Flow Sensor Para 2</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->flow_sensor_para2}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Flow Sensor Para 3</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->flow_sensor_para3}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Flow Sensor Para 4</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->flow_sensor_para4}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Evaporation</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->evaporation}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Evaporation Daily Accumulative</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->evaporation_daily_accumulative}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeCode" class="col-sm-3 control-label">Soil Moisture</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->soil_moisture}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">Soil Temperature</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->soil_temperature}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-3 control-label">FTP Contents</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$contents}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCreated" class="col-sm-3 control-label">Created</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->created_at . ' (' .$summary->createUser->name .')'}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputUpdated" class="col-sm-3 control-label">Updated</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->updated_at ? $summary->updated_at . ' (' .$summary->updateUser->name .')' : ''}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDeleted" class="col-sm-3 control-label">Deleted</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$summary->deleted_at ? $summary->deleted_at . ' (' .$summary->deleteUser->name .')' : ''}}</p>
					</div>
				</div>
			</form>
		</div>
	</div>
		
		
@stop