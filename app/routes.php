<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => 'admin'], function() {

	//Route::get('product_type/select', 'HomeController@showProductType');  
	//Route::post('product_type/select', 'HomeController@selectProductType');

	Route::get('channels/restore', array('as' => 'admin.channels.restore', 'uses' => 'AdminChannelController@getRestore'));
	Route::get('users/restore', array('as' => 'admin.users.restore', 'uses' => 'AdminUserController@getRestore'));

	Route::get('profile/edit', array('as' => 'admin.profile.edit', 'uses' => 'HomeController@editProfile'));  
	Route::put('profile/edit', array('as' => 'admin.profile.update', 'uses' => 'HomeController@updateProfile')); 

	Route::resource('channels', 'AdminChannelController');
	Route::resource('users', 'AdminUserController');
	Route::resource('brands', 'AdminBrandController');  
	Route::resource('branch', 'AdminBranchController');	
    Route::resource('station', 'AdminStationController');
    Route::resource('groups', 'AdminGroupController');
    Route::resource('types', 'AdminTypeController');
    Route::resource('summary', 'AdminSummaryController');
	Route::post("summary/export", array('as' => 'admin.summary.export', 'uses' => 'AdminSummaryController@export'));  

	Route::get('prepaidorder/{id}/print', array('as' => 'admin.prepaidorder.print', 'uses' => 'AdminPrepaidOrderController@getPrint'));
	Route::get('portin/{id}/print', array('as' => 'admin.portin.print', 'uses' => 'AdminPortInController@getPrint'));

	Route::post("channels/export", array('as' => 'admin.channels.export', 'uses' => 'AdminChannelController@export'));	
	Route::post("billing/export", array('as' => 'admin.billing.export', 'uses' => 'AdminBillingController@export'));	
	Route::post("reload/export", array('as' => 'admin.reload.export', 'uses' => 'AdminReloadController@export'));		

	Route::resource('prepaidorder', 'AdminPrepaidOrderController');
	Route::resource('portin', 'AdminPortInController');

	Route::resource('simreplacement', 'AdminSimReplacementController');
	Route::post("simreplacement/export", array('as' => 'admin.simreplacement.export', 'uses' => 'AdminSimReplacementController@export'));
	
	Route::resource('simchange', 'AdminSimChangeController');
	Route::post("simchange/export", array('as' => 'admin.simchange.export', 'uses' => 'AdminSimChangeController@export'));

	Route::resource('barunbar', 'AdminBarUnbarController');
	Route::post("barunbar/export", array('as' => 'admin.barunbar.export', 'uses' => 'AdminBarUnbarController@export'));

	Route::resource('transferownership', 'AdminTransferOwnershipController');
	Route::post("transferownership/export", array('as' => 'admin.transferownership.export', 'uses' => 'AdminTransferOwnershipController@export'));
	Route::get('transferownership/{id}/print', array('as' => 'admin.transferownership.print', 'uses' => 'AdminTransferOwnershipController@getPrint'));	

	Route::resource('billing', 'AdminBillingController');	
	Route::resource('product', 'AdminProductController');	
	
	Route::get("reload/old", array('as' => 'admin.reload.index_old', 'uses' => 'AdminReloadController@index_old'));
	Route::resource('reload', 'AdminReloadController');		

	Route::get('home', array('before' => 'auth', 'as' => 'admin.home', 'uses' => 'HomeController@showAdminHome'));

	// start - added by liyin 2015-03-17
	Route::post('pin/export', array('as' => 'admin.pin.export', 'uses' => 'AdminPinController@export'));
	Route::post('pinless/export', array('as' => 'admin.pinless.export', 'uses' => 'AdminPinlessController@export'));
	Route::post('simcard/export', array('as' => 'admin.simcard.export', 'uses' => 'AdminSimcardController@export'));
	Route::post('transferpinless/export', array('as' => 'admin.transferpinless.export', 'uses' => 'AdminTransferPinlessController@export'));
	Route::get('simcard/get_msisdn', array('as' => 'admin.simcard.get_msisdn', 'uses' => 'AdminSimcardController@get_msisdn'));
	Route::resource('pin', 'AdminPinController');
	Route::resource('pinless', 'AdminPinlessController');
	Route::resource('simcard', 'AdminSimcardController');

	Route::post('box/export', array('as' => 'admin.box.export', 'uses' => 'AdminBoxController@export'));
	Route::resource('warehouse', 'AdminWarehouseController');
	Route::resource('section', 'AdminSectionController');
	Route::resource('box', 'AdminBoxController');
	Route::get('stock/preview', function(){return Redirect::to("stock/create");});
	Route::post('stock/preview', array('as' => 'admin.stock.preview', 'uses' => 'AdminStockController@preview'));
	Route::post('stock/back', array('as' => 'admin.stock.back', 'uses' => 'AdminStockController@back'));
	Route::get('stock/get_info', array('as' => 'admin.stock.get_info', 'uses' => 'AdminStockController@get_info'));
	Route::post('stock/get_info', array('as' => 'admin.stock.get_info', 'uses' => 'AdminStockController@get_info'));
	Route::resource('stock', 'AdminStockController');

	Route::get("api/get_branches_by_channel_id/{id}", array('uses' => 'AdminAPIController@get_branches_by_channel_id'));
	Route::get("api/get_sections_by_branch_id/{id}", array('uses' => 'AdminAPIController@get_sections_by_branch_id'));
	Route::get("api/get_boxes_by_branch_id/{id}", array('uses' => 'AdminAPIController@get_boxes_by_branch_id'));
	Route::get("api/get_simcard_pattern_list/{length}", array('uses' => 'AdminAPIController@get_simcard_pattern_list'));
	// end

	Route::get("api/check_duplicate_channel", array('uses' => 'AdminAPIController@check_duplicate_channel'));
    Route::get("api/check_duplicate_brand", array('uses' => 'AdminAPIController@check_duplicate_brand'));
    Route::get("api/check_duplicate_type", array('uses' => 'AdminAPIController@check_duplicate_type'));

	// start - added by liyin 2015-04-16
	/*Route::get('report/pinless_balance', array('as' => 'admin.report.pinless.balance', 'uses' => 'AdminReportController@pinless_balance'));
	Route::post('report/pinless_balance/export', array('as' => 'admin.report.pinless.balance.export', 'uses' => 'AdminReportController@pinless_balance_export'));
	Route::get('report/pinless_transfer', array('as' => 'admin.report.pinless.transfer', 'uses' => 'AdminReportController@pinless_transfer'));
	Route::post('report/pinless_transfer/export', array('as' => 'admin.report.pinless.transfer.export', 'uses' => 'AdminReportController@pinless_transfer_export'));
	Route::get('report/subscriber_status/{term}', array('as' => 'admin.report.subscriber.status', 'uses' => 'AdminReportController@subscriber_status'));
	// end - added by liyin

	// ivan module start
	Route::resource('taxinvoice', 'AdminTaxInvoiceController');
	Route::post('voucher/transactions/export', array('as' => 'admin.voucher.transactions.export', 'uses' => 'AdminVoucherController@export'));
	Route::get('voucher/transactions', array('as' => 'admin.voucher.transactions', 'uses' => 'AdminVoucherController@voucher_transactions'));
	Route::resource('voucher', 'AdminVoucherController');
	Route::post('report/voucher/export', array('as' => 'admin.report.voucher.export', 'uses' => 'AdminReportController@voucher_info_export'));
	Route::get('report/voucher', array('as' => 'admin.report.voucher', 'uses' => 'AdminReportController@voucher_info'));
	// ivan module end */

	Route::resource('reloadpreload', 'AdminReloadPreloadController');
	Route::get('api/getProduct/{id}', array('uses' => 'AdminReloadPreloadAPIController@getProductByCategory'));

	Route::post("sim2/subscriber/export", array('as' => 'admin.sim2.subscriber.export', 'uses' => 'AdminITravelSimSubscriberController@export'));
	Route::post("sim2/subscriber/getBlockStatus", array('as' => 'admin.sim2.subscriber.getBlockStatus', 'uses' => 'AdminITravelSimSubscriberAPIController@getBlockStatus'));
	Route::post("sim2/subscriber/editBlockStatus", array('as' => 'admin.sim2.subscriber.editBlockStatus', 'uses' => 'AdminITravelSimSubscriberController@editBlockStatus'));
	Route::post("sim2/subscriber/getInfo", array('as' => 'admin.sim2.subscriber.getInfo', 'uses' => 'AdminITravelSimSubscriberAPIController@getInfo'));
	Route::resource('sim2/subscriber', 'AdminITravelSimSubscriberController');
	Route::post('sim2/billing/export', array('as' => 'admin.sim2.billing.export', 'uses' => 'AdminITravelSimBillingController@export'));
	Route::resource('sim2/billing', 'AdminITravelSimBillingController');
	Route::resource('sim2/iccid', 'AdminITravelSimICCIDController');
	Route::resource('sim2/registration', 'AdminITravelSimRegistrationController');
	Route::resource('sim2/reload', 'AdminITravelSimReloadController');
	Route::get('sim2/voucher/transaction', array('as' => 'admin.sim2.voucher.transaction', 'uses' => 'AdminITravelSimVoucherController@transaction'));
	Route::post('sim2/voucher/transaction/export', array('as' => 'admin.sim2.voucher.transaction.export', 'uses' => 'AdminITravelSimVoucherController@export'));
	Route::resource('sim2/voucher', 'AdminITravelSimVoucherController');
	Route::post('sim2/pinless/export', array('as' => 'admin.sim2.pinless.export', 'uses' => 'AdminITravelSimPinlessController@export'));
	Route::resource('sim2/pinless', 'AdminITravelSimPinlessController');
    
	Route::get('report/daily', array('as' => 'admin.report.daily', 'uses' => 'AdminReportController@daily'));
    Route::get('report/state', array('as' => 'admin.report.state', 'uses' => 'AdminReportController@state'));
    Route::get('report/summary', array('as' => 'admin.report.summary', 'uses' => 'AdminReportController@summary'));
    Route::resource('report', 'AdminReportController');
	
	Route::resource('download', 'AdminDownloadController');
	Route::post("download/export", array('as' => 'admin.download.export', 'uses' => 'AdminDownloadController@export'));    
});

