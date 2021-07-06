@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		$("#export").click(function() {
			$("#form_export").submit();
		});

		$("#paging").change(function() {
			$("#loading_panel").addClass("loading-show");
		});

		$("ul.pagination>li").click(function() {
			if(!$(this).hasClass("disabled")) {
				$("#loading_panel").addClass("loading-show");
			}
		});
		
		$(".sort, .sort_asc, .sort_desc").click(function() {
			if($(this).attr("value")!="")
			{
				$("#sort").val($(this).attr("value"));
				if($(this).hasClass("sort_asc")) {
					$("#loading_panel").addClass("loading-show");
					$("#sort_order").val("desc");
				}
				else {
					$("#loading_panel").addClass("loading-show");
					$("#sort_order").val("asc");
				}
				$("#form_search").submit();
			}
		});
	});
</script>
<h3>Manage Alarm</h3>
@stop

<?php define("PAGETITLE", " | Manage Alarm"); ?>

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message')) 
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@if (Session::has('error')) 
    <div class="alert alert-info">{{ Session::get('error') }}</div>
@endif
@if ($errors->all())
  <div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

<div class="clearfix">
	<div class="visible-md-block visible-lg-block">
	  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
	  	<!--<button type="button" class="btn btn-primary {{($alarms->getTotal()>0)?'':'disabled'}}" id="export"><span class="glyphicon glyphicon-export"></span>&nbsp;Export</button>-->
		<div style="margin-top:8px;"></div>
	</div>

	<div class="visible-xs-block visible-sm-block dropdown">
		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
		<div style="margin-top:8px;"></div>
		<ul class="dropdown-menu" role="menu">
			<li><a href="#" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span> Search</a></li>
			<!--<li><a id="export" class="{{($alarms->getTotal()>0)?'':'disabled'}}"><span class="glyphicon glyphicon-export"></span> Export</a></li>-->
		</ul>
	</div>
</div>

{{ Form::open([ "id"=>"form_export", "name"=>"form_export", "url" => "admin/alarm/export"]) }}
	<input type="hidden" value="{{Input::get('alarm_code')}}" name="alarm_code">
	<input type="hidden" value="{{$sort}}" name="sort">
	<input type="hidden" value="{{$sort_order}}" name="sort_order">
{{ Form::close() }}

<div class="panel panel-default ">
	<div class="panel-heading clearfix">
		<form class="form-inline" role="form">
			<div class="pull-left">
				Showing {{ $alarms->getFrom(); }} - {{ $alarms->getTo(); }} of {{ $alarms->getTotal(); }} entries.
			</div>
			<div class="form-group pull-right" style="margin-bottom:0px;">
				<label>Entries Per Page</label>
				{{ Form::select('paging',array('5' => '5', '10' => '10', '20' => '20', '30' => '30', '50' => '50', '100' => '100', '200' => '200'), $alarms->getPerPage(), array('id' => 'paging', 'class' => 'form-control', 'style' => 'style="width:80px;display:inline;', 'onchange' => 'window.location = "'.URL::to('admin/alarm').'?sort='.Input::get('sort').'&sort_order='.Input::get('sort_order').'&alarm_code='.Input::get('alarm_code').'&paging=" + this.value;')) }}
			</div>
		</form>
	</div>
    <div class="table-responsive clearfix">	
		<table class="table table-hover table-striped table-bordered">
            <thead>
				<tr>
					<th>No.</th>
					<th class="{{($sort=='station.station_code')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="station.station_code">Station Code</th>							
    				<th class="{{($sort=='station.station_name')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="station.station_name">Station Name</th>                        
                    <th class="{{($sort=='alarm_code')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="alarm_code">Alarm Code</th>
                    <th>Alarm Description</th>
                    <th>Alarm Date Time</th>
					<!--<th>Action</th>-->
				</tr>
            </thead>
            <tbody>
    			@if(isset($alarms))
                    @foreach($alarms as $key => $value)
        				<tr>
        					<td>{{ $key+1 }}</td>
                            <td>{{ $value->station_code }}</td>
                            <td>{{ $value->station_name }}</td> 
        					<td>{{ $value->alarm_code }}</td>
        					<td>{{ $value->alarm_description }}</td>	
                            <td>{{ $value->alarm_datetime }}</td>	
        					<!-- we will also add show, edit, and delete buttons -->
        					<!--<td>		
        						@if (allowed('alarm.show'))
        						<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
        						<!--<a href="{{ URL::to('admin/alarm/' . $value->id) }}">View</a>
        						@endif
        					</td>-->
        				</tr>
        			@endforeach
                @endif
            </tbody>
		</table>
	</div>
</div>

{{ $alarms->appends(array('paging' => $alarms->getPerPage(), 'sort' => $sort, 'sort_order' => $sort_order, 'alarm_code' => Input::get('alarm_code')))->links(); }}

<div class="modal fade btn-search" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
					Search Alarms
				</h4>
		    </div>
	    	<div class="modal-body">
                <form id="form_search" class="form-horizontal" role="form" method="GET">
					<input type="hidden" value="{{Input::get('paging')}}" name="paging" id="paging">
					<input type="hidden" value="{{Input::get('sort')}}" name="sort" id="sort">
					<input type="hidden" value="{{Input::get('sort_order')}}" name="sort_order" id="sort_order">
			  		<div class="form-group">
			    		<label for="station_name" class="col-sm-4 control-label">Station Name</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" name="station_name" id="station_name" placeholder="Station Name">
					    </div>
			  		</div>
                    <div class="form-group">
				    	<label for="alarm_code" class="col-sm-4 control-label">Alarm Code</label>
				    	<div class="col-sm-5">
							{{ Form::select('alarm_code', $alarm_codes, Input::get('alarm_code'), array('class' => 'form-control')) }}
				    	</div>
				  	</div>
                    <div class="form-group">
			    		<label for="alarm_description" class="col-sm-4 control-label">Alarm Description</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" name="alarm_description" id="alarm_description" placeholder="Main Power AC">
					    </div>
			  		</div>
			  		<div class="form-group">
					  	<div class="col-sm-offset-4 col-sm-10">
				  			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>	
				  		</div>
				  	</div>
				</form>
			</div>
		</div>
	</div>
</div>

@stop