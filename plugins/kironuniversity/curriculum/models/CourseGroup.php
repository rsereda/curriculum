<?php namespace Kironuniversity\Curriculum\Models;

use Model;

/**
 * CourseGroup Model
 */
class CourseGroup extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'course_group';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

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
    public $belongsToMany = [
      'courses' => [
        'Kironuniversity\Curriculum\Models\CourseModule',
        'otherKey' => 'course__module_id',
        'table' => 'course_group__course__module'
      ],
      'learning_outcomes' => [
        'Kironuniversity\Curriculum\Models\LearningOutcome',
        'table' => 'course_group__learning_outcome',
      ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