//Route::get('channels/restore', array('as' => 'channels.restore', 'uses' => 'Admin.ChannelController@getRestore'));
Route::get('users/restore', 'UserController@getRestore');

Route::group(array('before' => 'auth'), function(){
	//Route::get('product_type/select', 'HomeController@showProductType');  
	//Route::post('product_type/select', 'HomeController@selectProductType');  
	Route::get('branch/select', 'HomeController@showBranch');  
	Route::post('branch/select', 'HomeController@selectBranch');  
	Route::get('profile/edit', array('as' => 'profile.edit', 'uses' => 'HomeController@editProfile'));  
	Route::put('profile/edit', array('as' => 'profile.update', 'uses' => 'HomeController@updateProfile'));  	
});

Route::resource('users', 'UserController');  
Route::resource('groups', 'GroupController');
Route::resource('branch', 'BranchController');
Route::resource('station', 'StationController');
Route::resource('summary', 'SummaryController');
Route::post("summary/export", array('as' => 'summary.export', 'uses' => 'SummaryController@export')); 

Route::get('prepaidorder/{id}/print', array('as' => 'prepaidorder.print', 'uses' => 'PrepaidOrderController@getPrint'));
Route::get('prepaidorder/get_cities/{state}', array('as' => 'prepaidorder.get_cities', 'uses' => 'PrepaidOrderController@getCities'));

