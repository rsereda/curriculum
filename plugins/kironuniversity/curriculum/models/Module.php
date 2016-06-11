<?php namespace Kironuniversity\Curriculum\Models;

use Model;
use BackendAuth;
use Kironuniversity\Curriculum\Models\Course;
/**
* Module Model
*/
class Module extends Model
{

  /**
  * @var string The database table used by the model.
  */
  public $table = 'module';

  use \October\Rain\Database\Traits\Validation;

  public $rules = [
        'denomination' => 'required',
        'duration' => 'required|numeric',
        'cp' => 'required|numeric',
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
  public $hasOne = [];
  public $hasMany = [];
  public $belongsTo = [
    'responsible_user' => ['Backend\Models\User'],
    'partner_university' => ['Kironuniversity\Curriculum\Models\PartnerUniversity'],
    'updatedBy' => ['Backend\Models\User', 'key' => 'updated_by'],
  ];
  public $belongsToMany = [
    'teaching_methods' => ['Kironuniversity\Curriculum\Models\TeachingMethod', 'table' => 'module__teaching_method'],
    'study_trees' => ['Kironuniversity\Curriculum\Models\StudyTree', 'table' => 'module__study_tree'],
    'competencies' => ['Kironuniversity\Curriculum\Models\Competency', 'table' => 'competency__module'],
  ];
  public $morphTo = [];
  public $morphOne = [];
  public $morphMany = [];
  public $attachOne = [];
  public $attachMany = [];

  public function beforeSave(){
    $this->updated_by = BackendAuth::getUser()->id;
  }

  public function courses(){
    return Course::select('course.*')->
            join('competency__module__course', 'course_id', '=', 'course.id')->
            join('competency__module', 'competency__module_id', '=', 'competency__module.id')->
            join('module', 'module_id', '=', 'module.id')->
            where('module.id', '=', $this->id)->where('status', '=', 'accepted')->
            groupBy('course.id')->get();
  }

}
