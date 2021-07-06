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
<h3>Manage Daily Report</h3>
@stop

<? define("PAGETITLE", " | Manage Daily Report");?>

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

@if(isset($stations))
    <div class="clearfix">
    	<div class="visible-md-block visible-lg-block">
    	  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
    	  	<!--<button type="button" class="btn btn-primary {{($stations->getTotal()>0)?'':'disabled'}}" id="export"><span class="glyphicon glyphicon-export"></span>&nbsp;Export</button>-->
    		<div style="margin-top:8px;"></div>
    	</div>
    
    	<div class="visible-xs-block visible-sm-block dropdown">
    		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
    		<div style="margin-top:8px;"></div>
    		<ul class="dropdown-menu" role="menu">
    			<li><a href="#" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span> Search</a></li>
    			<!--<li><a id="export" class="{{($stations->getTotal()>0)?'':'disabled'}}"><span class="glyphicon glyphicon-export"></span> Export</a></li>-->
    		</ul>
    	</div>
    </div>

	{{ Form::open([ "id"=>"form_export", "name"=>"form_export", "url" => "admin/report/export"]) }}
		<input type="hidden" value="{{Input::get('station_ids')}}" name="station_ids">
		<input type="hidden" value="{{$sort}}" name="sort">
		<input type="hidden" value="{{$sort_order}}" name="sort_order">
	{{ Form::close() }}

    <div class="panel panel-default ">
    	<div class="panel-heading clearfix">
    		<form class="form-inline" role="form">
    			<div class="pull-left">
    				Showing {{ $stations->getFrom(); }} - {{ $stations->getTo(); }} of {{ $stations->getTotal(); }} entries.
    			</div>
    			<div class="form-group pull-right" style="margin-bottom:0px;">
    				<label>Entries Per Page</label>
    				{{ Form::select('paging',array('5' => '5', '10' => '10', '20' => '20', '30' => '30','50' => '50', '100' => '100', '200' => '200'), $stations->getPerPage(), array('id' => 'paging', 'class' => 'form-control', 'style' => 'style="width:80px;display:inline;', 'onchange' => 'window.location = "'.URL::to('admin/report/daily').'?station_name='.Input::get('station_name').'&sort='.Input::get('sort').'&sort_order='.Input::get('sort_order').'&paging=" + this.value;')) }}
    			</div>
    		</form>
    	</div>
    	<div class="table-responsive clearfix">	
    	    <table class="table table-hover table-striped table-bordered">
    	        <thead>
    				<tr>
    					<th>No.</th>
    					<th class="{{($sort=='station.station_ids')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="station.station_ids">Station ID</th>							
    					<th>Daily Accumulative Rainfall</th>					
    					<th>Action</th>
    				</tr>
    			</thead>
    			<tbody>
    				@foreach($stations as $key => $value)
    				<tr>
    					<td>{{ $key+1 }}</td>
    					<td>{{ $value->station_ids }}</td>
    					<td>{{-- $value->activeRainfall()->first()->daily_accumulative_rainfall --}}
                            @foreach($value->activeRainfall as $rainfall)
                                {{ $rainfall->daily_accumulative_rainfall }}
                            @endforeach
                        </td>
    					<!-- we will also add show, edit, and delete buttons--> 
                        <td>
            				@if (false and allowed('admin.report.destroy'))
            				<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
            				<!-- we will add this later since its a little more complicated than the other two buttons (if required)-->
            				{{-- Form::open(array('url' => 'admin/report/' . $value->id)) --}}
            				{{-- Form::hidden('_method', 'DELETE') --}}
            				{{-- Form::submit('Delete', array('class' => 'btn btn-warning pull-right')) --}}
            				{{-- Form::close() --}}
            				@endif				
            
            				@if (allowed('admin.report.show'))
            				<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
            				<a href="{{ URL::to('admin/report/' . $value->id) }}">View</a>
            				@endif
            				<!-- | -->
            				@if (allowed('admin.report.edit'))
            				<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
            				<!-- <a href="{{ URL::to('admin/report/' . $value->id . '/edit') }}">Edit</a> -->
            				@endif
    					</td> 
    				</tr>
                    @endforeach
    			</tbody>
    		</table>
    	</div>
    </div>
    {{ $stations->appends(array('paging' => $stations->getPerPage(), 'sort' => $sort, 'sort_order' => $sort_order, 'station_ids' => Input::get('station_ids')))->links(); }}  
@endif

<div class="modal fade btn-search" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
					Search Station
				</h4>
		    </div>
	    	<div class="modal-body">
				<form id="form_search" class="form-horizontal" role="form" method="GET">
					<input type="hidden" value="{{Input::get('paging')}}" name="paging" id="paging">
					<input type="hidden" value="{{Input::get('sort')}}" name="sort" id="sort">
					<input type="hidden" value="{{Input::get('sort_order')}}" name="sort_order" id="sort_order">
			  		<div class="form-group">
			    		<label for="station_name" class="col-sm-3 control-label">Station Name</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" id="station_name" name='station_name' placeholder="e.g. Asajaya">
					    </div>
			  		</div>	  		
				  	<div class="form-group">
				    	<label for="station_state" class="col-sm-3 control-label">Station State</label>
				    	<div class="col-sm-5">
							{{-- Form::select('station_state', $station_states, Input::get('station_state'), array('class' => 'form-control')) --}}
				    	</div>
				  	</div>
				  	<div class="form-group">
					  	<div class="col-sm-offset-3 col-sm-10">
				  			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>	  			
				  		</div>
				  	</div>
				</form>
			</div>
		</div>
	</div>
</div>


@stop