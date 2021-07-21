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
<h3>Normal User List</h3>
@stop
<?
define("PAGETITLE", " | Normal User List");

?>
@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
		  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
		  	<a type="button" class="btn btn-primary" href="users_normal/create"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</a>
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span> Search</a></li>
				<li><a href="users_normal/create"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
			<div class="panel-heading clearfix">
				<form class="form-inline" role="form">
					<div class="pull-left">
						Showing {{ $users->getFrom(); }} - {{ $users->getTo(); }} of {{ $users->getTotal(); }} entries.
					</div>
					<div class="form-group pull-right" style="margin-bottom:0px;">
						<label>Entries Per Page</label>
						{{ Form::select('paging',array('5' => '5','10' => '10', '20' => '20', '50' => '50', '100' => '100', '200' => '200'), $users->getPerPage(), array('id' => 'paging', 'class' => 'form-control', 'style' => 'style="width:80px;display:inline;', 'onchange' => 'window.location = "'.URL::to('admin/users_normal').'?name='.Input::get('name').'&type='.Input::get('type').'&sort='.Input::get('sort').'&sort_order='.Input::get('sort_order').'&paging=" + this.value;')) }}
					</div>
				</form>
			</div>
			<div class="table-responsive clearfix">	
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th class="{{($sort=='users.name')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="users.name">Name</th>	
							<th class="{{($sort=='users.channel_id')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="users.channel_id">Department</th>	
							<th class="{{($sort=='users.username')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="users.username">Username</th>							
							<!-- <th class="{{($sort=='users.brand_id')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="users.brand_id">Brand</th>						 -->
							<th class="{{($sort=='users.start_date')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="users.start_date">Start Date</th>						
							<th class="{{($sort=='users.end_date')? (($sort_order=='desc')? 'sort_desc' : 'sort_asc') : 'sort' }} pointer" value="users.end_date">End Date</th>						
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					@foreach($users as $key => $value)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $value->name }}</td>
							<td>{{ $value->channel ? $value->channel->name : '-' }}</td>
							<td>{{ $value->username }}</td>
							<td>{{ $value->valid_start }}</td>
							<td>{{ $value->valid_end }}</td>
							<!-- <td>{{ $value->brand->name }}</td> -->
							<!-- we will also add show, edit, and delete buttons -->
							<td>

        					@if (false and allowed('admin.users_normal.destroy'))
        					<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
        					<!-- we will add this later since its a little more complicated than the other two buttons -->
        					{{ Form::open(array('url' => 'admin/users/' . $value->id)) }}
        					{{ Form::hidden('_method', 'DELETE') }}
        					{{ Form::submit('Delete', array('class' => 'btn btn-warning pull-right')) }}
        					{{ Form::close() }}
        					@endif				
        
        					@if (allowed('admin.users_normal.show'))
        					<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
        					<a href="{{ URL::to('admin/users_normal/' . $value->id) }}">View</a>
        					@endif
        					|
        					@if (allowed('admin.users_normal.edit'))
        					<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
        					<a href="{{ URL::to('admin/users_normal/' . $value->id . '/edit') }}">Edit</a>
        					@endif

						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

{{ $users->appends(array('paging' => $users->getPerPage(), 'name' => Input::get('name'),'type' => Input::get('type')))->links(); }}

<div class="modal fade btn-search" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
					Search Users
				</h4>
		    </div>
	    	<div class="modal-body">
				<form id="form_search" class="form-horizontal" role="form" method="GET">
					<input type="hidden" value="{{Input::get('paging')}}" name="paging" id="paging">
					<input type="hidden" value="{{Input::get('sort')}}" name="sort" id="sort">
					<input type="hidden" value="{{Input::get('sort_order')}}" name="sort_order" id="sort_order">
			  		<div class="form-group">
			    		<label for="username" class="col-sm-2 control-label">Name</label>
					    <div class="col-sm-5">
					    	<input type="text" class="form-control" id="username" name='username' placeholder="Username">
					    </div>
			  		</div>	  		
				  	<div class="form-group">
				    	<label for="status" class="col-sm-2 control-label">Status</label>
				    	<div class="col-sm-5">
							{{ Form::select('status',array('A' => 'All', '' => 'Active', 
							'D' => 'Inactive'), Input::get('status'), array('class' => 'form-control')) }}
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