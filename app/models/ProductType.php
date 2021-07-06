<?php

class ProductType extends Eloquent {

    protected $table = "product_type";
     
    protected $guarded = [
        "id"
    ];       

    public function product()
    {
        return $this->hasMany('Product');
    }       

}