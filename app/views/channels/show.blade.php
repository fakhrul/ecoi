@extends('layouts.default')

@section('page-header')
<h3>View Department</h3>
<!--@if (allowed('channels.edit'))
<a class="btn btn-small btn-primary" href="{{ URL::to('channels/' . $channel->id) .'/edit' }}">Edit</a>
@endif-->
@stop

@section('content')
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
{{ Form::open(array('route' => array('channels.destroy', $channel->id), 'method' => 'delete')) }}
		 	<a type="button" class="btn btn-primary" href="{{ URL::to('channels') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>			
@if (!$channel->deleted_at)		
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('channels/' . $channel->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		  	<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</button>	
@endif
@if ($channel->deleted_at)			  	
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('channels/restore?id=' . $channel->id) }}"><span class="glyphicon glyphicon-repeat"></span>&nbsp;Restore</a>		  
@endif	
{{ Form::close() }}		  	
	  	
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
{{ Form::open(array('route' => array('channels.destroy', $channel->id), 'method' => 'delete')) }}			
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a href="{{ URL::to('channels') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
@if (!$channel->deleted_at)	
				<li><a href="{{ URL::to('channels/' . $channel->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>									
				<li><a href="javascript:" onclick="parentNode.parentNode.parentNode.submit();"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>	
@endif			
@if ($channel->deleted_at)					
				<li><a href="{{ URL::to('channels/restore?id=' . $channel->id) }}"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>	
@endif					
			</ul>
{{ Form::close() }}				
		</div>
	</div>
		<table class="table table-striped">		
			{{ HTML::clever_table('Channel Name', $channel->name) }}
			{{ HTML::clever_table('Channel ID', $channel->channel_id) }}
			{{ HTML::clever_table('Channel Type', $channel->type) }}
			{{ HTML::clever_table('Upline', $channel->upline->name) }}
			{{ HTML::clever_table('Brand', $channel->brand->name) }}
			{{ HTML::clever_table('Effective Date', $channel->effective_date) }}
			{{ HTML::clever_table('Address1', $channel->address1) }}
			{{ HTML::clever_table('Address2', $channel->address2) }}
			{{ HTML::clever_table('Address3', $channel->address3) }}
			{{ HTML::clever_table('Post Code', $channel->post_code) }}
			{{ HTML::clever_table('City', $channel->city) }}
			{{ HTML::clever_table('State', $channel->state) }}
			{{ HTML::clever_table('Contact Person', $channel->contact) }}
			{{ HTML::clever_table('Phone1', $channel->phone1) }}		
			{{ HTML::clever_table('Phone2', $channel->phone2) }}										
			{{ HTML::clever_table('Fax', $channel->fax) }}		
			{{ HTML::clever_table('Email', $channel->email) }}			
			{{ HTML::clever_table('Bank Name', $channel->bank_name) }}							
			{{ HTML::clever_table('Bank No', $channel->bank_no) }}		
			{{ HTML::clever_table('Remarks', $channel->remarks) }}	
					
			{{ HTML::clever_table('Created', $channel->created_at . ' (' .$channel->createUser->name .')') }}	
			{{ $channel->updated_at ? HTML::clever_table('Updated', $channel->updated_at . ' (' .$channel->updateUser->name .')') : '' }}
			{{ $channel->deleted_at ? HTML::clever_table('Deleted', $channel->deleted_at . ' (' .$channel->deleteUser->name .')') : '' }}			
		</table>
		
@stop