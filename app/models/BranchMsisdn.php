<?php

class BranchMsisdn extends Eloquent {

    protected $table = "branch_msisdn";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

   public function branch()
    {
        return $this->belongsTo('Branch');
    }


}