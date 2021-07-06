@extends('layouts.default')

@section('page-header')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#add_station, #back_to_station").click(function() {
			$("#loading_panel").addClass("loading-show");
		});
        
        $('.cat').click(function(){
            // Values from MySQL database
            var product = '<?php echo $station_district;?>'; 
            // Convert string to array
            var product_array = product.split(", "); //alert(product); alert(product_array); exit();
            
            var value = $(this).val(); //alert(value);
            var load = $('#load').data('load'); //alert(load);
            var lists = ""; 
            
            for(var cat in load){ 
              if(value === cat){ 
                $.each(load[cat], function(index, value) { //alert(index);
                  var selected = '';  
                  for (val of product_array) {//console.log(val);
                    if(val === index){selected = 'selected'} 
                  }
                  lists += "<option value="+index+" "+selected+">"+value+"</option>";
                });
              }
            }
            
            $('.subcat').html(lists);
            
            $("#states_districts").html($("#states_districts option").sort(function (a, b) {
                return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
            }));
        });
        
        function myFunction(){  
            // Values from MySQL database
            var product = '<?php echo $station_district;?>'; 
            // Convert string to array
            var product_array = product.split(", "); //alert(product); alert(product_array); exit();
            
            var value = $('.cat').val(); //alert(value);
            var load = $('#load').data('load'); //alert(load);
            var lists = ""; 
            
            for(var cat in load){ 
              if(value === cat){ 
                $.each(load[cat], function(index, value) { //alert(index);
                  var selected = '';  
                  for (val of product_array) {//console.log(val);
                    if(val === index){selected = 'selected'} 
                  }
                  lists += "<option value="+index+" "+selected+">"+value+"</option>";
                });
              }
            }
            
            $('.subcat').html(lists);
            
            $("#states_districts").html($("#states_districts option").sort(function (a, b) {
                return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
            }));       
        }
         
         myFunction();                                     
		
	});
</script>
<h3>Edit Station</h3>
@stop
<?
define("PAGETITLE", " | Edit Station");

?>
@section('content')

<!-- if there are creation errors, they will show here -->
@if ($errors->all())
<div class="alert alert-danger">{{ HTML::ul($errors->all()) }}</div>
@endif

<!-- action button start -->
<div class="clearfix">
	<div class="visible-md-block visible-lg-block">
		<a id="back_to_station" type="button" class="btn btn-primary" href="{{ URL::to('station') }}"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back</a>
		<div style="margin-top:8px;"></div>
	</div>
	<div class="visible-xs-block visible-sm-block dropdown">
		<button type="button" data-toggle="dropdown" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Action <span class="caret"></span></button>
		<div style="margin-top:8px;"></div>
		<ul class="dropdown-menu" role="menu">
			<li><a id="back_to_station" href="{{ URL::to('station') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></li>
		</ul>
	</div>
</div>
<!-- action button end -->

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Details</h3>
		</div>
		<div class="panel-body">
            {{ Form::model($station, array('route' => array('station.update', $station->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'form_station')) }}

			<div class="form-group">
				{{ Form::label('station_code', 'Station Code', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('station_code', Input::old('station_code'), array('class' => 'form-control', 'readonly')) }}
				</div>
			</div>
            
            <div class="form-group">
				{{ Form::label('station_name', 'Station Name', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('station_name', Input::old('station_name'), array('class' => 'form-control')) }}
				</div>	
			</div>
                                    
            <div class="form-group">
				{{ Form::label('latitude', 'Latitude', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('latitude', Input::old('latitude'), array('class' => 'form-control','step'=>'any')) }}
				</div>	
			</div>
            
            <div class="form-group">
				{{ Form::label('longtitude', 'Longtitude', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('longtitude', Input::old('longtitude'), array('class' => 'form-control','step'=>'any')) }}
				</div>	
			</div>
            
            <div class="form-group">
				{{ Form::label('house_type', 'House Type', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5">		
					{{ Form::text('house_type', Input::old('house_type'), array('class' => 'form-control', 'placeholder' => 'G (E)')) }}
				</div>	
			</div>
            
            <div class="form-group">
    			{{ Form::label('state', 'States', array('class' => 'col-sm-2 control-label')) }}
    			<div class="col-sm-5">        
                    {{ Form::select('states', $states, $station->station_state, array('class' => 'form-control cat' )) }}           																			
    			</div>	
    		</div>                        
            
           <div class="form-group">
    			{{ Form::label('states_districts', 'District', array('class' => 'col-sm-2 control-label')) }}
    			<div class="col-sm-5">        
                    <select name="states_districts" id="states_districts" class="form-control subcat">
                      <option value="">- Select A State To Select District -</option>
                    </select>
                    <div id="load" data-load='{{$states_districts}}'></div>   <br/>      																			
    			</div>	
    		</div>
            
            <div class="form-group">
				{{ Form::label('types', 'Types', array('class' => 'col-sm-2 control-label')) }}
				<div class="col-sm-5"> 
					@foreach($types as $key => $type)	
					<label class="radio-inline" style="width:200px; padding-left:0px; margin-left:0px;">
                        {{ Form::checkbox('types[]', $type->id, in_array($type->id, $station_types) ) }} {{ $type->type_description }}
                        {{-- Form::label('quantity'.$type->type_code, $type->type_code.' Quantity', array('class' => 'col-sm-5 control-label')) --}}		
    					{{ Form::text('quantity'.$type->id,  (array_key_exists($type->id, $station_types_quantity)) ? $station_types_quantity[$type->id] : 0, array('class' => 'form-control', 'max' => 9, 'type' => 'number', 'style' => 'width:50px; padding-left:0px; margin-left:0px;')) }}
                    </label>
					@endforeach																				
				</div>	
			</div>                                                       

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					 <button id="add_station" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;Submit</button>		 
				</div>	
			</div>           

			{{ Form::close() }}
		</div>
	</div>

@stop