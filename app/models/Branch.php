<?php

class Branch extends Eloquent {

    protected $table = "branch";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function users()
    {
        return $this->hasMany('User');
    }

    public function channel()
    {
        return $this->belongsTo('Channel')->withTrashed();
    }    

    public function msisdn()
    {
        return $this->hasMany('BranchMsisdn');
    }

    public function createUser()
    {
        return $this->belongsTo('User','created_by','id')->withTrashed();
    } 

    public function updateUser()
    {
        return $this->belongsTo('User','updated_by','id')->withTrashed();
    }     


}