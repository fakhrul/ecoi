<?php

class Device extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'device';

    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

   public function station()
	{
	    return $this->hasMany('StationAlarm', 'id','alarm_id');
	}

   public function stations()
	{
	    return $this->hasMany('Station');
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