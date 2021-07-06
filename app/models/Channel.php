<?php

class Channel extends Eloquent {

    protected $table = "channels";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

   public function downlines()
    {
        return $this->hasMany('Channel','id','upline')->withTrashed();
    }

   public function upline()
    {
        return $this->belongsTo('Channel','upline_id','id')->withTrashed();
    }

   public function brand()
    {
        return $this->belongsTo('Brand');
    }   

   public function users()
    {
        return $this->hasMany('User','id','channel_id');
    }   

   public function salesPerson()
    {
        return $this->hasOne('SalesPerson','id','sales_person');
    }       

   public function products()
    {
        return $this->belongsToMany('Product', 'channel_product','channel_id','product_id');
    }


   public function createUser()
    {
        return $this->belongsTo('User','created_by','id')->withTrashed();
    }  

   public function updateUser()
    {
        return $this->belongsTo('User','updated_by','id')->withTrashed();
    }  

   public function deleteUser()
    {
        return $this->belongsTo('User','deleted_by','id')->withTrashed();
    }                

}