<?php

class APIAccountConfig extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'api_account_config';

	protected $dates = ["deleted_at"];

	protected $softDelete = true;
	
	protected $guarded = [
        "id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}
?>