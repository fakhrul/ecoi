<?php

class SummaryController extends \BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('acl.permitted');		
	}		

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		$summary = RtuConfig::where('idrut_config', 1)->first();
		$timelog = TimeLog::orderBy('LOG_DATE', 'desc')->orderBy('LOG_TIME', 'desc')->first();
		$sms_no = SmsNo::where('idSMS_no', 1)->first();
		$sensor_setting = SensorSetting::where('idSensor_setting', 1)->first();
		
        $breadcrumbs = array('Summary' => 'summary' , 'Manage Summary' => 'summary');

		return View::make('summary.index')->with('breadcrumbs',$breadcrumbs)->with('summary', $summary)->with('timelog', $timelog)->with('sms_no', $sms_no)->with('sensor_setting', $sensor_setting);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		$summary = RtuConfig::where('idrut_config', 1)->first();
		$timelog = TimeLog::orderBy('LOG_DATE', 'desc')->orderBy('LOG_TIME', 'desc')->first();
		$sms_no = SmsNo::where('idSMS_no', 1)->first();
		$sensor_setting = SensorSetting::where('idSensor_setting', 1)->first();
		
        $breadcrumbs = array('Summary' => 'summary' , 'Manage Summary' => 'summary');

		return View::make('summary.edit')->with('breadcrumbs',$breadcrumbs)->with('summary', $summary)->with('timelog', $timelog)->with('sms_no', $sms_no)->with('sensor_setting', $sensor_setting);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		// validate - read more on validation at http://laravel.com/docs/validation        
        $rules = array(
			'Station_ID'	=> 'required|Max:80',
			'Station_Name'	=> 'required|Max:80',
			
			'sam_H'			=> 'required|integer|max:23',
			'sam_M'			=> 'required|integer|max:59',
			'transfer_H'	=> 'required|integer|max:23',
			'transfer_M'	=> 'required|integer|max:59',
			
			'server1_ip'	=> 'ip',
			'server1_user'	=> 'alpha_num',
			'server2_ip'	=> 'ip',
			'server2_user'	=> 'alpha_num',
			'server3_ip'	=> 'ip',
			'server3_user'	=> 'alpha_num',
			'server4_ip'	=> 'ip',
			'server4_user'	=> 'alpha_num',
			'health_ip'		=> 'ip',
			'health_user'	=> 'alpha_num',
			
			'SMS_01'	    => 'digits_between:10,11',
			'SMS_02'	    => 'digits_between:10,11',
			'SMS_03'	    => 'digits_between:10,11',
			'SMS_04'	    => 'digits_between:10,11',
			'SMS_05'	    => 'digits_between:10,11',
			'SMS_06'	    => 'digits_between:10,11',
			'SMS_07'	    => 'digits_between:10,11',
			'SMS_08'	    => 'digits_between:10,11',
			'SMS_09'	    => 'digits_between:10,11',
			'SMS_10'	    => 'digits_between:10,11',
			'SMS_11'	    => 'digits_between:10,11',
			'SMS_12'	    => 'digits_between:10,11',
			
			'rf1_h'			=> 'required|integer|max:1000',
			'rf1_vh'		=> 'required|integer|max:1000' 
		);

		$messages["groups.required"]      = "Please select at least 1 group.";
		$messages["brands.required"]      = "Please select at least 1 brand.";	        
				
		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('summary/' . $id . '/edit')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// store //var_dump(Input::all()); exit();
			
			$summary = RtuConfig::where('idrut_config', 1)->first();
			
			$summary->Station_ID       	= Input::get('Station_ID');
			$summary->Station_Name 		= Input::get('Station_Name');
			$summary->sam_H       		= Input::get('sam_H');
			$summary->sam_M 			= Input::get('sam_M');
			$summary->transfer_H       	= Input::get('transfer_H');
			$summary->transfer_M 		= Input::get('transfer_M');
			
			$summary->server1_enable	= (Input::has('server1_enable') == 'on' ? '1' : '0');
			$summary->server1_ip       	= Input::get('server1_ip');
			$summary->server1_user      = Input::get('server1_user');
			$summary->server1_pass		= Input::get('server1_pass');
			
			$summary->server2_enable	= (Input::has('server2_enable') == 'on' ? '1' : '0');
			$summary->server2_ip       	= Input::get('server2_ip');
			$summary->server2_user      = Input::get('server2_user');
			$summary->server2_pass		= Input::get('server2_pass');
			
			$summary->server3_enable	= (Input::has('server3_enable') == 'on' ? '1' : '0');
			$summary->server3_ip       	= Input::get('server3_ip');
			$summary->server3_user      = Input::get('server3_user');
			$summary->server3_pass		= Input::get('server3_pass');
			
			$summary->server4_en		= (Input::has('server4_en') == 'on' ? '1' : '0');
			$summary->server4_ip       	= Input::get('server4_ip');
			$summary->server4_user      = Input::get('server4_user');
			$summary->server4_pass		= Input::get('server4_pass');
			
			$summary->server1_enable	= (Input::has('server1_enable') == 'on' ? '1' : '0');
			$summary->health_ip       	= Input::get('health_ip');
			$summary->health_user       = Input::get('health_user');
			$summary->health_pass		= Input::get('health_pass');

			$summary->save();
			
			$sms_no = SmsNo::where('idSMS_no', 1)->first();
			
			$sms_no->SMS_01_en			= (Input::has('SMS_01_en') == 'on' ? '1' : '0');
			$sms_no->SMS_01		       	= Input::get('SMS_01');
			$sms_no->SMS_02_en			= (Input::has('SMS_02_en') == 'on' ? '1' : '0');
			$sms_no->SMS_02		       	= Input::get('SMS_02');
			$sms_no->SMS_03_en			= (Input::has('SMS_03_en') == 'on' ? '1' : '0');
			$sms_no->SMS_03		       	= Input::get('SMS_03');
			$sms_no->SMS_04_en			= (Input::has('SMS_04_en') == 'on' ? '1' : '0');
			$sms_no->SMS_04		       	= Input::get('SMS_04');
			$sms_no->SMS_05_en			= (Input::has('SMS_05_en') == 'on' ? '1' : '0');
			$sms_no->SMS_05		       	= Input::get('SMS_05');
			$sms_no->SMS_06_en			= (Input::has('SMS_06_en') == 'on' ? '1' : '0');
			$sms_no->SMS_06		       	= Input::get('SMS_06');
			$sms_no->SMS_07_en			= (Input::has('SMS_07_en') == 'on' ? '1' : '0');
			$sms_no->SMS_07		       	= Input::get('SMS_07');
			$sms_no->SMS_08_en			= (Input::has('SMS_08_en') == 'on' ? '1' : '0');
			$sms_no->SMS_08		       	= Input::get('SMS_08');
			$sms_no->SMS_09_en			= (Input::has('SMS_09_en') == 'on' ? '1' : '0');
			$sms_no->SMS_09		       	= Input::get('SMS_09');
			$sms_no->SMS_10_en			= (Input::has('SMS_10_en') == 'on' ? '1' : '0');
			$sms_no->SMS_10		       	= Input::get('SMS_10');
			$sms_no->SMS_11_en			= (Input::has('SMS_11_en') == 'on' ? '1' : '0');
			$sms_no->SMS_11		       	= Input::get('SMS_11');
			$sms_no->SMS_12_en			= (Input::has('SMS_12_en') == 'on' ? '1' : '0');
			$sms_no->SMS_12		       	= Input::get('SMS_12');
			
			$sms_no->save();
						
			$sensor_setting = SensorSetting::where('idSensor_setting', 1)->first();
			
			$sensor_setting->rf1_h       		= Input::get('rf1_h');
			$sensor_setting->rf1_vh 			= Input::get('rf1_vh');
			
			$sensor_setting->save();
            
            // redirect
			Session::flash('message', 'Summary Updated');
			return Redirect::to('summary/');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
		//
	}

}
