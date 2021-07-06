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
			'rf1_vh'		=> 'required|integer|max:1000', 

			'as1_A'			=> 'required',
			'as1_W'			=> 'required',
			'as1_D'			=> 'required'
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

			$sensor_setting->as1_A	 			= Input::get('as1_A');
			$sensor_setting->as1_W 				= Input::get('as1_W');
			$sensor_setting->as1_D 				= Input::get('as1_D');
			
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
	
	public function export(){ 
		$sort_by = "asc";
		$data = array();
		// validate		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'begin_date'			=> 'required',
			'end_date'				=> 'required'
		);        
        //var_dump(Input::all()); exit();
		$validator = Validator::make(Input::all(), $rules);
        
		// process the login
		if ($validator->fails()) {
			return Redirect::to('summary')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			//var_dump(Input::all()); //exit();
			$report_date 		= date("Y-m-d 00:00:00", time());
			
			$begin_date       	= Input::get('begin_date');
			$end_date       	= Input::get('end_date');
					
			$summary 			= RtuConfig::where('idrut_config', 1)->first();
			//var_dump($summary); exit();
			$Station_ID			= $summary->Station_ID;
			$serial_no			= $summary->serial_no;
			$SR_Alert			= $summary->SR_Alert;
			$SR_Danger			= $summary->SR_Danger;
			$RF_Alert			= $summary->RF_Alert;
			$RF_Danger			= $summary->RF_Danger;
			$WL_Alert			= $summary->WL_Alert;
			$WL_Warning			= $summary->WL_Warning;
			$WL_Danger			= $summary->WL_Danger;
			$SMS_1				= $summary->SMS_1;
			$SMS_2				= $summary->SMS_2;
			
			$report_format      = Input::get('report_format');
			
			set_time_limit(0); 
			ini_set('memory_limit', '512M');
			
			if($report_format=="ftp"){
				$timelogs			= TimeLog::where('LOG_DATE', '>=', $begin_date)->where('LOG_DATE', '<=', $end_date)->orderBy('LOG_DATE', $sort_by)->orderBy('LOG_TIME', $sort_by)->get();
				//var_dump($timelogs); exit();
				
				$inventory_rtu 		= InventoryRtu::where('id', 1)->first();
				//var_dump($inventory_rtu); exit();
				$Legacy_ID			= $inventory_rtu->Legacy_ID;
				$Siren_ID			= $inventory_rtu->Siren_ID;
				$RF_ID				= $inventory_rtu->RF_ID;
				$WL1_ID				= $inventory_rtu->WL1_ID;
				$WL2_ID				= $inventory_rtu->WL2_ID;
				$SF1_ID				= $inventory_rtu->SF1_ID;
				$EP_ID				= $inventory_rtu->EP_ID;
				$SM_ID				= $inventory_rtu->SM_ID;
				$WS_ID				= $inventory_rtu->WS_ID;
				$AT_ID				= $inventory_rtu->AT_ID;
				$RH_ID				= $inventory_rtu->RH_ID;
				$RD_ID				= $inventory_rtu->RD_ID;
				$SH_ID				= $inventory_rtu->SH_ID;
				$SP_ID				= $inventory_rtu->SP_ID;
				$WQ1_ID				= $inventory_rtu->WQ1_ID;
				$WQ2_ID				= $inventory_rtu->WQ2_ID;
				$WQ3_ID				= $inventory_rtu->WQ3_ID;
				$WQ4_ID				= $inventory_rtu->WQ4_ID;
				$WQ5_ID				= $inventory_rtu->WQ5_ID;
				$WQ6_ID				= $inventory_rtu->WQ6_ID;
				$WQ7_ID				= $inventory_rtu->WQ7_ID;
				$WQ8_ID				= $inventory_rtu->WQ8_ID;
				
				/*
				$data[] = array("start", "Station ID", "Station ID Legacy", "RTU ID", "Station Date Time", "Station Status", "Battery Voltage", "GSM Comm Signal Strength", "Satellite Signal Strength", 
								"internal battery voltage", "solar output", "siren alert threshold", "siren danger threshold", "rainfall alert threshold", "rainfall danger threshold", 
								"water level alert threshold", "water level warning threshold", "water level danger threshold", "siren id", "siren code", "rainfall id", 
								"yearly cumulative rainfall", "daily accumulative rainfall", "rainfall para1", "rainfall para2", "rainfall para3", "rainfall para4", "rainfall para5", 
								"rainfall para6", "rainfall para7", "rainfall para8", "rainfall para9", "rainfall para10", "rainfall para11", "rainfall para12", "water level id1", 
								"water level para1", "water level id2", "water level para2", "flow sensor id", "flow sensor para1", "flow sensor para2", "flow sensor para3", "flow sensor para4", 
								"hp officer1", "hp officer2", "evaporation id", "evaporation", "evaporation daily accumulative", "soil moisture id", "soil moisture", "soil temperature", 
								"wind speed id", "wind speed", "wind direction", "air temperature id", "air temperature", "relative humidity id", "relative humidity", "radiation id", 
								"radiation", "net radiation", "sunshine hours id", "sunshine hours", "surface pressure id", "surface pressure", "water quality id0", "water quality para0", 
								"water quality id2", "water quality para1", "water quality para2", "water quality id3", "water quality para3", "water quality id4", " water quality para4", 
								"water quality id5", "water quality para5", "water quality id6", "water quality para6", "water quality id7", "water quality para7", "water quality id8", 
								"water quality para8", "water quality para9", "latitude", "longitude", "end");
				*/
				
				$satellite_signal_strength 		= 0;
				$siren_code 					= "";
				$flow_sensor_para1				= 0;
				$flow_sensor_para2				= 0;
				$flow_sensor_para3				= 0;
				$flow_sensor_para4				= 0;
				$evaporation					= 0;
				$evaporation_daily_accumulative	= 0;
				$soil_moisture					= 0;
				$soil_temperature				= 0;
				$wind_speed						= 0;
				$wind_direction					= 0;
				$air_temperature				= 0;
				$relative_humidity				= 0;
				$radiation						= 0;
				$net_radiation					= 0;
				$sunshine_hours					= 0;
				$surface_pressure				= 0;
				$water_quality_para0			= 0;
				$water_quality_para1			= 0;
				$water_quality_para2			= 0;
				$water_quality_para3			= 0;
				$water_quality_para4			= 0;
				$water_quality_para5			= 0;
				$water_quality_para6			= 0;
				$water_quality_para7			= 0;
				$water_quality_para8			= 0;
				$water_quality_para9			= 0;

				foreach ($timelogs as $timelog) {
					//var_dump($timelog); exit();
					$data[] = array("$", $Station_ID, $Legacy_ID, $serial_no, date("ymd", strtotime($timelog->LOG_DATE)).date("His", strtotime($timelog->LOG_TIME)), 
									$timelog->alarm_status, $timelog->Bat_Voltage, $timelog->GSM_Sig, $satellite_signal_strength, $timelog->Int_Bat, $timelog->Solar_voltage, $SR_Alert, $SR_Danger, $timelog->Set_RF_H,
									$timelog->Set_RF_VH, $timelog->Set_WL_A, $timelog->Set_WL_W, $timelog->Set_WL_D, $Siren_ID, $siren_code, $RF_ID, $timelog->RF1_YEARLY, $timelog->RF1_DAILY,
									$timelog->last1h, $timelog->last2h, $timelog->last3h, $timelog->last4h, $timelog->last5h, $timelog->last6h, $timelog->last7h, $timelog->last8h, $timelog->last9h, $timelog->last10h, $timelog->last11h, $timelog->last12h, 
									$WL1_ID, $timelog->AI1, $WL2_ID, $timelog->AI2, $SF1_ID, $flow_sensor_para1, $flow_sensor_para2, $flow_sensor_para3, $flow_sensor_para4, $SMS_1, $SMS_2, 
									$EP_ID, $evaporation, $evaporation_daily_accumulative, $SM_ID, $soil_moisture, $soil_temperature, $WS_ID, $wind_speed, $wind_direction, $AT_ID, $air_temperature, $RH_ID, $relative_humidity, $RD_ID, $radiation, $net_radiation, 
									$SH_ID, $sunshine_hours, $SP_ID, $surface_pressure, $WQ1_ID, $water_quality_para0, $WQ2_ID, $water_quality_para1, $water_quality_para2, $WQ3_ID, $water_quality_para3, $WQ4_ID, $water_quality_para4, 
									$WQ5_ID, $water_quality_para5, $WQ6_ID, $water_quality_para6, $WQ7_ID, $water_quality_para7, $WQ8_ID, $water_quality_para8, $water_quality_para9, $timelog->gps_lat, $timelog->gps_long, "*");
					//echo "<pre>".print_r($data,true)."</pre>"; exit();
				}
				//echo "<pre>".print_r($data,true)."</pre>"; exit();
				/*Excel::create(date("Y-m-d H:i:s")." ".Input::get('report_format')." ".Input::get('begin_date')." to ".Input::get('end_date'), function($excel) use($data) {
					$excel->sheet(Input::get('report_format'), function($sheet) use($data) {
						set_time_limit(0);
						$sheet->fromArray($data, null, 'A1', false, false);
					});
				})->download('xlsx');
				*/
				$filename=date("ymdHis")."_".Input::get('report_format')."_".Input::get('begin_date')."_".Input::get('end_date').".csv";
				//$file_path=storage_path(). "\\reports"."\\".Input::get('report_format')."\\".$filename;
				$file_path=storage_path(). DIRECTORY_SEPARATOR ."reports". DIRECTORY_SEPARATOR .Input::get('report_format'). DIRECTORY_SEPARATOR .$filename;
				//echo "<pre>".print_r($file_path,true)."</pre>"; exit();
				$handle = fopen($file_path,"w+");
				//fputcsv($handle, array('date'));
				foreach($data as $line) {
					fputcsv($handle, $line);
				}

				fclose($handle);

				$headers = array(
					'Content-Type' => 'text/csv',
				);

				return Response::download($file_path, $filename, $headers);
			}
			
			if($report_format=="tideda"){
				$tideda_rf1			= TidedaRf1::where('tideda_Date', '>=', $begin_date)->where('tideda_Date', '<=', $end_date)->orderBy('tideda_Date', $sort_by)->orderBy('tideda_Date', $sort_by)->get();
				
				$filename=date("ymdHis")."_".Input::get('report_format')."_".Input::get('begin_date')."_".Input::get('end_date').".txt";
				//$file_path=storage_path(). "\\reports"."\\".Input::get('report_format')."\\".$filename;
				$file_path=storage_path(). DIRECTORY_SEPARATOR ."reports". DIRECTORY_SEPARATOR .Input::get('report_format').DIRECTORY_SEPARATOR .$filename;
				//echo "<pre>".print_r($file_path,true)."</pre>"; exit();
				/*
				$handle = fopen($file_path,"w+");
				fputcsv($handle, array('~~~ NIWA TIDEDA ~~~ JPS '));
				fputcsv($handle, array('~~~ LIST ~~~'));
				fputcsv($handle, array('Source is Site at '.$Station_ID));
				fputcsv($handle, array('1 Item INCREMENTAL From '.Input::get('begin_date')." to ".Input::get('end_date')));
				$data[] = array("Rain", "Date", "Time");
				foreach($tideda_rf1 as $line) {
					$data[] = array("5", date("Ymd",strtotime($line->tideda_Date)),  "=\"".date("His",strtotime($line->tideda_Time))."\"");
				}
				foreach($data as $tideda) {
					fputcsv($handle, $tideda);
				}
				fclose($handle);
				*/
								
				file_put_contents($file_path, "~~~ NIWA TIDEDA ~~~ JPS \n", FILE_APPEND | LOCK_EX);
				file_put_contents($file_path, "~~~ LIST ~~~\n", FILE_APPEND | LOCK_EX);
				file_put_contents($file_path, "Source is Site at ".$Station_ID. " \n", FILE_APPEND | LOCK_EX);
				file_put_contents($file_path, "1 Item INCREMENTAL From ".date("m/d/Y",strtotime(Input::get('begin_date')))." to ".date("m/d/Y",strtotime(Input::get('end_date')))." \n", FILE_APPEND | LOCK_EX);
				file_put_contents($file_path, "	Rain	Date		Time\n", FILE_APPEND | LOCK_EX);
				//echo "<pre>".print_r($tideda_rf1,true)."</pre>"; exit();
				foreach($tideda_rf1 as $tideda=>$line) {
					//echo "<pre>".print_r($line,true)."</pre>"; 
					file_put_contents($file_path, "	5	".date("ymd",strtotime($line->tideda_Date))."		".date("His",strtotime($line->tideda_Time))." \n", FILE_APPEND | LOCK_EX);
				}//exit();

				$headers = array(
					'Content-Type' => 'text/txt',
				);

				return Response::download($file_path, $filename, $headers);
			}
			
			/*
			Excel::create("Report ".$station_ids." ".date(Input::get('report_date')), function($excel) use($sum_phg_pdsa){
				$excel->sheet(date(Input::get('report_date')), function($sheet) use($sum_phg_pdsa){
					$sheet->appendRow(array("Start", "Station ID", "Station ID Legacy", "RTU ID", "Station Date Time", "Station Status", "Battery Voltage", "GSM Comm Signal Strength", "Satellite Signal Strength", 
							"internal battery voltage", "solar output", "siren alert threshold", "siren danger threshold", "rainfall alert threshold", "rainfall danger threshold", 
							"water level alert threshold", "water level warning threshold", "water level danger threshold", "siren id", "siren code", "rainfall id", 
							"yearly cumulative rainfall", "daily accumulative rainfall", "rainfall para1", "rainfall para2", "rainfall para3", "rainfall para4", "rainfall para5", 
							"rainfall para6", "rainfall para7", "rainfall para8", "rainfall para9", "rainfall para10", "rainfall para11", "rainfall para12", "water level id1", 
							"water level para1", "water level id2", "water level para2", "flow sensor id", "flow sensor para1", "flow sensor para2", "flow sensor para3", "flow sensor para4", 
							"hp officer1", "hp officer2", "evaporation id", "evaporation", "evaporation daily accumulative", "soil moisture id", "soil moisture", "soil temperature", 
							"wind speed id", "wind speed", "wind direction", "air temperature id", "air temperature", "relative humidity id", "relative humidity", "radiation id", 
							"radiation", "net radiation", "sunshine hours id", "sunshine hours", "surface pressure id", "surface pressure", "water quality id0", "water quality para0", 
							"water quality id2", "water quality para1", "water quality para2", "water quality id3", "water quality para3", "water quality id4", " water quality para4", 
							"water quality id5", "water quality para5", "water quality id6", "water quality para6", "water quality id7", "water quality para7", "water quality id8", 
							"water quality para8", "water quality para9", "latitude", "longtitude", "End"));
					//$sheet->fromArray($data, null, 'A1', false, false);
					$i = 2;
					$report_date = date(Input::get('report_date'))." 00:00:00"; //echo $report_date; exit();
					foreach ($sum_phg_pdsa->chunk(500) as $rows){
						set_time_limit(0);
						//echo "<pre>".print_r($rows,true)."</pre>"; exit();
						foreach($rows as $row){						
							if($report_date == $row->last_updated){
								$sheet->appendRow(array("$", $row->station_ids, $row->station_id_legacy, $row->rtu_ids, $row->station_datetime, $row->station_status, $row->battery_voltage, $row->gsm_comm_signal_strength, $row->satellite_signal_strength,
									$row->internal_battery_voltage, $row->solar_output, $row->siren_alert_threshold, $row->siren_danger_threshold, $row->rainfall_alert_threshold, $row->rainfall_danger_threshold, 
									$row->water_level_alert_threshold, $row->water_level_warning_threshold, $row->water_level_danger_threshold, $row->siren_id, $row->siren_code, $row->rainfall_id, 
									$row->yearly_cumulative_rainfall, $row->daily_accumulative_rainfall, $row->rainfall_para1, $row->rainfall_para2, $row->rainfall_para3, $row->rainfall_para4, $row->rainfall_para5, 
									$row->rainfall_para6, $row->rainfall_para7, $row->rainfall_para8, $row->rainfall_para9, $row->rainfall_para10, $row->rainfall_para11, $row->rainfall_para12, $row->water_level_id1, 
									$row->water_level_para1, $row->water_level_id2, $row->water_level_para2, $row->flow_sensor_id, $row->flow_sensor_para1, $row->flow_sensor_para2, $row->flow_sensor_para3, $row->flow_sensor_para,
									$row->hp_officer1, $row->hp_officer2, $row->evaporation_id, $row->evaporation, $row->evaporation_daily_accumulative, $row->soil_moisture_id, $row->soil_moisture, $row->soil_temperature, 
									$row->wind_speed_id, $row->wind_speed, $row->wind_direction, $row->air_temperature_id, $row->air_temperature, $row->relative_humidity_id, $row->relative_humidity, $row->radiation_id, 
									$row->radiation, $row->net_radiation, $row->sunshine_hours_id, $row->sunshine_hours, $row->surface_pressure_id, $row->surface_pressure, $row->water_quality_id0, $row->water_quality_para0, 
									$row->water_quality_id2, $row->water_quality_para1, $row->water_quality_para2, $row->water_quality_id3, $row->water_quality_para3, $row->water_quality_id4, $row->water_quality_para4, 
									$row->water_quality_id5, $row->water_quality_para5, $row->water_quality_id6, $row->water_quality_para6, $row->water_quality_id7, $row->water_quality_para7, $row->water_quality_id8, 
									$row->water_quality_para8, $row->water_quality_para9, $row->latitude, $row->longtitude, "*"
								));
								$report_date = date("Y-m-d H:i:s",strtotime($report_date." +5 minutes"));
							}else{
								if($report_date < $row->last_updated){
									do {
										$sheet->appendRow(array(
											'', ''	, '', '', $report_date
										));	
										//set row Background
										$sheet->row($i, function($color) {
											//$color->setBackground('#880000');
										});
										//set cell manipulation
										$sheet->cell('E'.$i, function($cells) {
											// manipulate the cell
											//$cell->setValue('data1');
											// Set background
											$cells->setBackground('#880000');
											// Set with font color
											//$cells->setFontColor('#880000');
											// Set font weight to bold
											$cells->setFontWeight('bold');
											// Set font
											//$cells->setFont(array(
											//	'family'		=> 'Calibri',
											//	'size'		=> '16',
											//	'bold'			=>  true
											//));
										});
										
										$i++;
										$report_date = date("Y-m-d H:i:s",strtotime($report_date." +5 minutes"));
									} while ($report_date < $row->last_updated);
									
									$sheet->appendRow(array("$", $row->station_ids, $row->station_id_legacy, $row->rtu_ids, $row->station_datetime, $row->station_status, $row->battery_voltage, $row->gsm_comm_signal_strength, $row->satellite_signal_strength,
										$row->internal_battery_voltage, $row->solar_output, $row->siren_alert_threshold, $row->siren_danger_threshold, $row->rainfall_alert_threshold, $row->rainfall_danger_threshold, 
										$row->water_level_alert_threshold, $row->water_level_warning_threshold, $row->water_level_danger_threshold, $row->siren_id, $row->siren_code, $row->rainfall_id, 
										$row->yearly_cumulative_rainfall, $row->daily_accumulative_rainfall, $row->rainfall_para1, $row->rainfall_para2, $row->rainfall_para3, $row->rainfall_para4, $row->rainfall_para5, 
										$row->rainfall_para6, $row->rainfall_para7, $row->rainfall_para8, $row->rainfall_para9, $row->rainfall_para10, $row->rainfall_para11, $row->rainfall_para12, $row->water_level_id1, 
										$row->water_level_para1, $row->water_level_id2, $row->water_level_para2, $row->flow_sensor_id, $row->flow_sensor_para1, $row->flow_sensor_para2, $row->flow_sensor_para3, $row->flow_sensor_para,
										$row->hp_officer1, $row->hp_officer2, $row->evaporation_id, $row->evaporation, $row->evaporation_daily_accumulative, $row->soil_moisture_id, $row->soil_moisture, $row->soil_temperature, 
										$row->wind_speed_id, $row->wind_speed, $row->wind_direction, $row->air_temperature_id, $row->air_temperature, $row->relative_humidity_id, $row->relative_humidity, $row->radiation_id, 
										$row->radiation, $row->net_radiation, $row->sunshine_hours_id, $row->sunshine_hours, $row->surface_pressure_id, $row->surface_pressure, $row->water_quality_id0, $row->water_quality_para0, 
										$row->water_quality_id2, $row->water_quality_para1, $row->water_quality_para2, $row->water_quality_id3, $row->water_quality_para3, $row->water_quality_id4, $row->water_quality_para4, 
										$row->water_quality_id5, $row->water_quality_para5, $row->water_quality_id6, $row->water_quality_para6, $row->water_quality_id7, $row->water_quality_para7, $row->water_quality_id8, 
										$row->water_quality_para8, $row->water_quality_para9, $row->latitude, $row->longtitude, "*"
									));
									
									if($report_date <= $row->last_updated){
										$report_date = date("Y-m-d H:i:s",strtotime($report_date." +5 minutes"));
									}								
								}else{
									$sheet->appendRow(array("$", $row->station_ids, $row->station_id_legacy, $row->rtu_ids, $row->station_datetime, $row->station_status, $row->battery_voltage, $row->gsm_comm_signal_strength, $row->satellite_signal_strength,
										$row->internal_battery_voltage, $row->solar_output, $row->siren_alert_threshold, $row->siren_danger_threshold, $row->rainfall_alert_threshold, $row->rainfall_danger_threshold, 
										$row->water_level_alert_threshold, $row->water_level_warning_threshold, $row->water_level_danger_threshold, $row->siren_id, $row->siren_code, $row->rainfall_id, 
										$row->yearly_cumulative_rainfall, $row->daily_accumulative_rainfall, $row->rainfall_para1, $row->rainfall_para2, $row->rainfall_para3, $row->rainfall_para4, $row->rainfall_para5, 
										$row->rainfall_para6, $row->rainfall_para7, $row->rainfall_para8, $row->rainfall_para9, $row->rainfall_para10, $row->rainfall_para11, $row->rainfall_para12, $row->water_level_id1, 
										$row->water_level_para1, $row->water_level_id2, $row->water_level_para2, $row->flow_sensor_id, $row->flow_sensor_para1, $row->flow_sensor_para2, $row->flow_sensor_para3, $row->flow_sensor_para,
										$row->hp_officer1, $row->hp_officer2, $row->evaporation_id, $row->evaporation, $row->evaporation_daily_accumulative, $row->soil_moisture_id, $row->soil_moisture, $row->soil_temperature, 
										$row->wind_speed_id, $row->wind_speed, $row->wind_direction, $row->air_temperature_id, $row->air_temperature, $row->relative_humidity_id, $row->relative_humidity, $row->radiation_id, 
										$row->radiation, $row->net_radiation, $row->sunshine_hours_id, $row->sunshine_hours, $row->surface_pressure_id, $row->surface_pressure, $row->water_quality_id0, $row->water_quality_para0, 
										$row->water_quality_id2, $row->water_quality_para1, $row->water_quality_para2, $row->water_quality_id3, $row->water_quality_para3, $row->water_quality_id4, $row->water_quality_para4, 
										$row->water_quality_id5, $row->water_quality_para5, $row->water_quality_id6, $row->water_quality_para6, $row->water_quality_id7, $row->water_quality_para7, $row->water_quality_id8, 
										$row->water_quality_para8, $row->water_quality_para9, $row->latitude, $row->longtitude, "*"
									));
									//set row Background
									$sheet->row($i, function($color) {
										//$color->setBackground('#008800');
									});
									//set cell manipulation
									$sheet->cell('E'.$i, function($cells) {
										// manipulate the cell
										//$cell->setValue('data1');
										// Set background
										$cells->setBackground('#008800');
										// Set with font color
										//$cells->setFontColor('#008800');
										// Set font weight to bold
										$cells->setFontWeight('bold');
										// Set font
										//$cells->setFont(array(
										//	'family'		=> 'Calibri',
										//	'size'		=> '16',
										//	'bold'			=>  true
										//));
									});
								}
							}			
							$i++;
						}
					}
				});
			})->download('xlsx');
			*/
			
			$timelog 			= TimeLog::orderBy('LOG_DATE', 'desc')->orderBy('LOG_TIME', 'desc')->first();
			$sms_no 			= SmsNo::where('idSMS_no', 1)->first();
			$sensor_setting 	= SensorSetting::where('idSensor_setting', 1)->first();
			
			Session::flash('message', 'Download failed. Kindly select the correct format.');
			
			$breadcrumbs = array('Summary' => 'summary' , 'Manage Summary' => 'summary');
			
			return View::make('summary.index')->with('breadcrumbs',$breadcrumbs)->with('summary', $summary)->with('timelog', $timelog)->with('sms_no', $sms_no)->with('sensor_setting', $sensor_setting);
		}
	}

}
