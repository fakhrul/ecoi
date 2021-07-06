<?php
class AclPermittedFilter {
 
    public function filter($route, $request)
    {

        $permitted = false;
        
        $user = Auth::user();
        $user->load('groups', 'groups.permissions');

        //pending to fix str_contains

        foreach($user->groups as $group) {
            if($group->id > 1) {
                if(str_contains($group->permissions,'"'.$route->getName().'"')) {
                    $permitted = true;
                    break;
                }
            }else{
                $permitted = true;
                break;
            }
        }
        if(!$permitted) {
            //return Redirect::route('access.denied');
            return Response::view('errors.restricted');
        }
    }
 
}

if (!function_exists("allowed"))
{
    function allowed($route)
    {
        if (Auth::check())
        {
            foreach (Auth::user()->groups as $group)
            {
                if ($group->id == 1) { return true; }
                foreach ($group->permissions as $permission)
                {
                    if ($permission->ident == $route)
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}

class CheckBranchFilter {

    public function filter($route, $request)
    {
        if(empty(Session::get('branch_id'))) { return Redirect::to('branch/select'); }

    }
}

function translateStatus($status)
{
    if($status == '0') { return 'Disabled'; }    
    if($status == '1') { return 'Enabled'; }
}

function translateID($id)
{
    if($id == '1') { return 'New IC'; }
    if($id == '2') { return 'Old IC'; }
    if($id == '3') { return 'Passport'; }
    if($id == '4') { return 'Work Permit'; }   
    if($id == '5') { return 'Others'; }        
}

function translateIDType($id_type)
{
	if ($id_type == 'nric') { return 'New IC'; }
	if ($id_type == 'passport') { return 'Passport'; }
	if ($id_type == 'brn') { return 'Business Registration Number'; }
	return $id_type;
}

function translateCDR($id)
{
    if($id == 'NSNMOC' or $id == 'CBSMOC') { return 'Voice Call'; }

    if($id == 'NSNCAF' or $id == 'CBSCAF') { return 'Call Forwarding'; }

    if($id == 'NSNSMO' or $id == 'CBSSMO') { return 'SMS'; }
    if($id == 'NSNMSO' or $id == 'CBSMSO') { return 'MMS'; }    

    if($id == 'CIBSUB' or $id == 'CBSRIDER') { return 'Data Plan'; }    
    if($id == 'DBA') { return 'Data Plan Renewal'; } 

    if($id == 'CIBTALKTIMETRA') { return 'TalkTime Transfer'; }    
    if($id == 'CBSTTTD') { return 'TalkTime Transfer (Donor)'; }  
    if($id == 'CBSTTTR') { return 'TalkTime Transfer (Recipient)'; }  

    if($id == 'NSNRELOAD') { return 'Reload'; }     
    if($id == 'CBSRLDPINLESS') { return 'Reload (Pinless)'; }     
    if($id == 'CBSRLDVOUCHER') { return 'Reload (Voucher)'; } 
    if($id == 'CBSRLDFCA') { return 'Reload (Activation)'; }      
    if($id == 'CBSRLD') { return 'Reload (Unknown)'; }     

    if($id == 'CBSTTAL') { return 'Talktime Advance Loan'; } 
    if($id == 'CBSTTAP') { return 'Talktime Advance Payback'; }    

    if($id == 'NSNGPRS' or $id == 'CBSGPRS') { return 'Data (GPRS)'; } 

    if($id == 'CPSMO') { return 'CPA SMS MO Chargeable'; }    
    if($id == 'CPSMOZ') { return 'CPA SMS MO Non-chargeable'; }     
    if($id == 'CPSMT') { return 'CPA SMS MT Chargeable'; }     
    if($id == 'CPSMTZ') { return 'CPA SMS MT Non-chargeable'; }     
    if($id == 'CPMSO') { return 'CPA MMS MO Chargeable'; }    
    if($id == 'CPMSOZ') { return 'CPA MMS MO Non-chargeable'; }     
    if($id == 'CPMST') { return 'CPA MMS MT Chargeable'; }     
    if($id == 'CPMSTZ') { return 'CPA MMS MT Non-chargeable'; } 
       

    return $id;               
}

function translateitravelSimCDR($id)
{
    if($id == 'CALL_IN') { return 'Voice Call (Inbound)'; }
    if($id == 'CALL_OUT') { return 'Voice Call (Outbound)'; }
    if($id == 'CALL_FWD') { return 'Voice Call (Forwording)'; }
    if($id == 'RLD_PINLESS') { return 'Reload (Pinless)'; }     
    if($id == 'RLD_PIN') { return 'Reload (Voucher)'; } 
    if($id == 'BALANCE_ADJUST') { return 'Balance Deduction'; } 
    if($id == 'GPRS') { return 'Data (GPRS)'; } 
    if($id == 'SUBSCRIPTION') { return 'Subscription'; }    
    if($id == 'SMS') { return 'SMS'; }

    return $id;               
}

function convert_address_to_mno($address_detail){
	
	// incoming data should be in array form, with key value and value data type listed as below
	# nationality - id
	# address_line_1 - string
	# address_line_2 - string
	# postcode - string
	# country - id
	# state - string
	# city - string
	
	$nationality = "";
	$address_line_1 = "";
	$address_line_2 = "";
	$address_line_3 = "";
	$address_line_3_city = "";
	$address_line_3_country = "";
	$address_line_3_nationality = "";
	$postcode = "";
	$country = "";
	$state = "";
	$city = "";
	$converted_nationality = "";
	$converted_country = "";
	$converted_state = "";
	$converted_city = "";
	$response = array();
	
	// validate incoming data
	$validation_rules = array(
							'address_line_1'	=> 'required',		
							'country'  			=> 'required|integer',
							'postcode'			=> 'required',
							'state'				=> 'required',
							'city'				=> 'required',
							'nationality'		=> 'integer'
						);
	
	$validator = Validator::make($address_detail, $validation_rules);
	
	if ($validator->fails()) {
		$validation_error = $validator->errors()->all();
		$error_msg = "";
		
		foreach($validation_error as $error){
			$error_msg .= $error." ";
		}
		
		$response = array("status" => "fail", "message" => "Validation fail - ".$error_msg);
	}
	else{
	
		// get all address and nationality info
		if(isset($address_detail["nationality"]))
			$nationality 	= $address_detail["nationality"];
		
		$address_line_1 = $address_detail["address_line_1"];
		
		if(isset($address_detail["address_line_2"]))
			$address_line_2 = $address_detail["address_line_2"];
		
		$postcode 		= $address_detail["postcode"];
		$country 		= $address_detail["country"];
		$state 			= $address_detail["state"];
		$city 			= $address_detail["city"];
		
		if($country == "134"){
			
			// convert country
			$mno_country_detail = get_mno_country_details_by_id($country);
			
			if(isset($mno_country_detail))
				$converted_country = $mno_country_detail->mno_country_id;
			
			// convert state
			$mno_state_detail = get_mno_state_details_by_value($state);
			
			if(isset($mno_state_detail))
				$converted_state = $mno_state_detail->mno_state_id;
			
			// convert city
			$mno_city_detail = City::whereName($city)->whereState_id($mno_state_detail->id)->first();
			
			if(isset($mno_city_detail) && !empty($mno_city_detail)){
			
				$converted_city = $mno_city_detail->mno_city_id;
				
			}
			else{
			
				// city which is not exist in mno glossary list
				$mno_city_detail = get_city_details_by_state_value($state);
				
				if(isset($mno_city_detail) && !empty($mno_city_detail)){
					$converted_city = $mno_city_detail->mno_city_id;
				}
							
				$address_line_3_city = $city;
				
			}
			
		}
		else{
			
			// convert country
			$mno_country_detail = get_mno_country_details_by_id($country);
			
			if(isset($mno_country_detail))
				$converted_country = $mno_country_detail->mno_country_id;
			
			if($converted_country == "228"){
				$address_line_3_country = $mno_country_detail->name;
			}
			
			$converted_state = $state;
			$converted_city = $city;
		}
		
		// convert nationality
		if($nationality != ""){
			$mno_nationality_detail = get_mno_nationality_by_id($nationality);
			
			if(isset($mno_nationality_detail))
				$converted_nationality = $mno_nationality_detail->mno_country_id;
			
			if($converted_nationality == "228"){
				$address_line_3_nationality = $mno_nationality_detail->name;
			}
		}
		
		// address line 3 ('city not in digi glossary' | 'Non-Malaysia country not in digi glossary' | 'nationality not in digi glossary')
		if($address_line_3_city != "" || $address_line_3_country != "" || $address_line_3_nationality != "")
			$address_line_3 = $address_line_3_city."|".$address_line_3_country."|".$address_line_3_nationality;
		
		// return converted address details
		$response = array(
										"status"					=> "success",
										"converted_nationality" 	=> $converted_nationality,
										"converted_address_line_1" 	=> $address_line_1,
										"converted_address_line_2" 	=> $address_line_2,
										"converted_address_line_3" 	=> $address_line_3,
										"converted_postcode" 		=> $postcode,
										"converted_country" 		=> $converted_country,
										"converted_state" 			=> $converted_state,
										"converted_city" 			=> $converted_city
									);
	}
	
	return $response;
}

function convert_address_from_mno($mno_address_detail){

	// incoming data should be in array form, with key value and value data type listed as below
	# mno_nationality - id
	# mno_address_line_1 - string
	# mno_address_line_2 - string
	# mno_postcode - string
	# mno_country - id
	# mno_state - string
	# mno_city - string
	
	$mno_nationality = "";
	$mno_address_line_1 = "";
	$mno_address_line_2 = "";
	$mno_address_line_3 = "";
	$mno_postcode = "";
	$mno_country = "";
	$mno_state = "";
	$mno_city = "";
	$converted_nationality = "";
	$converted_country = "";
	$converted_state = "";
	$converted_city = "";
	$city_from_add_3 = "";
	$country_from_add_3 = "";
	$nationality_from_add_3 = "";
	$validation_message = "";
	$response = array();
	
	// validate incoming data
	$validation_rules = array(
							'mno_address_line_1'	=> 'required',		
							'mno_country'  			=> 'required|integer',
							'mno_postcode'			=> 'required',
							'mno_state'				=> 'required',
							'mno_city'				=> 'required',
							'mno_nationality'		=> 'integer'
						);
	
	$validator = Validator::make($mno_address_detail, $validation_rules);
	
	if ($validator->fails()) {
		$validation_error = $validator->errors()->all();
		$error_msg = "";
		
		foreach($validation_error as $error){
			$error_msg .= $error." ";
		}
		
		$validation_message = "Validation fail - ".$error_msg;
	}
	
	
	// get all address and nationality info
	if(isset($mno_address_detail["mno_nationality"]))
		$mno_nationality 	= $mno_address_detail["mno_nationality"];
	
	if(isset($mno_address_detail["mno_address_line_1"]))
		$mno_address_line_1 = $mno_address_detail["mno_address_line_1"];
	
	if(isset($mno_address_detail["mno_address_line_2"]))
		$mno_address_line_2 = $mno_address_detail["mno_address_line_2"];
		
	if(isset($mno_address_detail["mno_address_line_3"]))
		$mno_address_line_3 = $mno_address_detail["mno_address_line_3"];
	
	if(isset($mno_address_detail["mno_postcode"]))
		$mno_postcode 		= $mno_address_detail["mno_postcode"];
	
	if(isset($mno_address_detail["mno_country"]))
		$mno_country 		= $mno_address_detail["mno_country"];
	
	if(isset($mno_address_detail["mno_state"]))
		$mno_state 			= $mno_address_detail["mno_state"];
	
	if(isset($mno_address_detail["mno_city"]))
		$mno_city 			= $mno_address_detail["mno_city"];
	
	if($mno_address_line_3 != ""){
		
		if (strpos($mno_address_line_3,'|') !== false) {
			$mno_address_line_3_array = explode("|", $mno_address_line_3);
		
			if(isset($mno_address_line_3_array[0]))
				$city_from_add_3 = $mno_address_line_3_array[0];
			
			if(isset($mno_address_line_3_array[1]))
				$country_from_add_3 = $mno_address_line_3_array[1];
			
			if(isset($mno_address_line_3_array[2]))
				$nationality_from_add_3 = $mno_address_line_3_array[2];
			
			$mno_address_line_3 = "";
			
		}
	}
	
	if($mno_country == "123"){
		
		// convert country
		$country_detail = get_country_details_by_id($mno_country);
		
		if(isset($country_detail))
			$converted_country = $country_detail->id;
		
		// convert state
		if($mno_state != "")
			$state_detail = get_state_details_by_id($mno_state);
		
		if(isset($state_detail))
			$converted_state = $state_detail->name;
		
		// convert city
		if($mno_city != "")
			$city_detail = get_city_details_by_id($mno_city);
		
		if(isset($city_detail)){
		
			if($city_detail->name == "Others"){
				$converted_city = $city_from_add_3;
			}
			else{
				$converted_city = $city_detail->name;
			}
			
		}
	}
	else{
		
		// convert country
		if($mno_country == "228"){
		
			if($country_from_add_3 != ""){
				$country_detail = Country::whereName($country_from_add_3)->first();
				
				if(isset($country_detail)){
					$converted_country = $country_detail->id;
				}
			}
			else{
				$converted_country = "228"; //unable to convert country
			}
		}
		else{
			if($mno_country != "")
				$country_detail = get_country_details_by_id($mno_country);
			
			if(isset($country_detail)){
				$converted_country = $country_detail->id;
			}
		}
		
		$converted_state = $mno_state;
		$converted_city = $mno_city;
	}
	
	// convert nationality
	if($mno_nationality != ""){
		if($mno_nationality == "228"){
			if($nationality_from_add_3 != ""){
				$nationality_detail = Country::whereName($nationality_from_add_3)->first();
				if(isset($converted_nationality)){
					$converted_nationality = $nationality_detail->id;
				}
			}
			else{
				$converted_nationality = "228"; //unable to convert nationality
			}
		}
		else{
			$nationality_detail = get_country_details_by_id($mno_nationality);
			
			if(isset($converted_nationality))
				$converted_nationality = $nationality_detail->id;
		}
	}
	
	// return converted address details
	$response = array(
					"validation_message"		=> $validation_message,
					"converted_nationality" 	=> $converted_nationality,
					"converted_address_line_1" 	=> $mno_address_line_1,
					"converted_address_line_2" 	=> $mno_address_line_2,
					"converted_address_line_3"	=> $mno_address_line_3,
					"converted_postcode" 		=> $mno_postcode,
					"converted_country" 		=> $converted_country,
					"converted_state" 			=> $converted_state,
					"converted_city" 			=> $converted_city
				);
	
	return $response;

}

function get_country_details_by_id($mno_country_id){
	$country_detail = Country::whereMno_country_id($mno_country_id)->first();
	
	return $country_detail;
}

function get_country_details_by_value($mno_country_value){
	$country_detail = Country::whereMno_country_name($mno_country_value)->first();
	
	return $country_detail;
}

function get_mno_country_details_by_id($country_id){
	$country_detail = Country::whereId($country_id)->first();
	
	return $country_detail;
}

function get_mno_country_details_by_value($country_value){
	$country_detail = Country::whereName($country_value)->first();
	
	return $country_detail;
}

function get_state_details_by_id($mno_state_id){
	$state_detail = State::whereMno_state_id($mno_state_id)->first();
	
	return $state_detail;
}

function get_state_details_by_value($mno_state_value){
	$state_detail = State::whereMno_state_name($mno_state_value)->first();
	
	return $state_detail;
}

function get_mno_state_details_by_id($state_id){
	$state_detail = State::whereId($state_id)->first();
	
	return $state_detail;
}

function get_mno_state_details_by_value($state_value){
	$state_detail = State::whereName($state_value)->first();
	
	return $state_detail;
}

function get_city_details_by_id($mno_city_id){
	$city_detail = City::whereMno_city_id($mno_city_id)->first();
	
	return $city_detail;
}

function get_city_details_by_value($mno_city_value){
	$city_detail = City::whereMno_city_name($mno_city_value)->first();
	
	return $city_detail;
}

function get_mno_city_details_by_id($city_id){
	$city_detail = City::whereId($city_id)->first();
	
	return $city_detail;
}

function get_mno_city_details_by_value($city_value){
	$city_detail = City::whereName($city_value)->first();
	
	return $city_detail;
}

function get_city_details_by_state_id($state_id){
	$city_detail = City::whereState_id($state_id)->first();
	
	return $city_detail;
}

function get_city_details_by_state_value($state_value){
	$city_detail = DB::table("city")
					->select("city.id", "city.state_id", "city.mno_city_id", "city.mno_city_name")
					->leftJoin("state", 'state.id', '=', 'city.state_id')
					->where("state.name", "=", $state_value)
					->where("city.name", "=", "Others")
					->first();
	
	return $city_detail;
}

function get_mno_nationality_by_id($nationality_id){
	$nationality_detail = Country::whereId($nationality_id)->first();
	
	return $nationality_detail;
}

function get_mno_nationality_by_value($nationality_value){
	$nationality_detail = Country::whereName($nationality_value)->first();
	
	return $nationality_detail;
}
