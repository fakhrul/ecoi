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
<h3>Add Branch</h3>
@stop
<?
define("PAGETITLE", " | Add Branch");

?>
@section('content')

@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
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
			{{ Form::open(array('url' => 'branch', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form_branch')) }}
			<div class="form-group">
				<label for="type" class="col-sm-2 control-label">Type <span class="text-danger">*</span></label>
				<div class="col-sm-5">		
					{{-- Form::select('type', array('Branch' => 'Branch', 'Project' => 'Project'), Input::old('type'), array('class' => 'form-control')) --}}
                    {{ Form::select('type', array('Branch' => 'Branch'), Input::old('type'), array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name <span class="text-danger">*</span></label>
				<div class="col-sm-5">		
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-5">		
					<input type="text" id="email" name="email" class="form-control" value="{{Input::old('email')}}">
				</div>
			</div>

			<div class="form-group">
				<label for="contact_no" class="col-sm-2 control-label">Contact No.</label>
				<div class="col-sm-5">		
					<div class="input-group">
    					<span class="input-group-addon">+</span>
			    		<input type="text" value="{{Input::old('contact_no')}}" class="form-control" id="contact_no" name="contact_no" placeholder="e.g. 601120123456">
			    	</div>
			    	<p class="help-block">Please add your country code for Contact No.</p>
				</div>
			</div>
			<div class="form-group">
				<label for="start_date" class="col-sm-2 control-label">Start Date</label>
				<div class="col-sm-5">
					<div class="input-group date">
						<input id="start_date" name="start_date" type="text" class="form-control" value="{{Input::old('start_date')}}" readonly>
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
						<input id="end_date" name="end_date" type="text" class="form-control" value="{{Input::old('end_date')}}" readonly>
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-calendar" onclick="selectDate();"></i>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="desc" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-5">		
					<textarea id="desc" name="desc" class="form-control" rows="3">{{Input::old('desc')}}</textarea>
				</div>
			</div>

			<!--<div class="form-group">
				<label for="" class="col-sm-2 control-label">SMS Reload MSISDN</label>
				<div class="col-sm-5">		
					<input type="text" name="msisdn[]" value="{{(Input::old('msisdn'))?Input::old('msisdn')[0] : ''}}" class="form-control" style="display:inline;width:200px" placeholder="e.g. 01120123456"> 
					<span class="glyphicon glyphicon-remove removeMsisdn" style="margin-left:5px; cursor:pointer;"></span>
				</div>
			</div>

			@if(Input::old("msisdn"))
				<?php $count=0; ?>
				@foreach(Input::old("msisdn") as $msisdn)
					<?php $count++; ?>
					@if($msisdn != "" and $count>1)
						<div class="form-group">
							<label for="" class="col-sm-2 control-label hidden">SMS Reload MSISDN</label>
							<div class="col-sm-offset-2 col-sm-5">
								<input type="text" name="msisdn[]" value="{{$msisdn}}" class="form-control" style="display:inline;width:200px" placeholder="e.g. 01120123456"> 
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
				<label for="pinless_reload_low_balance_notification1" class="col-sm-2 control-label">Enable Pinless Reload Low Balance Notification <span class="text-danger">*</span></label>
				<fieldset id="pinless_reload_low_balance_notification1" class="col-sm-5">
					<label class="radio-inline">
						{{ Form::radio('pinless_reload_low_balance_notification', 'y', false) }} Yes
					</label>
					<label class="radio-inline">
						{{ Form::radio('pinless_reload_low_balance_notification', 'n', true) }} No
					</label>
				</fieldset>
			</div>

			<div class="form-group hidden" id="pinless_reload_low_level_amount_group">
				<label for="pinless_reload_low_level_amount" class="col-sm-2 control-label">Low Level Amount <span class="text-danger">*</span></label>
				<div class="col-sm-5">		
					<input type="text" id="pinless_reload_low_level_amount" name="pinless_reload_low_level_amount" class="form-control" value="{{Input::old('pinless_reload_low_level_amount')}}" placeholder="e.g. 100">
				</div>
			</div>-->

			<!--<div class="form-group">
				<label for="low_sim_card_balance_alert" class="col-sm-2 control-label">Enable SIM Card Low Balance Notification <span class="text-danger">*</span></label>
				<fieldset id="low_sim_card_balance_alert" class="col-sm-5">
					<label class="radio-inline">
						{{ Form::radio('low_sim_card_balance_alert', 'y', false, array('id' => 'low_sim_card_balance_alert0')) }} Yes
					</label>
					<label class="radio-inline">
						{{ Form::radio('low_sim_card_balance_alert', 'n', true, array('id' => 'low_sim_card_balance_alert1')) }} No
					</label>
				</fieldset>
			</div>

			<div class="form-group">
				<label for="sim_card_balance_below" class="col-sm-2 control-label">Low Level Amount <span class="text-danger">*</span></label>
				<div class="col-sm-5">		
					<input type="text" id="sim_card_balance_below" name="sim_card_balance_below" class="form-control" value="{{Input::old('sim_card_balance_below')}}" placeholder="e.g. 100">
				</div>
			</div>-->

			<!--<div class="form-group">
				<label for="Stock_delivery" class="col-sm-2 control-label">Stock Delivery <span class="text-danger">*</span></label>
				<fieldset id="sms_reload" class="col-sm-5">
					<label class="radio-inline">
						{{ Form::radio('Stock_delivery', 'enable', false, array('id' => 'Stock_delivery0')) }} Enable
					</label>
					<label class="radio-inline">
						{{ Form::radio('Stock_delivery', 'disable', true, array('id' => 'Stock_delivery1')) }} Disable
					</label>
				</fieldset>
			</div>-->

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button id="add_branch" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>
				</div>
			</div>
		{{ Form::close() }}
	</div>
</div>

@stop