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
    'learning_outcomes' => ['Kironuniversity\Curriculum\Models\LearningOutcome', 'table' => 'course__learning_outcome'],
    /*'competency_modules' => ['Kironuniversity\Curriculum\Models\CompetencyModule', 'table' => 'competency__module__course','otherKey'=>'competency__module_id',
    'pivot' => ['status','id']],*/
    'languages' => ['Kironuniversity\Curriculum\Models\Language', 'table' => 'course__language'],
    'subtitles' => ['Kironuniversity\Curriculum\Models\Language', 'table' => 'course__subtitle'],
  ];
  public $morphTo = [];
  public $morphOne = [];
  public $morphMany = [];
  public $attachOne = [];
  public $attachMany = [];

}
