<?php

class Brand extends Eloquent {

    protected $table = "brands";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

   public function channels(){
        return $this->hasMany('Channel');
   }

   public function users(){
        return $this->hasMany('User');
   }      

   public function msisdn(){
        return $this->hasMany('Msisdn');
   }
   
   public function createUser(){
        return $this->belongsTo('User','created_by','id')->withTrashed();
   }  

   public function updateUser(){
        return $this->belongsTo('User','updated_by','id')->withTrashed();
   }  

   public function deleteUser(){
        return $this->belongsTo('User','deleted_by','id')->withTrashed();
   }               


}