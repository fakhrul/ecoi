<?php

class AdminUserSuperAdminController extends BaseController {

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
		#Sorting
    	//if (Input::has('sort')) {	$sort = Input::get('sort');}else { $sort = 'users.id'; }
        $sort = Input::has("sort") ? Input::get('sort') : "users.created_at";
    	$sort_order = Input::has("sort_order") ? Input::get('sort_order') : "desc";
        #Paging
    	if (Input::has('paging')) {	$paging = Input::get('paging'); }else { $paging = '5'; }
		
        $users = User::whereIn('brand_id',(Auth::user()->brands()->lists('brand_id')));
		
		$users = $users->where('group_id', '1');

    	#Filter Inactive
    	if (Input::get('status') == 'A') {
			$users = $users->withTrashed();
		}
        if (Input::get('status') == 'D') {
			$users = $users->onlyTrashed();
		}
        $users = $users->orderBy($sort, $sort_order);        
    	//var_dump(Auth::user()->brands()->lists('brand_id')); exit(); 
                
		#Search Filter
    	if (Input::has('username')) {
    		$users = $users->where('username','LIKE','%'. Input::get('username').'%');
    	}

    	$users = $users->paginate($paging);

    	$breadcrumbs = array('User' => 'admin/users_super_admin', 'Manage User' => 'admin/users_super_admin');

		return View::make('admin.users_super_admin.index')->with('breadcrumbs',$breadcrumbs)->with("sort", $sort)->with("sort_order",$sort_order)->with('users', $users);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		if(Auth::user()->brand_id == '1') {
			$groups = AclGroup::all();
		}else {
			$groups = AclGroup::all();
		}

		$brands = Brand::all();
        //echo "<pre>".print_r($brands,true)."</pre>"; exit();
        $channels = Channel::lists('name','id');
        $channels = ['' => '- Select A Department -'] + $channels;        
        //echo "<pre>".print_r($channels,true)."</pre>"; exit();
        $branch = Branch::lists('name','id');
        $branch = ['' => '- Please select only if required -'] + $branch; 
        //echo "<pre>".print_r($branch,true)."</pre>"; exit();        
        //$stations = Station::orderBy('id')->get();
        //$stations = $stations->lists('name', 'id');
        $states = State::all();
        $state_station = [];
        foreach($states as $state){
            $state_station = Station::where('station_state',$state->id)->orderBy('station_name')->lists('station_name','id');
            $states_stations[$state->name] = $state_station;
        }
        //var_dump($states_stations); exit();
        $states_stations['All'] = ['All' => 'All'];
        $states_stations = ['' => '- Select A State To Select Stations -'] + $states_stations;
        //var_dump($states_stations); exit();
        $jsonified = json_encode($states_stations, JSON_HEX_APOS);
        //var_dump($jsonified); exit();
        $data = ['states_stations' => $jsonified];
        //$available_states = DB::table('station')->distinct()->lists('station_state', 'station_state');
        $states = State::with('stations')->has('stations')->lists('name','name');
        //var_dump($states); exit();
        $states = ['' => '- Select A State -', 'All' => 'All' ] + $states;          
        //$states = ['All' => 'All' ] + $states;        
        //array_unshift($states, "- Select A State -");
		$breadcrumbs = array('User' => 'admin/users_super_admin', 'Add User' => 'admin/users_super_admin/create');

