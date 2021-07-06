@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#edit_channel, #back_to_channel").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
		
	});
</script>
<h3>Edit Channel</h3>

@stop
<?
define("PAGETITLE", " | Edit Channel");

?>
@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif
	<!-- action button start -->
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
			<a id="back_to_channel" type="button" class="btn btn-primary" href="{{ URL::to('admin/channels/' . $channel->id) }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
			<div style="margin-top:8px;"></div>
		</div>
		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a id="back_to_channel" href="{{ URL::to('admin/channels/' . $channel->id) }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
			</ul>
		</div>
	</div>
	<!-- action button end -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
			{{ Form::model($channel, array('route' => array('admin.channels.update', $channel->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

			<div class="form-group">
				{{ Form::label('channel_id', 'Channel ID', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('channel_id', $channel->channel_id, array('class' => 'form-control', 'readonly')) }}
				</div>	
			</div>

			<div class="form-group">
				{{ Form::label('name', 'Company Name', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('name', $channel->name, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('name', 'Company Reg No.', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('reg_no', $channel->reg_no, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('type', 'Channel Type', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::select('type', array('' => 'Select Type', 'MD' => 'Master Distributor', 'DS' => 'Distributor', 'D' => 'Dealer', 'C' => 'Client'), $channel->type, array('class' => 'form-control')) }}
				</div>	
			</div>

			<div class="form-group">
				{{ Form::label('upline_id', 'Upline', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::select('upline_id', $upline_options, $channel->upline_id, array('class' => 'form-control')) }}
				</div>	
			</div>

			<div class="form-group">
				{{ Form::label('brand_id', 'Brand', array('class' => 'col-sm-2 control-label')) }}		
				<div class="col-sm-5">
					{{ Form::select('brand_id', $brands, $channel->brand_id, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				<label for="effective_date" class="col-sm-2 control-label">Effective Date</label>
				<div class="col-sm-5">
					<div class="input-group date">
						<input id="effective_date" name="effective_date" type="text" class="form-control" value="{{$channel->effective_date}}" readonly>
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-calendar" onclick="selectDate();"></i>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('address1', 'Address1', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('address1', $channel->address1, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('address2', 'Address2', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('address2', $channel->address2, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('address3', 'Address3', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('address3', $channel->address3, array('class' => 'form-control')) }}
				</div>
			</div>


			<div class="form-group">
				{{ Form::label('post_code', 'Post Code', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('post_code', $channel->post_code, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('city', 'City', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('city', $channel->city, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('state', 'State', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::select('state', array('' => 'Select State', 'Other' => 'Other', 'Johor' => 'Johor', 'Kedah' => 'Kedah', 'Kelantan' => 'Kelantan', 'Melaka' => 'Melaka', 'Negeri Sembilan' => 'Negeri Sembilan', 'Pahang' => 'Pahang', 'Perak' => 'Perak', 'Perlis' => 'Perlis', 'Pulau Pinang' => 'Pulau Pinang', 'Sabah' => 'Sabah', 'Sarawak' => 'Sarawak', 'Selangor' => 'Selangor', 'Terengganu' => 'Terengganu', 'Wilayah Persekutuan' => 'Wilayah Persekutuan'), $channel->state, array('class' => 'form-control')) }}
				</div>
			</div>


			<div class="form-group">
				{{ Form::label('contact', 'Contact Person', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('contact', $channel->contact, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('phone1', 'Phone1', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('phone1', $channel->phone1, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('phone2', 'Phone2', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('phone2', $channel->phone2, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('fax', 'Fax', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('fax', $channel->fax, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('email', $channel->email, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('bank_name', 'Bank Name', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::select('bank_name', array('' => 'Select Bank', 'Agro Bank' => 'Agro Bank', 'Affin Bank' => 'Affin Bank', 'Alliance Bank' => 'Alliance Bank', 'AmBank' => 'AmBank', 'CIMB Bank' => 'CIMB Bank', 'Hong Leong Bank' => 'Hong Leong Bank', 'Maybank' => 'Maybank', 'Public Bank' => 'Public Bank', 'RHB Bank' => 'RHB Bank', 'OCBC Bank' => 'OCBC Bank', 'HSBC Bank' => 'HSBC Bank', 'Standard Chartered Bank' => 'Standard Chartered Bank', 'UOB Bank' => 'UOB Bank', 'Bank Simpanan Nasional' => 'Bank Simpanan Nasional', 'Bank Islam' => 'Bank Islam'), $channel->bank_name, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('bank_no', 'Bank Account No', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('bank_no', $channel->bank_no, array('class' => 'form-control')) }}
				</div>
			</div>

			@if(Auth::user()->brand_id == '1')
			<div class="form-group">
				{{ Form::label('recurring', 'Recurring Commissions', array('class' => 'col-sm-2 control-label')) }}
				<fieldset id="recurring" class="col-sm-5">		
					<label class="radio-inline">
						{{ Form::radio('recurring', 1, true, array('id' => 'recurring0')) }} Yes
					</label>
					<label class="radio-inline">
						{{ Form::radio('recurring', 0, false, array('id' => 'recurring1')) }} No
					</label>		
				</fieldset>	
			</div>

			<div class="form-group">
				{{ Form::label('is_consign', 'Consignment', array('class' => 'col-sm-2 control-label')) }}
				<fieldset id="is_consign" class="col-sm-5">		
					<label class="radio-inline">
						{{ Form::radio('is_consign', 1, false, array('id' => 'is_consign0')) }} Yes
					</label>
					<label class="radio-inline">
						{{ Form::radio('is_consign', 0, true, array('id' => 'is_consign1')) }} No
					</label>		
				</fieldset>	
			</div>

			<div class="form-group">
				{{ Form::label('consign_amount', 'Consignment Amount', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('consign_amount', $channel->consign_amount, array('class' => 'form-control')) }}
				</div>
			</div>
			@endif

			<div class="form-group">
				{{ Form::label('remarks', 'Remarks', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::textarea('remarks', $channel->remarks, array('class' => 'form-control', 'rows' => '5')) }}
				</div>
			</div>

			@if(Auth::user()->brand_id == '1')

			<div class="form-group">
				{{ Form::label('gps', 'GPS Coordinate', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('gps', $channel->gps, array('class' => 'form-control')) }}
				</div>
			</div>
			@endif


			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					 <button id="edit_channel" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>		 
				</div>	
			</div>

			{{ Form::close() }}
		</div>
	</div>

@stop