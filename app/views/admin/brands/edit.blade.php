@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#edit_brand, #back_to_brand").click(function() {
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
			<a id="back_to_brand" type="button" class="btn btn-primary" href="{{ URL::to('admin/brands/' . $brand->id) }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
			<div style="margin-top:8px;"></div>
		</div>
		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a id="back_to_brand" href="{{ URL::to('admin/brands/' . $brand->id) }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
			</ul>
		</div>
	</div>
	<!-- action button end -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
			{{ Form::model($brand, array('route' => array('admin.brands.update', $brand->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

			<div class="form-group">
				{{ Form::label('name', 'Brand Name', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('name', $brand->name, array('class' => 'form-control')) }}
				</div>
			</div>
            
            <div class="form-group">
				{{ Form::label('channel_id', 'Channel ID', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::select('channel_id', $channel, $brand->channel_id, array('class' => 'form-control')) }}
				</div>	
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					 <button id="edit_brand" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>		 
				</div>	
			</div>

			{{ Form::close() }}
		</div>
	</div>

@stop