<?php

class AdminGroupController extends BaseController {

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
    	if (Input::has('sort')) {	$sort = Input::get('sort'); 	}else { $sort = 'name'; }	
    	if (Input::has('sort_order')) {	$sort_order = Input::get('sort_order');	}else { $sort_order = 'desc'; }
    	if (Input::has('paging')) {	$paging = Input::get('paging');	}else { $paging = '5'; }
        
        $groups = AclGroup::orderBy($sort, $sort_order);
        
        #Search Filter        
        if (Input::has('description')) {
    		//check prefix                
    		$description = Input::get('description');	//var_dump(description); exit();	
    		$groups = $groups->where('description','LIKE', "%".$description."%" );
    	} 
        
        if (Input::has('name')) {
    		//check prefix                
    		$name = Input::get('name');	//var_dump($groups); exit();	
    		$groups = $groups->where('name','LIKE', "%".$name."%" );
    	}
       
		$groups = $groups->paginate($paging);
 
        $breadcrumbs = array('Group' => 'admin/groups', 'Manage Group' => 'admin/groups');	
        
		return View::make('admin.groups.index',compact('sort', 'sort_order'))->with('breadcrumbs',$breadcrumbs)->with('groups', $groups); 	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
	   $permission = AclPermission::all();
       $permission = $permission->lists('description','id');
       //var_dump($permission); exit();
	   $breadcrumbs = array('Groups' => 'admin/groups', 'Add Group' => 'admin/groups/create');

		return View::make('admin.groups.create')->with('breadcrumbs',$breadcrumbs)->with('permission',$permission);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		// validate		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name'           => 'required|Max:80',
			'description'	 => 'required'
			);        
        //var_dump(Input::all()); exit();
		$validator = Validator::make(Input::all(), $rules);
        
		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/groups/create')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// store Group
			$group               = new AclGroup;
			$group->name         = Input::get('name');
			$group->description  = Input::get('description');								
			$group->save();
            //Store Group Permission	
            //add station for Group
            if (Input::get('permission')){
    			$permission = Input::get('permission');
                //$permission = array_fill_keys($permission, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
   				$group->permissions()->attach($permission);
            }
			// redirect
			Session::flash('message', 'Group Created');
			return Redirect::to('admin/groups/'.$group->id);
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
		$groups = AclGroup::find($id);
        //$roles = AclGroup::find($id)->permissions; var_dump($roles); exit();
		if(!empty($groups)) {
			$breadcrumbs = array('Group' => 'admin/group', 'View Group' => 'admin/group');	
			// show the view and pass the nerd to it
			return View::make('admin.groups.show')->with('breadcrumbs',$breadcrumbs)->with('groups', $groups);
		}else{
			return Redirect::to('admin/groups');
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
		$groups = AclGroup::find($id);

	    $groups_permission = array();
	    foreach ($groups->permissions as $permission) {
	        $groups_permission[] = $permission->id;
	    }//var_dump($groups_permission); exit();
        
        $permission = AclPermission::all();
        $permission = $permission->lists('description','id');	

		$breadcrumbs = array('Group' => 'admin/group', 'Edit Group' => 'admin/group');			

		// show the edit form and pass the nerd
		return View::make('admin.groups.edit')->with('breadcrumbs',$breadcrumbs)->with('groups', $groups)->with('groups_permission', $groups_permission)->with('permission', $permission);
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
			'name'           => 'required|Max:80',
			'description'	 => 'required'
		);
        
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/groups/' . $id . '/edit')
			->withErrors($validator)
			->withInput(Input::except('password'));
		} else {
			// update Group
			$group 				= AclGroup::find($id);
			$group->name         = Input::get('name');
			$group->description  = Input::get('description');								
			$group->save();
            //Update Group Permission
            if (Input::get('permission')){
    			$permission = Input::get('permission');
                //$permission = array_fill_keys($permission, array('status' => 1, 'created_by' => Auth::user()->id,  'updated_by' => Auth::user()->id) );
                $group->permissions()->sync($permission);
            }else{
                $group->permissions()->detach();                
            }
			// redirect
			Session::flash('message', 'Group Updated');
			return Redirect::to('admin/groups/'.$group->id);
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