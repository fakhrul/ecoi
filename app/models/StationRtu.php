<?php

class StationRtu extends Eloquent {

    protected $table = "station_rtu";
 
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
   
   public function rtu(){
        return $this->belongsTo('Rtu');
   } 
}