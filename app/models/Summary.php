<?php

class Summary extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = "summary";
    
    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];
    
    public function station(){
        return $this->hasMany('Station', 'station_id', 'id');
    }
    
    public function activeStation() {
        return $this->station()->where('status','=', 1);
    }
    
    public function state(){
        return $this->belongsTo('State','station_state','id');
    }
    
    public function district(){
        return $this->belongsTo('District','station_district','id');
    }
    
    public function createUser(){
        return $this->belongsTo('User','created_by','id')->withTrashed();
   }  

   public function updateUser(){
        return $this->belongsTo('User','updated_by','id')->withTrashed();
   }  

   public function deleteUser(){
        return $this->belongsTo('User','deleted_by','id')->withTrashed();
   } 
}
?>