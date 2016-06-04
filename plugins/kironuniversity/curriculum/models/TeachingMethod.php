<?php namespace Kironuniversity\Curriculum\Models;

use Model;

/**
 * TeachingMethod Model
 */
class TeachingMethod extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'teaching_method';

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
