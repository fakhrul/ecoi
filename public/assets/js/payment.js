function add_ship(){

	if(document.getElementById("ship_to_diff").checked){
		document.getElementById("shipping_add").className  = "show";
	}
	else
	{
		document.getElementById("shipping_add").className  = "hidden";
	}
}

function get_shipping_method(){
	
	if(document.getElementById("shipping_method").value == "selfPickup"){
		document.getElementById("self_pick_up").className  = "show";
		document.getElementById("shipping_add").className  = "hidden";
		document.getElementById("courier").className  = "hidden";
	}
	else if(document.getElementById("shipping_method").value == "courier"){
		document.getElementById("self_pick_up").className  = "hidden";
		document.getElementById("self_pick_up_location").className  = "hidden";
		document.getElementById("courier").className  = "show";
	}
	else if(document.getElementById("shipping_method").value == ""){
		document.getElementById("self_pick_up").className  = "hidden";
		document.getElementById("self_pick_up_location").className  = "hidden";
		document.getElementById("shipping_add").className  = "hidden";
		document.getElementById("courier").className  = "hidden";
	}
}

function get_self_pickup_location(){
	if(document.getElementById("outlet").value == "1" || document.getElementById("outlet").value == "2"){
		document.getElementById("self_pick_up_location").className  = "show";
		document.getElementById("gmap").src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.863342237519!2d101.62704300000003!3d3.130799000000013!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4948714bdb6f%3A0x9e539e32066bee6a!2sTron+-+Life.On!5e0!3m2!1sen!2smy!4v1417075218928";
	}
	else
		document.getElementById("self_pick_up_location").className  = "hidden";
}

function select_my_voucher(){
	if(document.getElementById("my_voucher").checked){
		document.getElementById("my_stored_voucher").className  = "show";
	}
	else
	{
		document.getElementById("my_stored_voucher").className  = "hidden";
	}
}

function applyVoucher(){
	document.getElementById("voucher").deleteRow(1);
	
	var table = document.getElementById("purchased_item");
	var row = table.insertRow(10);
	var cell = row.insertCell(0);
	cell.colSpan = "6";
	cell.align = "right"; 
	cell.innerHTML = "<b>Cash Voucher (TF001160)</b>&nbsp;&nbsp;&nbsp;<span class=\"glyphicon-btnless glyphicon-remove\" onclick=\"removeVoucher();\"></span>";
	var cell1 = row.insertCell(1);
	cell1.align = "right"; 
	cell1.innerHTML = "-";
	var cell1 = row.insertCell(2);
	cell1.align = "right"; 
	cell1.innerHTML = "- 10.00";
	document.getElementById("totalPurchase").innerHTML = "3,423.95";
}

function removeVoucher(){
	var remove = confirm("Are you sure you want to remove the selected voucher(s)?");
	
	if(remove == true){
		var table = document.getElementById("purchased_item");
		table.deleteRow(10);
		document.getElementById("totalPurchase").innerHTML  = "3,433.95";
		var table = document.getElementById("voucher");
		var row = table.insertRow(2);
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		cell1.innerHTML = "<input type=\"checkbox\" />";
		cell2.innerHTML = "TF001160";
		cell3.innerHTML = "10.00";
		cell4.innerHTML = "31 December 2014";
	}
}

function applyCoupon(){
	var couponCode = document.getElementById("coupon_code").value;
	document.getElementById("coupon_code").value = "";
	var table = document.getElementById("coupon_details");
	
	if(couponCode == "TFCP0001"){
		document.getElementById("coupon1").innerHTML = "<i>Coupon TFCP0001: Buy 2, Save 20% on same products</i>&nbsp;&nbsp;<span class=\"glyphicon-btnless glyphicon-remove\" onclick=\"removeCoupon('coupon1');\"></span>";
		document.getElementById("offer1").innerHTML = "- 487.20";
		
		document.getElementById("gst1").innerHTML = "116.90";
		document.getElementById("totalPayable1").innerHTML = "2,065.70";
		document.getElementById("totalExclGST").innerHTML = "3,487.80";
		document.getElementById("totalGST").innerHTML = "209.20";
		document.getElementById("totalAmountDue").innerHTML = "3,633.40";
		document.getElementById("totalPurchase").innerHTML = "3,633.40";
	}else if(couponCode == "TFCP0002"){
		document.getElementById("coupon2").innerHTML = "<i>Coupon TFCP0002: Buy more than 1, Save 10% on same products</i>&nbsp;&nbsp;<span class=\"glyphicon-btnless glyphicon-remove\" onclick=\"removeCoupon('coupon2');\"></span>";
		document.getElementById("offer2").innerHTML = "- 129.90";
		
		document.getElementById("gst2").innerHTML = "70.15";
		document.getElementById("totalPayable2").innerHTML = "1,239.25";
		document.getElementById("totalExclGST").innerHTML = "3,357.90";
		document.getElementById("totalGST").innerHTML = "201.40";
		document.getElementById("totalAmountDue").innerHTML = "3,355.45";
		document.getElementById("totalPurchase").innerHTML = "3,355.45";
	}
	else if(couponCode == "TFCP0003"){
		document.getElementById("coupon3").innerHTML = "<i>Coupon TFCP0004: Buy 2, Free 1</i>&nbsp;&nbsp;<span class=\"glyphicon-btnless glyphicon-remove\" onclick=\"removeCoupon('coupon3');\"></span>";
		document.getElementById("offer3").innerHTML = "- 60.00";
		
		document.getElementById("gst3").innerHTML = "7.20";
		document.getElementById("totalPayable3").innerHTML = "127.20";
		document.getElementById("totalExclGST").innerHTML = "3,297.90";
		document.getElementById("totalGST").innerHTML = "197.70";
		document.getElementById("totalAmountDue").innerHTML = "3,432.15";
		document.getElementById("totalPurchase").innerHTML = "3,432.15";		
	}
	else if(couponCode == "TFCP0004"){
		var table_1 = document.getElementById("purchased_item");
		
		var row2 = table_1.insertRow(7);
		
		var cell_new1 = row2.insertCell(0);
		cell_new1.colSpan = "7";
		cell_new1.align = "right";
		cell_new1.innerHTML = "<i>Coupon TFCP0003: Buy more than RM 1,000.00, Save RM30 on total price</i>&nbsp;&nbsp;<span class=\"glyphicon-btnless glyphicon-remove\" onclick=\"removeCoupon('coupon4');\"></span>";
		
		var cell_new2 = row2.insertCell(1);
		cell_new2.align = "right";
		cell_new2.innerHTML = "-";
		
		var cell_new3 = row2.insertCell(2);
		cell_new3.align = "right";
		cell_new3.innerHTML = "- 30.00";
		document.getElementById("totalPurchase").innerHTML = "3,402.15";
	}
	else{
		alert("Sorry, the coupon code is invalid.");
	}
}

