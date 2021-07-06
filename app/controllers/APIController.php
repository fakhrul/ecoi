<?php

class APIController extends BaseController{

	public function __construct()
    {
        $this->secret_key = Config::get("api.secret_key");
        $this->validity = Config::get("api.validity");
    }

    public function create_pre_registration()
    {
        $referer = isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"";
        $api_log_id = $this->API_log_request($referer,"create_pre_registration",json_encode(Input::all()));

		$rules = array(
			'msisdn'       	=> 'required|min:10|max:11|exists:msisdn,msisdn,status,1',
			'iccid'			=> 'required|min:16|max:16|exists:msisdn,iccid,status,1,msisdn,'.Input::get('msisdn'),
			'name'       	=> 'required|min:5|Max:80',
			'id_type'      	=> 'required|digits:1',
			'ic'      		=> 'required|alpha_num|min:5|max:20',
            'nation'        => 'required|numeric|max:228',
			'email' 		=> 'Email',
            'race'          => 'required|digits:1',
            'marital_status'=> 'required',  
            'language'      => 'required|digits:1', 
			'gender'		=> 'required',
			'birth_date'	=> 'required',	
			'address1'		=> 'required|min:5',
			'address2'		=> 'required|min:5',
			'post_code'		=> 'required|digits:5|max:5',
			'city'			=> 'required|numeric|max:470',
			//'state'		=> 'required',
            "signature" 	=> "required",
            "timestamp" 	=> "required|integer"				
			);

		$validator = Validator::make(Input::all(), $rules);
        $validate = true;

        if($this->get_timestamp_diff(time(),Input::get("timestamp")) <= $this->validity)
        {
            if($this->get_encryption($this->secret_key.Input::get("timestamp").Input::get("msisdn").Input::get("iccid"),"md5") == Input::get("signature"))
            {

                if ($validator->passes())
                {
                    if (Input::get('id_type') == 'PASSPORT' and Input::get('nation') == 'MALAYSIA')
                    {
                        $validate = false;
                        //$error = "Invalid Input Nation";
                        $validator->messages()->add('id_type','passport is not allowed for nation Malaysia');
                    }   

                    if (Input::get('id_type') == '1' and (strlen(Input::get('ic')) != 12 or ctype_digit(Input::get('ic')) == false)){
                        
                        $validate = false;
                        //$error = "Invalid Input NRIC (12 digits)";
                        $validator->messages()->add('ic','NRIC must be 12 digits');
                    } 

                    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",Input::get('birth_date')))
                    {
                        $validate = false;
                        //$error = "Invalid Input Birth Date (YYYY-MM-DD)";
                        $validator->messages()->add('birth_date','invalid birth date format YYYY-MM-DD');
                    }

                    if (Input::get('id_type') != '1' && Input::get('id_type') != '5'){
                        $validate = false;
                        //$error = "Invalid Input ID Type";
                        $validator->messages()->add('id_type','invalid id_type');
                    }  

                    if (Input::get('nation') > 228 || Input::get('nation') < 1){
                        $validate = false;
                        //$error = "Invalid Input Nation";
                        $validator->messages->add('nation','invalid nation');
                    }                

                    if (Input::get('race') != '1' && Input::get('race') != '2' && Input::get('race') != '3' && Input::get('race') != '4'){
                        $validate = false;
                        //$error = "Invalid Input Race";
                        $validator->messages()->add('race','invalid race');
                    } 

                    if (Input::get('marital_status') != 'SINGLE' && Input::get('marital_status') != 'MARRIED'){
                        $validate = false;
                        //$error = "Invalid Input Marital Status";
                        $validator->messages()->add('marital_status','invalid marital status');
                    }

                    if (Input::get('language') != '2' && Input::get('language') != '3' && Input::get('language') != '5'){
                        $validate = false;
                        //$error = "Invalid Input Language";
                        $validator->messages()->add('language','invalid language');
                    } 

                    if (Input::get('gender') != 'MALE' && Input::get('gender') != 'FEMALE'){
                        $validate = false;
                        //$error = "Invalid Input Gender";
                        $validator->messages()->add('gender','invalid gender');
                    }


                    if (Input::get('city') > 470 || Input::get('city') < 1){
                        $validate = false;
                        //$error = "Invalid Input City";
                        $validator->messages()->add('city','invalid city');
                    }

                    if($validate == true)
                    {

                        $city = Glossary::where('type','=','Cities')->where('value','=',Input::get('city'))->first();
                        $state = Glossary::where('type','=','States')->where('label','=',$city->remarks)->first();          

                        $prepaidorder                   = new PreRegistration;
                        $prepaidorder->msisdn           = Input::get('msisdn');
                        $prepaidorder->iccid            = Input::get('iccid');      

                        $prepaidorder->name             = Input::get('name');
                        $prepaidorder->id_type          = Input::get('id_type'); //1-> NRIC, 4-> Passport
                        $prepaidorder->ic               = Input::get('ic');
                        $prepaidorder->email            = Input::get('email');
                        $prepaidorder->race             = Input::get('race'); //1-> Malay, 2-> Chinese, 3-> Indian, 4-> Others
                        
                        if (Input::get('id_type') == 'NRIC') { $prepaidorder->nation = 'MALAYSIA'; }
                        else { $prepaidorder->nation = Input::get('nation'); }

                        $prepaidorder->marital_status    = Input::get('marital_status'); //SINGLE, MARRIED
                        $prepaidorder->language         = Input::get('language'); //2-> English, 3-> Malay, 5-> Chinese
                        $prepaidorder->gender           = Input::get('gender'); //MALE, FEMALE
                        $prepaidorder->birth_date       = date('Y-m-d', strtotime(Input::get('birth_date')));   

                        $prepaidorder->address1         = Input::get('address1');
                        $prepaidorder->address2         = Input::get('address2');   
                        $prepaidorder->post_code        = Input::get('post_code');  
                        $prepaidorder->city             = $city->label;
                        $prepaidorder->state            = $state->label;
                        $prepaidorder->country          = 'MALAYSIA';   

                        $prepaidorder->save();

                        $response = array("status" => "successful");        
                    }
                    else
                    {
                        $response = array("status" => "failed", "error" => $validator->messages()->toJson());
                    }             
                }
                else
                {
                    $response = array("status" => "failed", "error" => $validator->messages()->toJson());
                }                 
            }
            else
            {
                $validator->messages()->add('signature','invalid signature');
                $response = array("status" => "failed", "error" => $validator->messages()->toJson());
            }
        }
        else
        {
            $validator->messages()->add('timestamp','request expired');
            $response = array("status" => "failed", "error" => $validator->messages()->toJson());
        }
        $response = json_encode($response);
        $this->API_log_response($api_log_id,$response);
        return $response;
    }

