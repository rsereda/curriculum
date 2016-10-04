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
        'duration' => 'numeric',
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
  public $hasMany = [
    'learning_outcomes' => ['Kironuniversity\Curriculum\Models\LearningOutcome'],
    'course_groups' => ['Kironuniversity\Curriculum\Models\CourseGroup'],
  ];
  public $belongsTo = [
    'responsible_user' => ['Backend\Models\User'],
    'partner_university' => ['Kironuniversity\Curriculum\Models\PartnerUniversity'],
    'updatedBy' => ['Backend\Models\User', 'key' => 'updated_by'],
  ];
  public $belongsToMany = [
    'teaching_methods' => ['Kironuniversity\Curriculum\Models\TeachingMethod', 'table' => 'module__teaching_method'],
    'study_trees' => ['Kironuniversity\Curriculum\Models\StudyTree', 'table' => 'module__study_tree'],
    'courses' => ['Kironuniversity\Curriculum\Models\Course', 'table' => 'course__module'],
  ];

  public $hasManyThrough = [
       'course_groups' => [
           'Kironuniversity\Curriculum\Models\CourseGroup',
           'through' => 'Kironuniversity\Curriculum\Models\LearningOutcome'
       ],
   ];
  public $morphTo = [];
  public $morphOne = [];
  public $morphMany = [];
  public $attachOne = [];
  public $attachMany = [];

  public function beforeSave(){
    $this->updated_by = BackendAuth::getUser()->id;
  }

}
