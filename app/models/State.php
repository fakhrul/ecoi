<?php

class State extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = "state";
    
    public function stations(){
        return $this->hasMany('Station', 'station_state', 'id');
    }

}
?>