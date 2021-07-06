@extends('layouts.admin_default')

@section('page-header')
<h3>View MSISDN Status</h3>
@stop

@section('content')
<script type="text/javascript">$('.datepicker').datepicker()</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#retrieveSubsriber").click(function(){
	        var prepaidOrderId = $('#prepaidaccountid').val();// 	        alert (prepaidOrderId);
	        var scriptUrl = "/subscribers/retrieveAccBalance/" + prepaidOrderId; //alert (scriptUrl);

		    $.ajax({
			    url : scriptUrl,
			    type : 'GET',
			    data : {"id": prepaidOrderId},
			    //dataType:'json',
			    success : function(data) {              //alert('Data: ' + data);
			    	data = data / 100;
			    	data = data.toFixed(2);
			        $("#Balance").text(data);
			    },
			    //			    error : function(request,error) {   alert("Request: "+JSON.stringify(request));    }
			});
 		});
		
		$("#retrieveSubsriber2").click(function(){
	        var prepaidOrderId = $('#prepaidaccountid').val();// 	        alert (prepaidOrderId);
	        var scriptUrl = "/subscribers/retrieveAccBalance/" + prepaidOrderId; //alert (scriptUrl);

		    $.ajax({
			    url : scriptUrl,
			    type : 'GET',
			    data : {"id": prepaidOrderId},
			    //dataType:'json',
			    success : function(data) {              //alert('Data: ' + data);
			    	data = data / 100;
			    	data = data.toFixed(2);
			        $("#Balance").text(data);
			    },
			    //			    error : function(request,error) {   alert("Request: "+JSON.stringify(request));    }
			});
 		});
		
 		$("#getStatus").click(function(){
	        var prepaidOrderId = $('#prepaidaccountid').val();// 	        alert (prepaidOrderId);
	        var scriptUrl = "/subscribers/getBill2/" + prepaidOrderId; //alert (scriptUrl);

		    $.ajax({
			    url : scriptUrl,
			    type : 'GET',
			    data : {"id": prepaidOrderId},
			    dataType:'json',
			    success : function(data) { //alert('Data: ' + data); alert('Data: ' + data['SubscriberStatus']);
			        if (data['SubscriberStatus'] == "PREACTIVE") { //alert('Data: ' + data);
			            $("#barUnbarSubmit").attr("disabled", "disabled");
			        } else {
			        	$("#barUnbarSubmit").removeAttr("disabled");
			        }


			        if(data['SubscriberStatus']=="ACTIVE"){
						$("#SubStatus").text(data['SubscriberStatus']);
						$("#reason").text("Bar Reason");
			        }else{
			        	var status = data['SubscriberStatus'] + " [" + data['SuspensionReason'] + "]" ;
			        	$("#SubStatus").text(status);
						$("#reason").text("Unbar Reason");
			        }
			        
			    },
			    //			    error : function(request,error) {   alert("Request: "+JSON.stringify(request));    }
			});
 		});

 		$("#getStatus2").click(function(){
	        var prepaidOrderId = $('#prepaidaccountid').val();// 	        alert (prepaidOrderId);
	        var scriptUrl = "/subscribers/getBill2/" + prepaidOrderId; //alert (scriptUrl);

		    $.ajax({
			    url : scriptUrl,
			    type : 'GET',
			    data : {"id": prepaidOrderId},
			    dataType:'json',
			    success : function(data) { //alert('Data: ' + data); alert('Data: ' + data['SubscriberStatus']);
			        if (data['SubscriberStatus'] == "PREACTIVE") { //alert('Data: ' + data);
			            $("#barUnbarSubmit").attr("disabled", "disabled");
			        } else {
			        	$("#barUnbarSubmit").removeAttr("disabled");
			        }


			        if(data['SubscriberStatus']=="ACTIVE"){
						$("#SubStatus").text(data['SubscriberStatus']);
						$("#reason").text("Bar Reason");
			        }else{
			        	var status = data['SubscriberStatus'] + " [" + data['SuspensionReason'] + "]" ;
			        	$("#SubStatus").text(status);
						$("#reason").text("Unbar Reason");
			        }
			        
			    },
			    //			    error : function(request,error) {   alert("Request: "+JSON.stringify(request));    }
			});
 		});
	});
