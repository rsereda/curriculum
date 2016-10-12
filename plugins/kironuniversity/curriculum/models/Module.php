<?php namespace Kironuniversity\Curriculum\Models;

use Model;
use BackendAuth;
use Kironuniversity\Curriculum\Models\Course;
use DB;
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

  use \October\Rain\Database\Traits\SoftDelete;
  protected $dates = ['deleted_at'];

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
    'courses' => ['Kironuniversity\Curriculum\Models\Course', 'table' => 'course__module', 'pivot' => ['id']],
  ];

  public $hasManyThrough = [
       'course_groups' => [
           'Kironuniversity\Curriculum\Models\CourseGroup',
           'through' => 'Kironuniversity\Curriculum\Models\LearningOutcome'
       ],
   ];
  public $morphTo = [];
  public $morphOne = [];


  use \October\Rain\Database\Traits\Revisionable;

  /**
  * @var array Monitor these attributes for changes.
  */
  protected $revisionable = ['denomination', 'cp', 'duration','responsible_user_id',
    'da_link', 'rank', 'ready'];

  /**
  * @var array Relations
  */
  public $morphMany = [
    'revision_history' => ['System\Models\Revision', 'name' => 'revisionable']
  ];


  public $attachOne = [];
  public $attachMany = [];

  public function beforeSave(){
    $this->updated_by = BackendAuth::getUser()->id;
  }

  public function usedCourses(){
   return Course::select('course.*')->
           join('course__module', 'course_id', '=', 'course.id')->
           join('course_group__course__module', 'course__module_id', '=', 'course__module.id')->
           join('course_group__learning_outcome', 'course_group__course__module.course_group_id', '=', 'course_group__learning_outcome.course_group_id')->
           join('learning_outcome', 'learning_outcome_id', '=', 'learning_outcome.id')->
           where('learning_outcome.module_id', '=', $this->id)->
           groupBy('course.id')->get();

  }

  public function scopeStudyProgram($query, $studyProgramID){
    $result = DB::select(DB::raw("SELECT DISTINCT m.id FROM module m
    JOIN study_tree st ON st.id = {$studyProgramID}
  	JOIN study_tree st2 ON st2.nest_left > st.nest_left AND st2.nest_right < st.nest_right
  	JOIN module__study_tree mst ON m.id = mst.module_id and mst.study_tree_id = st2.id"), [], false);
    $ids = [];
    foreach($result as $id){
      $ids[] = $id->id;
    }
    return $query->whereIn('id', $ids);
  }

}
