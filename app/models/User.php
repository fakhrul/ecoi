<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    protected $softDelete = true;
    
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
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

	public function groups()
	{
	    return $this->belongsToMany('AclGroup', 'acl_user_groups','user_id','group_id');
	}

	public function channel()
	{
	    return $this->belongsTo('Channel', 'channel_id','id')->withTrashed();
	}	

	public function channels()
	{
	    return $this->hasMany('Channel', 'id','created_by');
	}

	public function branches()
	{
	    return $this->belongsToMany('Branch', 'branch_user','user_id','branch_id');
	}	

	public function brand()
	{
	    return $this->belongsTo('Brand', 'brand_id','id')->withTrashed();
	}		

	public function brands()
	{
	    return $this->belongsToMany('Brand', 'brand_user','user_id','brand_id');
	}
    
    public function stations()
	{
	    return $this->belongsToMany('Station', 'user_station','user_id','station_id')->withTimestamps();
	}	

}