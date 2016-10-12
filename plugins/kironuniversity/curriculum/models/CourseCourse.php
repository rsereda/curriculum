<?php namespace Kironuniversity\Curriculum\Models;

use Model;

/**
 * CourseCourse Model
 */
class CourseCourse extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'course__course';

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
