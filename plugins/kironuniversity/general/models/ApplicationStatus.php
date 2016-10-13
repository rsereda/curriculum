<?php namespace Kironuniversity\General\Models;

use Model;

/**
 * CheckStatus Model
 */
class ApplicationStatus extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'application_status';

    public $connection = 'plan';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = ['applications' => 'Kironuniversity\General\Models\General'];
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
