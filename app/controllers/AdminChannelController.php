<?php

class AdminChannelController extends BaseController
{

	public $layout = 'layouts.admin_default';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('auth');
		$this->beforeFilter('acl.permitted');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$sort = Input::has("sort") ? Input::get('sort') : "channels.created_at";
		$sort_order = Input::has("sort_order") ? Input::get('sort_order') : "desc";

		$channels = Channel::whereIn('brand_id', (Auth::user()->brands()->lists('brand_id')))->orderBy($sort, $sort_order);
		
		#Filter Inactive
		// if (Input::get('status') == 'A') {
		// 	$channels = Channel::whereIn('brand_id', (Auth::user()->brands()->lists('brand_id')))->withTrashed()->orderBy($sort, $sort_order);
		// } elseif (Input::get('status') == 'D') {
		// 	$channels = Channel::whereIn('brand_id', (Auth::user()->brands()->lists('brand_id')))->onlyTrashed()->orderBy($sort, $sort_order);
		// } else {
		// 	$channels = Channel::whereIn('brand_id', (Auth::user()->brands()->lists('brand_id')))->orderBy($sort, $sort_order);
		// }


		#Search Filter
		// if (Input::has('name')) {
		// 	$channels = $channels->where('name', 'LIKE', '%' . Input::get('name') . '%');
		// }
		// if (Input::has('channel_id')) {
		// 	$channels = $channels->where('channel_id', 'LIKE', '%' . Input::get('channel_id') . '%');
		// }
		// if (Input::has('type')) {
		// 	$channels = $channels->where('type', '=', Input::get('type'));
		// }
		// if (Input::has('upline_id')) {
		// 	$channels = $channels->where('upline_id', '=', Input::get('upline_id'));
		// }
		// if (Input::has('date_from')) {
		// 	$channels = $channels->where('created_at', '>=', Input::get('date_from'));
		// }
		// if (Input::has('date_to')) {
		// 	$channels = $channels->where('created_at', '<', date('Y-m-d', strtotime('+1 days', strtotime(Input::get('date_to')))));
		// }

		#Paging
		if (Input::has('paging')) {
			$paging = Input::get('paging');
		} else {
			$paging = '5';
		}


		$channels = $channels->paginate($paging);
		// echo "<pre>".print_r('asds',true)."</pre>"; exit();
		// $upline_options = Channel::select('id', DB::raw('CONCAT(channel_id, " - ", name) AS name'))
		// 	->whereIn('brand_id', Auth::user()->brands()->lists('brand_id'))
		// 	->where(function ($query) {
		// 		$query->where('type', '=', 'MD')
		// 			->orWhere('type', '=', 'DS')
		// 			->orWhere('type', '=', 'HQ');
		// 	})
		// 	->orderBy('channel_id', 'asc')
		// 	->lists('name', 'id');

		// $upline_options = ['' => 'All'] + $upline_options;

		$breadcrumbs = array('Department' => 'admin/channels', 'Manage Department' => 'admin/channels');
		
		return View::make('admin.channels.index')->with('breadcrumbs', $breadcrumbs)->with("sort", $sort)->with("sort_order", $sort_order)->with('list', $channels);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$brands = Auth::user()->brands()->lists('name', 'brand_id');
		//var_dump(Auth::user()->brands()->lists('brand_id')); exit();		
		$upline_options = Channel::whereIn('brand_id', Auth::user()->brands()->lists('brand_id'))
			->where(function ($query) {
				$query->where('type', '=', 'MD')
					->orWhere('type', '=', 'DS')
					->orWhere('type', '=', 'HQ');
			})
			->lists('name', 'id');
		//var_dump($upline_options); exit();
		if (Auth::user()->brand_id == '3' or Auth::user()->brand_id == '4') {
			$channel_type = array('' => 'Select Type', 'DS' => 'Dealer', 'D' => 'Reseller');
		} else {
			$channel_type = array('' => 'Select Type', 'MD' => 'Master Distributor', 'DS' => 'Distributor', 'D' => 'Dealer', 'C' => 'Client');
		}

		$breadcrumbs = array('Channel' => 'admin/channels', 'Add Channel' => 'admin/channels/create');

