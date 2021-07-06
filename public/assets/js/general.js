function blockui(){
	$.blockUI({ 
		message: '<h4>Please wait...</h4>', 
		css: {	
			border: 'none', 
			padding: '5px', 
			backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', 
			opacity: .5, 
			color: '#fff',
			width:'200px'
		} 
	});
	//setTimeout($.unblockUI, 2000); 
}