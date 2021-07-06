<?php

class Product extends BaseModel {

    protected $table = "product";

    protected $stiClassField = 'product_type';

    protected $stiBaseClass = 'Product';
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

   public function reload()
    {
        return $this->hasMany('Reload');
    }   

   public function productAmount()
    {
        return $this->hasMany('ProductReloadAmount','product_id','id');
    }  

   public function productCategory()
    {
        return $this->belongsTo('ProductCategory');
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