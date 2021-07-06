@extends('layouts.default')

@section('page-header')
<h3>Manage Channels</h3>
@stop

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
		  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</button>
		  	<a type="button" class="btn btn-primary" href="/channels/create"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</a>
			<div style="margin-top:8px;"></div>
		</div>

		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#" data-toggle="modal" data-target=".btn-search"><span class="glyphicon glyphicon-search"></span> Search</a></li>
				<li><a href="/channels/create"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
			</ul>
		</div>
	</div>
<div class="panel panel-default ">
		<div class="panel-heading clearfix">
			<form class="form-inline" role="form">
				<div class="pull-left">Showing {{ $list->getFrom(); }} - {{ $list->getTo(); }} of {{ $list->getTotal(); }} entries.</div>
				<div class="form-group pull-right" style="margin-bottom:0px;">
						<label>Entries Per Page</label>
						{{ Form::select('paging',array('5' => '5', '10' => '10', 
						'20' => '20', '50' => '50', '100' => '100', '200' => '200'), $list->getPerPage(), array('class' => 'form-control', 'style' => 'style="width:80px;display:inline;', 'onchange' => 'window.location = "/channels/?paging=" + this.value;')) }}
					</div>
			</form>
		</div>
		<div class="table-responsive">	
			<table class="table table-hover table-striped table-bordered">
					<tr>
						<th>No.</td>
						<th>ID</a></td>
						<th><a href="{{ URL::route('channels.index') }}?sort=name">Name</a></td>
						<th>Type</a></td>
						<th>Upline</td>			
						<th>Action</td>
					</tr>

				@foreach($list as $key => $value)
					<tr>
						<td>{{ $key+1 }}</td>
						<td>{{ $value->channel_id }}</td>
						<td>{{ $value->name }}</td>
						<td>{{ $value->type }}</td>			
						<td>{{ $value->upline->name }}</td>

						<!-- we will also add show, edit, and delete buttons -->
						<td>

				@if (false and allowed('channels.destroy'))
				<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
				<!-- we will add this later since its a little more complicated than the other two buttons -->
				{{ Form::open(array('url' => 'channels/' . $value->id)) }}
				{{ Form::hidden('_method', 'DELETE') }}
				{{ Form::submit('Delete', array('class' => 'btn btn-warning pull-right')) }}
				{{ Form::close() }}
				@endif				

				@if (allowed('channels.show'))
				<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
				<a href="{{ URL::to('channels/' . $value->id) }}">View</a>
				@endif
				/
				@if (allowed('channels.edit'))
				<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
				<a href="{{ URL::to('channels/' . $value->id . '/edit') }}">Edit</a>
				@endif




					</td>
				</tr>
			@endforeach

		</table>
	</div>
</div>

{{ $list->appends(array('paging' => $list->getPerPage(), 'name' => Input::get('name'),'type' => Input::get('type')))->links(); }}

<div class="modal fade btn-search" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">
 					<span class="glyphicon glyphicon-search"></span>
					Search Channels
				</h4>
		    </div>
    	<div class="modal-body">
			<form class="form-horizontal" role="form" method="GET">
		  		<div class="form-group">
		    		<label for="name" class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-4">
				    	<input type="text" class="form-control" id="name" name='name' placeholder="Channel Name">
				    </div>
		  		</div>
		  		<div class="form-group">
		    		<label for="upline" class="col-sm-2 control-label">Upline Name</label>
				    <div class="col-sm-4">
						{{ Form::select('upline',$upline_options, Input::get('upline'), array('class' => 'form-control')) }}
				    </div>
		  		</div>		  		
			  	<div class="form-group">
			    	<label for="type" class="col-sm-2 control-label">Type</label>
			    	<div class="col-sm-4">
						{{ Form::select('type',array('' => 'All', 'MD' => 'Master Distributor', 'DS' => 'Distributor', 'D' => 'Dealer'), Input::get('type'), array('class' => 'form-control')) }}
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="status" class="col-sm-2 control-label">Status</label>
			    	<div class="col-sm-4">
						{{ Form::select('status',array('A' => 'All', '' => 'Active', 
						'D' => 'Inactive'), Input::get('status'), array('class' => 'form-control')) }}
			    	</div>
			  	</div>	

			  	<div class="col-sm-offset-2">
		 			<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</button>
		  			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>	  			
		  		</div>
			</form>
		</div>
		</div>
	</div>
</div>


@stop