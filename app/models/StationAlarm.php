<?php

class StationAlarm extends Eloquent {

    protected $table = "station_alarm";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

   public function station()
    {
        return $this->belongsTo('Station');
    }
    
   public function alarm()
    {
        return $this->belongsTo('Alarm');
    }
}