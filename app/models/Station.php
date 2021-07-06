<?php

class Station extends Eloquent {

    protected $table = "station";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];
    
    public function state(){
        return $this->belongsTo('State','station_state','id');
    }
    
    public function district(){
        return $this->belongsTo('District','station_district','id');
    }
    
    public function getStationLabelAttribute(){
        //return $this->attributes['station_name'] .' ('. ucfirst( $this->attributes['station_state'] ).')';
    }
    
    public function alarm(){
	    //return $this->hasMany('StationAlarm', 'id','station_ids');
	}
    
    public function alarms(){
	    //return $this->belongsToMany('Alarm', 'station_alarm', 'station_id', 'alarm_id');
	}
        
    public function status(){
        //return $this->hasMany('StationStatus', 'station_id', 'id');
    }
    
    public function activeStatus(){
        return $this->status()->where('status','=', 1);
    }
    
    public function types(){
	    return $this->belongsToMany('Type', 'station_type','station_id', 'type_id')->withPivot('quantity');
	}
    
    public function users(){
	    return $this->belongsToMany('User', 'user_station','station_id', 'user_id');
	}

    public function createUser(){
        return $this->belongsTo('User','created_by','id')->withTrashed();
    } 

    public function updateUser(){
        return $this->belongsTo('User','updated_by','id')->withTrashed();
    }     


}