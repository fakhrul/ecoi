<?php

class Section extends Eloquent {

    protected $table = "inventory_section";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

	public function branch()
    {
        return $this->belongsTo('Branch','branch_id','id')->withTrashed();
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

    public function boxes()
    {
        return $this->hasMany('Box');
    }      

}