</script>
@if (Session::has("message"))
	<div class="alert alert-info">{{ Session::get("message") }}</div>
@endif
@if (isset($response))
	@if ($response->ResultStatus->StatusCode=='Successful')
<div ng-app="csgApp" ng-controller="pukController">
	
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
		 	<a type="button" class="btn btn-primary" href="{{ URL::to('msisdnstatus') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>	 	 	
			{{--<a type="button" class="btn btn-primary" href="#" data-toggle="modal" data-target=".btn-puk" ng-click="pukRefresh3({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve PUK</a>--}}
			{{--<a type="button" class="btn btn-primary" href="#" data-toggle="modal" data-target=".btn-bill" ng-click="billRefresh3({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve Account Info</a>--}}
			{{--<a type="button" class="btn btn-primary" href="#" data-toggle="modal" data-target=".btn-cust" ng-click="custRefresh3({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve Customer Info</a>--}}					
		  	{{--<a type="button" class="btn btn-danger" data-toggle="modal" data-target=".btn-bar" ng-click="barRefresh({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-remove"></span>&nbsp;Bar Account</a> --}}		  	
		  	{{--<button id="getStatus" type="button" class="btn btn-danger" data-toggle="modal" data-target=".btn-bar"><span class="glyphicon glyphicon-remove"></span>&nbsp;Bar / Unbar Account</button>--}}	  					  	  	 	  			
			<!--<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-reloadHistory"><span class="glyphicon glyphicon-refresh"></span>Retrieve Reload History</a>-->
			{{--<a type="button" class="btn btn-primary" target="_blank" href='/subscribers/retrievereloadhistory/{{$prepaidaccount->id}}'><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve Reload History</a>--}}
			{{--<a type="button" class="btn btn-primary" target="_blank" href='/subscribers/retrieveFreebies/{{$prepaidaccount->id}}'><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve Freebies</a>--}}  
			{{--<a type="button" class="btn btn-primary" target="_blank" href='/subscribers/retrieveFnF/{{$prepaidaccount->id}}'><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve Friends &amp; Family</a>--}} 
			{{--<a type="button" class="btn btn-primary" target="_blank" href='/subscribers/retrieveSubsriber/{{$prepaidaccount->id}}'><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve Subscription</a>--}} 
			{{--<button id="retrieveSubsriber" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-adjustAcc"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Adjust Balance</button>--}}
			<div style="margin-top:8px;"></div> 
		</div>
		<input id="prepaidaccountid" name="prepaidaccountid" class="hidden" value="{{$prepaidaccount->id}}" />
		<div class="visible-xs-block visible-sm-block dropdown">		
				<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
				<div style="margin-top:8px;"></div>
				<ul class="dropdown-menu" role="menu">
					<li><a href="{{ URL::to('msisdnstatus') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
					{{--<li><a href="#" data-toggle="modal" data-target=".btn-puk" ng-click="pukRefresh3({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-refresh"></span> Retrieve PUK</a></li>--}}
					{{--<li><a href="#" data-toggle="modal" data-target=".btn-bill" ng-click="billRefresh3({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-refresh"></span> Retrieve Account Info</a></li>--}}		
					{{--<li><a href="#" data-toggle="modal" data-target=".btn-cust" ng-click="custRefresh3({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-refresh"></span> Retrieve Customer Info</a></li>--}}
					{{--<li><a href="#" data-toggle="modal" data-target=".btn-cust" ng-click="custRefresh({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-remove"></span> Bar Account</a></li>--}}	
					{{--<li><a id="getStatus2" href="#" data-toggle="modal" data-target=".btn-bar"><span class="glyphicon glyphicon-remove"></span> Bar / Unbar Account</a></li>--}}						
					<!--<li><a href="#" data-toggle="modal" data-target="#modal-reloadHistory"><span class="glyphicon glyphicon-refresh"></span>Retrieve Reload History</a></li>-->
					{{--<li><a href="/subscribers/retrievereloadhistory/{{$prepaidaccount->id}}"><span class="glyphicon glyphicon-refresh"></span> Retrieve Reload History</a></li>--}}
					{{--<li><a href="/subscribers/retrieveFreebies/{{$prepaidaccount->id}}"><span class="glyphicon glyphicon-refresh"></span> Retrieve Freebies</a></li>--}}
					{{--<li><a href="/subscribers/retrieveFnF/{{$prepaidaccount->id}}"><span class="glyphicon glyphicon-refresh"></span> Retrieve Friends &amp; Family</a></li>--}}
					{{--<li><a href="/subscribers/retrieveSubsriber/{{$prepaidaccount->id}}"><span class="glyphicon glyphicon-refresh"></span> Retrieve Subscription</a></li>--}}
					{{--<li><a id="retrieveSubsriber2" href="#" data-toggle="modal" data-target="#modal-adjustAcc"><span class="glyphicon glyphicon-refresh"></span> Adjust Balance</a></li>--}}
				</ul>		
		</div>
	</div>

		<?php 
            if(isset($prepaidaccount)){
				$currentSub = $prepaidaccount;
				$currentSub->race = $race;
				$currentSub->nation = $nation;
				$currentSub->language = $language;
				$currentSub->city = $city;
				$currentSub->state = $state;
				$currentSub->country = $country;

			}//echo '<pre>',print_r($response,1),'</pre>';			exit();
		?>
	
		<table class="table table-striped">		

			{{ HTML::clever_table('MSISDN', "+".$currentSub->msisdn ) }}
			{{ HTML::clever_table('ICCID', $response->ICCID ) }}
			{{ HTML::clever_table('Port In', $currentSub->network ) }}

			{{-- HTML::clever_table('Package', $currentSub->msisdnDetail->package->name ) --}}
			{{-- HTML::clever_table('Scheme', $currentSub->msisdnDetail->scheme->name ) --}}	

			{{ HTML::clever_table('Name', $response->CustomerDetails->Name  ) }}
			{{ HTML::clever_table('ID Type', $response->CustomerDetails->IdType ) }}	
			{{ HTML::clever_table('IC/Passport', $response->CustomerDetails->IdNumber ) }}	
			{{ HTML::clever_table('Subscriber Status', $currentSub->subs_status ) }}
			{{ HTML::clever_table('Gender', $response->CustomerDetails->Gender ) }}
			{{ HTML::clever_table('Birth Date', $response->CustomerDetails->DateOfBirth ) }}			
			{{ HTML::clever_table('Race', $currentSub->race ) }}
			{{ HTML::clever_table('Nation', $currentSub->nation ) }}			

			{{ HTML::clever_table('Marital Status', $response->CustomerDetails->MaritalStatus ) }}	
			{{ HTML::clever_table('Language', $currentSub->language ) }}	

			{{ HTML::clever_table('Address1', $response->Address->PrimaryAddress->AddressLine1  ) }}
			{{ HTML::clever_table('Address2', $response->Address->PrimaryAddress->AddressLine2 ) }}
			<?php if(isset($response->Address->PrimaryAddress->AddressLine3)){ ?>
				{{ $response->Address->PrimaryAddress->AddressLine3 ? HTML::clever_table('Address3', $response->Address->PrimaryAddress->AddressLine3 ) : $currentSub->address3   }} 
			<?php }else{?>
				{{ $currentSub->address3  ? HTML::clever_table('Address3', $currentSub->address3 ) : ""  }} 
			<?php }?>
			{{ HTML::clever_table('Post Code', $response->Address->PrimaryAddress->PostCode ) }}	
			{{ HTML::clever_table('City', $currentSub->city ) }}
			{{ HTML::clever_table('State', $currentSub->state ) }}	
			{{ HTML::clever_table('Country', $currentSub->country ) }}	
			<?php if(isset($response->ContactDetails->Email)){ ?>
				{{ HTML::clever_table('Email', $response->ContactDetails->Email ) }}
			<?php }else{?>
				{{ HTML::clever_table('Email', $currentSub->email ) }}
			<?php }?>
			{{ HTML::clever_table('Alternate Contact No.', $currentSub->alternate_no ) }}
			{{ HTML::clever_table('Member No.', $currentSub->member_no ) }}
			{{ HTML::clever_table('Referral No.', $currentSub->referral_no ) }}
			{{ HTML::clever_table('Receipt No.', $currentSub->receipt_no ) }}

			{{ HTML::clever_table('Channel', $currentSub->channel->name ) }}
			{{ HTML::clever_table('Branch', $currentSub->branch->name ) }}		

			{{ HTML::clever_table('Created', $currentSub->created_at . ' (' .$currentSub->createUser->name .')') }}	
			{{ $currentSub->updated_at ? HTML::clever_table('Updated', $currentSub->updated_at . ' (' .$currentSub->updateUser->name .')') : '' }}
			{{ $currentSub->deleted_at ? HTML::clever_table('Deleted', $currentSub->deleted_at . ' (' .$currentSub->deleteUser->name .')') : '' }}

		</table>

<div class="modal fade btn-puk" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
 					<span class="glyphicon glyphicon-search"></span>
					Retrieve PUK
				</h4>
		    </div>
    	<div class="modal-body">		
			<table class="table table-striped">	
				{{ HTML::clever_table('MSISDN', "+".$prepaidaccount->msisdn ) }}				
				{{ HTML::clever_table('Primary PUK', '<% puk.PUK.PrimaryPUK %>' ) }}
				{{ HTML::clever_table('Secondary PUK', '<% puk.PUK.SecondaryPUK %>' ) }}
			</table>
			  	<div class="col-sm-offset-2">
		 			<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</button>
					<a type="button" class="btn btn-primary" ng-click="pukRefresh({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve PUK</a>		 			
		  		</div>
		</div>
		</div>
	</div>
</div>

<div class="modal fade btn-bill" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
 					<span class="glyphicon glyphicon-search"></span>
					Retrieve Account Info
				</h4>
		    </div>
    	<div class="modal-body">		
			<table class="table table-striped">	
				{{ HTML::clever_table('MSISDN', "+".$prepaidaccount->msisdn ) }}				
				{{ HTML::clever_table('Subscriber Status', '<% bill.Subscriber.SubscriberStatus %>' ) }}
				{{ HTML::clever_table('Active Date', '<% bill.Subscriber.ActiveDate %>' ) }}
				{{ HTML::clever_table('Expiry Date', '<% bill.Subscriber.ExpiryDate %>' ) }}
				{{ HTML::clever_table('Language', '<% bill.Subscriber.SubscriberLanguage %>' ) }}
				{{ HTML::clever_table('Last Call Amount', '<% bill.LastCallInformation.Amount %>' ) }}
				{{ HTML::clever_table('Last Call Start', '<% bill.LastCallInformation.StartDate %>' ) }}
				{{ HTML::clever_table('Last Call End', '<% bill.LastCallInformation.EndDate %>' ) }}
				{{ HTML::clever_table('Balance Amount', '<% bill.Balance.Amount %>' ) }}			
				{{ HTML::clever_table('Balance Expire Time', '<% bill.Balance.ExpireTime %>' ) }}												
			</table>
			  	<div class="col-sm-offset-2">
		 			<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</button>
		 			<a type="button" class="btn btn-primary" ng-click="billRefresh({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve Account Info</a>	
		  		</div>
		</div>
		</div>
	</div>
</div>

<div class="modal fade btn-cust" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
 					<span class="glyphicon glyphicon-search"></span>
					Retrieve Customer Info
				</h4>
		    </div>
    	<div class="modal-body">		
			<table class="table table-striped">	
				{{ HTML::clever_table('MSISDN', "+".$prepaidaccount->msisdn ) }}
				{{ HTML::clever_table('Title', '<% cust.CustomerDetails.Title %>' ) }}
				{{ HTML::clever_table('Name', '<% cust.CustomerDetails.Name %>' ) }}
				{{ HTML::clever_table('IdType', '<% cust.CustomerDetails.IdType %>' ) }}
				{{ HTML::clever_table('IdNumber', '<% cust.CustomerDetails.IdNumber %>' ) }}
				{{ HTML::clever_table('DateOfBirth', '<% cust.CustomerDetails.DateOfBirth %>' ) }}
				{{ HTML::clever_table('Gender', '<% cust.CustomerDetails.Gender %>' ) }}
				{{ HTML::clever_table('Nationality', '<% cust.CustomerDetails.Nationality %>' ) }}
				{{ HTML::clever_table('Race', '<% cust.CustomerDetails.Race %>' ) }}	
				{{ HTML::clever_table('MaritalStatus', '<% cust.CustomerDetails.MaritalStatus %>' ) }}																																
				{{ HTML::clever_table('AddressLine1', '<% cust.Address.PrimaryAddress.AddressLine1 %>' ) }}
				{{ HTML::clever_table('AddressLine2', '<% cust.Address.PrimaryAddress.AddressLine2 %>' ) }}
				{{ HTML::clever_table('AddressLine3', '<% cust.Address.PrimaryAddress.AddressLine3 %>' ) }}
				{{ HTML::clever_table('City', '<% cust.Address.PrimaryAddress.City %>' ) }}
				{{ HTML::clever_table('PostCode', '<% cust.Address.PrimaryAddress.PostCode %>' ) }}
				{{ HTML::clever_table('State', '<% cust.Address.PrimaryAddress.State %>' ) }}
				{{ HTML::clever_table('Country', '<% cust.Address.PrimaryAddress.Country %>' ) }}																								
				{{ HTML::clever_table('PortInStatus', '<% cust.PortInDetails.PortInStatus %>' ) }}
				{{ HTML::clever_table('PortingDate', '<% cust.PortInDetails.PortingDate %>' ) }}
				{{ HTML::clever_table('DonorNetwork', '<% cust.PortInDetails.DonorNetwork %>' ) }}

				{{ HTML::clever_table('ICCID', '<% cust.ICCID %>' ) }}									
			</table>
			  	<div class="col-sm-offset-2">
		 			<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</button>
		 			<a type="button" class="btn btn-primary" ng-click="custRefresh({{$prepaidaccount->id}});"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Retrieve Customer Info</a>	
		  		</div>
		</div>
		</div>
	</div>
</div>

<div class="modal fade btn-bar" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
 					<span class="glyphicon glyphicon-search"></span>
					Bar / Unbar Account
				</h4>
		    </div>
    	<div class="modal-body">
			{{ Form::open([ "id"=>"form_barUnbar", "name"=>"form_barUnbar", "class" => "form-horizontal", "url" => "/subscribers/barUnbar/".$prepaidaccount->id, "method"=>"GET"]) }}
		  		<div class="form-group">
		    		<label for="msisdn" class="col-sm-2 control-label">MSISDN</label>
				    <div class="col-sm-4 input-group">
				    	<span class="input-group-addon">+</span>
				    	<input type="text" class="form-control" name="msisdn" id="msisdn" placeholder="MSISDN" value="{{ $prepaidaccount->msisdn }}" DISABLED>
				    </div>		    
		  		</div>
		  		<div class="form-group">
						<label class="col-sm-2 control-label">Current Status</label>
						<div class="col-sm-5">
				     		<p class="form-control-static" id="SubStatus"></p>
				    	</div>
				  	</div>
		  		<div class="form-group">		  		
				    <label for="reason" id="reason" class="col-sm-2 control-label">Bar / Unbar Reason</label>
			    	<div class="col-sm-4">
						{{ Form::select('reason',array('1' => 'Lost & Stolen'), '', array('class' => 'form-control')) }}
			    	</div>			
			    </div>		  		
			  	<div class="col-sm-offset-2">
		 			<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</button>
		  			<button type="submit" id="barUnbarSubmit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>	
		  		</div>
			{{ Form::close() }}
		</div>
		</div>
	</div>
</div>

<div id="modal-reloadHistory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Search Reload</h4>
		    </div>
	    	<div class="modal-body">
				{{ Form::open([ "id"=>"form_search", "name"=>"form_search", "class" => "form-horizontal", "url" => "/subscribers/retrievereloadhistory/".$prepaidaccount->id, "method"=>"GET"]) }}
			  		<div class="form-group">
						<label for="SearchCriteria" class="col-sm-2 control-label">Search Criteria</label>
						<div class="col-sm-5">
					    	<select id="SearchCriteria" name="searchCriteria" class="form-control">
								<option value="SearchStartTime">Start Date</option>
								<option value="SearchEndTime">End Date</option>
							</select>
					    </div>

					</div>
				  	<div class="form-group">
						<label for="Date" class="col-sm-2 control-label">Date</label>
						<div class="col-sm-5">
							<div class="input-group date">
								<input type="text" name="date" class="form-control" readonly>
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-calendar" onclick="selectDate();"></i>
								</span>
							</div>
						</div>
					</div>
				  	<div class="form-group">
				  		<div class="col-sm-offset-2 col-sm-10">
				    		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span> Submit</button>
				    	</div>
				    </div>
				    
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div id="modal-adjustAcc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
					<span class="glyphicon glyphicon-search"></span>
					Adjust Account
				</h4>
		    </div>
	    	<div class="modal-body">
				{{ Form::open([ "id"=>"form_adjustAcc", "name"=>"form_adjustAcc", "class" => "form-horizontal", "url" => "/subscribers/adjustAcc/".$prepaidaccount->id, "method"=>"GET"]) }}
			  		<div class="form-group">
			    		<label for="msisdn" class="col-sm-2 control-label">MSISDN</label>
					    <div class="col-sm-5 input-group">
					    	<span class="input-group-addon">+</span>
					    	<input type="text" class="form-control" name="msisdn" id="msisdn" placeholder="MSISDN" value="{{ $prepaidaccount->msisdn }}" DISABLED>
					    </div>		    
			  		</div>
			  		<div class="form-group">
						<label class="col-sm-2 control-label">Current Balance</label>
						<div class="col-sm-5">
				     		<p class="form-control-static" id="Balance"></p>
				    	</div>
				  	</div>
				  	<div class="form-group">
						<label class="col-sm-2 control-label">Adjustment</label>
						<div class="col-sm-2">
				     		<select id="plusMinus" name="plusMinus" class="form-control">
								<option value="-">-</option>
								<option value="+">+</option>
							</select>
				    	</div>
						<div class="col-sm-3">
					    	<input type="text" class="form-control" name="adjustmentAmount" id="adjustmentAmount" placeholder="adjustmentAmount" value="0.00" >
					    </div>
				  	</div>
				  	<div class="form-group">
				  		<div class="col-sm-offset-2 col-sm-10">
				  			<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</button>
				    		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span> Submit</button>
				    	</div>
				    </div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@stop

</div>
	@else
	<div ng-app="csgApp" ng-controller="pukController">
	
		<div class="clearfix">
			<div class="visible-md-block visible-lg-block">
			 	<a type="button" class="btn btn-primary" href="{{ URL::to('subscribers') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>	 	 	
				<div style="margin-top:8px;"></div>
			</div>
			<div class="visible-xs-block visible-sm-block dropdown">		
					<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
					<div style="margin-top:8px;"></div>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ URL::to('subscribers') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
					</ul>		
			</div>
		</div>
	</div>
	@endif
@else
	<div ng-app="csgApp" ng-controller="pukController">
		
		<div class="clearfix">
			<div class="visible-md-block visible-lg-block">
			 	<a type="button" class="btn btn-primary" href="{{ URL::to('msisdnstatus') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>	 	 	
				@if(isset($msisdn))
				<a type="button" class="btn btn-primary" href="{{ URL::to('msisdnstatus/' . $msisdn) }}"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Refresh</a>
				@endif
				<div style="margin-top:8px;"></div>
			</div>
			<div class="visible-xs-block visible-sm-block dropdown">		
					<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
					<div style="margin-top:8px;"></div>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ URL::to('msisdnstatus') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
						@if(isset($msisdn))
						<li><a target="_blank" href="{{ URL::to('msisdnstatus/' . $msisdn)  }}"><span class="glyphicon glyphicon-refresh"></span> Refresh</a></li>
						@endif
					</ul>		
			</div>
		</div>
	</div>

	<?php 
        if(isset($search_Prepaid_Customer)){
			$response = $search_Prepaid_Customer;
		}

		//echo '<pre>',print_r($search_Prepaid_Customer,1),'</pre>';			
		//echo '<pre>',print_r($retrieve_Prepaid_Account,1),'</pre>';			
		//echo '<pre>',print_r($retrieve_PUK,1),'</pre>';			exit(); //0103773642
	?>
	

		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Account Info</h3>
		</div>
		<ul class="list-group">
				<li class="list-group-item">
					<table class="table table-striped">	
						{{ HTML::clever_table('MSISDN', "+".$msisdn ) }}

						<?php if($retrieve_Prepaid_Account!=''){ 
							$retrieve_Prepaid_Account->Balance->ExpireTime = str_replace("T"," ",$retrieve_Prepaid_Account->Balance->ExpireTime);	
							$retrieve_Prepaid_Account->Subscriber->ExpiryDate = str_replace("T"," ",$retrieve_Prepaid_Account->Subscriber->ExpiryDate);						
						?>

						<?php if(isset($retrieve_Prepaid_Account->Subscriber->PortInStatus)){ ?>
							{{ $retrieve_Prepaid_Account->Subscriber->PortInStatus ? HTML::clever_table('Port In Status', $retrieve_Prepaid_Account->Subscriber->PortInStatus ) : ''   }} 
						<?php }?>

						{{ HTML::clever_table('Language', $retrieve_Prepaid_Account->language ) }}

						{{ HTML::clever_table('Subscriber Status', $retrieve_Prepaid_Account->Subscriber->SubscriberStatus ) }}

						<?php if(isset($retrieve_Prepaid_Account->Subscriber->ActiveDate)){ 
							$retrieve_Prepaid_Account->Subscriber->ActiveDate = str_replace("T"," ",$retrieve_Prepaid_Account->Subscriber->ActiveDate);
						?>
							{{ $retrieve_Prepaid_Account->Subscriber->ActiveDate ? HTML::clever_table('Activate Date', $retrieve_Prepaid_Account->Subscriber->ActiveDate ) : ''   }} 
						<?php }?>

						{{ HTML::clever_table('Expiry Date', $retrieve_Prepaid_Account->Subscriber->ExpiryDate ) }}	

						<?php if(isset($retrieve_Prepaid_Account->LastCallInformation)){ 
							$retrieve_Prepaid_Account->LastCallInformation->StartDate = str_replace("T"," ",$retrieve_Prepaid_Account->LastCallInformation->StartDate);
							$retrieve_Prepaid_Account->LastCallInformation->EndDate = str_replace("T"," ",$retrieve_Prepaid_Account->LastCallInformation->EndDate);
						?>
							{{ HTML::clever_table('Last Call Amount', $retrieve_Prepaid_Account->LastCallInformation->Amount ) }}	
							{{ HTML::clever_table('Last Call Start', $retrieve_Prepaid_Account->LastCallInformation->StartDate ) }}	
							{{ HTML::clever_table('Last Call End', $retrieve_Prepaid_Account->LastCallInformation->EndDate ) }}
						<?php }?>

						{{ HTML::clever_table('Balance Amount', $retrieve_Prepaid_Account->Balance->Amount ) }}	
						{{ HTML::clever_table('Balance Expiry', $retrieve_Prepaid_Account->Balance->ExpireTime ) }}
						
						<?php } ?>
					</table>
				</li>
			 </ul>
		</div>

		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">PUK Info</h3>
		</div>
		<ul class="list-group">
				<li class="list-group-item">
					<table class="table table-striped">	

						<?php if($retrieve_PUK!=''){ ?>

						{{ HTML::clever_table('Primary PUK', $retrieve_PUK->PUK->PrimaryPUK ) }}	
						{{ HTML::clever_table('Secondary PUK', $retrieve_PUK->PUK->SecondaryPUK ) }}

						<?php }?>
					</table>
				</li>
			 </ul>
		</div>

		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Subsriber Info</h3>
		</div>
		<ul class="list-group">
				<li class="list-group-item">

					<table class="table table-striped">	
						<?php 
					        if(isset($search_Prepaid_Customer)){
								$response = $search_Prepaid_Customer;
							}
							//echo '<pre>',print_r($search_Prepaid_Customer,1),'</pre>';			
							//echo '<pre>',print_r($retrieve_Prepaid_Account,1),'</pre>';			
							//echo '<pre>',print_r($retrieve_PUK,1),'</pre>';			exit(); //0103773642
							if($search_Prepaid_Customer!=''){
						?>
						
										
								  	
						{{ HTML::clever_table('ICCID', $response->ICCID ) }}
						{{ HTML::clever_table('Name', $response->CustomerDetails->Name  ) }}
						{{ HTML::clever_table('ID Type', $response->CustomerDetails->IdType ) }}	
						{{ HTML::clever_table('IC/Passport', $response->CustomerDetails->IdNumber ) }}	
						{{ HTML::clever_table('Gender', $response->CustomerDetails->Gender ) }}
						{{ HTML::clever_table('Birth Date', $response->CustomerDetails->DateOfBirth ) }}			
						{{ HTML::clever_table('Race', $response->race ) }}
						{{ HTML::clever_table('Nation', $response->nation ) }}			
						{{ HTML::clever_table('Marital Status', $response->CustomerDetails->MaritalStatus ) }}	
						{{ HTML::clever_table('Address1', $response->Address->PrimaryAddress->AddressLine1  ) }}
						{{ HTML::clever_table('Address2', $response->Address->PrimaryAddress->AddressLine2 ) }}
						<?php if(isset($response->Address->PrimaryAddress->AddressLine3)){ ?>
							{{ $response->Address->PrimaryAddress->AddressLine3 ? HTML::clever_table('Address3', $response->Address->PrimaryAddress->AddressLine3 ) : ''  }} 
						<?php }?>
						{{ HTML::clever_table('Post Code', $response->Address->PrimaryAddress->PostCode ) }}	
						{{ HTML::clever_table('City', $response->city ) }}
						{{ HTML::clever_table('State', $response->state ) }}	
						{{ HTML::clever_table('Country', $response->country ) }}	
						<?php if(isset($response->ContactDetails->Email)){ ?>
							{{ HTML::clever_table('Email', $response->ContactDetails->Email ) }}
						<?php }		}?>
					</table>
				</li>
			 </ul>
		</div>


		
	</table>
@endif
@stop