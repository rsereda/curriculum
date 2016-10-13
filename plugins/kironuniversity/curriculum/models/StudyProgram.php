<?php namespace Kironuniversity\Curriculum\Models;

use Model;

/**
 * StudyProgram Model
 */
class StudyProgram extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'study_program';

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
    public $belongsToMany = [
      'courses' => ['Kironuniversity\Curriculum\Models\Course', 'table' => 'course__study_program'],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
