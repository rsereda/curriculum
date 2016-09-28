<?php namespace Kironuniversity\Curriculum\Models;

use Model;

/**
 * LearningOutcome Model
 */
class LearningOutcome extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'kironuniversity_curriculum_learning_outcomes';

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