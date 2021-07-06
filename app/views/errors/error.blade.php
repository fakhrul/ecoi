@extends(!empty(Auth::user()->channel_id)? 'layouts.default':'layouts.admin_default')

@section('content')

<div class="alert alert-danger">Something went wrong, kindly contact nazer@hdls.com.my for further assistance.</div>

@stop