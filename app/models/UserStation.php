<?php

class UserStation extends Eloquent {

    protected $table = "user_station";
 
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


}