		return View::make('admin.users_super_admin.create', $data)->with('breadcrumbs',$breadcrumbs)->with('groups',$groups)->with('brands',$brands)->with('channels',$channels)//->with('stations',$stations)
        ->with('branch',$branch)->with('states',$states);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name'                  => 'required|Max:80',
			'username'              => 'required|Between:6,32|Unique:users',
			'email' 	            => 'Email',
			'password'              => 'Required|AlphaNum|Between:8,20|Confirmed',
			'password_confirmation'	=> 'Required|AlphaNum|Between:8,20',
			//'groups'	            => 'required',
			//'brands'	            => 'required',
            //'channel_id'            => 'required_if:groups,3|required_if:groups,4',
            //'channel_id'            => 'required_if:groups.*,in:4'
            //'channel_id'	        => 'required_if:groups,1,2'           
			);
            
        // if ( Input::has('groups') && (in_array('1', Input::get('groups') )  ||  in_array('2', Input::get('groups') ) )  ) {
        // }else{
        //     $rules['channel_id'] = 'required';
        //     $messages["channel_id.required"]  = "Please select the Channel ID.";
        // }        

		$messages["groups.required"]      = "Please select at least 1 group.";
		$messages["brands.required"]      = "Please select at least 1 brand.";
		
		$validator = Validator::make(Input::all(), $rules, $messages);
		
		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/users_super_admin/create')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			
            //here to validate groups other than super admin and admin channel_id is required.
            //return Redirect::to('admin/users/create')->withInput(Input::except('password'));
			// store
			$user = new user;
			$user->name       		= Input::get('name');
			$user->username      	= Input::get('username');
			$user->email 			= Input::get('email');
			$user->password 		= Hash::make(Input::get('password'));
            if(Input::has("channel_id")){ 
                $user->channel_id 		= Input::get('channel_id');
            }

			// $user->valid_start 		= Input::get('valid_start');
			// $user->valid_end 		= Input::get('valid_end');

			// $user->channel_id 		= 1; //default	
			//$user->brand_id 		= Auth::user()->brand_id;	
			$user->group_id 		= 1;	
			$user->brand_id 		= 1;	
			$user->created_by	 	= Auth::user()->id;		
			$user->updated_by		= Auth::user()->id;									
			$user->save();

			$user->groups()->attach(1);
			$user->brands()->attach(1);
			// $groups = Input::get('groups');
			// $brands = Input::get('brands');

			// foreach ($groups as $group) {
			// 	$user->groups()->attach($group);
			// }

			// foreach ($brands as $brand) {
			// 	$user->brands()->attach($brand);
			// }   

            //var_dump(Input::get("branch_id")); exit();
			// if(Input::has("channel_id") && Input::has("branch_id")){ 
			// 	foreach (Input::get("branch_id") as $branch_id) {
			// 		if($branch_id!="" and Branch::where("id","=",$branch_id)->count() > 0 and BranchUser::where("branch_id","=",$branch_id)->where("user_id","=",$user->id)->count() == 0){
			// 			$user->branches()->attach($branch_id); 
			// 		}
			// 	}
			// }
            
            //add station for user
            /*if (Input::get('stations')){
    			$stations = Input::get('stations');
                $stations = array_fill_keys($stations, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
   				$user->stations()->attach($stations);
            }*/
            
            // if (Input::get('states')){ 
            //     //get input
            //     $user_selected_state    = Input::get('states'); //var_dump($user_selected_state); echo "</br>"; 
            //     $state_stations         = Station::lists('id'); 
            //     if ($user_selected_state != 'All') {
            // 		$state_stations         = Station::where('station_state',$user_selected_state)->lists('id');
            	
            //         $stations               = array();
            //         if (Input::get('stations')){ 
            //             $stations           = Input::get('stations');
            //         } 
                    
            //         $user_removed_station   = array_diff($state_stations, $stations); //var_dump($user_removed_station); echo "</br>"; echo "</br>";
            //         $user_added_station     = array_diff($stations, $user_removed_station); //var_dump($user_added_station); echo "</br>"; echo "</br>"; exit();
       				
            //         if(sizeof($user_added_station) > 0){
            //             $added_stations = array_fill_keys($user_added_station, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
            //             //$user->stations()->sync($add_stations);
            //             $user->stations()->sync($added_stations, false); //$user->stations()->attach ($add_stations);
            //         }
    
            //         if(sizeof($user_removed_station) > 0){
            //             $user->stations()->detach($user_removed_station);
            //         }
            //     }else{
            //         if(sizeof($state_stations) > 0){
            //             $added_stations = array_fill_keys($state_stations, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
            //             //$user->stations()->sync($add_stations);
            //             $user->stations()->sync($added_stations, false); //$user->stations()->attach ($add_stations);
            //         }
            //     }                
            // }

			// redirect
			Session::flash('message', 'User Created');
			return Redirect::to('admin/users_super_admin/'.$user->id);
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
		$user = User::withTrashed()->find($id);
		if(!empty($user)) {

			$breadcrumbs = array('User' => 'admin/users_super_admin', 'View User' => 'admin/users_super_admin');	

			// show the view and pass the nerd to it
			return View::make('admin.users_super_admin.show')->with('breadcrumbs',$breadcrumbs)->with('user', $user);
		}else{
			return Redirect::to('admin/users_super_admin');
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
		$user = User::withTrashed()->find($id);

		$groups = AclGroup::all();
        
	    $user_groups = array();
	    foreach ($user->groups as $group) {
	        $user_groups[] = $group->id;
	    }	

		$brands = Brand::all();
	    $user_brands = array();		 	
	    foreach ($user->brands as $brand) {
	        $user_brands[] = $brand->id;
	    }			

        $channels = Channel::lists('name','id');
        //echo "<pre>".print_r($channels,true)."</pre>"; exit();
        $branch = Branch::lists('name','id');
        $branch = ['' => 'Please select only if required'] + $branch; 
        $branch_user = BranchUser::where('user_id','=',$id)->lists('branch_id');
        
        $station_user = $user->stations()->lists('station_id');
        $station_user = implode(', ', $station_user);
        
        $states = State::all();
        $state_station = [];
        foreach($states as $state){
            $state_station = Station::where('station_state',$state->id)->orderBy('station_name')->lists('station_name','id');
            $states_stations[$state->name] = $state_station;
        }
        //var_dump($states_stations); exit();
        $states_stations['All'] = ['All' => 'All'];
        $states_stations = ['' => '- Select A State To Select Stations -'] + $states_stations;
        //var_dump($states_stations); exit();
        $jsonified = json_encode($states_stations, JSON_HEX_APOS);
        //var_dump($jsonified); exit();
        $data = ['states_stations' => $jsonified];
        //$available_states = DB::table('station')->distinct()->lists('station_state', 'station_state');
        $states = State::with('stations')->has('stations')->lists('name','name');
        //var_dump($states); exit();
        $states = ['' => '- Select A State -', 'All' => 'All' ] + $states;

		$breadcrumbs = array('User' => 'admin/users_super_admin', 'Edit User' => 'admin/users_super_admin');			

		// show the edit form and pass the nerd
		return View::make('admin.users_super_admin.edit', $data)->with('breadcrumbs',$breadcrumbs)->with('user', $user)->with('user_groups', $user_groups)->with('groups',$groups)
        ->with('user_brands', $user_brands)->with('branch_user', $branch_user)->with('brands',$brands)->with('channels', $channels)->with('branch', $branch)
        ->with('station_user',$station_user)->with('states',$states);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		// validate
		// read more on validation at http://laravel.com/docs/validation        
        $rules = array(
			'name'                  => 'required|Max:80',
			'email' 	            => 'Email',
			'password'              => 'AlphaNum|Between:8,20|Confirmed',
			'password_confirmation'	=> 'AlphaNum|Between:8,20',
			// 'groups'	            => 'required',
			// 'brands'	            => 'required'            
			);

		$messages["groups.required"]      = "Please select at least 1 group.";
		$messages["brands.required"]      = "Please select at least 1 brand.";	        
				
		$validator = Validator::make(Input::all(), $rules, $messages);

       // echo "<pre>".print_r($channels,true)."</pre>"; exit();

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/users_super_admin/' . $id . '/edit')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// store
			$user 				= User::find($id);
			$user->name       	= Input::get('name');
			$user->email 		= Input::get('email');	

			if (Input::get('password'))			{
				$user->password = Hash::make(Input::get('password'));
			}

			// $user->valid_start 		= Input::get('valid_start');	
			// $user->valid_end 		= Input::get('valid_end');	

			$user->save();
			
			// $groups      = Input::get('groups');
			// $brands      = Input::get('brands');
            
            // $user->groups()->sync($groups);
			// $user->brands()->sync($brands);
            
            //var_dump(Input::get("branch_id")); exit();
			// if(Input::has("branch_id")){
            //     $user->branches()->detach();
			// 	foreach (Input::get("branch_id") as $branch_id) {
			// 		if($branch_id!="" and Branch::where("id","=",$branch_id)->count() > 0 and BranchUser::where("branch_id","=",$branch_id)->where("user_id","=",$user->id)->count() == 0){
			// 			$user->branches()->attach($branch_id); 
			// 		}
			// 	}
			// }
            
            // if (Input::get('states')){ 
            //     //get input
            //     $user_selected_state    = Input::get('states'); //var_dump($user_selected_state); echo "</br>"; 
            //     $state_stations         = Station::lists('id'); 
            //     if ($user_selected_state != 'All') {
            // 		$state_stations         = Station::where('station_state',$user_selected_state)->lists('id');
            	
            //         $stations               = array();
            //         if (Input::get('stations')){ 
            //             $stations           = Input::get('stations');
            //         } 
                    
            //         $user_removed_station   = array_diff($state_stations, $stations); //var_dump($user_removed_station); echo "</br>"; echo "</br>";
            //         $user_added_station     = array_diff($stations, $user_removed_station); //var_dump($user_added_station); echo "</br>"; echo "</br>"; exit();
       				
            //         if(sizeof($user_added_station) > 0){
            //             $added_stations = array_fill_keys($user_added_station, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
            //             //$user->stations()->sync($add_stations);
            //             $user->stations()->sync($added_stations, false); //$user->stations()->attach ($add_stations);
            //         }
    
            //         if(sizeof($user_removed_station) > 0){
            //             $user->stations()->detach($user_removed_station);
            //         }
            //     }else{
            //         if(sizeof($state_stations) > 0){
            //             $added_stations = array_fill_keys($state_stations, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
            //             //$user->stations()->sync($add_stations);
            //             $user->stations()->sync($added_stations, false); //$user->stations()->attach ($add_stations);
            //         }
            //     }                
            // }else{
            //     $user->stations()->detach();
            // }
            // redirect
			Session::flash('message', 'User Updated');
			return Redirect::to('admin/users_super_admin/'.$user->id);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){		
		// delete
		$user = User::find($id);
		$user->deleted_by	= Auth::user()->id;																			
		$user->save();			
		$user->delete();
		// redirect
		Session::flash('message', 'User Deleted');
		return Redirect::to('admin/users_super_admin/'.$user->id);
	}

	public function getRestore(){		
		$id = Input::get('id');
		// delete
		$user = User::onlyTrashed()->find($id);
		$user->restore();
		$user->deleted_by	= null;				
		$user->restore();
		// redirect
		Session::flash('message', 'User Restored');
		return Redirect::to('admin/users_super_admin/'.$user->id);
	}	

}