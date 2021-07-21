@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {

		$("#add_user, #back_to_user").click(function() {
			$("#loading_panel").addClass("loading-show");
		});

		$('#form_user')
			// Add button click handler
			.on('click', '#addBranch', function() {

				var $template = $('#branchTemplate'),
					$clone = $template
					.clone()
					.removeClass('hidden')
					.removeAttr('id')
					.insertBefore($template),
					$branch = $clone.find('[name="branch_id[]"]');

				if ($(':visible[name="branch_id[]"]').length >= 100) {
					$('#addBranch').addClass('hidden');
				}
			})
			// Remove button click handler
			.on('click', '.removeBranch', function() {
				if ($(':visible[name="branch_id[]"]').length == 1) {
					$(this).parents('.form-group').find("input").val("");
					return false;
				}
				if (!$(this).parents('.form-group').find(".control-label").hasClass("hidden")) {
					$(this).parents('.form-group').next(':visible(".form-group")').find(".control-label").removeClass('hidden');
					$(this).parents('.form-group').next(':visible(".form-group")').find(".col-sm-offset-2").removeClass('col-sm-offset-2');
				}

				var $row = $(this).parents('.form-group'),
					$branch = $row.find('[name="branch_id[]"]');

				// Remove element containing the option
				$row.remove();

				if ($(':visible[name="branch_id[]"]').length < 100) {
					$('#addBranch').removeClass('hidden');
				}
			})

		$('.cat').click(function() {

			var value = $(this).val(); //alert(value);
			var load = $('#load').data('load');
			var lists = "";
			for (var cat in load) {
				if (value === cat) {
					$.each(load[cat], function(index, value) {
						//alert(value);
						lists += "<option value=" + index + ">" + value + "</option>";

					});
				}
			} //alert(lists);
			$('.subcat').html(lists);

			$("#station_name").html($("#station_name option").sort(function(a, b) {
				return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
			}))

			$('select[multiple]').multiselect('reload');

		});

		$('.cat').change(function() {

			var value = $(this).val(); //alert(value);
			var load = $('#load').data('load');
			var lists = "";
			for (var cat in load) {
				if (value === cat) {
					$.each(load[cat], function(index, value) {
						//alert(value);
						lists += "<option value=" + index + ">" + value + "</option>";

					});
				}
			} //alert(lists);
			$('.subcat').html(lists);

			$("#station_name").html($("#station_name option").sort(function(a, b) {
				return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
			}))

			$('select[multiple]').multiselect('reload');

		});
	});
</script>
<h3>Add Normal User</h3>
@stop
<?
define("PAGETITLE", " | Add Normal User");

?>
@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

<!-- action button start -->
<div class="clearfix">
	<div class="visible-md-block visible-lg-block">
		<a id="back_to_user" type="button" class="btn btn-primary" href="{{ URL::to('admin/users_normal') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
		<div style="margin-top:8px;"></div>
	</div>
	<div class="visible-xs-block visible-sm-block dropdown">
		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
		<div style="margin-top:8px;"></div>
		<ul class="dropdown-menu" role="menu">
			<li><a id="back_to_user" href="{{ URL::to('admin/users_normal') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
		</ul>
	</div>
</div>
<!-- action button end -->

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Details</h3>
	</div>
	<div class="panel-body">
		{{ Form::open(array('url' => 'admin/users_normal', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form_user')) }}

		<div class="form-group">
			{{ Form::label('name', 'Name', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('channel_id', 'Department', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::select('channel_id', $channels, '', array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('username', 'Username', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}
			</div>
		</div>


		<div class="form-group">
			{{ Form::label('password', 'Password', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::password('password', array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('password_confirmation', 'Password Confirmation', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('valid_start', 'Start Date', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::text('valid_start', Input::old('valid_start'), array('class' => 'form-control','id' => 'valid_start')) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('valid_end', 'End Date', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::text('valid_end', Input::old('valid_end'), array('class' => 'form-control','id' => 'valid_end')) }}
			</div>
		</div>

		<!-- <div class="form-group">
			{{ Form::label('state', 'States', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">        
                {{ Form::select('states', $states, NULL, array('class' => 'form-control cat' )) }}           																			
			</div>	
		</div>                        
        
       <div class="form-group">
			{{ Form::label('stations', 'Stations', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">        
                <select name="stations[]" id="station_name" class="form-control subcat" multiple="multiple" size="11">
                  <option value="- Select A State -">- Select A State -</option>
                </select>
                <div id="load" data-load='{{$states_stations}}'></div>   <br/>      																			
			</div>	
		</div>-->

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button id="add_user" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>
			</div>
		</div>

		<script type="text/javascript">
			//select2
			var data = [{
				id: 0,
				text: 'enhancement'
			}, {
				id: 1,
				text: 'bug'
			}, {
				id: 2,
				text: 'duplicate'
			}, {
				id: 3,
				text: 'invalid'
			}, {
				id: 4,
				text: 'wontfix'
			}];
			$(".js-example-data-array").select2({
				data: data
			})
			$(".js-example-data-array-selected").select2({
				data: data
			})
			//jQuery MultiSelect
			$('select[multiple]').multiselect({
				columns: 1,
				placeholder: 'Select Permission',
				search: true,
				selectAll: true
			});
			$("#valid_start").datepicker({
				format: "yyyy-mm-dd",
				//weekStart: 0,
				//calendarWeeks: true,
				autoclose: true,
				todayHighlight: true,
				//rtl: true,
				orientation: "auto"
			});
			$("#valid_end").datepicker({
				format: "yyyy-mm-dd",
				//weekStart: 0,
				//calendarWeeks: true,
				autoclose: true,
				todayHighlight: true,
				//rtl: true,
				orientation: "auto"
			});
		</script>

		{{ Form::close() }}
	</div>
</div>

@stop