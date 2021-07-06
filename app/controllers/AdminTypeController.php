<?php

class AdminTypeController extends \BaseController {

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
		$sort = Input::has("sort") ? Input::get('sort') : "created_at";
    	$sort_order = Input::has("sort_order") ? Input::get('sort_order') : "desc";
    	$paging = (Input::has('paging')) ? Input::get('paging') : "5";
        
        $types = Type::orderBy($sort, $sort_order);
        
        #Search Filter
    	if (Input::has('type_code')) {
    		$types = $types->where('type_code','LIKE','%'. Input::get('type_code').'%');
    	}
    	if (Input::has('type_description')) {
    		$types = $types->where('type_description','LIKE','%'. Input::get('type_description').'%');
    	}   

    	$types = $types->paginate($paging);

        $breadcrumbs = array('Type' => 'admin/types' , 'Manage Type' => 'admin/types');

		return View::make('admin.types.index')->with('breadcrumbs',$breadcrumbs)->with('types', $types)->with("sort", $sort)->with("sort_order",$sort_order);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		$breadcrumbs = array('Type' => '/admin/types', 'Add Type' => '/admin/types');

		return View::make('admin.types.create')->with('breadcrumbs',$breadcrumbs);
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
			'type_code'          =>  'required||max:2|unique:types,type_code',
            'type_description'   =>  'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('admin/types/create')->withErrors($validator)->withInput();
		} else {
			// store
			$type = new Type;
			$type->type_code       	= Input::get('type_code');           
			$type->type_description = Input::get('type_description');
			$type->created_by	    = Auth::user()->id;	
            $type->updated_by	    = Auth::user()->id;					
			$type->save();

			// redirect
			Session::flash('message', 'Type Created');
			return Redirect::to('admin/types/'.$type->id);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
		$type = Type::find($id);

        $breadcrumbs = array('Type' => '/admin/types', 'View Type' => '/admin/types');
		// show the view and pass the nerd to it
		return View::make('admin.types.show')->with('breadcrumbs',$breadcrumbs)->with('type', $type);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		$type = Type::find($id);
        
        $breadcrumbs = array('Type' => '/admin/types', 'Edit Type' => '/admin/types');        
		// show the view and pass the nerd to it
		return View::make('admin.types.edit')->with('breadcrumbs',$breadcrumbs)->with('type', $type);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		$rules = array(
			'type_code'          => 'required|max:2',
			'type_description'   => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('admin/types/'.$id.'/edit')->withErrors($validator)->withInput();
		} else {
			// store
            $type                   = Type::find($id);
			$type->type_code        = Input::get('type_code');
            $type->type_description = Input::get('type_description');
			$type->updated_by	 	= Auth::user()->id;					
			$type->save();

			// redirect
			Session::flash('message', 'Type Updated');
			return Redirect::to('admin/types/'.$id);
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
		//
	}

}
