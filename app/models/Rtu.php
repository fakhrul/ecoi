<?php

class Rtu extends Eloquent {

    protected $table = "rtu";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];
    
    public function stations(){
        return $this->belongsToMany('Station', 'station_rtu', 'rtu_id', 'station_id');
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