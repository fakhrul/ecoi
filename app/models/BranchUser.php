<?php

class BranchUser extends Eloquent {

    protected $table = "branch_user";
    
    protected $guarded = [
        "id",
    ];

    public function branch()
    {
        return $this->belongsTo('Branch');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }


}