function removeCoupon(id){

	var remove = confirm("Are you sure you want to remove the selected coupon?");
	
	if(remove == true){
		if(id=="coupon1"){
			document.getElementById(id).innerHTML = "";
			document.getElementById("offer1").innerHTML = "";
			document.getElementById("gst1").innerHTML = "146.20";
			document.getElementById("totalPayable1").innerHTML = "2,582.20";
			
			document.getElementById("totalExclGST").innerHTML = "3,915.00";
			document.getElementById("totalGST").innerHTML = "234.90";
			document.getElementById("totalAmountDue").innerHTML = "4,149.90";
			document.getElementById("totalPurchase").innerHTML = "4,149.90";
		}
		else if(id=="coupon2"){
			document.getElementById(id).innerHTML = "";
			document.getElementById("offer2").innerHTML = "";
			
			document.getElementById("gst2").innerHTML = "77.90 	";
			document.getElementById("totalPayable2").innerHTML = "1,376.90";
			
			document.getElementById("totalExclGST").innerHTML = "3,427.80";
			document.getElementById("totalGST").innerHTML = "205.70";
			document.getElementById("totalAmountDue").innerHTML = "3,633.40";
			document.getElementById("totalPurchase").innerHTML = "3,633.40";
		}
		else if(id=="coupon3"){
			document.getElementById(id).innerHTML = "";
			document.getElementById("offer3").innerHTML = "";
			
			document.getElementById("gst3").innerHTML = "10.80";
			document.getElementById("totalPayable3").innerHTML = "190.80";
			
			document.getElementById("totalExclGST").innerHTML = "3,297.90";
			document.getElementById("totalGST").innerHTML = "197.90";
			document.getElementById("totalAmountDue").innerHTML = "3,355.45";
			document.getElementById("totalPurchase").innerHTML = "3,355.45";
		}
		else if(id=="coupon4"){
			var table_1 = document.getElementById("purchased_item");
			table_1.deleteRow(7);
			document.getElementById("totalPurchase").innerHTML = "3,432.15";
		}
	}
}

function select_from_add_book(){
	if(document.getElementById("addbook").value == "1"){
		document.getElementById("name").value = "";
		document.getElementById("add1").value = "";
		document.getElementById("add2").value = "";
		document.getElementById("postcode").value = "";
		document.getElementById("city").value = "";
		document.getElementById("shippingState").value = "";
		document.getElementById("phone").value = "";
	}
	else if(document.getElementById("addbook").value == "2"){
		document.getElementById("name").value = "Sia Nga Ping";
		document.getElementById("add1").value = "No.12, Lorong 1 Taman Pearl";
		document.getElementById("add2").value = "";
		document.getElementById("postcode").value = "96000";
		document.getElementById("city").value = "Sibu";
		document.getElementById("shippingState").value = "sarawak";
		document.getElementById("phone").value = "60168835479";
	}
	else if(document.getElementById("addbook").value == "3"){
		document.getElementById("name").value = "Sia Nga Ping";
		document.getElementById("add1").value = "No.9, PJU 10/13J, Saujana Damansara";
		document.getElementById("add2").value = "Damansara Damai";
		document.getElementById("postcode").value = "52000";
		document.getElementById("city").value = "Petaling Jaya";
		document.getElementById("shippingState").value = "sarawak";
		document.getElementById("phone").value = "60168835479";
	}
}

function selectDate(){
	$('.input-group.date').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
}