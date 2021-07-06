@extends('layouts.default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {

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
<h3>Manage Branch</h3>
@stop
<?
define("PAGETITLE", " | Manage Branch");

?>
@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
		  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
            @if (allowed('branch.create'))
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('branch/create') }}"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</a>
            @endif
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span> Search</a></li>
                @if (allowed('branch.create'))
				<li><a href="{{ URL::to('branch/create') }}"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
                @endif
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading clearfix">
			<form class="form-inline" role="form">
				<div class="pull-left">
					Showing {{ $list->getFrom(); }} - {{ $list->getTo(); }} of {{ $list->getTotal(); }} entries.
				</div>
				<div class="form-group pull-right" style="margin-bottom:0px;">
					<label>Entries Per Page</label>
					{{ Form::select('paging',array('20' => '20', '50' => '50', '100' => '100', '200' => '200'), $list->getPerPage(), array('id' => 'paging', 'class' => 'form-control', 'style' => 'style="width:80px;display:inline;', 'onchange' => 'window.location = "/branch/?name='.Input::get('name').'&sort='.Input::get('sort').'&sort_order='.Input::get('sort_order').'&paging=" + this.value;')) }}
				</div>
			</form>
		</div>
		<div class="table-responsive clearfix">	
			<table class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th>No.</td>
						<th class="{{($sort=='name')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="name">Name</td>
						<th class="{{($sort=='type')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="type">Type</td>
						<th class="{{($sort=='start_date')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="start_date">Start Date</td>	
						<th class="{{($sort=='end_date')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="end_date">End Date</td>		
						<th>Action</td>
					</tr>
				</thead>
				<tbody>
				@foreach($list as $key => $value)
					<tr>
						<td>{{ $key+1 }}</td>
						<td>{{ $value->name }}</td>
						<td>{{ $value->type }}</td>
						<td>{{ $value->start_date }}</td>
						<td>{{ $value->end_date }}</td>

						<!-- we will also add show, edit, and delete buttons -->
						<td>

					@if (false and allowed('branch.destroy'))
					<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
					<!-- we will add this later since its a little more complicated than the other two buttons -->
					{{ Form::open(array('url' => 'branch/' . $value->id)) }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('Delete', array('class' => 'btn btn-warning pull-right')) }}
					{{ Form::close() }}
					@endif				

					@if (allowed('branch.show'))
					<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
					<a href="{{ URL::to('branch/' . $value->id) }}">View</a>
					@endif
					
					@if (allowed('branch.edit'))
                    |
					<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
					<a href="{{ URL::to('branch/' . $value->id . '/edit') }}">Edit</a>
					@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

{{ $list->appends(array('paging' => $list->getPerPage(), 'sort' => Input::get('sort'), 'sort_order' => Input::get('sort_order'), 'name' => Input::get('name')))->links(); }}

<div class="modal fade btn-search" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
					Search Branch
				</h4>
		    </div>
	    	<div class="modal-body">
				<form id="form_search" class="form-horizontal" role="form" method="get">
					<input type="hidden" value="{{Input::get('paging')}}" name="paging" id="paging">
					<input type="hidden" value="{{Input::get('sort')}}" name="sort" id="sort">
					<input type="hidden" value="{{Input::get('sort_order')}}" name="sort_order" id="sort_order">
			  		<div class="form-group">
			    		<label for="name" class="col-sm-2 control-label">Name</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" id="name" name="name" value="{{Input::get('name')}}" placeholder="Branch Name">
					    </div>
			  		</div>
				  	
				  	<div class="form-group">
					  	<div class="col-sm-offset-2 col-sm-10">
				  			<button type="submit" class="btn btn-primary">Submit</button>
				  		</div>
				  	</div>
				</form>
			</div>
		</div>
	</div>
</div>


@stop