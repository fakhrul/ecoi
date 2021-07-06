<?php

class StationType extends Eloquent {

    protected $table = "station_type";

   public function station(){
        return $this->belongsTo('Station');
   }
   
   public function type(){
        return $this->belongsTo('Type');
   }
    
}