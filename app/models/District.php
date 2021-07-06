<?php

class District extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = "district";
    
    public function stations(){
        return $this->hasMany('Station', 'station_district', 'id');
    }

}
?>