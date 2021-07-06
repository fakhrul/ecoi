<?php

class BrandController extends \BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		//$this->beforeFilter('acl.permitted');		
	}		

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

    	if (Input::has('sort')) {
    		$sort = Input::get('sort');
    	}else { $sort = 'id'; }		

		$brands = Brand::orderBy($sort, 'asc');		

    	if (Input::has('paging')) {
    		$paging = Input::get('paging');
    	}else { $paging = '10'; }


    	$brands = $brands->paginate($paging);

    	$breadcrumbs = array('Brands' => '/brands');

		return View::make('brands.index')
		->with('breadcrumbs',$breadcrumbs)
		->with('brands', $brands);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$upline_options = Channel::where('type','=','MD')->lists('name','id');

		$breadcrumbs = array('Brands' => '/brands', 'Add' => '/brands/create');

		return View::make('brands.create')
		->with('breadcrumbs',$breadcrumbs)
		->with('upline_options', $upline_options);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// get the nerd
		$brand = Brand::find($id);

		$breadcrumbs = array('Brands' => '/brands', $brand->name => '/brands/'.$id);

		// show the view and pass the nerd to it
		return View::make('brands.show')
		->with('breadcrumbs',$breadcrumbs)		
		->with('brand', $brand);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
