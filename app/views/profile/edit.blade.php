@extends('layouts.default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {

		$("#edit_profile").click(function() {
			$("#loading_panel").addClass("loading-show");
		});

	});
</script>
<h3>Edit Profile</h3>

@stop
<?
define("PAGETITLE", " | Edit Profile");

?>
@section('content')

@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Details</h3>
	</div>
	<div class="panel-body">
		{{ Form::model($user, array('route' => array('profile.update'), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

		<div class="form-group">
			{{ Form::label('username', 'Username', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">		
				{{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'readonly')) }}
			</div>	
		</div>

		<div class="form-group">
			{{ Form::label('name', 'Name *', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">		
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">		
				{{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('password', 'Password', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">		
				{{ Form::password('password', array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('password_confirmation', 'Password Confirmation', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">		
				{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				 <button id="edit_profile" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>		 
			</div>
		</div>

		{{ Form::close() }}
	</div>
</div>

@stop