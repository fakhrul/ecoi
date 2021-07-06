<?php
	return array(
	'acdc_url'                              => 'http://127.0.0.1/digiacdc/',  //'http://192.168.4.50/digiacdc/',
	'secret_key'                            => 'vPOFDfbTPH',
	'secret_key_bt'                         => 'XhjKXySLZE',	
	'validity'                              => '600', // in second, for security	
	'ip_allow'                              => array("192.168.4.43","192.168.4.50"),
    
    'syncronize_vtiger_url'                 => 'http://192.168.4.15/troncrm/script/', 
	'travelsim'								=> array(
    											'itravelsim'=>array('account'=>'hdls.channel.itravelsim','secret_key'=>'Nng4DOdO'),
    											'touchdown'=>array('account'=>'hdls.channel.touchdown','secret_key'=>'BYE9q48N'),
    											),
	
	'travelsim_sms_sender'					=> "37281635033",
	);
