<?php

class ProductCategory extends Eloquent {

    protected $table = "product_category";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];       

   public function product()
    {
        return $this->hasMany('Product');
    }      

}