Route::get('portin/{id}/print', array('as' => 'portin.print', 'uses' => 'PortInController@getPrint'));

Route::resource('prepaidorder', 'PrepaidOrderController');

Route::resource('portin', 'PortInController');

Route::resource('prepaidorder', 'PrepaidOrderController');
Route::resource('sim2/registration', 'ITravelSimRegistrationController');
Route::get('sim2/validate_registration', 'ITravelSimRegistrationAPIController@validate_itravelsim_registration');
Route::resource('sim2/reload', 'ITravelSimReloadController');
Route::resource('sim2/transferpinless', 'ITravelSimTransferPinlessController');
Route::resource('sim2/pinless', 'ITravelSimPinlessController');

//naz 2015-06-01
Route::get('subscribers/{id}/puk', array('as' => 'subscribers.puk', 'uses' => 'SubscribersController@getPUK'));
Route::get('subscribers/{id}/bill', array('as' => 'subscribers.bill', 'uses' => 'SubscribersController@getBill'));
Route::get('subscribers/{id}/cust', array('as' => 'subscribers.cust', 'uses' => 'SubscribersController@getCust'));
Route::get('subscribers/{id}/bar', array('as' => 'subscribers.bar', 'uses' => 'SubscribersController@getBar'));
Route::get('subscribers/{id}/unbar', array('as' => 'subscribers.unbar', 'uses' => 'SubscribersController@getUnbar'));
Route::resource('subscribers', 'SubscribersController');
Route::get('subscribers/getBill2/{id}', array('as' => 'subscribers.getBill2', 'uses' => 'SubscribersController@getBill2'));
Route::get('subscribers/barUnbar/{id}', array('as' => 'subscribers.barUnbar', 'uses' => 'SubscribersController@barUnbar'));
Route::get('subscribers/retrievereloadhistory/{id}', array('as' => 'subscribers.retrievereloadhistory', 'uses' => 'SubscribersController@getReloadHistory'));
Route::get('subscribers/retrieveFreebies/{id}', array('as' => 'subscribers.retrieveFreebies', 'uses' => 'SubscribersController@getFreebies'));
Route::get('subscribers/retrieveFnF/{id}', array('as' => 'subscribers.retrieveFnF', 'uses' => 'SubscribersController@getFnF'));
Route::get('subscribers/retrieveSubsriber/{id}', array('as' => 'subscribers.retrieveSubsriber', 'uses' => 'SubscribersController@getSubscription'));
Route::get('subscribers/retrieveAccBalance/{id}', array('as' => 'subscribers.retrieveAccBalance', 'uses' => 'SubscribersController@getAccbalance'));
Route::get('subscribers/adjustAcc/{id}', array('as' => 'subscribers.adjustAcc', 'uses' => 'SubscribersController@adjustAcc'));
Route::post("subscribers/export", array('as' => 'subscribers.export', 'uses' => 'SubscribersController@export'));

