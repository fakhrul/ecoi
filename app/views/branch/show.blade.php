@extends('layouts.default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#back_to_branch").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
		
	});
</script>
<h3>View Branch</h3>
@stop

@section('content')
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
			<a id="back_to_branch" type="button" class="btn btn-primary" href="{{ URL::to('branch') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
            @if (allowed('branch.edit'))
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('branch/' . $list->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
            @endif
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a id="back_to_branch" href="{{ URL::to('branch') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
                @if (allowed('branch.edit'))
				<li><a href="{{ URL::to('branch/' . $list->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>
                @endif
			</ul>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Channel</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->channel->name}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->name}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Type</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->type}}</p>
					</div>
				</div>
				{{-- <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->email}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Contact No.</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->contact_no}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Start Date</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->start_date}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">End Date</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->end_date}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Description</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->desc}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">SMS Reload MSISDN</label>
					<div class="col-sm-5">
						<p class="form-control-static">
							@foreach($list->msisdn as $msisdn)
								{{$msisdn->msisdn}}<br>
							@endforeach
						</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Enable Pinless Reload Low Balance Notification</label>
					<div class="col-sm-5">
						<p class="form-control-static">
							@if($list->pinless_reload_low_balance_notification == "y")
								Yes
							@else
								No
							@endif
						</p>
					</div>
				</div>
				@if($list->pinless_reload_low_balance_notification == "y")
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Low Level Amount</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{number_format($list->pinless_reload_low_level_amount)}}</p>
					</div>
				</div>
				@endif
                --}}
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Created At</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->created_at}} ({{$list->createUser->name}})</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Updated At</label>
					<div class="col-sm-5">
						<p class="form-control-static">
							{{$list->updated_at}} 
							@if($list->updated_by !="")
								({{$list->updateUser->name}})
							@endif
						</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Deleted At</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$list->deleted_at}}</p>
					</div>
				</div>
			</form>
		</div>
	</div>
@stop