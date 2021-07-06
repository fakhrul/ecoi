@extends('layouts.admin_default')

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
<h3>Manage Brands</h3>
@stop
<?
define("PAGETITLE", " | Manage Brands");
?>
@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
		  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
     @if (allowed('admin.brands.create'))		  	
		  	<a type="button" class="btn btn-primary" href="brands/create"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</a>
     @endif
	  		<!--<button type="button" class="btn btn-primary {{($brands->getTotal()>0)?'':'disabled'}}" id="export"><span class="glyphicon glyphicon-export"></span>&nbsp;Export</button>-->
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span> Search</a></li>
            @if (allowed('admin.brands.create'))					
				<li><a href="brands/create"><span class="glyphicon glyphicon-plus"></span> Add</a></li>	
            @endif				
				<!--<li><a href="#" id="export"><span class="glyphicon glyphicon-export"></span> Export</a></li>-->
			</ul>
		</div>
    {{ Form::open([ "id"=>"form_export", "name"=>"form_export", "url" => "admin/brands/export"]) }}
		<input type="hidden" value="{{Input::get('name')}}" name="name">
		<input type="hidden" value="{{Input::get('upline_id')}}" name="upline_id">
		<input type="hidden" value="{{Input::get('type')}}" name="type">
		<input type="hidden" value="{{Input::get('status')}}" name="status">	
		<input type="hidden" value="{{Input::get('date_from')}}" name="date_from">
		<input type="hidden" value="{{Input::get('date_to')}}" name="date_to">
	{{ Form::close() }}
    
	</div>
    <div class="panel panel-default ">
		<div class="panel-heading clearfix">
			<form class="form-inline" role="form">
				<div class="pull-left">Showing {{ $brands->getFrom(); }} - {{ $brands->getTo(); }} of {{ $brands->getTotal(); }} entries.</div>
				<div class="form-group pull-right" style="margin-bottom:0px;">
						<label>Entries Per Page</label>
                        {{ Form::select('paging',array('5' => '5', '10' => '10', '20' => '20', '30' => '30', '50' => '50', '100' => '100', '200' => '200'), $brands->getPerPage(), array('id' => 'paging', 'class' => 'form-control', 'style' => 'style="width:80px;display:inline;', 'onchange' => 'window.location = "'.URL::to('admin/brands').'?sort='.Input::get('sort').'&sort_order='.Input::get('sort_order').'&name='.Input::get('name').'&upline_id='.Input::get('upline_id').'&paging=" + this.value;')) }}
					</div>
			</form>
		</div>
		<div class="table-responsive clearfix">	
			<table class="table table-hover table-striped table-bordered">
                <thead>
					<tr>
						<th>No.</td>
                        <th class="{{($sort=='brands.name')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="brands.name">Brand Name</td>
                        <th class="{{($sort=='brands.channel_id')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="brands.channel_id">Channel ID</td>
						<th>Action</td>
					</tr>
                </thead>
                <tbody>
				@foreach($brands as $key => $value)
					<tr>
						<td>{{ $key+1 }}</td>
						<td>{{ $value->name }}</td>
						<td>{{ $value->channel_id }}</td>

						<!-- we will also add show, edit, and delete buttons -->
						<td>
            				@if (false and allowed('admin.brands.destroy'))
            				<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
            				<!-- we will add this later since its a little more complicated than the other two buttons -->
            				{{ Form::open(array('url' => 'brands/' . $value->id)) }}
            				{{ Form::hidden('_method', 'DELETE') }}
            				{{ Form::submit('Delete', array('class' => 'btn btn-warning pull-right')) }}
            				{{ Form::close() }}
            				@endif				
            
            				@if (allowed('admin.brands.show'))
            				<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a href="{{ URL::to('admin/brands/' . $value->id) }}">View</a>
            				@endif
            				/
            				@if (allowed('admin.brands.edit'))
            				<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <a href="{{ URL::to('admin/brands/' . $value->id . '/edit') }}">Edit</a>
                            
            				@endif
                        </td>
    				</tr>
    			@endforeach
            </tbody>
		</table>
	</div>
</div>

{{ $brands->appends(array('paging' => $brands->getPerPage(), 'name' => Input::get('name'), 'upline_id' => Input::get('upline_id')))->links(); }}

<div class="modal fade btn-search" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
                    <span class="glyphicon glyphicon-search"></span> 
					Search Brands
				</h4>
		    </div>
	    	<div class="modal-body">
				<form id="form_search" class="form-horizontal" role="form" method="GET">
					<input type="hidden" value="{{Input::get('paging')}}" name="paging" id="paging">
					<input type="hidden" value="{{Input::get('sort')}}" name="sort" id="sort">
					<input type="hidden" value="{{Input::get('sort_order')}}" name="sort_order" id="sort_order">
			  		<div class="form-group">
			    		<label for="name" class="col-sm-2 control-label">Name</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" id="name" name='name' placeholder="Brand Name">
					    </div>
			  		</div>
			  		<div class="form-group">
			    		<label for="name" class="col-sm-2 control-label">Channel ID</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" id="channel_id" name='channel_id' placeholder="Channel ID">
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