Route::get('subscribers/{id}/edit', array('as' => 'subscribers.edit', 'uses' => 'SubscribersController@edit'));
Route::put('subscribers/update/{id}', array('as' => 'subscribers.update', 'uses' => 'SubscribersController@update'));

Route::get('subscribers/{id}/unsubscribe', array('as' => 'subscribers.unsubscribe', 'uses' => 'SubscribersController@unsubscribe'));
Route::get('subscribers/{id}/addSubscription', array('as' => 'subscribers.addSubscription', 'uses' => 'SubscribersController@addSubscription'));
Route::put('subscribers/subscribe/{id}', array('as' => 'subscribers.subscribe', 'uses' => 'SubscribersController@subscribe'));

Route::get('admin/subscribers/{id}/puk', array('as' => 'admin.subscribers.puk', 'uses' => 'AdminSubscribersController@getPUK'));
Route::get('admin/subscribers/{id}/bill', array('as' => 'admin.subscribers.bill', 'uses' => 'AdminSubscribersController@getBill'));
Route::get('admin/subscribers/{id}/cust', array('as' => 'admin.subscribers.cust', 'uses' => 'AdminSubscribersController@getCust'));
Route::get('admin/subscribers/{id}/bar', array('as' => 'admin.subscribers.bar', 'uses' => 'AdminSubscribersController@getBar'));
Route::get('admin/subscribers/{id}/unbar', array('as' => 'admin.subscribers.unbar', 'uses' => 'AdminSubscribersController@getUnbar'));
Route::resource('admin/subscribers', 'AdminSubscribersController');
Route::get('admin/subscribers/getBill2/{id}', array('as' => 'admin.subscribers.getBill2', 'uses' => 'AdminSubscribersController@getBill2'));
Route::get('admin/subscribers/barUnbar/{id}', array('as' => 'admin.subscribers.barUnbar', 'uses' => 'AdminSubscribersController@barUnbar'));
Route::get('admin/subscribers/retrievereloadhistory/{id}', array('as' => 'admin.subscribers.retrievereloadhistory', 'uses' => 'AdminSubscribersController@getReloadHistory'));
Route::get('admin/subscribers/retrieveFreebies/{id}', array('as' => 'admin.subscribers.retrieveFreebies', 'uses' => 'AdminSubscribersController@getFreebies'));
Route::get('admin/subscribers/retrieveFnF/{id}', array('as' => 'admin.subscribers.retrieveFnF', 'uses' => 'AdminSubscribersController@getFnF'));
Route::get('admin/subscribers/retrieveSubsriber/{id}', array('as' => 'admin.subscribers.retrieveSubsriber', 'uses' => 'AdminSubscribersController@getSubscription'));
Route::get('admin/subscribers/retrieveAccBalance/{id}', array('as' => 'admin.subscribers.retrieveAccBalance', 'uses' => 'AdminSubscribersController@getAccbalance'));
Route::get('admin/subscribers/{id}/retrieveAccBalance', array('as' => 'admin.subscribers.retrieveAccBalance', 'uses' => 'AdminSubscribersController@getAccbalance'));
Route::get('admin/subscribers/adjustAcc/{id}', array('as' => 'admin.subscribers.adjustAcc', 'uses' => 'AdminSubscribersController@adjustAcc'));
Route::get('admin/subscribers/{id}/adjustAcc', array('as' => 'admin.subscribers.adjustAcc', 'uses' => 'AdminSubscribersController@adjustAcc'));
Route::post("admin/subscribers/export", array('as' => 'admin.subscribers.export', 'uses' => 'AdminSubscribersController@export'));

