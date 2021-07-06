@extends('layouts.default')

@section('page-header')
<script type="text/javascript">$('.datepicker').datepicker()</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#back_to_station, #back_to_station2").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
        
        function isMobileDevices() {
            return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
        };
        
        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };
        
        if( isMobile.iOS() ){
            var nav = 'maps:'; //iOS
        }else if( isMobile.Android() ){
            var nav = 'geo:'; //Android
        }else if( isMobile.Windows() ){
            var nav = 'maps:'; //Windows
        }else{
            var nav = 'bingmaps:'; //BlackBerry
        }          
        //define navigation link
        var lat             = <?php echo $station->latitude; ?>; //alert(lat);
        var lng             = <?php echo $station->longtitude; ?>; //alert(lng);
        var station_name    = "<?php echo htmlentities($station->station_name); ?>"; //alert(station_name);
        var station_code    = "<?php echo htmlentities($station->station_code); ?>"; //alert(station_code);
        var stationID       = station_name + '(' + station_code  + ')'; //alert(stationID);
        var isMobileDevice  = isMobileDevices(); 
        if(isMobileDevice){
            var fullNav = nav + lat + ',' + lng + '?q=' + lat + ',' + lng + '(' + stationID  + ')'; //alert(fullNav);
            document.getElementById("nav_mobile").href=fullNav; 
            $("#nav_mobile").attr("href", fullNav); 
            return false;
        }else{ 
            var fullNav = 'http://maps.google.com?q=' + lat + ',' + lng + '(' + stationID + ')'; //alert(fullNav);
            document.getElementById("nav").target="_BLANK"; 
            document.getElementById("nav").href=fullNav; 
            $("#nav").attr("target", "_BLANK");
            $("#nav").attr("href", fullNav); 
            return false;
        }
	});
</script>
<h3>View Station</h3>

@stop
<?php define("PAGETITLE", " | View Station"); ?>
@section('content')

@if (Session::has("message"))
	<div class="alert alert-info">{{ Session::get("message") }}</div>
@endif
<div ng-app="csgApp" ng-controller="pukController">
	
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
		 	<a id="back_to_station" type="button" class="btn btn-primary" href="{{ URL::to('station') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
        @if (!$station->deleted_at  && allowed('station.edit'))		
	  		<a type="button" class="btn btn-primary" href="{{ URL::to('station/' . $station->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		@endif		 	 	
		 	<a id="nav" type="button" class="btn btn-primary" href="#"><span class="glyphicon glyphicon-globe"></span>&nbsp;Go Here</a>
             <div style="margin-top:8px;"></div> 
		</div>
		<input id="stationid" name="stationid" class="hidden" value="{{$station->id}}" />
		<div class="visible-xs-block visible-sm-block dropdown">		
				<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
				<div style="margin-top:8px;"></div>
				<ul class="dropdown-menu" role="menu">
					<li><a id="back_to_station2" href="{{ URL::to('station') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
                @if (!$station->deleted_at && allowed('station.edit') )	
					<li><a href="{{ URL::to('station/' . $station->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>	
				@endif
                    <li><a id="nav_mobile" href="#"><span class="glyphicon glyphicon-globe"></span> Go Here</a></li>
				</ul>		
		</div>
	</div>
	
    <div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-sm-4 control-label">Station Name</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$station->station_name}}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Station Code</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$station->station_code}}</p>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-4 control-label">Station ID</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$station->station_ids}}</p>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-4 control-label">Latitude</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{ $station->latitude }}</p>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-4 control-label">Longtitude</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{ $station->longtitude }}</p>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-4 control-label">House Type</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{ $station->house_type }}</p>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-4 control-label">State</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{ $station->state->name }}</p>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-4 control-label">District</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{ $station->district->name }}</p>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-4 control-label">Assigned To</label>
					<div class="col-sm-5">
						@foreach($station->users as $key => $value)
						<p class="form-control-static">{{ ucfirst($value->name) }}</p>
						@endforeach
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Created</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$station->created_at . ' (' .$station->createUser->name .')'}}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Updated</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$station->updated_at ? $station->updated_at . ' (' .$station->updateUser->name .')' : ''}}</p>
					</div>
				</div>                				
			</form>
        @if(!$station->types->isEmpty())
            <hr />
            <form accept-charset="UTF-8" class="form-horizontal">
                <div class="form-group">
					<label class="col-sm-4 control-label">Station Types</label>
					<div class="col-sm-5">
						@foreach ($station->types as $type)
						<p class="form-control-static">{{ $type->type_description . ' ('. $type->pivot->quantity . ')' }}</p>
						@endforeach
					</div>
				</div>
            </form>
        @endif
		</div>
	</div>
</div>


@stop