<?php

class UserController extends BaseController {

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
		$sort = Input::has("sort") ? Input::get('sort') : "users.created_at";
    	$sort_order = Input::has("sort_order") ? Input::get('sort_order') : "desc";
        #Paging
    	if (Input::has('paging')) { $paging = Input::get('paging');	}else { $paging = '20'; }

    	#Filter Inactive
    	if (Input::get('status') == 'A') {
			$users = User::withTrashed()->orderBy($sort, $sort_order);
		}elseif (Input::get('status') == 'D') {
			$users = User::onlyTrashed()->orderBy($sort, $sort_order);
		}else { $users = User::orderBy($sort, $sort_order); }

		#Search Filter
    	if (Input::has('username')) {
    		$users = $users->where('username','LIKE','%'. Input::get('username').'%');
    	}

    	if(Auth::user()->channel) { $users = $users->where('channel_id','=',Auth::user()->channel->id); }

    	$users = $users->paginate($paging);

    	$breadcrumbs = array('User' => '/users', 'Manage User' => '/users');

		return View::make('users.index')->with('breadcrumbs',$breadcrumbs)->with("sort", $sort)->with("sort_order",$sort_order)->with('users', $users);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		$branch = Branch::where('channel_id','=',Auth::user()->channel->id)->lists('name','id');
        
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

		$breadcrumbs = array('User' => '/users', 'Add User' => '/users/create');

