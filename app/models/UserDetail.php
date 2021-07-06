<?php

class UserDetail extends Eloquent {

    protected $table = "user_details";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

   public function users()
    {
        return $this->belongsTo('User');
    }
   
    
    


}