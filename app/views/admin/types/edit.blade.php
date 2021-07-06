@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#edit_type, #back_to_type").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
		
	});
</script>
<h3>Edit Type</h3>

@stop
<?
define("PAGETITLE", " | Edit Type");

?>
@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif
	<!-- action button start -->
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
			<a id="back_to_type" type="button" class="btn btn-primary" href="{{ URL::to('admin/types/' . $type->id) }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
			<div style="margin-top:8px;"></div>
		</div>
		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a id="back_to_type" href="{{ URL::to('admin/types/' . $type->id) }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
			</ul>
		</div>
	</div>
	<!-- action button end -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
			{{ Form::model($type, array('route' => array('admin.types.update', $type->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

			<div class="form-group">
				{{ Form::label('type_code', 'Type Code', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('type_code', $type->type_code, array('class' => 'form-control', 'maxlength' => 2)) }}
				</div>
			</div>
            
            <div class="form-group">
				{{ Form::label('type_description', 'Type Description', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::textarea('type_description', $type->type_description, array('class' => 'form-control')) }}
				</div>	
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					 <button id="edit_type" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>		 
				</div>	
			</div>

			{{ Form::close() }}
		</div>
	</div>

@stop