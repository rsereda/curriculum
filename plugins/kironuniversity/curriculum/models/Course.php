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
        'workload' => 'required',
        'cp' => 'required',
    ];


  /**
  * @var array Guarded fields
  */
  protected $guarded = ['*'];

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
/*    'modules' => [
      'Kironuniversity\Curriculum\Models\Module',
      'table' => 'course_modules__module_courses',
      'key' => 'course_modules',
      'otherKey' => 'module_courses',
    ],*/
    'examtypes' => ['Kironuniversity\Curriculum\Models\Examtype', 'table' => 'course__exam_type'],
    'competencies' => ['Kironuniversity\Curriculum\Models\Competency', 'table' => 'competency__course']
  ];
  public $morphTo = [];
  public $morphOne = [];
  public $morphMany = [];
  public $attachOne = [];
  public $attachMany = [];

}
