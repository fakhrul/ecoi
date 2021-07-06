<?php

class StationStatus extends Eloquent {

    protected $table = "station_status";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

   public function station(){
        return $this->belongsTo('Station');
    }
    
}