    public function create_reload()
    {
        $referer = isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"";
        $api_log_id = $this->API_log_request($referer,"create_reload",json_encode(Input::all()));

        $rules = array(
            "msisdn"        => "required",
            "sku"           => "required",
            "source"        => "required", 
            "channel"       => "required",             
            "signature"     => "required",
            "timestamp"     => "required|integer"   
        );

        $validator = Validator::make(Input::all(), $rules);

        if($this->get_timestamp_diff(time(),Input::get("timestamp")) <= $this->validity)
        {
            if($this->get_encryption($this->secret_key.Input::get("timestamp").Input::get("msisdn").Input::get("sku"),"md5") == Input::get("signature"))
            {

                if ($validator->passes())
                {

                    $product = Product::where('sku',Input::get('sku'))->first();

                    $product_amount = $product->productAmount;

                    $branch_id   = null !== Input::get('branch_id')?Input::get('branch_id'): 0;

                    if($branch_id > 0){

                        $branch = Branch::find($branch_id);

                    }else {

                        if(Input::get('source') == 'SMS') {
                            $branch_msisdn = BranchMsisdn::where('msisdn',Input::get('channel'))->first();

                            if(isset($branch_msisdn)) {
                                $branch = $branch_msisdn->branch;
                            }
                        }

                        if(Input::get('source') == 'API') {
                            $channel = Channel::where('channel_id',Input::get('channel'))->first();
                            
                            if(isset($channel)) {
                                $branch = Branch::where('channel_id',$channel->id)->first();
                            }
                        }
                    }



                    if(isset($branch)) {


                    $pinless = Pinless::where('branch_id',$branch->id)->first();

                    $user = User::where('channel_id',$branch->channel->id)->first();


                    if($pinless->balance >= $product_amount[0]->reload_amount) {
                    
                        if($product_amount[0]->reload_amount > 0) {

                            $reload                 = new Reload;
                            $reload->msisdn         = Input::get('msisdn');
                            $reload->amount         = $product_amount[0]->reload_amount;
                            $reload->source         = Input::get('source');
                            $reload->source_ref     = Input::get('source_ref');
                            $reload->product_id     = $product->id;
                            $reload->receipt_no     = null !== Input::get('receipt_no')?Input::get('receipt_no'): NULL;
                            $reload->remarks        = null !== Input::get('remarks')?Input::get('remarks'): NULL;
                            $reload->sequence       = '1';
                            $reload->pinless_balance_before = $pinless->balance;
                            $reload->brand_id       = $branch->channel->brand->id;
                            $reload->channel_id     = $branch->channel->id;
                            $reload->branch_id      = $branch->id;               
                            $reload->created_by     = $user->id;               
                            $reload->save();

                            $ref_id = str_pad($branch->channel->id, 4, "0", STR_PAD_LEFT) . str_pad($branch->channel->brand_id, 2, "0", STR_PAD_LEFT)
                                    . str_pad($product->id, 4, "0", STR_PAD_LEFT) . 'y' . ($reload->parent_id > 0 ? 'n' : 'y') . str_pad($reload->id, 8, "0", STR_PAD_LEFT);

                            $pinless->balance = $pinless->balance - $reload->amount;
                            $pinless->save();

                            $reload->pinless_balance_after  = $pinless->balance;
                            $reload->ref_id = $ref_id;
                            $reload->save();

                            $parent_id = $reload->id;

                            $acdc = New ACDC;
                            $result = $acdc->pinlessReload($reload->msisdn, $reload->amount, $ref_id);

                            if($result->ResultStatus->StatusCode == 'Successful') {

                               $reload->status = 'successful';
                               $reload->new_talktime_balance = $result->PrepaidAccount->NewBalance;
                               $reload->new_expiry_date = $result->PrepaidAccount->ExpiryDate;
                               $reload->save();

                                $response = array("status" => "successful", "channel_id" => $branch->channel->channel_id, "msisdn" => Input::get('msisdn'), "amount" => $product_amount[0]->reload_amount, "account_balance" => $pinless->balance, "talktime_balance" => $reload->new_talktime_balance, "exipry_date" => $reload->new_expiry_date, "ref_id" => $ref_id);  

                                $points   = null !== Input::get('points')?Input::get('points'): $reload->amount * 2;
  
                                if($product->product_category_id == '1' && $reload->amount >= 10 && $branch->channel->brand_id == '1' && $points > 0) {

                                    $secretkey = 'gK8B3vuY';
                                    $mobile_no = '6'.$reload->msisdn;
                                    $point  = $points;
                                    $remark = '';
                                    $timestamp = time();
                                    $signature = md5($secretkey.$timestamp.$mobile_no.$point);


                                    $fields = array(
                                        'mobile_no'     =>  urlencode($mobile_no),
                                        'point'         =>  urlencode($point),
                                        'remark'        =>  urlencode($remark),
                                        'timestamp'     =>  urlencode($timestamp),
                                        'signature'     =>  urlencode($signature),
                                        'reference_no'  =>  urlencode($reload->ref_id),
                                        'source'        =>  urlencode('WEB')
                                    );
                                    

                                    //$url = 'http://192.168.4.43/tronpoints/public/api/user_point_add_by_mobile';
                                    $url = 'http://192.168.4.50/tronpoints/public/api/user_point_add_by_mobile';        
                                    $fields_string = '';
                                    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
                                    rtrim($fields_string, '&');

                                    $ch = curl_init(); 
                                    curl_setopt($ch,CURLOPT_URL, $url);
                                    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch,CURLOPT_POST, count($fields));
                                    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);                
                                    curl_exec ($ch);
                                    curl_close ($ch);
                                    //echo $response;
                                    //exit;
                                    //$response = json_decode($response);

                                }       
                                    
                          }else {

                            $pinless->balance = $pinless->balance + $reload->amount;
                            $pinless->save();

                            $reload->status                 = 'failed';
                            $reload->error_msg              = $result->ResultStatus->ErrorDescription;
                            $reload->pinless_balance_after  = $pinless->balance;
                            $reload->save();

                            $response = array("status" => "failed", "error" => $result->ResultStatus->ErrorDescription);

                            $response = json_encode($response);
                            $this->API_log_response($api_log_id,$response);
                            return $response;  

                          }             
                        
                        }

                        if($product_amount[0]->free_amount > 0) {

                            $reload                 = new Reload;
                            $reload->msisdn         = Input::get('msisdn');
                            $reload->amount         = $product_amount[0]->free_amount;
                            $reload->product_id     = $product->id;         
                            $reload->receipt_no     = null !== Input::get('receipt_no')?Input::get('receipt_no'): NULL;
                            $reload->remarks        = null !== Input::get('remarks')?Input::get('remarks'): NULL;
                            $reload->source         = Input::get('source');
                            $reload->source_ref     = Input::get('source_ref');
                            $reload->is_free        = '1';
                            $reload->sequence       = '1';
                            $reload->pinless_balance_before = $pinless->balance;
                            $reload->pinless_balance_after  = $pinless->balance;
                            $reload->brand_id       = $branch->channel->brand->id;
                            $reload->channel_id     = $branch->channel->id;
                            $reload->branch_id      = $branch->id;                    
                            $reload->created_by     = $user->id;            
                            $reload->save();

                            $ref_id = str_pad($branch->channel->id, 4, "0", STR_PAD_LEFT) . str_pad($branch->channel->brand_id, 2, "0", STR_PAD_LEFT)
                                    . str_pad($product->id, 4, "0", STR_PAD_LEFT) . 'n' . ($reload->parent_id > 0 ? 'n' : 'y') . str_pad($reload->id, 8, "0", STR_PAD_LEFT);

                            if(isset($parent_id)) { $reload->parent_id = $parent_id; }
                            else { $parent_id = $reload->id; }
                            $reload->ref_id = $ref_id;
                            $reload->save();



                            $acdc = New ACDC;
                            $result = $acdc->pinlessReload($reload->msisdn, $reload->amount, $ref_id);

                            if($result->ResultStatus->StatusCode == 'Successful') {

                               $reload->status = 'successful';
                               $reload->new_talktime_balance = $result->PrepaidAccount->NewBalance;
                               $reload->new_expiry_date = $result->PrepaidAccount->ExpiryDate;
                               $reload->save();

                               if(empty($response)) {
                                    
                                    $response = array("status" => "successful", "channel_id" => $branch->channel->channel_id, "msisdn" => Input::get('msisdn'), "amount" => $product_amount[0]->free_amount, "account_balance" => $pinless->balance, "talktime_balance" => $reload->new_talktime_balance, "exipry_date" => $reload->new_expiry_date, "ref_id" => $ref_id);  
                                }

                            }else {

                                $reload->status         = 'failed';
                                $reload->error_msg      = $result->ResultStatus->ErrorDescription;
                                $reload->save();      

                                $response = array("status" => "failed", "error" => $result->ResultStatus->ErrorDescription);    

                                $response = json_encode($response);
                                $this->API_log_response($api_log_id,$response);
                                return $response;                                       

                            }

                        }

                        $first = true;
                        $current_date = date("Y-m-d");
                        $seq = 1;

                        foreach($product_amount as $amount) {

                            if($first == false) {

                                $seq = $seq + 1;

                                if($product->recurrence_pattern == 'monthly' && $product->recurrence_type == 'fix') {
                                    $current_date = date("Y-m-", strtotime($current_date . " first day of +1 month")). $product->recurrence_fix_day;
                                }

                                if($product->recurrence_pattern == 'daily' && $product->recurrence_type == 'current') {
                                    $current_date = date("Y-m-d", strtotime($current_date . " +".$product->recurrence_frequency." days"));
                                }                  

                                if($amount->reload_amount > 0) {

                                    $reload                 = new ReloadPending;
                                    $reload->reload_date    = $current_date;
                                    $reload->msisdn         = Input::get('msisdn');
                                    $reload->amount         = $amount->reload_amount;
                                    $reload->product_id     = $product->id;         
                                    $reload->receipt_no     = null !== Input::get('receipt_no')?Input::get('receipt_no'): NULL;
                                    $reload->remarks        = null !== Input::get('remarks')?Input::get('remarks'): NULL;
                                    $reload->source         = Input::get('source');
                                    $reload->source_ref     = Input::get('source_ref');
                                    $reload->parent_id      = $parent_id;                   
                                    $reload->sequence       = $seq;     
                                    $reload->brand_id       = $branch->channel->brand->id;
                                    $reload->channel_id     = $branch->channel->id;
                                    $reload->branch_id      = $branch->id;                    
                                    $reload->created_by     = $user->id;                  
                                    $reload->save();                        
                                
                                }

                                if($amount->free_amount > 0) {

                                    $reload                 = new ReloadPending;
                                    $reload->reload_date    = $current_date;                    
                                    $reload->msisdn         = Input::get('msisdn');
                                    $reload->amount         = $amount->free_amount;
                                    $reload->product_id     = $product->id;         
                                    $reload->receipt_no     = null !== Input::get('receipt_no')?Input::get('receipt_no'): NULL;
                                    $reload->remarks        = null !== Input::get('remarks')?Input::get('remarks'): NULL;
                                    $reload->source         = Input::get('source');
                                    $reload->source_ref     = Input::get('source_ref');
                                    $reload->is_free        = '1';
                                    $reload->parent_id      = $parent_id; 
                                    $reload->sequence       = $seq; 
                                    $reload->brand_id       = $branch->channel->brand->id;
                                    $reload->channel_id     = $branch->channel->id;
                                    $reload->branch_id      = $branch->id;                    
                                    $reload->created_by     = $user->id;                                
                                    $reload->save();

                                }

                            }else{ $first = false; }


                    }


                    } else {

                        $response = array("status" => "failed", "error" => 'Insufficient Balance');

                    }
                }else
                {

                    $response = array("status" => "failed", "error" => 'Invalid Channel');
                
                }                    

                }else
                {

                    $response = array("status" => "failed", "error" => 'Validation Failed');
                
                }
            }
            else
            {

                $response = array("status" => "failed", "error" => 'Invalid Signature');
            }
        }
        else
        {

            $response = array("status" => "failed", "error" => 'Request Expired.');
        }        

        $response = json_encode($response);
        $this->API_log_response($api_log_id,$response);
        return $response;        

    }

    public function get_pinless_balance()
    {
        $referer = isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"";
        $api_log_id = $this->API_log_request($referer,"get_pinless_balance",json_encode(Input::all()));

        $rules = array(
            "source"        => "required", 
            "channel"       => "required",             
            "signature"     => "required",
            "timestamp"     => "required|integer"   
        );

        $validator = Validator::make(Input::all(), $rules);

        if($this->get_timestamp_diff(time(),Input::get("timestamp")) <= $this->validity)
        {
            if($this->get_encryption($this->secret_key.Input::get("timestamp").Input::get("source").Input::get("channel"),"md5") == Input::get("signature"))
            {

                if ($validator->passes())
                {
                    if(Input::get('source') == 'SMS') {
                        $branch_msisdn = BranchMsisdn::where('msisdn',Input::get('channel'))->first();

                        if(isset($branch_msisdn)) {
                            $branch = $branch_msisdn->branch;
                        }
                    }

                    if(Input::get('source') == 'API') {
                        $branch = Branch::where('channel_id',Input::get('channel'))->first();
                    }


                    if(isset($branch)) {


                        $pinless = Pinless::where('branch_id',$branch->id)->first();

                        $response = array("status" => "successful", "channel_id" => $branch->channel->channel_id, "brand_id" => $branch->channel->brand->id, "balance" => $pinless->balance);

                    }else
                    {

                        $response = array("status" => "failed", "error" => 'Invalid Channel');
                    
                    } 

                }else
                {

                    $response = array("status" => "failed", "error" => 'Validation Failed');
                
                }
            }
            else
            {

                $response = array("status" => "failed", "error" => 'Invalid Signature');
            }
        }
        else
        {

            $response = array("status" => "failed", "error" => 'Request Expired.');
        }        

        $response = json_encode($response);
        $this->API_log_response($api_log_id,$response);
        return $response;                       
    }

    public function reload_pending()
    {
        $referer = isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"";
        $api_log_id = $this->API_log_request($referer,"reload_pending",json_encode(Input::all()));

        $rules = array(
            "reload_id"     => "required",           
            "signature"     => "required",
            "timestamp"     => "required|integer"   
        );

        $validator = Validator::make(Input::all(), $rules);

        if($this->get_timestamp_diff(time(),Input::get("timestamp")) <= $this->validity)
        {
            if($this->get_encryption($this->secret_key.Input::get("timestamp").Input::get("reload_id"),"md5") == Input::get("signature"))
            {

                if ($validator->passes())
                {

                    $reload_pending = ReloadPending::find(Input::get('reload_id'));

                    if(isset($reload_pending)) {

                    $branch = Branch::find($reload_pending->branch_id);

                    $pinless = Pinless::where('branch_id',$branch->id)->first();

                    $user = User::where('channel_id',$branch->channel->id)->first();

                    if($pinless->balance >= $reload_pending->amount or $reload_pending->is_free == '1') {

                            $reload                 = new Reload;
                            $reload->msisdn         = $reload_pending->msisdn;
                            $reload->amount         = $reload_pending->amount;
                            $reload->product_id     = $reload_pending->product_id;
                            $reload->receipt_no     = $reload_pending->receipt_no;
                            $reload->remarks        = $reload_pending->remarks;
                            $reload->is_free        = $reload_pending->is_free;
                            $reload->parent_id      = $reload_pending->parent_id;                            
                            $reload->sequence       = $reload_pending->sequence;
                            $reload->source         = 'WEB';
                            $reload->pinless_balance_before = $pinless->balance;
                            $reload->brand_id       = $branch->channel->brand->id;
                            $reload->channel_id     = $branch->channel->id;
                            $reload->branch_id      = $branch->id;               
                            $reload->created_by     = $user->id;               
                            $reload->save();

                            $ref_id = str_pad($branch->channel->id, 4, "0", STR_PAD_LEFT) . str_pad($branch->channel->brand_id, 2, "0", STR_PAD_LEFT)
                                    . str_pad($reload->product_id, 4, "0", STR_PAD_LEFT) . ($reload->is_free > 0 ? 'n' : 'y') . ($reload->parent_id > 0 ? 'n' : 'y') . str_pad($reload->id, 8, "0", STR_PAD_LEFT);

                            if($reload->is_free == '0'){
                                $pinless->balance = $pinless->balance - $reload->amount;
                                $pinless->save();
                            }

                            $reload->pinless_balance_after  = $pinless->balance;
                            $reload->ref_id = $ref_id;
                            $reload->save();

                            $reload_pending->delete();
                            

                           $acdc = New ACDC;
                           $result = $acdc->pinlessReload($reload->msisdn, $reload->amount, $ref_id);

                           if($result->ResultStatus->StatusCode == 'Successful') {

                               $reload->status = 'successful';
                               $reload->new_talktime_balance = $result->PrepaidAccount->NewBalance;
                               $reload->new_expiry_date = $result->PrepaidAccount->ExpiryDate;
                               $reload->save();

                               $reload_pending->delete();

                                $response = array("status" => "successful", "channel_id" => $branch->channel->channel_id, "msisdn" => $reload->msisdn, "amount" => $reload->amount, "account_balance" => $pinless->balance, "talktime_balance" => $reload->new_talktime_balance, "exipry_date" => $reload->new_expiry_date, "ref_id" => $ref_id);                                
                          }else {

                            $pinless->balance = $pinless->balance + $reload->amount;
                            $pinless->save();

                            $reload->status                 = 'failed';
                            $reload->error_msg              = $result->ResultStatus->ErrorDescription;
                            $reload->pinless_balance_after  = $pinless->balance;
                            $reload->save();

                            $response = array("status" => "failed", "error" => $result->ResultStatus->ErrorDescription);


                          }         


                    } else {

                        $response = array("status" => "failed", "error" => 'Insufficient Balance');

                    }
                }else
                {

                    $response = array("status" => "failed", "error" => 'Invalid Reload ID');
                
                }                    

                }else
                {

                    $response = array("status" => "failed", "error" => 'Validation Failed');
                
                }
            }
            else
            {

                $response = array("status" => "failed", "error" => 'Invalid Signature');
            }
        }
        else
        {

            $response = array("status" => "failed", "error" => 'Request Expired.');
        }        

        $response = json_encode($response);
        $this->API_log_response($api_log_id,$response);
        return $response;        

    }

    public function create_reload_preload()
    {
        $referer = isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"";
        $api_log_id = $this->API_log_request($referer,"create_reload_preload",json_encode(Input::all()));

        $rules = array(
            "msisdn"        => "required",  
            "sku"           => "required",            
            "branch_id"     => "required",         
            "signature"     => "required",
            "timestamp"     => "required|integer"   
        );

        $validator = Validator::make(Input::all(), $rules);

        if($this->get_timestamp_diff(time(),Input::get("timestamp")) <= $this->validity)
        {
            if($this->get_encryption($this->secret_key.Input::get("timestamp").Input::get("msisdn").Input::get("sku"),"md5") == Input::get("signature"))
            {

                if ($validator->passes())
                {

                    $branch = Branch::find(Input::get('branch_id'));

                    $product = Product::where('sku',Input::get('sku'))->first();

                    if(isset($product)) {
                        if(isset($branch)) {

                            $reload                 = new ReloadPreload;
                            $reload->msisdn         = Input::get('msisdn');
                            $reload->product_id     = $product->id;
                            $reload->receipt_no     = null !== Input::get('receipt_no')?Input::get('receipt_no'): NULL;
                            $reload->remarks        = null !== Input::get('remarks')?Input::get('remarks'): NULL;
                            $reload->brand_id       = $branch->channel->brand->id;
                            $reload->channel_id     = $branch->channel->id;
                            $reload->branch_id      = $branch->id;               
                            $reload->save();


                           $response = array("status" => "successful");                                 

                    }else
                    {

                        $response = array("status" => "failed", "error" => 'Invalid Branch');
                    
                    }
                }else
                {

                    $response = array("status" => "failed", "error" => 'Invalid Product');
                
                }                                 

                }else
                {

                    $response = array("status" => "failed", "error" => 'Validation Failed');
                
                }
            }
            else
            {

                $response = array("status" => "failed", "error" => 'Invalid Signature');
            }
        }
        else
        {

            $response = array("status" => "failed", "error" => 'Request Expired.');
        }        

        $response = json_encode($response);
        $this->API_log_response($api_log_id,$response);
        return $response;        

    }   

    public function reload_preload()
    {
        $referer = isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"";
        $api_log_id = $this->API_log_request($referer,"reload_preload",json_encode(Input::all()));

        $rules = array(
            "reload_id"     => "required",           
            "signature"     => "required",
            "timestamp"     => "required|integer"   
        );

        $validator = Validator::make(Input::all(), $rules);

        if($this->get_timestamp_diff(time(),Input::get("timestamp")) <= $this->validity)
        {
            if($this->get_encryption($this->secret_key.Input::get("timestamp").Input::get("reload_id"),"md5") == Input::get("signature"))
            {

                if ($validator->passes())
                {

                    $reload_preload = ReloadPreload::find(Input::get('reload_id'));

                    if(isset($reload_preload)) {

                        $product = $reload_preload->product;
                        
                        $product_amount = $product->productAmount;


                        $current_date = date("Y-m-d");
                        $seq = 0;

                        foreach($product_amount as $amount) {

                            $seq = $seq + 1;

                            if($seq > 1 && $product->recurrence_pattern == 'monthly' && $product->recurrence_type == 'fix') {
                                $current_date = date("Y-m-", strtotime($current_date . " first day of +1 month")). $product->recurrence_fix_day;
                            }

                            if($seq > 1 && $product->recurrence_pattern == 'daily' && $product->recurrence_type == 'current') {
                                $current_date = date("Y-m-d", strtotime($current_date . " +".$product->recurrence_frequency." days"));
                            }                  

                            if($amount->reload_amount > 0) {

                                $reload                 = new ReloadPending;
                                $reload->reload_date    = $current_date;
                                $reload->msisdn         = $reload_preload->msisdn;
                                $reload->amount         = $amount->reload_amount;
                                $reload->product_id     = $product->id;         
                                $reload->receipt_no     = $reload_preload->receipt_no;
                                $reload->remarks        = $reload_preload->remarks;
                                $reload->source         = 'WEB';                 
                                $reload->sequence       = $seq;     
                                $reload->brand_id       = $reload_preload->brand_id;
                                $reload->channel_id     = $reload_preload->channel_id;
                                $reload->branch_id      = $reload_preload->branch_id;                    
                                $reload->created_by     = '1';                  
                                $reload->save();
                            
                            }

                            if($amount->free_amount > 0) {

                                $reload                 = new ReloadPending;
                                $reload->reload_date    = $current_date;                    
                                $reload->msisdn         = $reload_preload->msisdn;
                                $reload->amount         = $amount->free_amount;
                                $reload->product_id     = $product->id;         
                                $reload->receipt_no     = $reload_preload->receipt_no;
                                $reload->remarks        = $reload_preload->remarks;
                                $reload->source         = 'WEB';
                                $reload->is_free        = '1';
                                $reload->sequence       = $seq; 
                                $reload->brand_id       = $reload_preload->brand_id;
                                $reload->channel_id     = $reload_preload->channel_id;
                                $reload->branch_id      = $reload_preload->branch_id;                    
                                $reload->created_by     = '1';                                
                                $reload->save();

                            }
                        }

                        $reload_preload->delete();
                        $response = array("status" => "successful");  

                }else
                {

                    $response = array("status" => "failed", "error" => 'Invalid Reload ID');
                
                }                    

                }else
                {

                    $response = array("status" => "failed", "error" => 'Validation Failed');
                
                }
            }
            else
            {

                $response = array("status" => "failed", "error" => 'Invalid Signature');
            }
        }
        else
        {

            $response = array("status" => "failed", "error" => 'Request Expired.');
        }        

        $response = json_encode($response);
        $this->API_log_response($api_log_id,$response);
        return $response;        

    }               

    // start - add by liyin 2015-04-10
    public function update_pin_is_used()
    {
        $addr = isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"";
        if(in_array($addr, Config::get("api.ip_allow")))
        {
            $rules = array(
                "serial_no"     => "required"               
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->passes())
            {
                $serial_nos = explode(",", trim(Input::get("serial_no")));
            
                $total_updated = Pin::whereIn("serial_no",$serial_nos)->update(array("is_used" => "y"));

                $pins = Pin::leftJoin("branch","branch.id","=","pin.branch_id")
                        ->leftJoin("channels","channels.id","=","branch.channel_id")
                        ->whereIn("pin.serial_no",$serial_nos)
                        ->select("pin.serial_no",DB::raw("IFNULL(branch.channel_id,0) AS channel_id"),DB::raw("IFNULL(channels.brand_id,0) AS brand_id"),"pin.is_gst AS is_taxable")
                        ->get();

                $pins = json_decode($pins);
                $response = array("status" => "successful", "pins" => $pins, "total_updated"=>$total_updated);
            }
            else
            {
                $response = array("status" => "failed", "error" => 'Validation Failed');
            }
        }
        else
        {
            $response = array("status" => "failed");
        }
        $response = json_encode($response);
        return $response;  
    }
    // end 

    // start - add by liyin 2015-04-10
    public function get_pin_info()
    {
        $addr = isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"";
        if(in_array($addr, Config::get("api.ip_allow")))
        {
            $rules = array(
                "serial_no"     => "required"               
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->passes())
            {
                $serial_nos = explode(",", trim(Input::get("serial_no")));
            
                $pins = Pin::join("branch","branch.id","=","pin.branch_id")
                        ->join("channels","channels.id","=","branch.channel_id")
                        ->whereIn("pin.serial_no",$serial_nos)
                        ->select("pin.serial_no",DB::raw("IFNULL(branch.channel_id,0) AS channel_id"),DB::raw("IFNULL(channels.brand_id,0) AS brand_id"),"pin.is_gst AS is_taxable")
                        ->get();

                $pins = json_decode($pins);
                $response = array("status" => "successful", "pins" => $pins);
            }
            else
            {
                $response = array("status" => "failed", "error" => 'Validation Failed');
            }
        }
        else
        {
            $response = array("status" => "failed");
        }
        $response = json_encode($response);
        return $response;   
    }
    // end 

    public function get_timestamp_diff($timestamp1, $timestamp2)
    {
        return $timestamp1 - $timestamp2;
    }

    public function get_encryption($string, $method)
    {
        switch ($method) {
            case "md5":
                $encrypted_value = md5($string);
                break;
            default:
                $encrypted_value = "";
        }
        return $encrypted_value;
    }
    public function mobile_no_remove_prefix($mobile_no)
    {
      if(substr($mobile_no, 0, 2) == "60")
      {
        return substr($mobile_no, 1);
      }
      else
      {
        return $mobile_no;
      }
    }

    public function API_log_request($referer,$name,$request)
    {
        $api_log = new APILog;
        $api_log->name = $name;
        $api_log->referer = $referer;
        $api_log->request = $request;
        $api_log->save();
        return $api_log->id;
    }

    public function API_log_response($id,$response)
    {
        $api_log = APILog::find($id);
        $api_log->response = $response;
        $api_log->save();
    }


    //On Site API

    public function getProductByCategory($id)
    {

        $product = Product::where('product_category_id',$id)->where('status','active')->whereIn('id', Auth::user()->channel->products->lists('id')?Auth::user()->channel->products->lists('id'):array(''))->orderBy('name', 'asc')->lists('name','id');


        //$product = ['' => ''] + $product;

        return json_encode($product);
    
    }   

    public function getNameByMsisdn($msisdn)
    {
        $prepaid_order = PrepaidOrder::where('msisdn',$msisdn)->where('status','2')->orderBy('created_at','desc')->first();

        return strtoupper(isset($prepaid_order->name)?$prepaid_order->name:'N/A');
    
    } 

    public function get_simcard_pattern_list($length)
    {
        return SimcardPattern::where("length","=",$length)->orderBy("pattern","asc")->lists("pattern");
    }

    public function getPrint($abc)
    {
        return $abc;
    }  

}
?>