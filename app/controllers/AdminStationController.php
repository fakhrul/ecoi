<?php

class AdminStationController extends BaseController {

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
	public function index()	{
    	if (Input::has('sort')) {	$sort = Input::get('sort'); 	}else { $sort = 'created_at'; }	
    	if (Input::has('sort_order')) {	$sort_order = Input::get('sort_order');	}else { $sort_order = 'desc'; }
        #Paging
    	if (Input::has('paging')) {	$paging = Input::get('paging');	}else { $paging = '5'; }  
        //$station_states = Station::select('station_state')->distinct()->orderBy( 'station_state', 'asc')->lists('station_state', 'station_state');
        //$station_states = ['' => 'All'] + $station_states;
        //$station_states = Station::with('State')->select('state.station_state')->distinct()->orderBy( 'state.name', 'asc')->lists('state', 'state');
        $station_states = State::has('Stations')->lists('name', 'id'); //echo "<pre>".print_r($station_states,true)."</pre>"; exit();
        $station_states = ['' => 'All'] + $station_states;
        
        $stations = Station::with('State', 'District')->orderBy($sort, $sort_order);
                     
        $station_ids = array();       
        if(!empty(Auth::user()->channel_id)) {
            $station_ids = Auth::user()->stations()->select('station.id')->lists('id');
            
            if(sizeof($station_ids)>0){ 
            }else{
                $station_ids = array("0");   
            }
            
            $stations = $stations->whereIn('id', $station_ids);
        }
        
        #Search Filter
    	if (Input::has('station_state')) {
    		//check prefix                
    		$station_state = Input::get('station_state');	//var_dump($station_state); exit();	
    		$stations = $stations->where('station_state', $station_state );
    	} 
        
        if (Input::has('station_name')) {
    		//check prefix                
    		$station_name = Input::get('station_name');	//var_dump($station_name); exit();	
    		$stations = $stations->where('station_name','LIKE', "%".$station_name."%" );
    	}                                      
        // echo "<pre>".print_r($stations->get(),true)."</pre>"; exit();
		$stations = $stations->paginate($paging);
        
    	$breadcrumbs = array('Station' => 'admin/station', 'Manage Station' => 'admin/station');
        
		return View::make('admin.station.index',compact('sort', 'sort_order'))->with('breadcrumbs',$breadcrumbs)->with('station_states', $station_states)->with('stations', $stations); 	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
        $states = State::all();
        $district = District::all();
        $state_district = [];
        foreach($states as $state){
            $state_district = District::where('state_id', $state->id)->orderBy('name')->lists('name','id');
            $states_districts[$state->id] = $state_district;
        }//var_dump($states_districts); exit();
        //$states_districts['All'] = ['All' => 'All'];
        $states_districts = ['' => '- Select A State To Select District -'] + $states_districts;
        //var_dump($states_districts); exit();
        $jsonified = json_encode($states_districts, JSON_HEX_APOS);
        //var_dump($jsonified); exit();
        $data = ['states_districts' => $jsonified];
        //$available_states = DB::table('station')->distinct()->lists('station_state', 'station_state');
        $states = State::lists('name','id');
        //var_dump($states); exit();
        $states = ['' => '- Select A State -'] + $states;        
        //array_unshift($states, "- Select A State -");
        $types = Type::all();
        
		$breadcrumbs = array('Station' => 'admin/station', 'Add Station' => 'admin/station/create');

		return View::make('admin.station.create', $data)->with('breadcrumbs',$breadcrumbs)->with('states',$states)->with('types',$types);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'station_code'          => 'required|Between:3,25|Unique:station',
            'station_name'          => 'required',
			'latitude'	            => 'required|digits_between:1,11|numeric',
			'longtitude'	        => 'required|digits_between:1,11|numeric',
			'house_type'	        => 'required',
            'states' 	            => 'required',
			'states_districts'      => 'required'       
			);	        
				
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/station/create')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// store var_dump($station_type); exit();
			$station = new Station;
			$station->station_code 		= Input::get('station_code');
			$station->station_name    	= Input::get('station_name');
			$station->latitude 			= Input::get('latitude');
			$station->longtitude 		= Input::get('longtitude');
            $station->house_type 		= strtoupper(Input::get('house_type'));
			$station->station_state 	= Input::get('states');
            $station->station_district  = Input::get('states_districts');;	
			$station->created_by	 	= Auth::user()->id;		
			$station->updated_by		= Auth::user()->id;									
			$station->save();
            
