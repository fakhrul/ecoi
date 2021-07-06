<?php

class BranchController extends \BaseController {

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
		$sort = Input::has("sort") ? Input::get('sort') : "created_at";
    	$sort_order = Input::has("sort_order") ? Input::get('sort_order') : "desc";
    	$paging = (Input::has('paging')) ? Input::get('paging') : "20";

		$branch = Branch::whereIn('id', Auth::user()->branches()->lists('branch_id') )->orderBy($sort, $sort_order);	       

		$branch = $branch->where('channel_id','=',Auth::user()->channel->id);		
		if(Input::has("name")){
            $branch = $branch->where("name","LIKE","%".Input::get("name")."%");			  
		}
        
        $branch = $branch->paginate($paging);

    	$breadcrumbs = array('Branch' => '/branch', 'Manage Branch' => '/branch');

		return View::make('branch.index')->with('breadcrumbs',$breadcrumbs)->with("sort", $sort)->with("sort_order",$sort_order)->with('list', $branch);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		$breadcrumbs = array('Branch' => '/branch', 'Add Branch' => '/branch');

		return View::make('branch.create')->with('breadcrumbs',$breadcrumbs);
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
			'name'      => 'required|Max:50',
			'type'      => 'required|Max:10',		
			'email'		=> 'email|required_if:pinless_reload_low_balance_notification,y',	
			'contact_no'=> 'between:10,12',
			'desc' 		=> 'Max:250',
			'pinless_reload_low_level_amount'=>'required_if:pinless_reload_low_balance_notification,y|integer'
		);

		$messages = array(
		    'pinless_reload_low_level_amount.required_if' => 'The Pinless Reload Low Level Amount field is required when Enable Pinless Reload Low Balance Notification is Yes.',
		    'email.required_if' => 'The Email field is required when Enable Pinless Reload Low Balance Notification is Yes.'
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
			return Redirect::to('branch/create')->withErrors($validator)->withInput();
		} else {// store 
            //$count=0;
			/*foreach (Input::get("msisdn") as $msisdn) {
				if($msisdn != ""){
					if(LiteSimSubscriber::where("msisdn","=","6".$msisdn)->count() == 1){
						if(LiteSimSubscriber::where("msisdn","=","6".$msisdn)->whereIn('status',array('registered','active'))->count() == 1){
							if(BranchMsisdn::where("msisdn","=",$msisdn)->count() > 0){
								Session::flash('message', 'The MSISDN ('.$msisdn.') has been used.');
								return Redirect::to('branch/create')->withErrors($validator)->withInput();
							}
						}else{
							Session::flash('message', 'The MSISDN ('.$msisdn.') has not be register successfully.');
							return Redirect::to('branch/create')->withErrors($validator)->withInput();
						}
					}else{
						Session::flash('message', 'The MSISDN ('.$msisdn.') not found.');
						return Redirect::to('branch/create')->withErrors($validator)->withInput();
					}
					$count++;
				}
			}*/

			if(Input::has("contact_no") and substr(Input::get("contact_no"), 0,1) == "0"){
				Session::flash('message', 'Please add your country code for Contact No.');
				return Redirect::to('branch/create')->withErrors($validator)->withInput();
			}

			$branch = new Branch;
			$branch->name       	= Input::get('name');
			$branch->type      		= Input::get('type');
			$branch->desc 			= Input::get('desc');
            
			if (Input::get('start_date') != '') {
				$branch->start_date 	= Input::get('start_date'); 
			}
			if (Input::get('end_date') != '') {
				$branch->end_date 		= Input::get('end_date');
			}	
			if (Input::has('email')) {
				$branch->email 	= Input::get('email');
			}	
			if (Input::has('contact_no')) {
				$branch->contact_no 	= Input::get('contact_no');
			}
			/*$branch->enable_stock_delivery 	= "n";	
			$branch->pinless_reload_low_balance_notification = Input::get("pinless_reload_low_balance_notification");	
			if(Input::get("pinless_reload_low_balance_notification") == "y"){
				$branch->pinless_reload_low_level_amount 	= Input::get('pinless_reload_low_level_amount');
			}*/
			$branch->channel_id 	= Auth::user()->channel->id;	
			$branch->created_by	 	= Auth::user()->id;					
			$branch->save();

			/*if($count>0){
				foreach (Input::get("msisdn") as $msisdn) {
					if($msisdn != "" and BranchMsisdn::where("msisdn","=",$msisdn)->count() == 0)
					{
						$branchMsisdn = new BranchMsisdn;
						$branchMsisdn->branch_id = $branch->id;
						$branchMsisdn->msisdn = $msisdn;
						$branchMsisdn->created_by = Auth::user()->id;	
						$branchMsisdn->save();	
					}
				}
			}*/

			Auth::user()->branches()->attach($branch->id);		

			/*$pinless = new Pinless;
			$pinless->branch_id = $branch->id;
			$pinless->balance = 0;
			$pinless->save();	

			$itravelsimpinless = new ITravelSimPinless;
			$itravelsimpinless->branch_id = $branch->id;
			$itravelsimpinless->balance   = 0;
			$itravelsimpinless->save();	*/	

			// redirect
			Session::flash('message', 'Branch Created');
			return Redirect::to('branch/'.$branch->id);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
		$branch = Branch::find($id);

		$breadcrumbs = array('Branch' => '/branch', 'View Branch' => '/branch');

		// show the view and pass the nerd to it
		return View::make('branch.show')
		->with('breadcrumbs',$breadcrumbs)		
		->with('list', $branch);
	
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$branch = Branch::find($id);
		$msisdn = BranchMsisdn::where("branch_id","=",$id)->lists("msisdn");

		$breadcrumbs = array('Branch' => '/branch', 'Edit Branch' => '/branch');

		// show the view and pass the nerd to it
		return View::make('branch.edit')
		->with('breadcrumbs',$breadcrumbs)		
		->with('list', $branch)
		->with("msisdn", $msisdn);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'name'      => 'required|Max:50',
			'type'      => 'required|Max:10',		
			'email'		=> 'email|required_if:pinless_reload_low_balance_notification,y',	
			'contact_no'=> 'between:10,12',
			'desc' 		=> 'Max:250',
			'pinless_reload_low_level_amount'=>'required_if:pinless_reload_low_balance_notification,y|integer'
		);

		$messages = array(
		    'pinless_reload_low_level_amount.required_if' => 'The Pinless Reload Low Level Amount field is required when Enable Pinless Reload Low Balance Notification is Yes.',
		    'email.required_if' => 'The Email field is required when Enable Pinless Reload Low Balance Notification is Yes.'
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
			return Redirect::to('branch/'.$id.'/edit')->withErrors($validator)->withInput();
		} else {
			// store
			foreach (Input::get("msisdn") as $msisdn) {
				if($msisdn != "")
				{
					if(LiteSimSubscriber::where("msisdn","=","6".$msisdn)->count() == 1)
					{
						if(LiteSimSubscriber::where("msisdn","=","6".$msisdn)->whereIn('status',array('registered','active'))->count() == 1)
						{
							if(BranchMsisdn::where("msisdn","=",$msisdn)->where("branch_id","!=",$id)->count() > 0)
							{
								Session::flash('message', 'The MSISDN ('.$msisdn.') has been used.');
								return Redirect::to('branch/'.$id.'/edit')->withErrors($validator)->withInput();
							}
						}
						else
						{
							Session::flash('message', 'The MSISDN ('.$msisdn.') has not be register successfully.');
							return Redirect::to('branch/'.$id.'/edit')->withErrors($validator)->withInput();
						}
					}
					else
					{
						Session::flash('message', 'The MSISDN ('.$msisdn.') not found.');
						return Redirect::to('branch/'.$id.'/edit')->withErrors($validator)->withInput();
					}
				}
			}

			if(Input::has("contact_no") and substr(Input::get("contact_no"), 0,1) == "0")
			{
				Session::flash('message', 'Please add your country code for Contact No.');
				return Redirect::to('branch/'.$id.'/edit')->withErrors($validator)->withInput();
			}

			$branch = Branch::find($id);
			$branch->name       	= Input::get('name');
			$branch->type      		= Input::get('type');
			$branch->desc 			= Input::get('desc');
			if (Input::get('start_date') != '') {
				$branch->start_date 	= Input::get('start_date'); 
			}
			if (Input::get('end_date') != '') {
				$branch->end_date 		= Input::get('end_date');
			}	
			if (Input::has('email'))
				$branch->email 	= Input::get('email');
			if (Input::has('contact_no'))
				$branch->contact_no 	= Input::get('contact_no');
			$branch->enable_stock_delivery 	= "n";	
			$branch->pinless_reload_low_balance_notification = Input::get("pinless_reload_low_balance_notification");	
			if(Input::get("pinless_reload_low_balance_notification") == "y")
				$branch->pinless_reload_low_level_amount = Input::get('pinless_reload_low_level_amount');
			else
				$branch->pinless_reload_low_level_amount = NULL;
			$branch->updated_by	 	= Auth::user()->id;					
			$branch->save();

			$branchMsisdn = BranchMsisdn::where("branch_id","=",$id)->lists("msisdn");
			$editMsisdn = Input::get("msisdn");

			$addMsisdn = array_diff($editMsisdn, $branchMsisdn);
			$deleteMsisdn = array_diff($branchMsisdn,$editMsisdn);
			foreach ($addMsisdn as $msisdn) {
				if($msisdn != "" and BranchMsisdn::where("msisdn","=",$msisdn)->count() == 0)
				{
					$branchMsisdn = new BranchMsisdn;
					$branchMsisdn->branch_id = $branch->id;
					$branchMsisdn->msisdn = $msisdn;
					$branchMsisdn->created_by = Auth::user()->id;	
					$branchMsisdn->save();	
				}
			}
			foreach ($deleteMsisdn as $msisdn) {
				if($msisdn != "" and BranchMsisdn::where("msisdn","=",$msisdn)->where("branch_id","=",$id)->count() > 0)
				{
					BranchMsisdn::where("msisdn","=",$msisdn)->where("branch_id","=",$id)->forceDelete();
				}
			}
			Auth::user()->branches()->attach($branch->id);			

			// redirect
			Session::flash('message', 'Branch Updated');
			return Redirect::to('branch/'.$id);
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