		return View::make('admin.channels.create')->with('breadcrumbs', $breadcrumbs)
			->with('upline_options', $upline_options)->with('brands', $brands)->with('channel_type', $channel_type);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name'       		=> 'required',
			// 'reg_no'       		=> 'alpha_num',
			'channel_id'      	=> 'required|alpha_num|unique:channels',
			// 'type' 				=> 'required',
			// 'upline_id' 		=> 'required',
			//'effective_date' 	=> 'required',
			// 'post_code' 		=> 'numeric',
			// 'phone1' 			=> 'numeric',
			// 'phone2' 			=> 'numeric',
			// 'fax' 				=> 'numeric',
			// 'email' 			=> 'email',
			// 'bank_no' 			=> 'numeric',
			// 'msisdn' 			=> 'min:12|max:12|exists:prepaid_order,msisdn,status,2,msisdn,'.Input::get('msisdn'),
			// 'consign_amount' 	=> 'numeric'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/channels/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$channel = new Channel;
			$channel->name       = Input::get('name');
			// $channel->reg_no       = Input::get('reg_no');			
			$channel->channel_id = strtoupper(Input::get('channel_id'));
			$channel->type 		= 'HQ';
			$channel->upline_id 	= 1;
			$channel->brand_id 	= 1;
			// if (Input::get('effective_date')) { $channel->effective_date = Input::get('effective_date'); } 	
			// $channel->address1 	= Input::get('address1');		
			// $channel->address2 	= Input::get('address2');		
			// $channel->address3 	= Input::get('address3');		
			// $channel->post_code = Input::get('post_code');		
			// $channel->city 		= Input::get('city');		
			// $channel->state 	= Input::get('state');		
			// $channel->contact 	= Input::get('contact');
			// $channel->phone1	= Input::get('phone1');
			// $channel->phone2	= Input::get('phone2');
			// $channel->fax		= Input::get('fax');
			// $channel->email		= Input::get('email');
			// $channel->bank_name = Input::get('bank_name');
			// $channel->bank_no	= Input::get('bank_no');	
			// $channel->remarks	= Input::get('remarks');
			//if (Input::get('recurring') !== NULL) { $channel->recurring = Input::get('recurring'); } 					
			//if (Input::get('is_consign') !== NULL) { $channel->is_consign = Input::get('is_consign'); } 	
			//if (Input::get('consign_amount') > 0) { $channel->consign_amount = Input::get('consign_amount'); }				
			//$channel->gps 			= Input::get('gps');


			$channel->created_by	= Auth::user()->id;
			$channel->updated_by	= Auth::user()->id;
			$channel->save();

			//echo "<pre>".print_r('asdas',true)."</pre>"; exit();

			// $user = new User;
			// $user->name       	= Input::get('channel_id');
			// $user->username     = Input::get('channel_id');
			// $user->email 		= Input::get('channel_id');
			// $user->password 	= Hash::make(Input::get('channel_id'));
			// $user->channel_id	= $channel->id;		
			// $user->brand_id		= $channel->brand_id;		
			// $user->created_by	= Auth::user()->id;		
			// $user->updated_by	= Auth::user()->id;									
			// $user->save();		

			// $user->groups()->attach(3);
			// $user->brands()->attach($channel->brand_id);	

			// $branch = new Branch;
			// $branch->name       	= Input::get('name');
			// $branch->type      		= 'Branch';
			// $branch->desc 			= Input::get('name');
			// $branch->is_home		= 'y';
			// $branch->channel_id 	= $channel->id;	
			// $branch->created_by	 	= $user->id;				
			// $branch->save();

			// $user->branches()->attach($branch->id);	

