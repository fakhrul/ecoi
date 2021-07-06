@extends('layouts.admin_default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#edit_group, #back_to_group").click(function() {
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
<h3>Edit Group</h3>

@stop
<?
define("PAGETITLE", " | Edit Group");
?>
@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif
	<div class="clearfix">
		<div class="visible-md-block visible-lg-block">
			<a id="back_to_group" type="button" class="btn btn-primary" href="{{ URL::to('admin/groups/' . $groups->id) }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
			<div style="margin-top:8px;"></div>
		</div>
		<div class="visible-xs-block visible-sm-block dropdown">
			<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
			<div style="margin-top:8px;"></div>
			<ul class="dropdown-menu" role="menu">
				<li><a id="back_to_group" href="{{ URL::to('admin/groups/' . $groups->id) }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
			</ul>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
		{{ Form::model($groups, array('route' => array('admin.groups.update', $groups->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
    
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
                    {{ Form::select('permission[]', $permission, $groups_permission, array('id' => 'permission', 'multiple' => 'multiple', 'class' => 'form-control') ) }}           																			
    			</div>	
    		</div>                              
    
    		<div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
    				 <button id="edit_group" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>		 
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
                    placeholder : 'Select Permission',
                    search      : true,
                    selectAll   : true
                });
            </script>

		{{ Form::close() }}
    	</div>
    </div>

@stop