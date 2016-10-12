<?php namespace Kironuniversity\General\Models;

use Model;

/**
 * account Model
 */
class Account extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'account';

    /**
     * @var array Guarded fields
     */


    /**
     * @var array Fillable fields
     */
    protected $guarded = [];

    protected $connection = 'plan';

    public $timestamps = false;

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    protected function getDateFormat(){
      return 'Y-m-d H:i:sO';
    }

}
