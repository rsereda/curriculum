<?php namespace Kironuniversity\Curriculum\Models;

use Model;

/**
 * PartnerUniversity Model
 */
class PartnerUniversity extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'partner_university';

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
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
