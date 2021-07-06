<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);

	$emails = ['nazer@hdls.com.my'];

	//$cc = ['jin.pat@hdls.com.my','liyin.teo@hdls.com.my','ngaping.sia@hdls.com.my'];
	$cc = ['nazer@hdls.com.my'];

	if(Auth::user()) {
		$details = array(
			'ip' => isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "",
			'user_id' => Auth::user() ? Auth::user()->id : "", 
			'username' => Auth::user() ? Auth::user()->username : "",
			'channel_id' => Auth::user()->channel ? Auth::user()->channel->id : "",		
			'channel_code' => Auth::user()->channel ? Auth::user()->channel->channel_id : "", 
			'channel_name' => Auth::user()->channel ? Auth::user()->channel->name : "",
			'branch_id' => Session::get('branch_id') ? Session::get('branch_id') : "",
			'branch_name' => Session::get('branch_id') ? Branch::find(Session::get('branch_id'))->name : "",
		);	
	}else{
		$details = array('ip' => isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "");
	}


	Mail::send([], [], function ($message) use ($exception,$emails,$cc,$details) {
	  $message->to($emails)->cc($cc)->subject('HDLS ')
	  ->setBody(Route::current()->getPath()." -> ".Route::current()->getName()."\r\n".json_encode(Route::current()->parameters()).json_encode(Input::all())."\r\n\r\n".json_encode($details)."\r\n\r\n".(string)$exception);
	});	

	return Response::view('errors.error');

    //$errors = "Something went wrong, kindly contact administrator for assistance.";

	//Session::flash('message', 'Something went wrong, kindly contact administrator for assistance.');	 

    //return Redirect::to('/')->withErrors($errors);

});


App::fatal(function($exception)
{

	Log::error($exception);

	$emails = ['nazer@hdls.com.my'];

	//$cc = ['jin.pat@hdls.com.my','liyin.teo@hdls.com.my','ngaping.sia@hdls.com.my'];
	$cc = ['nazer@hdls.com.my'];

	if(Auth::user()) {
		$details = array(
			'ip' => isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "",
			'user_id' => Auth::user() ? Auth::user()->id : "", 
			'username' => Auth::user() ? Auth::user()->username : "",
			'channel_id' => Auth::user()->channel ? Auth::user()->channel->id : "",		
			'channel_code' => Auth::user()->channel ? Auth::user()->channel->channel_id : "", 
			'channel_name' => Auth::user()->channel ? Auth::user()->channel->name : "",
			'branch_id' => Session::get('branch_id') ? Session::get('branch_id') : "",
			'branch_name' => Session::get('branch_id') ? Branch::find(Session::get('branch_id'))->name : "",
		);	
	}else{
		$details = array('ip' => isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "");
	}


	Mail::send([], [], function ($message) use ($exception,$emails,$cc,$details) {
	  $message->to($emails)->cc($cc)->subject('HDLS Report')
	  ->setBody(Route::current()->getPath()." -> ".Route::current()->getName()."\r\n".json_encode(Route::current()->parameters()).json_encode(Input::all())."\r\n\r\n".json_encode($details)."\r\n\r\n".(string)$exception);
	});	

	return Response::view('errors.error');

    //$errors = "Something went wrong, kindly contact administrator for assistance.";

	//Session::flash('message', 'Something went wrong, kindly contact administrator for assistance.');	

    //return Redirect::to('/')->withErrors($errors);

});


App::missing(function($e) {

    $url = Request::fullUrl();
    $userAgent = Request::header('user-agent');
    Log::warning("404 for URL: $url requested by user agent: $userAgent");

    //return Response::view('errors.not-found', array(), 404);

    $errors = "The page you are looking for is not available.";

    return Redirect::to('/')->withErrors($errors);

});


App::error(function(Illuminate\Session\TokenMismatchException $exception, $code)
{
    /*
    |    Write to a specific log
    |    Or write the request information to the database for e.g. a firewall mechanism
    |    
    |    Or just:
    */
    
    $errors = [
        '_token' => [
            'Session token expired.'
        ]
    ];
    
    /**
     * Generate a new token for more security
     */
    Session::regenerateToken();

    /**
     * Redirect to the last step
     * Refill any old inputs except _token (it would override our new token)
     * Set the error message
     */
    return Redirect::back()->withInput(Input::except('_token'))->withErrors($errors);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';
require app_path().'/macros.php';
require app_path().'/helpers.php';
require app_path().'/validators.php';
