<?php namespace Kironuniversity\General\Models;

use Model;

/**
 * Auth Model
 */
class Auth extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'auth';

    /**
     * @var array Guarded fields
     */


    /**
     * @var array Fillable fields
     */
    protected $guarded = [];

    public $timestamps = false;

    public $connection = 'plan';
    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = ['account' => ['Kironuniversity\General\Models\Account','key' => 'user']];
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
