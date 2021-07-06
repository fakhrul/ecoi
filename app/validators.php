<?php

/*
* app/validators.php
*/

Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL\s]+$/u', $value);
});

Validator::extend('full_name', function($attribute, $value)
{
    return preg_match('/^[\pL\s\@\/\&\.\(\)\']+$/u', $value);
});

Validator::extend('msisdn_prefix', function($attribute, $value, $parameters)
{
    if($value[0] == '6') { return true; }
    else { return false; }

}); 

Validator::extend('validate_sim', function($attribute, $value, $parameters)
{

    $po = New PrepaidOrder;
    $po->msisdn = $parameters[0];
    $po->iccid = $value;            

    $acdc = New ACDC;
    $result = $acdc->validateSim($po);

    if($result == 'Successful') { return true; }
    else { return false; }
    
}); 

Validator::extend('no_pipe', function($attribute, $value)
{

    if (strpos($value,'|') !== false) {
		return false;
	}
	else{
		return true;
	}
    
}); 