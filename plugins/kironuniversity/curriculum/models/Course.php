<?php namespace Kironuniversity\Curriculum\Models;

use Model;
use DB;
/**
* Course Model
*/
class Course extends Model
{

  /**
  * @var string The database table used by the model.
  */
  public $table = 'course';
  use \October\Rain\Database\Traits\Validation;

  use \October\Rain\Database\Traits\SoftDelete;
  protected $dates = ['deleted_at'];

  public $rules = [
    'denomination' => 'required',
    'platform_id' => 'required',
    'course_level_id' => 'required',
    'certificate' => 'required',
    'weeks' => 'required',
    'workload' => 'required'
  ];





  /**
  * @var array Guarded fields
  */
  protected $guarded = ['id'];

  /**
  * @var array Fillable fields
  */
  protected $fillable = [];



  public function getDates()
  {
    return [];
  }

  /**
  * @var array Relations
  */
  public $hasOne = [
  ];
  public $hasMany = [

  ];
  public $belongsTo = [
    'course_level' => ['Kironuniversity\Curriculum\Models\Level', 'key' => 'course_level_id'],
    'platform' => ['Kironuniversity\Curriculum\Models\Platform', 'key' => 'platform_id'],
  ];
  public $belongsToMany = [
    'examtypes' => ['Kironuniversity\Curriculum\Models\ExamType', 'table' => 'course__exam_type'],
    'modules' => ['Kironuniversity\Curriculum\Models\Module', 'table' => 'course__module'],
    /*
    'competency_modules' => ['Kironuniversity\Curriculum\Models\CompetencyModule', 'table' => 'competency__module__course','otherKey'=>'competency__module_id',
    'pivot' => ['status','id']],
    */
    'languages' => ['Kironuniversity\Curriculum\Models\Language', 'table' => 'course__language'],
    'subtitles' => ['Kironuniversity\Curriculum\Models\Language', 'table' => 'course__subtitle'],
    'required' =>
    [
      'Kironuniversity\Curriculum\Models\Course',
      'table' => 'course__course',
      'key' => 'course_for_id',
      'otherKey' => 'course_required_id',
    ],
    'required_by' =>
    [
      'Kironuniversity\Curriculum\Models\Course',
      'table' => 'course__course',
      'otherKey' => 'course_for_id',
      'key' => 'course_required_id',
    ],
  ];
  public $morphTo = [];
  public $morphOne = [];


  use \October\Rain\Database\Traits\Revisionable;

  /**
  * @var array Monitor these attributes for changes.
  */
  protected $revisionable = ['denomination', 'workload', 'start_date', 'platform_id', 'end_date',
    'university', 'certificate', 'link', 'syllabus',
    'short_description', 'long_description', 'status', 'notes', 'lecturer_contacted'];

  /**
  * @var array Relations
  */
  public $morphMany = [
    'revision_history' => ['System\Models\Revision', 'name' => 'revisionable']
  ];

  public $attachOne = [];
  public $attachMany = [];

}
