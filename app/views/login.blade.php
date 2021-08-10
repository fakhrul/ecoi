<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<!--  Mobile Viewport Fix -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>{{ Config::get('app.name') }}</title>

	<!-- Bootstrap core CSS -->
	<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('assets/css/bootstrap.customize.css') }}" rel="stylesheet">
</head>
<script type="text/javascript">
	$(document).ready(function() {
		$("#submit").change(function() {
			$("#loading_panel").addClass("loading-show");
		});
	});
</script>

<body>
	<div class="container">
		<div class="ecoi_logo_small"></div>
		<div class="login-form">
			{{ Form::open(array('route'=>'doLogin', 'method'=>'post', 'class'=>'form-horizontal', 'role'=>'form')) }}

			<h3 style="text-align: center;">{{ Config::get('app.fullname'); }} ({{ Config::get('app.name'); }})</h3>

			<div class="login-panel">
				@if ($errors->all())
				<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
				@endif

				@if (Session::has('message'))
				<div class="alert alert-danger">{{ Session::get('message') }}</div>
				@endif

				{{ Form::text('username', Input::old('username'), array('placeholder'=>'Username', 'id'=>'username', 'class'=>'form-control', 'style'=>'margin-bottom:15px')) }}

				{{ Form::password('password', array('placeholder'=>'Password', 'id'=>'password', 'class'=>'form-control', 'style'=>'margin-bottom:15px')) }}

				Captcha:
				{{ $secured_captcha }}
				{{ Form::hidden('generated_captcha', $secured_captcha, array('placeholder'=>'', 'id'=>'generated_captcha', 'class'=>'form-control', 'style'=>'margin-bottom:15px')) }}

				{{ Form::text('captcha', '', array('placeholder'=>'Insert Captcha Number', 'id'=>'captcha', 'class'=>'form-control', 'style'=>'margin-bottom:15px')) }}

				{{ Form::submit('Sign In', array('id'=>'submit','class'=>'btn btn-lg btn-primary btn-block')) }}

				{{ Form::close() }}
			</div>
			<h5 style="text-align: center;">{{ Config::get('app.version'); }}</h5>
			<!-- <h5 style="text-align: center;">Username: superadmin</h5>
            <h5 style="text-align: center;">Password: Superadmin@123</h5> -->
		</div>
	</div> <!-- /container -->
	<!-- Start of LiveChat (www.livechatinc.com) code
    <script type="text/javascript">
        window.__lc = window.__lc || {};
        window.__lc.license = 9036345;
        (function() {
          var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
          lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
        })();
    </script>
    <!-- End of LiveChat code -->
	<!-- Start of UserLike (www.userlike.com) code -->
	<!-- <script async type="text/javascript" src="//userlike-cdn-widgets.s3-eu-west-1.amazonaws.com/c16be916ed0d86c5f4777ae5726636505bc634f33bc2b2b568f6fa1b6021eb50.js"></script> -->
	<!-- End of UserLike code -->

	<!-- loading panel -->
	<div id="loading_panel" class="loading loading-content-effect">
		<div class="loading-content">
			<h4><img src="{{ URL::asset('assets/images/loading.gif') }}" style="margin-top:-4px;">&nbsp;&nbsp;Loading...</h4>
		</div>
	</div>
	<div class="loading-backdrop"></div>
	<!-- loading panel -->
</body>

</html>