Route::get('admin/subscribers/{id}/edit', array('as' => 'admin.subscribers.edit', 'uses' => 'AdminSubscribersController@edit'));
Route::put('admin/subscribers/update/{id}', array('as' => 'admin.subscribers.update', 'uses' => 'AdminSubscribersController@update'));

Route::get('admin/subscribers/{id}/unsubscribe', array('as' => 'admin.subscribers.unsubscribe', 'uses' => 'AdminSubscribersController@unsubscribe'));
Route::get('admin/subscribers/{id}/addSubscription', array('as' => 'admin.subscribers.addSubscription', 'uses' => 'AdminSubscribersController@addSubscription'));
Route::put('admin/subscribers/subscribe/{id}', array('as' => 'admin.subscribers.subscribe', 'uses' => 'AdminSubscribersController@subscribe'));
Route::get('admin/subscribers/getCities/{state}', array('as' => 'admin.subscribers.getCities', 'uses' => 'AdminSubscribersController@getCities'));
//MDM
Route::get('admin/subscribers/retrieveSubsriberProfile/{id}', array('as' => 'admin.subscribers.retrieveSubsriberProfile', 'uses' => 'AdminSubscribersController@getSubsriberProfile'));
Route::get('admin/subscribers/retrieveDeviceCapabilities/{id}', array('as' => 'admin.subscribers.retrieveDeviceCapabilities', 'uses' => 'AdminSubscribersController@getDeviceCapabilities'));
Route::get('admin/subscribers/retrieveDeviceSettings/{id}', array('as' => 'admin.subscribers.retrieveDeviceSettings', 'uses' => 'AdminSubscribersController@getDeviceSettings'));
Route::put('admin/subscribers/sendDeviceSettings/{id}', array('as' => 'admin.subscribers.sendDeviceSettings', 'uses' => 'AdminSubscribersController@setDeviceSetting'));

Route::resource('admin/updatesubscribers', 'AdminUpdateSubscriberController');
Route::post("admin/updatesubscribers/export", array('as' => 'admin.updatesubscribers.export', 'uses' => 'AdminUpdateSubscriberController@export'));

Route::resource('admin/subscriptions', 'AdminSubscriptionsController');
Route::post("admin/subscriptions/export", array('as' => 'admin.subscriptions.export', 'uses' => 'AdminSubscriptionsController@export'));

Route::resource('admin/adjustaccount', 'AdminAdjustAccountController');
Route::post("admin/adjustaccount/export", array('as' => 'admin.adjustaccount.export', 'uses' => 'AdminAdjustAccountController@export'));

//QTU
Route::get('admin/subscribers/retrieveQuota/{id}', array('as' => 'admin.subscribers.retrieveQuota', 'uses' => 'AdminSubscribersController@getQuota'));
Route::get('admin/subscribers/{id}/addQuotaTopUp', array('as' => 'admin.subscribers.addQuotaTopUp', 'uses' => 'AdminSubscribersController@addQuotaTopUp'));
Route::put('admin/subscribers/quotaTopUp/{id}', array('as' => 'admin.subscribers.quotaTopUp', 'uses' => 'AdminSubscribersController@quotaTopUp'));

// jin 2015-03-17
Route::get("reload/old", array('as' => 'reload.index_old', 'uses' => 'ReloadController@index_old'));
Route::resource('reload', 'ReloadController');

