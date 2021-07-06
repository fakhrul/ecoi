@extends('layouts.default')

@section('page-header')
<h3>View User</h3>
@stop

@section('content')
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
{{ Form::open(array('route' => array('users.destroy', $user->id), 'method' => 'delete')) }}
		 	<a type="button" class="btn btn-primary" href="{{ URL::to('users') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>			
@if (!$user->deleted_at)		
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('users/' . $user->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		  	<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</button>	
@endif
@if ($user->deleted_at)			  	
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('users/restore?id=' . $user->id) }}"><span class="glyphicon glyphicon-repeat"></span>&nbsp;Restore</a>		  
@endif	
{{ Form::close() }}		  	
	  	
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
{{ Form::open(array('route' => array('users.destroy', $user->id), 'method' => 'delete')) }}			
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a href="{{ URL::to('users') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
@if (!$user->deleted_at)	
				<li><a href="{{ URL::to('users/' . $user->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>									
				<li><a href="javascript:" onclick="parentNode.parentNode.parentNode.submit();"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>	
@endif			
@if ($user->deleted_at)					
				<li><a href="{{ URL::to('users/restore?id=' . $user->id) }}"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>	
@endif					
			</ul>
{{ Form::close() }}				
		</div>
	</div>
		<table class="table table-striped">		
			{{ HTML::clever_table('Name', $user->name) }}
			{{ HTML::clever_table('Username', $user->username) }}
			{{ HTML::clever_table('Channel', $user->channel->name) }}
			{{ HTML::clever_table('Created', $user->created_at) }}	
			{{ HTML::clever_table('Updated', $user->updated_at) }}	
			{{ HTML::clever_table('Deleted', $user->deleted_at) }}				
		</table>
		
@stop