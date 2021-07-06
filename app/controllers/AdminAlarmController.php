<?php

class AdminAlarmController extends BaseController {

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
    	if (Input::has('sort')) {	$sort = Input::get('sort'); 	}else { $sort = 'station_alarm.alarm_datetime'; }	
    	if (Input::has('sort_order')) {	$sort_order = Input::get('sort_order');	}else { $sort_order = 'desc'; }
    	if (Input::has('paging')) {	$paging = Input::get('paging');	}else { $paging = '5'; }
        
        $alarm = StationAlarm::leftjoin("alarm","alarm.id","=","station_alarm.alarm_id")
                             ->leftjoin("station","station.id","=","station_alarm.station_id")
                                ->where('status', 1)->orderBy($sort, $sort_order);
        
        $station_id = Auth::user()->stations()->lists('station_id');        
        if(sizeof($station_id)>0){ 
        }else{
            $station_id = array("0");
        }
        
        $alarm = $alarm->whereIn('station_id', $station_id);
        
        #Search Filter
    	if (Input::has('alarm_code')) {
    		//check prefix                
    		$alarm_code = Input::get('alarm_code');	//var_dump($alarm_code); exit();	
    		$alarm = $alarm->where('alarm.alarm_code','LIKE', "%".$alarm_code."%" );
    	} 
        
        if (Input::has('alarm_description')) {
    		//check prefix                
    		$alarm_description = Input::get('alarm_description');	//var_dump($alarm_description); exit();	
    		$alarm = $alarm->where('alarm.alarm_description','LIKE', "%".$alarm_description."%" );
    	} 
        
        if (Input::has('station_name')) {
    		//check prefix                
    		$station_name = Input::get('station_name');	//var_dump($alarm_code); exit();	
    		$alarm = $alarm->where('station.station_name','LIKE', "%".$station_name."%" );
    	}
       
		$alarm = $alarm->paginate($paging);
        
        $alarm_codes = Alarm::distinct('alarm_code')->orderBy('alarm_code', 'asc')->lists('alarm_code', 'alarm_code');
        $alarm_codes = ['' => 'All'] + $alarm_codes;
        //var_dump($alarm_codes); exit();  
        $breadcrumbs = array('Home' => 'admin/alarm', 'Manage Alarm' => 'admin/alarm');	
        
		return View::make('admin.alarm.index',compact('sort', 'sort_order'))->with('breadcrumbs',$breadcrumbs)->with('alarms', $alarm)->with('alarm_codes', $alarm_codes); 	
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
	   
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)	{
	   
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
	   
	}
}