@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#delete_user, #restore_user, #back_to_user").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
		
	});
</script>
<h3>View User</h3>
@stop
<? define("PAGETITLE", " | View User"); ?>
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
			{{ Form::open(array('route' => array('admin.groups.destroy', $groups->id), 'method' => 'delete')) }}
		 		<a id="back_to_user" type="button" class="btn btn-primary" href="{{ URL::to('admin/groups') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>			
			@if (!$groups->deleted_at)		
		  		<a type="button" class="btn btn-primary" href="{{ URL::to('admin/groups/' . $groups->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
			@endif
			{{ Form::close() }}		  	
	  	
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
			{{ Form::open(array('route' => array('admin.groups.destroy', $groups->id), 'method' => 'delete')) }}			
				<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
				<div style="margin-top:8px;"></div>
				<ul class="dropdown-menu" role="menu">
					<li><a id="back_to_user" href="{{ URL::to('admin/groups') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
				@if (!$groups->deleted_at)	
					<li><a href="{{ URL::to('admin/groups/' . $groups->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>	
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
					<label for="name" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$groups->name}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="description" class="col-sm-2 control-label">Description</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$groups->description}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="permission" class="col-sm-2 control-label">Permission</label>
					<div class="col-sm-5">
						@foreach($groups->permissions as $key => $value)
						<p class="form-control-static">{{ $value->description }}</p>
						@endforeach
					</div>
				</div>
			</form>
		</div>
	</div>
	
@stop