// start - added by liyin 2015-03-17
Route::get('pin/quick_stock_allocation', array('as' => 'pin.quick_stock_allocation', 'uses'=>'PinController@quick_stock_allocation'));
Route::post('pin/export', array('as' => 'pin.export', 'uses'=>'PinController@export'));
Route::get('simcard/quick_stock_allocation', array('as' => 'simcard.quick_stock_allocation', 'uses'=>'SimcardController@quick_stock_allocation'));
Route::post('simcard/export', array('as' => 'simcard.export', 'uses'=>'SimcardController@export'));
Route::get('transferpin/preview', function(){return Redirect::to("transferpin/create");});
Route::post('transferpin/preview', array('as' => 'transferpin.preview', 'uses' => 'TransferPinController@preview'));
Route::post('transferpin/back', array('as' => 'transferpin.back', 'uses' => 'TransferPinController@back'));
Route::post('pinsales/preview', array('as' => 'pinsales.preview', 'uses' => 'PinSalesController@preview'));
Route::post('pinsales/back', array('as' => 'pinsales.back', 'uses' => 'PinSalesController@back'));
Route::get('transfersimcard/preview', function(){return Redirect::to("transfersimcard/create");});
Route::post('transfersimcard/preview', array('as' => 'transfersimcard.preview', 'uses' => 'TransferSimcardController@preview'));
Route::post('transfersimcard/back', array('as' => 'transfersimcard.back', 'uses' => 'TransferSimcardController@back'));
Route::resource('pin', 'PinController');
Route::resource('pinless', 'PinlessController');
Route::resource('simcard', 'SimcardController'); 
Route::resource('transferpin', 'TransferPinController');
Route::resource('transferpinless', 'TransferPinlessController');
Route::resource('transfersimcard', 'TransferSimcardController'); 
Route::resource('pinsales', 'PinSalesController');

Route::post('stock/export', array('as' => 'stock.export', 'uses' => 'StockController@export'));
Route::post('box/export', array('as' => 'box.export', 'uses' => 'BoxController@export'));
Route::resource('section', 'SectionController');
Route::resource('box', 'BoxController');
Route::get('stock/preview', function(){return Redirect::to("stock/create");});
Route::post('stock/preview', array('as' => 'stock.preview', 'uses' => 'StockController@preview'));
Route::post('stock/back', array('as' => 'stock.back', 'uses' => 'StockController@back'));
Route::get('stock/get_info', array('as' => 'stock.get_info', 'uses' => 'StockController@get_info'));
Route::post('stock/get_info', array('as' => 'stock.get_info', 'uses' => 'StockController@get_info'));
Route::resource('stock', 'StockController'); 
// end

// start - added by liyin 2015-03-17
Route::get('report/pinless_balance', array('as' => 'report.pinless.balance', 'uses' => 'ReportController@pinless_balance'));
Route::post('report/pinless_balance/export', array('as' => 'report.pinless.balance.export', 'uses' => 'ReportController@pinless_balance_export'));
// end

Route::get('denied', array(
	'as'        => 'access.denied',
	function(){ 
		if(!empty(Auth::user()->channel_id)) { 
			return View::make('restricted');
		}
		else { return View::make('admin.restricted'); }
	}
)); 

Route::get('/', array('before' => 'auth', 'uses' => 'HomeController@showHome'));

Route::get('home', array('before' => 'auth', 'as' => 'home', 'uses' => 'HomeController@showHome'));

Route::get('login', array('uses' => 'HomeController@showLogin'));

Route::post('login', array('as'=> 'doLogin', 'uses' => 'HomeController@doLogin'));

Route::get('logout', array('uses' => 'HomeController@doLogout'));

Route::post("api/pre_registration", array('uses' => "PrepaidOrderAPIController@create_pre_registration"));
Route::post("api/create_prepaid_order", array('uses' => "PrepaidOrderAPIController@create_prepaid_order"));
Route::post("api/create_prepaid_order_new", array('uses' => "PrepaidOrderAPIController@create_prepaid_order_new"));
Route::post("api/create_port_in", array('uses' => "PrepaidOrderAPIController@create_port_in"));
Route::get("api/get_cities/{state}", array('uses' => "PrepaidOrderAPIController@getCities")); // internal API, added by liyin
Route::get("api/get_cities_old/{state}", array('uses' => "PrepaidOrderAPIController@getCitiesOld")); // internal API, added by liyin
Route::post("api/get_iccid", array('uses' => "PrepaidOrderAPIController@get_iccid"));
Route::post("api/validate_registration", array('uses' => "PrepaidOrderAPIController@validate_registration"));
Route::post("api/validate_transferownership", array('uses' => "PrepaidOrderAPIController@validate_transferownership"));
Route::post("api/retrieve_transaction", array('uses' => "PrepaidOrderAPIController@retrieve_transaction"));
Route::get("api/itravelsim/getCities/{state}", array('uses' => "ITravelSimRegistrationAPIController@getCities"));

