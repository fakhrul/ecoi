<?php
class APILog extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_log';
    //protected $dates = ["deleted_at"];
    protected $guarded = [
        "id",
        "created_at",
        "updated_at"
    ];
}
?>