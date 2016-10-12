<?php namespace Kironuniversity\Curriculum\Models;

use Model;
use Config;
/**
 * CourseGroup Model
 */
class CourseGroup extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'course_group';

    use \October\Rain\Database\Traits\SoftDelete;
    protected $dates = ['deleted_at'];

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
    public $belongsTo = [
      'module' => ['Kironuniversity\Curriculum\Models\Module'],
    ];
    public $belongsToMany = [
      'courses' => [
        'Kironuniversity\Curriculum\Models\CourseModule',
        'otherKey' => 'course__module_id',
        'table' => 'course_group__course__module',
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

    public function getLearningOutcomesOptions(){
      if(Config::has('current_module')){
        $options = LearningOutcome::where('module_id', '=', Config::get('current_module'))->lists('denomination', 'id');
        if(empty($options)){
          return ['No Learning Outcomes Set for this module'];
        }
        return $options;
      }
      return LearningOutcome::lists('denomination', 'id');
    }

    public function getCoursesOptions(){
      $query = CourseModule::join('course', 'course_id', '=', 'course.id');
      if(Config::has('current_module')){
        $query->where('module_id', '=', Config::get('current_module'));
      }
      $options = $query->lists('course.denomination');
      if(empty($options)){
        $options =  ['No Courses are selected for this module'];
      }
      return $options;
    }


}
