@extends('layouts.default')

@section('page-header')
	<h3>Edit Channel</h3>

@stop

@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

{{ Form::model($channel, array('route' => array('channels.update', $channel->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

<div class="form-group">
	{{ Form::label('channel_id', 'Channel ID', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-2">		
		{{ Form::text('channel_id', Input::old('channel_id'), array('class' => 'form-control', 'readonly')) }}
	</div>	
</div>

<div class="form-group">
	{{ Form::label('name', 'Channel Name', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-4">		
		{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('type', 'Channel Type', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">		
		{{ Form::select('type', array('' => 'Select Type', 'Master Distributor' => 'Master Distributor', 'Distributor' => 'Distributor', 'Dealer' => 'Dealer'), Input::old('type'), array('class' => 'form-control')) }}
	</div>	
</div>

<div class="form-group">
	{{ Form::label('upline_id', 'Upline', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-4">		
		{{ Form::select('upline_id', $upline_options, Input::old('upline_id'), array('class' => 'form-control')) }}
	</div>	
</div>

<div class="form-group">
	{{ Form::label('brand_id', 'Brand', array('class' => 'col-sm-2 control-label')) }}		
	<div class="col-sm-3">
		{{ Form::select('brand_id', $brands, Input::old('brand_id'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('effective_date', 'Effective date', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-2">		
		{{ Form::input('date', 'effective_date', Input::old('effective_date'), array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('address1', 'Address1', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-4">		
		{{ Form::text('address1', Input::old('address1'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('address2', 'Address2', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-4">		
		{{ Form::text('address2', Input::old('address2'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('address3', 'Address3', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-4">		
		{{ Form::text('address3', Input::old('address3'), array('class' => 'form-control')) }}
	</div>
</div>


<div class="form-group">
	{{ Form::label('post_code', 'Post Code', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-2">		
		{{ Form::text('post_code', Input::old('post_code'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('city', 'City', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">		
		{{ Form::text('city', Input::old('city'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('state', 'State', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">		
		{{ Form::select('state', array('' => 'Select State', 'Other' => 'Other', 'Johor' => 'Johor', 'Kedah' => 'Kedah', 'Kelantan' => 'Kelantan', 'Melaka' => 'Melaka', 'Negeri Sembilan' => 'Negeri Sembilan', 'Pahang' => 'Pahang', 'Perak' => 'Perak', 'Perlis' => 'Perlis', 'Pulau Pinang' => 'Pulau Pinang', 'Sabah' => 'Sabah', 'Sarawak' => 'Sarawak', 'Selangor' => 'Selangor', 'Terengganu' => 'Terengganu', 'Wilayah Perseketuan' => 'Wilayah Perseketuan'), Input::old('state'), array('class' => 'form-control')) }}
	</div>
</div>


<div class="form-group">
	{{ Form::label('contact', 'Contact Person', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">		
		{{ Form::text('contact', Input::old('contact'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('phone1', 'Phone1', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-2">		
		{{ Form::text('phone1', Input::old('phone1'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('phone2', 'Phone2', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-2">		
		{{ Form::text('phone2', Input::old('phone2'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('fax', 'Fax', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-2">		
		{{ Form::text('fax', Input::old('fax'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">		
		{{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('bank_name', 'Bank Name', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">		
		{{ Form::select('bank_name', array('' => 'Select Bank', 'Affin Bank' => 'Affin Bank', 'Alliance Bank' => 'Alliance Bank', 'AmBank' => 'AmBank', 'CIMB Bank' => 'CIMB Bank', 'Hong Leong Bank' => 'Hong Leong Bank', 'Maybank' => 'Maybank', 'Public Bank' => 'Public Bank', 'RHB Bank' => 'RHB Bank'), Input::old('bank_name'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('bank_no', 'Bank Account No', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">		
		{{ Form::text('bank_no', Input::old('bank_no'), array('class' => 'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('remarks', 'Remarks', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-5">		
		{{ Form::textarea('remarks', Input::old('remarks'), array('class' => 'form-control')) }}
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