Route::post("api/create_reload", array('uses' => "ReloadAPIController@create_reload"));
Route::post("api/get_pinless_balance", array('uses' => "ReloadAPIController@get_pinless_balance"));
Route::post("api/reload_pending", array('uses' => "ReloadAPIController@reload_pending"));
Route::post("api/create_reload_preload", array('uses' => "ReloadAPIController@create_reload_preload"));
Route::post("api/reload_preload", array('uses' => "ReloadAPIController@reload_preload"));
Route::get('api/getName/{msisdn}', array('uses' => 'ReloadAPIController@getNameByMsisdn'));
Route::get('api/getNameOld/{msisdn}', array('uses' => 'ReloadAPIController@getNameByMsisdnOld'));
Route::get('api/getProduct/{id}', array('uses' => 'ReloadAPIController@getProductByCategory'));
Route::get('api/getITravelSimName/{msisdn}', array('uses' => 'ITravelSimReloadAPIController@getITravelSimNameByMsisdn'));
Route::get('api/getITravelSimProduct/{id}', array('uses' => 'ITravelSimReloadAPIController@getITravelSimProductByCategory'));

Route::post("api/update_pin_is_used", array('uses' => "PinAPIController@update_pin_is_used")); // added by liyin 2015-04-10
Route::post("api/get_pin_info", array('uses' => "PinAPIController@get_pin_info")); // added by liyin 2015-04-10
Route::get("api/get_simcard_pattern_list/{length}", array('uses' => 'APIController@get_simcard_pattern_list'));

Route::post("/api/update_subscriber_info", "AdminSubscribersAPIController@update_subscriber_info");
Route::post("/api/retrieve_msisdn_by_status", "AdminSubscribersAPIController@retrieve_msisdn_by_status");
Route::post("/api/retrieve_msisdn_fca", "AdminSubscribersAPIController@retrieve_msisdn_fca");
Route::post("/api/retrieve_prepaid_account", "AdminSubscribersAPIController@retrieve_prepaid_account");
Route::post("/api/update_mno_subscriber_info", "AdminSubscribersAPIController@update_mno_subscriber_info");
Route::post("api/synchronise_subscriber", array('uses' => "AdminSubscribersAPIController@synchronise_subscriber")); 
Route::post("api/retrieve_subscriber_info", array('uses' => "AdminSubscribersAPIController@retrieve_subscriber_info"));
Route::post("api/synchronize_vtiger", array('uses' => "AdminSubscribersAPIController@synchronize_vtiger"));  
Route::post("/api/retrieve_latest_msisdn_info", "AdminSubscribersAPIController@retrieve_latest_msisdn_info");

Route::post("api/itravelsim/create_reload", array('uses' => "ITravelSimReloadAPIController@create_reload"));
Route::post("api/itravelsim/create_pin_reload", array('uses' => "ITravelSimReloadAPIController@create_pin_reload"));
Route::post("api/itravelsim/update_pin_reload_used", array('uses' => "ITravelSimReloadAPIController@update_pin_reload_used"));
Route::post("api/itravelsim/get_subs_info_by_msisdn", array('uses' => "ITravelSimAPIController@get_subs_info_by_msisdn"));
Route::post("api/itravelsim/update_subs_info", array('uses' => "ITravelSimAPIController@update_subs_info"));
Route::post("api/itravelsim/get_sim_info", array('uses' => "ITravelSimAPIController@get_sim_info"));
Route::post("api/itravelsim/send_sms", array('uses' => "ITravelSimAPIController@send_sms"));
Route::post("api/itravelsim/create_registration", array('uses' => "ITravelSimRegistrationAPIController@create_registration"));

Route::post("api/retrieve_transaction_sim_change", array('uses' => "AdminSimChangeAPIController@retrieve_transaction"));

Route::post("/api/retrieve_msisdn_status", "PrepaidOrderAPIController@retrieve_msisdn_status");

Route::get('api/test', function(){ 
		return View::make('test');
});

Route::get("api/encrypt/{pin}", function($pin){ 
		return Crypt::encrypt($pin);
});

Route::get("api/decrypt/{pin}", function($pin){ 
		return Crypt::decrypt($pin);
});