			/*$pinless 			= new Pinless;
			$pinless->branch_id = $branch->id;
			$pinless->save();	

			$itravelsimpinless 			  = new ITravelSimPinless;
			$itravelsimpinless->branch_id = $branch->id;
			$itravelsimpinless->balance   = 0;
			$itravelsimpinless->save();	

			$channelproducttype = new ChannelProductType;
			$channelproducttype->channel_id = $channel->id;
			$channelproducttype->product_type_id = 1; // 1=tronlitesim product type
			$channelproducttype->status = 'active';
			$channelproducttype->save();

			$channelproducttype = new ChannelProductType;
			$channelproducttype->channel_id = $channel->id;
			$channelproducttype->product_type_id = 2; // 2=itravelsim product type
			$channelproducttype->status = 'inactive';
			$channelproducttype->save();	
		

			if (Input::get('msisdn')){
				$msisdn 			= new BranchMsisdn;
				$msisdn->branch_id 	= $branch->id;
				$msisdn->msisdn 	= substr(Input::get('msisdn'),1);
				$msisdn->save();
			}
			
			if ($channel->brand_id == '3' or $channel->brand_id == '4') {
				$channel->products()->attach(105);
				$channel->products()->attach(106);
				$channel->products()->attach(107);
				$channel->products()->attach(108);
			}

			if ($channel->brand_id == '1' or $channel->brand_id == '2') {
#				if(in_array($channel->upline_id, array('6','35','40','718','398','147','476'))) {
#					$channel->products()->attach(53);
#					$channel->products()->attach(50);
#					$channel->products()->attach(51);
#					$channel->products()->attach(52);

#				}else{
					$channel->products()->attach(53);
					$channel->products()->attach(100);
					$channel->products()->attach(101);
					$channel->products()->attach(102);
#				}
			}*/
			Session::flash('message', 'Channel Added');

			return Redirect::to('admin/channels/' . $channel->id);
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
		// get the nerd
		$channel = Channel::withTrashed()->find($id);

		$breadcrumbs = array('Channel' => 'admin/channels', 'View Channel' => 'admin/channels');

		// show the view and pass the nerd to it
		return View::make('admin.channels.show')
			->with('breadcrumbs', $breadcrumbs)
			->with('channel', $channel);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// get the nerd
		$channel = Channel::withTrashed()->find($id);

		//$upline_options = Channel::where('type','=','MD')->orWhere('type','=','DS')->orWhere('type','=','HQ')->lists('name','id');
		$upline_options = Channel::whereIn('brand_id', Auth::user()->brands()->lists('brand_id'))
			->where(function ($query) {
				$query->where('type', '=', 'MD')
					->orWhere('type', '=', 'DS')
					->orWhere('type', '=', 'HQ');
			})
			->lists('name', 'id'); // edit by liyin 2015-04-29

		$brands = Auth::user()->brands()->lists('name', 'brand_id');

		$breadcrumbs = array('Channel' => 'admin/channels', 'Edit Channel' => 'admin/channels');

		// show the edit form and pass the nerd
		return View::make('admin.channels.edit')
			->with('breadcrumbs', $breadcrumbs)
			->with('channel', $channel)
			->with('upline_options', $upline_options)
			->with('brands', $brands);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name'       => 'required',
			'channel_id'      => 'required|unique:channels,id,' . $id,
			// 'type' 	=> 'required',
			// 'upline_id' 	=> 'required',
			//'effective_date' => 'required',			
			// 'post_code' => 'numeric',
			// 'phone1' => 'numeric',
			// 'phone2' => 'numeric',
			// 'fax' => 'numeric',
			// 'email' => 'email',
			// 'bank_no' => 'numeric',
			// 'consign_amount' => 'numeric'	
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/channels/' . $id . '/edit')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// store
			$channel 				= Channel::find($id);
			$channel->name       	= Input::get('name');
			$channel->type 			= 'HQ';
			$channel->upline_id 	= 1;
			$channel->brand_id 		= 1;