            if (Input::get('types')){ 
                //get input
                $station_types    = Input::get('types'); 
                //var_dump($station_types); echo "inside  <br/>"; //exit();
                if(sizeof($station_types) > 0){ 
                    foreach($station_types as $keys => $type_id){
                        $quantity = Input::get('quantity'.$type_id);
                        if($quantity < 1){ $quantity = 0; }
                        $station_type[$type_id] = array('type_id' => $type_id,  'quantity' => $quantity );
                    }   
                }
                $station = Station::find($station->id); //;
                $station->types()->sync($station_type); //$user->stations()->attach ($add_stations); var_dump($station_type); exit();                            
            }
            //Attach the station to super Admin
            $user_station[1] = array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) ;
            if(Auth::user()->id != 1){
                $user_station[Auth::user()->id] = array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) ;                
            }
            $station->users()->attach($user_station); 
			// redirect
			Session::flash('message', 'Station Created');
			return Redirect::to('admin/station/'.$station->id);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
	   // get the nerd
		$station          = Station::with('state','district','types')->find($id);
        //echo "<pre>".print_r($station->types,true)."</pre>"; exit(); //$station->types
        if(!empty($station)) {
			$breadcrumbs = array('Station' => 'admin/station', 'View Station' => 'admin/station');	
			// show the view and pass the nerd to it
			return View::make('admin.station.show')->with('breadcrumbs',$breadcrumbs)->with('station', $station);
		}else{	
			return Redirect::to('admin/station');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
        // get the nerd
		$station = Station::withTrashed()->find($id);
        //echo "<pre>".print_r($station,true)."</pre>"; exit(); 
        $station_district = $station->district()->lists('id');
        $station_district = implode(', ', $station_district);
        //echo "<pre>".print_r($station_district,true)."</pre>"; exit(); //$station->types        
        $states = State::all();
        $district = District::all();
        $state_district = [];
        foreach($states as $state){
            $state_district = District::where('state_id', $state->id)->orderBy('name')->lists('name','id');
            $states_districts[$state->id] = $state_district;
        }//var_dump($states_districts); exit();
        //$states_districts['All'] = ['All' => 'All'];
        $states_districts = ['' => '- Select A State To Select District -'] + $states_districts;
        //var_dump($states_districts); exit();
        $jsonified = json_encode($states_districts, JSON_HEX_APOS);
        //var_dump($jsonified); exit();
        $data = ['states_districts' => $jsonified];
        //$available_states = DB::table('station')->distinct()->lists('station_state', 'station_state');
        $states = State::lists('name','id');
        //var_dump($states); exit();
        $states = ['' => '- Select A State -'] + $states;        
        //array_unshift($states, "- Select A State -");
        $types = Type::all();
        
        $station_types = $station->types()->lists('type_id');
        //echo "<pre>".print_r($station_types,true)."</pre>"; exit();
        $station_types_quantity = $station->types()->lists('quantity','type_id');
        //echo "<pre>".print_r($station_types_quantity,true)."</pre>"; exit();
		$breadcrumbs = array('Station' => 'admin/station', 'Edit Station' => 'admin/station/edit');

		return View::make('admin.station.edit', $data)->with('breadcrumbs',$breadcrumbs)->with('states',$states)->with('station',$station)->with('types',$types)
        ->with('station_types',$station_types)->with('station_types_quantity',$station_types_quantity)->with('station_district',$station_district);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)	{
		// validate
		// read more on validation at http://laravel.com/docs/validation        
        $rules = array(
			//'station_code'          => 'required|Between:3,25|Unique:station',
            'station_name'          => 'required',
			'latitude'	            => 'Required',
			'longtitude'	        => 'required',
			'house_type'	        => 'required',
            'states' 	            => 'required',
			'states_districts'      => 'required'       
			);	        
				
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/station/' . $id . '/edit')->withErrors($validator)->withInput(Input::except('password'));
		} else {
            // store //return Redirect::to('admin/station/' . $id . '/edit')->withErrors($validator)->withInput(Input::except('password'));
			$station 				    = Station::find($id);
			$station->station_code 		= Input::get('station_code');
			$station->station_name    	= Input::get('station_name');
			$station->latitude 			= Input::get('latitude');
			$station->longtitude 		= Input::get('longtitude');
            $station->house_type 		= strtoupper(Input::get('house_type'));
			$station->station_state 	= Input::get('states');
            $station->station_district  = Input::get('states_districts');;	
			$station->created_by	 	= Auth::user()->id;		
			$station->updated_by		= Auth::user()->id;									
			$station->save();
            
            if (Input::get('types')){ 
                //get input
                $station_types    = Input::get('types'); 
                //var_dump($station_types); echo "inside  <br/>"; //exit();
                if(sizeof($station_types) > 0){ 
                    foreach($station_types as $keys => $type_id){
                        $quantity = Input::get('quantity'.$type_id);
                        if($quantity < 1){ $quantity = 0; }
                        $station_type[$type_id] = array('type_id' => $type_id,  'quantity' => $quantity );
                    }   
                }
                $station = Station::find($station->id); //;
                $station->types()->sync($station_type); //$user->stations()->attach ($add_stations); var_dump($station_type); exit();                            
            }
            //Attach the station to super Admin
            $user_station[1] = array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) ;
            if(Auth::user()->id != 1){
                $user_station[Auth::user()->id] = array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) ;                
            }
            $station->users()->sync($user_station, false); 
                        
            // redirect
			Session::flash('message', 'Station Updated');
			return Redirect::to('admin/station/'.$station->id);
		}
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