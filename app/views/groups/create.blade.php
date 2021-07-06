@extends('layouts.default')
@section('page-header')
<h3>Add User</h3>
@stop

@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

{{ Form::open(array('url' => 'users', 'class' => 'form-horizontal', 'role' => 'form')) }}

<div class="form-group">
	{{ Form::label('username', 'Username', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-10">		
		{{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}
	</div>	
</div>

<div class="form-group">
	{{ Form::label('channel', 'Channel', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-10">		
		{{ Form::text('channel_id', Input::old('channel_id'), array('class' => 'form-control')) }}
	</div>	
</div>

<div class="form-group">
	{{ Form::label('name', 'Name', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-10">		
		{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-10">		
		{{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('password', 'Password', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-10">		
		{{ Form::password('password', array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('password_confirmation', 'Password Confirmation', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-10">		
		{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
	</div>
</div>




<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		 <a type="button" class="btn btn-primary" href="{{ URL::to('channels') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
		 <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>		 
	</div>	
</div>

{{ Form::close() }}

@stop