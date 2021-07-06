@extends('layouts.admin_default')

@section('page-header')
<h3>View Alarm</h3>

@stop
<?
define("PAGETITLE", " | View Alarm");

?>
@section('content')
<script type="text/javascript">$('.datepicker').datepicker()</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#back_to_subscriber_update_history, #back_to_subscriber_update_history2").click(function() {
			$("#loading_panel").addClass("loading-show");
		});

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
<div ng-app="csgApp" ng-controller="pukController">
	
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
		 	<a id="back_to_subscriber_update_history" type="button" class="btn btn-primary" href="{{ URL::to('admin/updatesubscribers') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>	 	 	
		 	<div style="margin-top:8px;"></div> 
		</div>
		<input id="prepaidaccountid" name="prepaidaccountid" class="hidden" value="{{$prepaidaccount->id}}" />
		<div class="visible-xs-block visible-sm-block dropdown">		
				<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
				<div style="margin-top:8px;"></div>
				<ul class="dropdown-menu" role="menu">
					<li><a id="back_to_subscriber_update_history2" href="{{ URL::to('admin/updatesubscribers') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
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
	
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Details</h3>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form">		

			{{ HTML::clever_form('MSISDN', "+".$currentSub->msisdn ) }}

			{{ HTML::clever_form('Name', $currentSub->name  ) }}
			{{ HTML::clever_form('Update Status', $currentSub->status ) }}
			{{ ($currentSub->status!="Successful")  ? HTML::clever_form('Error Description', $currentSub->error_description ) : "" }}
			{{ HTML::clever_form('Gender', $currentSub->gender ) }}
			{{ HTML::clever_form('Birth Date', $currentSub->birth_date ) }}			
			{{ HTML::clever_form('Race', $currentSub->race ) }}		

			{{ HTML::clever_form('Marital Status', $currentSub->marital_status ) }}	
			{{ HTML::clever_form('Language', $currentSub->language ) }}	

			{{ HTML::clever_form('Address1', $currentSub->address1  ) }}
			{{ HTML::clever_form('Address2', $currentSub->address2 ) }}

			{{ $currentSub->address3  ? HTML::clever_form('Address3', $currentSub->address3 ) : ""  }} 

			{{ HTML::clever_form('Post Code', $currentSub->post_code ) }}	
			{{ HTML::clever_form('City', $currentSub->city ) }}
			{{ HTML::clever_form('State', $currentSub->state ) }}	
			{{ HTML::clever_form('Country', $currentSub->country ) }}	

			{{ $currentSub->oversea_state  ? HTML::clever_form('Oversea State', $currentSub->oversea_state ) : ""  }} 

			{{ HTML::clever_form('Channel', $currentSub->channel->name ) }}
			{{ HTML::clever_form('Branch', $currentSub->branch->name ) }}		

			{{ HTML::clever_form('Created At', $currentSub->created_at . ' (' .$currentSub->createUser->name .')') }}	
			{{ $currentSub->updated_at ? HTML::clever_form('Updated At', $currentSub->updated_at . ' (' .$currentSub->updateUser->name .')') : '' }}
			{{ $currentSub->deleted_at ? HTML::clever_form('Deleted At', $currentSub->deleted_at . ' (' .$currentSub->deleteUser->name .')') : '' }}

		</form>
	</div>
</div>

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
				{{ HTML::clever_table('Account Status', '<% bill.Subscriber.SubscriberStatus %>' ) }}
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


@stop