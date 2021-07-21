@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {

		$("#edit_user, #back_to_user").click(function() {
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
			// Values from MySQL database
			var product = '<?php echo $station_user; ?>';
			// Convert string to array
			var product_array = product.split(", "); //alert(product); alert(product_array); exit();

			var value = $(this).val();
			var load = $('#load').data('load');
			var lists = "";
			for (var cat in load) {
				if (value === cat) {
					$.each(load[cat], function(index, value) { //alert(index);
						var selected = '';
						for (val of product_array) { //console.log(val);
							if (val === index) {
								selected = 'selected'
							}
						}
						lists += "<option value=" + index + " " + selected + ">" + value + "</option>";
					});
				}
			}

			$('.subcat').html(lists);

			$("#station_name").html($("#station_name option").sort(function(a, b) {
				return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
			}))

			$('select[multiple]').multiselect('reload');
		});

		$('.cat').change(function() {
			// Values from MySQL database
			var product = '<?php echo $station_user; ?>';
			// Convert string to array
			var product_array = product.split(", "); //alert(product); alert(product_array); exit();

			var value = $(this).val();
			var load = $('#load').data('load');
			var lists = "";
			for (var cat in load) {
				if (value === cat) {
					$.each(load[cat], function(index, value) { //alert(index);
						var selected = '';
						for (val of product_array) { //console.log(val);
							if (val === index) {
								selected = 'selected'
							}
						}
						lists += "<option value=" + index + " " + selected + ">" + value + "</option>";
					});
				}
			}

			$('.subcat').html(lists);

			$("#station_name").html($("#station_name option").sort(function(a, b) {
				return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
			}))

			$('select[multiple]').multiselect('reload');
		});

	});
</script>
<h3>Edit Super Admin</h3>

@stop
<?
define("PAGETITLE", " | Edit Super Admin");

?>
@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif
<div class="clearfix">
	<div class="visible-md-block visible-lg-block">
		<a id="back_to_user" type="button" class="btn btn-primary" href="{{ URL::to('admin/users_super_admin/' . $user->id) }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
		<div style="margin-top:8px;"></div>
	</div>
	<div class="visible-xs-block visible-sm-block dropdown">
		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
		<div style="margin-top:8px;"></div>
		<ul class="dropdown-menu" role="menu">
			<li><a id="back_to_user" href="{{ URL::to('admin/users_super_admin/' . $user->id) }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
		</ul>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Details</h3>
	</div>
	<div class="panel-body">
		{{ Form::model($user, array('route' => array('admin.users_super_admin.update', $user->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'form_user')) }}
		<div class="form-group">
			{{ Form::label('name', 'Name', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('channel', 'Department', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				{{ Form::text('channel_id', $user->channel ? $user->channel->name : '-' , array('class' => 'form-control', 'readonly')) }}
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
				{{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'readonly')) }}
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

		<!-- <div class="form-group">
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
		</div> -->

		<!-- <div class="form-group">
			{{ Form::label('group_id', 'Group', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				@foreach($groups as $group)
					<label class="radio-inline"  style="width:200px; padding-left:0px; margin-left:0px;">
						{{ Form::checkbox('groups[]', $group->id, in_array($group->id, $user_groups) ) }} {{ $group->name }}
					</label>
				@endforeach																				
			</div>	
		</div>

		<div class="form-group">
			{{ Form::label('brand_id', 'Brand', array('class' => 'col-sm-2 control-label')) }}
			<div class="col-sm-5">
				@foreach($brands as $brand)
					<label class="radio-inline"  style="width:200px; padding-left:0px; margin-left:0px;">
						{{ Form::checkbox('brands[]', $brand->id, in_array($brand->id, $user_brands) ) }} {{ $brand->name }}
					</label>
				@endforeach																				
			</div>	
		</div> -->


		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button id="edit_user" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>
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