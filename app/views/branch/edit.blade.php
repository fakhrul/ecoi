@extends('layouts.default')
@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		checkPinlessReloadNotification();
		$("#add_branch, #back_to_branch").click(function() {
			$("#loading_panel").addClass("loading-show");
		});

		$('input[type=radio][name=pinless_reload_low_balance_notification]').change(function () {
            checkPinlessReloadNotification();
        });

        function checkPinlessReloadNotification()
       	{
       		var radios = document.getElementsByName("pinless_reload_low_balance_notification");
            for (i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    if(radios[i].value=="y")
                    {
                        $("#pinless_reload_low_level_amount_group").removeClass( "hidden" );
                    }
                    else
                    {
                        $("#pinless_reload_low_level_amount_group").addClass( "hidden" );
                    }
                }
            }
            return false;
       	}

		$('#form_branch')
        // Add button click handler
        .on('click', '#addMsisdn', function() {
        	
            var $template = $('#msisdnTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hidden')
                                .removeAttr('id')
                                .insertBefore($template);

            if ($(':visible[name="msisdn[]"]').length >= 5) {
                $('#addMsisdn').addClass('hidden');
                $('#maxMsisdn').removeClass('hidden');
            }
        })
        // Remove button click handler
        .on('click', '.removeMsisdn', function() {
            if ($(':visible[name="msisdn[]"]').length == 1) {
            	$(this).parents('.form-group').find("input").val("");
            	return false;
            }
            if(!$(this).parents('.form-group').find(".control-label").hasClass("hidden")){
            	$(this).parents('.form-group').next(':visible(".form-group")').find(".control-label").removeClass('hidden');
            	$(this).parents('.form-group').next(':visible(".form-group")').find(".col-sm-offset-2").removeClass('col-sm-offset-2');
            }
            
            var $row    = $(this).parents('.form-group');

            // Remove element containing the option
            $row.remove();

            if ($(':visible[name="msisdn[]"]').length < 5) {
            	$('#addMsisdn').removeClass('hidden');
                $('#maxMsisdn').addClass('hidden');
            }
        })
	});
</script>
<h3>Edit Branch</h3>
@stop
<?
define("PAGETITLE", " | Edit Branch");

?>
@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

<!-- action button start -->
<div class="clearfix">
	<div class="visible-md-block visible-lg-block">
		<a id="back_to_branch" type="button" class="btn btn-primary" href="{{ URL::to('branch') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
		<div style="margin-top:8px;"></div>
	</div>
	<div class="visible-xs-block visible-sm-block dropdown">
		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
		<div style="margin-top:8px;"></div>
		<ul class="dropdown-menu" role="menu">
			<li><a id="back_to_branch" href="{{ URL::to('branch') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
		</ul>
	</div>
</div>
<!-- action button end -->

<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
			{{ Form::open(array('route' => array('branch.update', $list->id), 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form_branch', 'method' => 'PUT')) }}
			<div class="form-group">
				<label for="type" class="col-sm-2 control-label">Type <span class="text-danger">*</span></label>
				<div class="col-sm-5">		
					{{ Form::select('type', array('Branch' => 'Branch', 'Project' => 'Project'),$list->type, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name <span class="text-danger">*</span></label>
				<div class="col-sm-5">		
					{{ Form::text('name', $list->name, array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-5">		
					<input type="text" id="email" name="email" class="form-control" value="{{$list->email}}">
				</div>
			</div>

			<div class="form-group">
				<label for="contact_no" class="col-sm-2 control-label">Contact No.</label>
				<div class="col-sm-5">		
					<div class="input-group">
    					<span class="input-group-addon">+</span>
			    		<input type="text" value="{{$list->contact_no}}" class="form-control" id="contact_no" name="contact_no" placeholder="e.g. 601120123456">
			    	</div>
			    	<p class="help-block">Please add your country code for Contact No.</p>
				</div>
			</div>
			<div class="form-group">
				<label for="start_date" class="col-sm-2 control-label">Start Date</label>
				<div class="col-sm-5">
					<div class="input-group date">
						<input id="start_date" name="start_date" type="text" class="form-control" value="{{$list->start_date}}" readonly>
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-calendar" onclick="selectDate();"></i>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="end_date" class="col-sm-2 control-label">End Date</label>
				<div class="col-sm-5">
					<div class="input-group date">
						<input id="end_date" name="end_date" type="text" class="form-control" value="{{$list->end_date}}" readonly>
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-calendar" onclick="selectDate();"></i>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="desc" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-5">		
					<textarea id="desc" name="desc" class="form-control" rows="3">{{$list->desc}}</textarea>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-2 control-label">SMS Reload MSISDN</label>
				<div class="col-sm-5">		
					<input type="text" name="msisdn[]" value="{{($msisdn)?$msisdn[0] : ''}}" class="form-control" style="display:inline;width:200px" placeholder="e.g. 01120123456"> 
					<span class="glyphicon glyphicon-remove removeMsisdn" style="margin-left:5px; cursor:pointer;"></span>
				</div>
			</div>

			@if($msisdn)
				<?php $count=0; ?>
				@foreach($msisdn as $data)
					<?php $count++; ?>
					@if($count>1)
						<div class="form-group">
							<label for="" class="col-sm-2 control-label hidden">SMS Reload MSISDN</label>
							<div class="col-sm-offset-2 col-sm-5">
								<input type="text" name="msisdn[]" value="{{$data}}" class="form-control" style="display:inline;width:200px" placeholder="e.g. 01120123456"> 
								<span class="glyphicon glyphicon-remove removeMsisdn" style="margin-left:5px; cursor:pointer;"></span>
							</div>
						</div>
					@endif
				@endforeach
			@endif

			<div class="form-group hidden" id="msisdnTemplate">
				<label for="" class="col-sm-2 control-label hidden">SMS Reload MSISDN</label>
				<div class="col-sm-offset-2 col-sm-5">
					<input type="text" name="msisdn[]" class="form-control" style="display:inline;width:200px" placeholder="e.g. 01120123456"> 
					<span class="glyphicon glyphicon-remove removeMsisdn" style="margin-left:5px; cursor:pointer;"></span>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<span class="glyphicon glyphicon-plus" style="cursor:pointer;" id="addMsisdn"></span>
					<p class="help-block hidden" id="maxMsisdn">Maximum 5 MSISDN only.</p>
				</div>
			</div>


			<div class="form-group">
				<label for="pinless_reload_low_balance_notification" class="col-sm-2 control-label">Enable Pinless Reload Low Balance Notification <span class="text-danger">*</span></label>
				<fieldset id="pinless_reload_low_balance_notification" class="col-sm-5">
					<label class="radio-inline">
						{{ Form::radio('pinless_reload_low_balance_notification', 'y', ($list->pinless_reload_low_balance_notification == 'y' ? true : false)) }} Yes
					</label>
					<label class="radio-inline">
						{{ Form::radio('pinless_reload_low_balance_notification', 'n', ($list->pinless_reload_low_balance_notification == 'n' ? true : false)) }} No
					</label>
				</fieldset>
			</div>

			<div class="form-group hidden" id="pinless_reload_low_level_amount_group">
				<label for="pinless_reload_low_level_amount" class="col-sm-2 control-label">Low Level Amount <span class="text-danger">*</span></label>
				<div class="col-sm-5">		
					<input type="text" id="pinless_reload_low_level_amount" name="pinless_reload_low_level_amount" class="form-control" value="{{$list->pinless_reload_low_level_amount}}" placeholder="e.g. 100">
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button id="add_branch" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>
				</div>
			</div>
		{{ Form::close() }}
	</div>
</div>

@stop