			// $channel->reg_no       = Input::get('reg_no');				
			// $channel->type 			= Input::get('type');
			// $channel->upline_id 	= Input::get('upline_id');			
			// Input::get('brand_id') ? : $channel->brand_id 		= Input::get('brand_id');	
			// if (Input::get('effective_date')) { $channel->effective_date = Input::get('effective_date'); } 	
			// $channel->address1 	= Input::get('address1');		
			// $channel->address2 	= Input::get('address2');		
			// $channel->address3 	= Input::get('address3');		
			// $channel->post_code = Input::get('post_code');		
			// $channel->city 		= Input::get('city');		
			// $channel->state 	= Input::get('state');		
			// $channel->contact 	= Input::get('contact');
			// $channel->phone1	= Input::get('phone1');
			// $channel->phone2	= Input::get('phone2');
			// $channel->fax		= Input::get('fax');
			// $channel->email		= Input::get('email');
			// $channel->bank_name = Input::get('bank_name');
			// $channel->bank_no	= Input::get('bank_no');	
			// $channel->remarks	= Input::get('remarks');	
			//if (Input::get('recurring') !== NULL) { $channel->recurring = Input::get('recurring'); } 					
			//if (Input::get('is_consign') !== NULL) { $channel->is_consign = Input::get('is_consign'); } 	
			//if (Input::get('consign_amount') > 0) { $channel->consign_amount = Input::get('consign_amount'); }		
			//$channel->gps 			= Input::get('gps');			
			$channel->updated_by	= Auth::user()->id;
			$channel->save();

			// redirect
			Session::flash('message', 'Channel Updated');
			return Redirect::to('admin/channels/' . $channel->id);
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
		$channel = Channel::find($id);
		$channel->deleted_by	= Auth::user()->id;
		$channel->save();
		$channel->delete();

		// redirect
		Session::flash('message', 'Channel Deleted');
		return Redirect::to('admin/channels/' . $channel->id);
	}

	public function getRestore()
	{

		$id = Input::get('id');

		// delete
		$channel = Channel::onlyTrashed()->find($id);
		$channel->restore();
		$channel->deleted_by	= null;
		$channel->save();

		// redirect
		Session::flash('message', 'Channel Restored');
		return Redirect::to('admin/channels/' . $channel->id);
	}

	public function export()
	{

		if (Input::get('status') == 'A') {
			$channels = Channel::whereIn('brand_id', (Auth::user()->brands()->lists('brand_id')))->withTrashed()->orderBy('created_at', 'asc');
		} elseif (Input::get('status') == 'D') {
			$channels = Channel::whereIn('brand_id', (Auth::user()->brands()->lists('brand_id')))->onlyTrashed()->orderBy('created_at', 'asc');
		} else {
			$channels = Channel::whereIn('brand_id', (Auth::user()->brands()->lists('brand_id')))->orderBy('created_at', 'asc');
		}


		#Search Filter
		if (Input::has('name')) {
			$channels = $channels->where('name', 'LIKE', '%' . Input::get('name') . '%');
		}
		if (Input::has('type')) {
			$channels = $channels->where('type', '=', Input::get('type'));
		}
		if (Input::has('upline_id')) {
			$channels = $channels->where('upline_id', '=', Input::get('upline_id'));
		}
		if (Input::has('date_from')) {
			$channels = $channels->where('created_at', '>=', Input::get('date_from'));
		}
		if (Input::has('date_to')) {
			$channels = $channels->where('created_at', '<', date('Y-m-d', strtotime('+1 days', strtotime(Input::get('date_to')))));
		}

		$channels = $channels->get();

		$data[] = array("Channel ID", " Channel Name", "Company Reg No", "Type", "Upline ID", "Upline", "Brand", "Address1", "Address2", "Address3", "Post Code", "City", "State", "Contact", "Phone1", "Phone2", "Fax", "Email", "Bank Name", "Bank No", "Remarks", "Created At", "Created By", "Updated At", "Updated By");

		foreach ($channels as $channel) {
			$data[] = array($channel->channel_id, $channel->name, $channel->reg_no, $channel->type, $channel->upline ? $channel->upline->channel_id : '-', $channel->upline ? $channel->upline->name : '-', $channel->brand->name, $channel->address1, $channel->address2, $channel->address3, $channel->post_code, $channel->city, $channel->state, $channel->contact, $channel->phone1, $channel->phone2, $channel->fax, $channel->email, $channel->bank_name, $channel->bank_no, $channel->remarks, (string)$channel->created_at, $channel->createUser->username, (string)$channel->updated_at, $channel->updateUser->username);
		}

		Excel::create("Channel " . date("Y-m-d His"), function ($excel) use ($data) {
			$excel->sheet("Channel", function ($sheet) use ($data) {
				$sheet->fromArray($data, null, 'A1', false, false);
			});
		})->download('xlsx');
	}
}
