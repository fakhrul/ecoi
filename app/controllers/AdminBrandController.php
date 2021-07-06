<?php

class AdminBrandController extends \BaseController {

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
        
        $brands = Brand::orderBy($sort, $sort_order);
        
        #Search Filter
    	if (Input::has('name')) {
    		$brands = $brands->where('name','LIKE','%'. Input::get('name').'%');
    	}
    	if (Input::has('channel_id')) {
    		$brands = $brands->where('channel_id','LIKE','%'. Input::get('channel_id').'%');
    	}   

    	$brands = $brands->paginate($paging);

        $breadcrumbs = array('Brand' => 'admin/brands' , 'Manage Brand' => 'admin/brands');

		return View::make('admin.brands.index')->with('breadcrumbs',$breadcrumbs)->with('brands', $brands)->with("sort", $sort)->with("sort_order",$sort_order);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
        $upline_options = Channel::lists('name','channel_id');

		$breadcrumbs = array('Brand' => '/admin/brands', 'Add Brand' => '/admin/brands');

		$channels = Channel::whereIn('brand_id',Auth::user()->brands()->lists('brand_id'))->select(DB::raw('CONCAT(channel_id," - ",name) AS name'),"channel_id")->orderBy("brand_id")->orderBy("id")->lists("name","channel_id");

		return View::make('admin.brands.create')->with('breadcrumbs',$breadcrumbs)->with('channels',$channels)->with('upline_options', $upline_options);
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
			'name'   =>  'required|unique:brands,name',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('admin/brands/create')->withErrors($validator)->withInput();
		} else {
			// store
			$brand = new Brand;
			$brand->name       	= Input::get('name');           
			//$brand->channel_id 	= Input::get('channel_id');
			$brand->created_by	= Auth::user()->id;	
            $brand->updated_by	= Auth::user()->id;					
			$brand->save();

			// redirect
			Session::flash('message', 'Brand Created');
			return Redirect::to('admin/brands/'.$brand->id);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
		$brand = Brand::find($id);

        $breadcrumbs = array('Brand' => '/admin/brands', 'View Brand' => '/admin/brands');
		// show the view and pass the nerd to it
		return View::make('admin.brands.show')->with('breadcrumbs',$breadcrumbs)->with('brand', $brand);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		$brand = Brand::find($id);
        $channel = Channel::where('channel_id','=', $brand->channel_id)->withTrashed()->first();
        if($channel){
            $brand->channel_id = $channel->id;
        }        
        
        $channel = Channel::lists('name','id');
        
        $breadcrumbs = array('Brand' => '/admin/brands', 'Edit Brand' => '/admin/brands');        
		// show the view and pass the nerd to it
		return View::make('admin.brands.edit')->with('breadcrumbs',$breadcrumbs)->with('brand', $brand)->with('channel', $channel);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		$rules = array(
			'name'       => 'required|Max:50',
			'channel_id' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('admin/brands/'.$id.'/edit')->withErrors($validator)->withInput();
		} else {
			// store
            $brand                  = Brand::find($id);
			$brand->name            = Input::get('name');
            
            $channel_id             = Input::get('channel_id');
            $channel                = Channel::find($channel_id);
            //var_dump($channel); exit(); 
            $brand->channel_id      = $channel->channel_id;
			$brand->updated_by	 	= Auth::user()->id;					
			$brand->save();

			// redirect
			Session::flash('message', 'Brand Updated');
			return Redirect::to('admin/brands/'.$id);
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
