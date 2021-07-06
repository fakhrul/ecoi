@extends(!empty(Auth::user()->channel_id)? 'layouts.default':'layouts.admin_default')

@section('content')

<div class="alert alert-danger">The page you are looking for is not available.</div>

@stop