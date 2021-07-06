@extends('layouts.admin_default')
@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#add_group, #back_to_group").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
        
        //SELECT2
        $(".js-example-basic-multiple").select2();
        $("#checkbox").click(function(){
            if($("#checkbox").is(':checked') ){
                //$("#permission > option").prop("selected","selected");// Select All Options
                $("#permission").find('option').prop("selected",true);
                $("#permission").trigger("change");// Trigger change to select 2
            }else{
                //$("#permission > option").removeAttr("selected");
                $("#permission").find('option').prop("selected",false);
                $("#permission").trigger("change");// Trigger change to select 2
             }
        });
		
	});
</script>
<h3>Add Group</h3>
@stop
<?
define("PAGETITLE", " | Add Group");

?>
@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

<!-- action button start -->
<div class="clearfix">
	<div class="visible-md-block visible-lg-block">
		<a id="back_to_group" type="button" class="btn btn-primary" href="{{ URL::to('admin/groups') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
		<div style="margin-top:8px;"></div>
	</div>
	<div class="visible-xs-block visible-sm-block dropdown">
		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
		<div style="margin-top:8px;"></div>
		<ul class="dropdown-menu" role="menu">
			<li><a id="back_to_group" href="{{ URL::to('admin/groups') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
		</ul>
	</div>
</div>
<!-- action button end -->

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
			{{ Form::open(array('url' => 'admin/groups', 'class' => 'form-horizontal', 'role' => 'form')) }}

			<div class="form-group">
				{{ Form::label('name', 'Name', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('description', 'Description', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
				</div>
			</div>
            
            <div class="form-group">
				{{ Form::label('permission', 'Permission', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">	
                    <!-- jQuery MultiSelect  -->
                    {{ Form::select('permission[]', $permission, NULL, array('id' => 'permission', 'multiple' => 'multiple', 'class' => 'form-control') ) }}
                    <!-- using select2
                    <select multiple="multiple" name="permission[]" id="permission" class="js-example-basic-multiple form-control">
                        @foreach($permission as $id => $value)
                            <option value="{{$id}}">{{$value}}</option>
                        @endforeach
                    </select> <input type="checkbox" id="checkbox" >Select All-->                   
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					 <button id="add_group" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>		 
				</div>	
			</div>
            
            <script type="text/javascript">
                //select2
                var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];
                $(".js-example-data-array").select2({
                  data: data
                })
                $(".js-example-data-array-selected").select2({
                  data: data
                })
                //jQuery MultiSelect
                $('select[multiple]').multiselect({
                    columns     : 1,
                    search      : true,
                    selectAll   : true,
                    texts    : {
                        placeholder: 'Select Permission',
                        search     : 'Search Permission'
                    }
                });
            </script>

			{{ Form::close() }}
		</div>
	</div>
    
@stop