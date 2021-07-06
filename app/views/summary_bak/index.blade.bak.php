@extends('layouts.default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		$("#export").click(function() {
			$("#form_export").submit();
			$("#loading_panel").addClass("loading-show");
			setTimeout(function(){
			  $("#loading_panel").removeClass("loading-show");
			}, 5000);
		});

		$("#paging").change(function() {
			$("#loading_panel").addClass("loading-show");
		});

		$("th").click(function() {
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
<h3>Manage Summary</h3>
@stop
<?
define("PAGETITLE", " | Manage Summary");
?>
@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
		  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
     @if (allowed('summary.create'))		  	
		  	<!--<a type="button" class="btn btn-primary" href="summary/create"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</a>-->
     @endif
	  		<!--<button type="button" class="btn btn-primary {{($summary->getTotal()>0)?'':'disabled'}}" id="export"><span class="glyphicon glyphicon-export"></span>&nbsp;Export</button>--?
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span> Search</a></li>
            @if (allowed('summary.create'))					
				<!--<li><a href="summary/create"><span class="glyphicon glyphicon-plus"></span> Add</a></li>-->	
            @endif				
				<!--<li><a href="#" id="export"><span class="glyphicon glyphicon-export"></span> Export</a></li>-->
			</ul>
		</div>
    {{ Form::open([ "id"=>"form_export", "name"=>"form_export", "url" => "summary/export"]) }}
		<input type="hidden" value="{{Input::get('station_code')}}" name="station_code">   
		<input type="hidden" value="{{Input::get('station_ids')}}" name="station_ids">
        <input type="hidden" value="{{Input::get('station_name')}}" name="station_name">
	{{ Form::close() }}
    
	</div>
    <div class="panel panel-default ">
		<div class="panel-heading clearfix">
			<form class="form-inline" role="form">
				<div class="pull-left">Showing {{ $summary->getFrom(); }} - {{ $summary->getTo(); }} of {{ $summary->getTotal(); }} entries.</div>
				<div class="form-group pull-right" style="margin-bottom:0px;">
						<label>Entries Per Page</label>
                        {{ Form::select('paging',array('5' => '5', '10' => '10', '20' => '20', '30' => '30', '50' => '50', '100' => '100', '200' => '200'), $summary->getPerPage(), array('id' => 'paging', 'class' => 'form-control', 'style' => 'style="width:80px;display:inline;', 'onchange' => 'window.location = "'.URL::to('summary').'?sort='.Input::get('sort').'&sort_order='.Input::get('sort_order').'&station_code='.Input::get('station_code').'&station_ids='.Input::get('station_ids').'&station_name='.Input::get('station_name').'&paging=" + this.value;')) }}
					</div>
			</form>
		</div>
		<div class="table-responsive clearfix">	
			<table class="table table-hover table-striped table-bordered">
                <thead>
					<tr>
						<th>No.</td>
                        <th class="{{($sort=='summary.station_code')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="summary.station_code">Station Code</td>
                        <th class="{{($sort=='summary.station_ids')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="summary.station_ids">Station ID</td>
                        <th class="{{($sort=='summary.station_name')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="summary.station_name">Station Name</td>
                        <th class="{{($sort=='summary.last_updated')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="summary.last_updated">Last Updated</td>
						<th>Action</td>
					</tr>
                </thead>
                <tbody>
				@foreach($summary as $key => $value)
					<tr>
						<td>{{ $key+1 }}</td>
						<td>{{ $value->station_code }}</td>
						<td>{{ $value->station_ids }}</td>
                        <td>{{ $value->station_name }}</td>
                        <td>{{ $value->last_updated }}</td>

						<!-- we will also add show, edit, and delete buttons -->
						<td>
            				@if (false and allowed('summary.destroy'))
            				<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
            				<!-- we will add this later since its a little more complicated than the other two buttons -->
            				{{ Form::open(array('url' => 'summary/' . $value->id)) }}
            				{{ Form::hidden('_method', 'DELETE') }}
            				{{ Form::submit('Delete', array('class' => 'btn btn-warning pull-right')) }}
            				{{ Form::close() }}
            				@endif				
            
            				@if (allowed('summary.show'))
            				<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a href="{{ URL::to('summary/' . $value->id) }}">View</a>
            				@endif
            				<!-- / -->
            				@if (allowed('summary.edit'))
            				<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <!--<a href="{{ URL::to('summary/' . $value->id . '/edit') }}">Edit</a>-->
                            
            				@endif
                        </td>
    				</tr>
    			@endforeach
            </tbody>
		</table>
	</div>
</div>

{{ $summary->appends(array('paging' => $summary->getPerPage(), 'station_code' => Input::get('station_code'), 'station_ids' => Input::get('station_ids')))->links(); }}

<div class="modal fade btn-search" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
                    <span class="glyphicon glyphicon-search"></span> 
					Search Types
				</h4>
		    </div>
	    	<div class="modal-body">
				<form id="form_search" class="form-horizontal" role="form" method="GET">
					<input type="hidden" value="{{Input::get('paging')}}" name="paging" id="paging">
					<input type="hidden" value="{{Input::get('sort')}}" name="sort" id="sort">
					<input type="hidden" value="{{Input::get('sort_order')}}" name="sort_order" id="sort_order">
			  		<div class="form-group">
			    		<label for="station_code" class="col-sm-3 control-label">Station Code</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" id="station_code" name='station_code' placeholder="Station Code">
					    </div>
			  		</div>
			  		<div class="form-group">
			    		<label for="station_ids" class="col-sm-3 control-label">Station ID</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" id="station_ids" name='station_ids' placeholder="Station ID">
					    </div>
			  		</div>
                    <div class="form-group">
			    		<label for="station_ids" class="col-sm-3 control-label">Station Name</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" id="station_name" name='station_name' placeholder="Station Name">
					    </div>
			  		</div>
				  	<div class="form-group">
				  		<div class="col-sm-offset-2 col-sm-10">
		  					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>
			  			</div>		
			  		</div>
				</form>
			</div>
		</div>
	</div>
</div>


@stop