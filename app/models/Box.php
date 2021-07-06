<?php

class Box extends Eloquent {

    protected $table = "inventory_box";
 
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

	public function section()
    {
        return $this->belongsTo('Section','section_id','id')->withTrashed();
    }

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

    public function simcards()
    {
        return $this->hasMany('Simcard');
    }       

    public function pins()
    {
        return $this->hasMany('Pin');
    }   

}