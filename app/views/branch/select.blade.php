@extends('layouts.default')
@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		$("#select_branch").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
	});
</script>
<h3>Select Branch/Project</h3>
@stop
<?
define("PAGETITLE", " | Select Branch");

?>
@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Details</h3>
	</div>
	<div class="panel-body">
		{{ Form::open(array('url' => 'branch/select', 'class' => 'form-horizontal', 'role' => 'form')) }}


		<div class="form-group">
			{{ Form::label('branch_id', 'Branch/Project', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-3">		
				{{ Form::select('branch_id', $branches, Session::get('branch_id'), array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				 {{-- <a type="button" class="btn btn-default" href="{{ URL::to('branch') }}">Back</a>	--}}	
				{{ Form::submit('Submit', array('id' => 'select_branch', 'class' => 'btn btn-primary')) }}
			</div>
		</div>

		{{ Form::close() }}
	</div>
</div>

@stop