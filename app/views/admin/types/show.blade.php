@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#delete_type, #restore_type, #back_to_type").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
		
	});
</script>
<h3>View Type</h3>
@stop
<?
define("PAGETITLE", " | View Type");
?>
@section('content')
@if (Session::has("message"))
	<div class="alert alert-info">{{ Session::get("message") }}</div>
@endif
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
        {{ Form::open(array('route' => array('admin.types.destroy', $type->id), 'method' => 'delete')) }}
            <a id="back_to_type" type="button" class="btn btn-primary" href="{{ URL::to('admin/types') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a> 		
        @if (!$type->deleted_at and allowed('admin.types.edit'))		
		  	<a type="button" class="btn btn-primary" href="{{ URL::to('admin/types/' . $type->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		  	<!--<button id="delete_type" type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</button>-->	
        @endif
        @if ($type->deleted_at and allowed('admin.types.destroy'))			  	
		  	<a id="restore_type" type="button" class="btn btn-primary" href="{{ URL::to('admin/types/restore?id=' . $type->id) }}"><span class="glyphicon glyphicon-repeat"></span>&nbsp;Restore</a>		  
        @endif	
        {{ Form::close() }}		  	
	  	
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
        {{ Form::open(array('route' => array('admin.types.destroy', $type->id), 'method' => 'delete')) }}			
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a id="back_to_type" href="{{ URL::to('admin/types') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
            @if (!$type->deleted_at and allowed('admin.types.edit'))	
				<li><a href="{{ URL::to('admin/types/' . $type->id) .'/edit' }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a></li>									
				<!--<li><a id="delete_type" href="javascript:" onclick="parentNode.parentNode.parentNode.submit();"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>-->	
            @endif			
            @if ($type->deleted_at and allowed('admin.types.destroy'))					
				<li><a id="restore_type" href="{{ URL::to('admin/types/restore?id=' . $type->id) }}"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>	
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
					<label for="inputTypeCode" class="col-sm-2 control-label">Type Code</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$type->type_code}}</p>
					</div>
				</div>
                <div class="form-group">
					<label for="inputTypeDescription" class="col-sm-2 control-label">Type Description</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$type->type_description}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCreated" class="col-sm-2 control-label">Created</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$type->created_at . ' (' .$type->createUser->name .')'}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputUpdated" class="col-sm-2 control-label">Updated</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$type->updated_at ? $type->updated_at . ' (' .$type->updateUser->name .')' : ''}}</p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDeleted" class="col-sm-2 control-label">Deleted</label>
					<div class="col-sm-5">
						<p class="form-control-static">{{$type->deleted_at ? $type->deleted_at . ' (' .$type->deleteUser->name .')' : ''}}</p>
					</div>
				</div>
			</form>
		</div>
	</div>
		
		
@stop