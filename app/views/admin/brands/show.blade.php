@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#delete_brand, #restore_brand, #back_to_brand").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
		
	});
</script>
<h3>View Brand</h3>
@stop
<?
define("PAGETITLE", " | View Brand");

?>
@section('content')
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
        {{ Form::open(array('route' => array('admin.brands.destroy', $brand->id), 'method' => 'delete')) }}
            <a id="back_to_brand" type="button" class="btn btn-primary" href="{{ URL::to('admin/brands') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a> 		
        @if (!$brand->deleted_at and allowed('admin.brands.edit'))		
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('admin/brands/' . $brand->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		  	<!--<button id="delete_brand" type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</button>-->	
        @endif
        @if ($brand->deleted_at and allowed('admin.brands.destroy'))			  	
		  	<a id="restore_brand" type="button" class="btn btn-primary" href="{{ URL::to('admin/brands/restore?id=' . $brand->id) }}"><span class="glyphicon glyphicon-repeat"></span>&nbsp;Restore</a>		  
        @endif	
        {{ Form::close() }}		  	
	  	
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
        {{ Form::open(array('route' => array('admin.brands.destroy', $brand->id), 'method' => 'delete')) }}			
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a id="back_to_brand" href="{{ URL::to('admin/brands') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
            @if (!$brand->deleted_at and allowed('admin.brands.edit'))	
				<li><a href="{{ URL::to('admin/brands/' . $brand->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>									
				<!--<li><a id="delete_brand" href="javascript:" onclick="parentNode.parentNode.parentNode.submit();"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>-->	
            @endif			
            @if ($brand->deleted_at and allowed('admin.brands.destroy'))					
				<li><a id="restore_brand" href="{{ URL::to('admin/brands/restore?id=' . $brand->id) }}"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>	
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
					<label for="inputBrandName" class="col-sm-2 control-label">Brand Name</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$brand->name}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputChannelID" class="col-sm-2 control-label">Channel ID</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$brand->channel_id}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCreated" class="col-sm-2 control-label">Created</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$brand->created_at . ' (' .$brand->createUser->name .')'}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputUpdated" class="col-sm-2 control-label">Updated</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$brand->updated_at ? $brand->updated_at . ' (' .$brand->updateUser->name .')' : ''}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDeleted" class="col-sm-2 control-label">Deleted</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$brand->deleted_at ? $brand->deleted_at . ' (' .$brand->deleteUser->name .')' : ''}}</p>
					</div>
				</div>
			</form>
		</div>
	</div>
		
		
@stop