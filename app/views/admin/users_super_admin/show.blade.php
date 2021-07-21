@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {

		$("#delete_user, #restore_user, #back_to_user").click(function() {
			$("#loading_panel").addClass("loading-show");
		});

	});
</script>
<h3>View Super Admin</h3>
@stop
<?
define("PAGETITLE", " | View Super Admin");

?>
@section('content')
<div class="clearfix">
	<div class="visible-md-block visible-lg-block">
		{{ Form::open(array('route' => array('admin.users_super_admin.destroy', $user->id), 'method' => 'delete')) }}
		<a id="back_to_user" type="button" class="btn btn-primary" href="{{ URL::to('admin/users_super_admin') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
		@if (!$user->deleted_at)
		<a type="button" class="btn btn-primary" href="{{ URL::to('admin/users_super_admin/' . $user->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		<button id="delete_user" type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</button>
		@endif
		@if ($user->deleted_at)
		<a id="restore_user" type="button" class="btn btn-primary" href="{{ URL::to('admin/users_super_admin/restore?id=' . $user->id) }}"><span class="glyphicon glyphicon-repeat"></span>&nbsp;Restore</a>
		@endif
		{{ Form::close() }}

		<div style="margin-top:8px;"></div>
	</div>

	<div class="visible-xs-block visible-sm-block dropdown">
		{{ Form::open(array('route' => array('admin.users_super_admin.destroy', $user->id), 'method' => 'delete')) }}
		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
		<div style="margin-top:8px;"></div>
		<ul class="dropdown-menu" role="menu">
			<li><a id="back_to_user" href="{{ URL::to('admin/users_super_admin') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
			@if (!$user->deleted_at)
			<li><a href="{{ URL::to('admin/users_super_admin/' . $user->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
			<li><a id="delete_user" href="javascript:" onclick="parentNode.parentNode.parentNode.submit();"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
			@endif
			@if ($user->deleted_at)
			<li><a id="restore_user" href="{{ URL::to('admin/users_super_admin/restore?id=' . $user->id) }}"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>
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
				<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$user->name}}</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Department</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$user->channel ? $user->channel->name : '-'}}</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$user->email}}</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Username</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$user->username}}</p>
				</div>
			</div>
			<!-- <div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Start Date</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$user->valid_start}}</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">End Date</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$user->valid_end}}</p>
				</div>
			</div> -->
			<!-- <div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Created</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$user->created_at . ' (' .$user->createUser->name .')'}}</p>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Updated</label>
				<div class="col-sm-5">
					<p class="form-control-static">{{$user->updated_at ? $user->updated_at . ' (' .$user->updateUser->name .')' : ''}}</p>
				</div>
			</div> -->
			<!-- <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Branches</label>
					<div class="col-sm-5">
						@foreach($user->branches as $key => $value)
						<p class="form-control-static">{{ $value->name }}</p>
						@endforeach
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Groups</label>
					<div class="col-sm-5">
						@foreach($user->groups as $key => $value)
						<p class="form-control-static">{{ $value->name }}</p>
						@endforeach
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Brands</label>
					<div class="col-sm-5">
						@foreach($user->brands as $key => $value)
						<p class="form-control-static">{{ $value->name }}</p>
						@endforeach
					</div>
				</div>
                <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Stations</label>
					<div class="col-sm-5">
						@foreach($user->stations as $key => $value)
						<p class="form-control-static">{{ $value->station_name }}</p>
						@endforeach
					</div>
				</div> -->
		</form>
	</div>
</div>

@stop