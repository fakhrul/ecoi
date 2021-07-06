<?php

class Msisdn extends Eloquent {

    protected $table = "msisdn";

    protected $softDelete = true;    
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];


   public function package()
    {
        return $this->belongsTo('PrepaidPackage','package_id','id')->withTrashed();
    }

   public function scheme()
    {
        return $this->belongsTo('PrepaidScheme','scheme_id','id')->withTrashed();
    }

   public function prepaidOrder()
    {
        return $this->hasMany('PrepaidOrder','msisdn','msisdn')->withTrashed();
    }




}