@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#delete_channel, #restore_channel, #back_to_channel").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
		
	});
</script>
<h3>View Channel</h3>
@stop
<?
define("PAGETITLE", " | View Channel");

?>
@section('content')
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
{{ Form::open(array('route' => array('admin.channels.destroy', $channel->id), 'method' => 'delete')) }}
		 	<a id="back_to_channel" type="button" class="btn btn-primary" href="{{ URL::to('admin/channels') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>			
@if (!$channel->deleted_at and allowed('admin.channels.edit'))		
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('admin/channels/' . $channel->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		  	<button id="delete_channel" type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</button>	
@endif
@if ($channel->deleted_at and allowed('admin.channels.destroy'))			  	
		  	<a id="restore_channel" type="button" class="btn btn-primary" href="{{ URL::to('admin/channels/restore?id=' . $channel->id) }}"><span class="glyphicon glyphicon-repeat"></span>&nbsp;Restore</a>		  
@endif	
{{ Form::close() }}		  	
	  	
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
{{ Form::open(array('route' => array('admin.channels.destroy', $channel->id), 'method' => 'delete')) }}			
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a id="back_to_channel" href="{{ URL::to('admin/channels') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
@if (!$channel->deleted_at and allowed('admin.channels.edit'))	
				<li><a href="{{ URL::to('admin/channels/' . $channel->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>									
				<li><a id="delete_channel" href="javascript:" onclick="parentNode.parentNode.parentNode.submit();"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>	
@endif			
@if ($channel->deleted_at and allowed('admin.channels.destroy'))					
				<li><a id="restore_channel" href="{{ URL::to('admin/channels/restore?id=' . $channel->id) }}"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>	
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
					<label for="inputEmail3" class="col-sm-2 control-label">Channel ID</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->channel_id}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Company Name</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->name}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Company Reg No.</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->reg_no}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Channel Type</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->type}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Upline</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->upline ? $channel->upline->name : '-'}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Brand</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->brand->name}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Effective Date</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->effective_date}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Address1</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->address1}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Address2</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->address2}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Address3</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->address3}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Postcode</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->post_code}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">City</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->city}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">State</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->state}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Contact Person</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->contact}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Phone1</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->phone1}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Phone2</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->phone2}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Fax</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->fax}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->email}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Bank Name</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->bank_name}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Bank No</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->bank_no}}</p>
					</div>
				</div>
				<!--<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Recurring Commissions</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->recurring?'Yes':'No'}}</p>
					</div>
				</div>				
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Consignment</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->is_consign?'Yes':'No'}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Consignment Amount</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{number_format($channel->consign_amount,2)}}</p>
					</div>
				</div>-->
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Remarks</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->remarks}}</p>
					</div>
				</div>
				<!--<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">GPS Coordinate</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->gps}}</p>
					</div>
				</div>-->
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Created</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->created_at . ' (' .$channel->createUser->name .')'}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Updated</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->updated_at ? $channel->updated_at . ' (' .$channel->updateUser->name .')' : ''}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Deleted</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$channel->deleted_at ? $channel->deleted_at . ' (' .$channel->deleteUser->name .')' : ''}}</p>
					</div>
				</div>
			</form>
		</div>
	</div>
		
		
@stop