		return View::make('users.create', $data)->with('breadcrumbs',$breadcrumbs)->with('branch',$branch)->with('states',$states);	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		$rules = array(
			'name'       	=> 'required|Max:80',
			'username'      => 'required|Between:6,32|Unique:users',
			'email' 		=> 'Email',
			'password' 		=> 'required|AlphaNum|Between:8,16|Confirmed',
			'password_confirmation'=>'required|AlphaNum|Between:8,16'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('users/create')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// store
			$user = new user;
			$user->name       		= Input::get('name');
			$user->username      	= Input::get('username');
			$user->email 			= Input::get('email');
			$user->password 		= Hash::make(Input::get('password'));				
			$user->channel_id 		= Auth::user()->channel->id;
            $user->brand_id 		= Auth::user()->brand_id;	
			$user->created_by	 	= Auth::user()->id;		
			$user->updated_by		= Auth::user()->id;											
			$user->save();
                                    
			$user->groups()->attach(4);	
            //var_dump(Input::get("branch_id")); exit();
            $brand_id = Auth::user()->brand_id;
            $user->brands()->attach($brand_id);
            
			if(Input::has("branch_id")){ 
				$channel_id = Auth::user()->channel->id;
				foreach (Input::get("branch_id") as $branch_id) {
					if($branch_id!="" and Branch::where("id","=",$branch_id)->where("channel_id","=",$channel_id)->count() > 0 and BranchUser::where("branch_id","=",$branch_id)->where("user_id","=",$user->id)->count() == 0){
						$user->branches()->attach($branch_id); 
					}
				}
			}           
            
            if (Input::get('states')){ 
                //get input
                $user_selected_state    = Input::get('states'); //var_dump($user_selected_state); echo "</br>"; 
                $state_stations         = Station::lists('id'); 
                if ($user_selected_state != 'All') {
            		$state_stations         = Station::where('station_state',$user_selected_state)->lists('id');
            	
                    $stations               = array();
                    if (Input::get('stations')){ 
                        $stations           = Input::get('stations');
                    } 
                    
                    $user_removed_station   = array_diff($state_stations, $stations); //var_dump($user_removed_station); echo "</br>"; echo "</br>";
                    $user_added_station     = array_diff($stations, $user_removed_station); //var_dump($user_added_station); echo "</br>"; echo "</br>"; exit();
       				
                    if(sizeof($user_added_station) > 0){
                        $added_stations = array_fill_keys($user_added_station, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
                        //$user->stations()->sync($add_stations);
                        $user->stations()->sync($added_stations, false); //$user->stations()->attach ($add_stations);
                    }
    
                    if(sizeof($user_removed_station) > 0){
                        $user->stations()->detach($user_removed_station);
                    }
                }else{
                    if(sizeof($state_stations) > 0){
                        $added_stations = array_fill_keys($state_stations, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
                        //$user->stations()->sync($add_stations);
                        $user->stations()->sync($added_stations, false); //$user->stations()->attach ($add_stations);
                    }
                }                
            }                                    

			// redirect
			Session::flash('message', 'User Created');
			return Redirect::to('users/'.$user->id);
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
		$user = User::withTrashed()->where('channel_id','=',Auth::user()->channel->id)->find($id);

		if(!empty($user)) {

			$breadcrumbs = array('User' => '/users', 'View User' => '/users/'.$id);	

			// show the view and pass the nerd to it
			return View::make('users.show')
			->with('breadcrumbs',$breadcrumbs)		
			->with('user', $user);

		}else{	

			return Redirect::to('users');

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
		$user = User::find($id);

		$branch_user = BranchUser::where('user_id','=',$id)->lists('branch_id');
		$branch = Branch::where('channel_id','=',$user->channel->id)->lists('name','id');
        
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

		$breadcrumbs = array('User' => '/users', 'Edit User' => '/users/'.$id.'/edit' );			

		// show the edit form and pass the nerd
		return View::make('users.edit', $data)->with('breadcrumbs',$breadcrumbs)->with('user', $user)->with('branch', $branch)->with('branch_user', $branch_user)
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
			'name'      	=> 'required',
			'email' 		=> 'email',
			'password'  	=> 'AlphaNum|Between:8,16|Confirmed',
			'password_confirmation' => 'AlphaNum|Between:8,16'

		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('users/' . $id . '/edit')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// store
			$user 				= user::find($id);
			$user->name       	= Input::get('name');
			$user->email 		= Input::get('email');		
			if (Input::get('password')){
				$user->password = Hash::make(Input::get('password'));
			}
			$user->updated_by	= Auth::user()->id;	
			$user->save();

			$branchUser = BranchUser::where("user_id","=",$id)->lists("branch_id");
			$editBranch = Input::get("branch_id");

			$addBranch = array_diff($editBranch, $branchUser);
			$deleteBranch = array_diff($branchUser,$editBranch);
			$channel_id = Auth::user()->channel->id;
			foreach ($addBranch as $branch_id) {
				if($branch_id != "" and Branch::where("id","=",$branch_id)->where("channel_id","=",$channel_id)->count() > 0 and BranchUser::where("branch_id","=",$branch_id)->where("user_id","=",$user->id)->count() == 0){
					$user->branches()->attach($branch_id); 
				}
			}
			foreach ($deleteBranch as $branch_id) {
				if($branch_id != "" and BranchUser::where("user_id","=",$id)->where("branch_id","=",$branch_id)->count() > 0){
					$user->branches()->detach($branch_id);
				}
			}
            
            if (Input::get('states')){ 
                //get input
                $user_selected_state    = Input::get('states'); //var_dump($user_selected_state); echo "</br>"; 
                $state_stations         = Station::lists('id'); 
                if ($user_selected_state != 'All') {
            		$state_stations         = Station::where('station_state',$user_selected_state)->lists('id');
            	
                    $stations               = array();
                    if (Input::get('stations')){ 
                        $stations           = Input::get('stations');
                    } 
                    
                    $user_removed_station   = array_diff($state_stations, $stations); //var_dump($user_removed_station); echo "</br>"; echo "</br>";
                    $user_added_station     = array_diff($stations, $user_removed_station); //var_dump($user_added_station); echo "</br>"; echo "</br>"; exit();
       				
                    if(sizeof($user_added_station) > 0){
                        $added_stations = array_fill_keys($user_added_station, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
                        //$user->stations()->sync($add_stations);
                        $user->stations()->sync($added_stations, false); //$user->stations()->attach ($add_stations);
                    }
    
                    if(sizeof($user_removed_station) > 0){
                        $user->stations()->detach($user_removed_station);
                    }
                }else{
                    if(sizeof($state_stations) > 0){
                        $added_stations = array_fill_keys($state_stations, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
                        //$user->stations()->sync($add_stations);
                        $user->stations()->sync($added_stations, false); //$user->stations()->attach ($add_stations);
                    }
                }                
            }else{
                $user->stations()->detach();
            }

			// redirect
			Session::flash('message', 'User Updated');
			return Redirect::to('users/'.$user->id);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{		

		// delete
		$user = User::where('channel_id','=',Auth::user()->channel->id)->find($id);
		$user->deleted_by	= Auth::user()->id;																			
		$user->save();				
		$user->delete();

		// redirect
		Session::flash('message', 'User Deleted');
		return Redirect::to('users/'.$user->id);
	}


	public function getRestore()
	{		
		$id = Input::get('id');

		// delete
		$user = User::where('channel_id','=',Auth::user()->channel->id)->onlyTrashed()->find($id);
		$user->restore();
		$user->deleted_by	= null;																		
		$user->save();				

		// redirect
		Session::flash('message', 'User Restored');
		return Redirect::to('users/'.$user->id);
	}	


}