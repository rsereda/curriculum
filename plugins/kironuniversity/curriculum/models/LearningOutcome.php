<?php namespace Kironuniversity\Curriculum\Models;

use Model;
use Config;
/**
 * LearningOutcome Model
 */
class LearningOutcome extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'learning_outcome';

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
      //'courses' => ['Kironuniversity\Curriculum\Models\Course', 'table' => 'learning_outcome__course'],
      'clusters' => ['Kironuniversity\Curriculum\Models\Cluster', 'table' => 'cluster__learning_outcome'],
      'required' =>
      [
        'Kironuniversity\Curriculum\Models\LearningOutcome',
        'table' => 'learning_outcome__learning_outcome',
        'key' => 'learning_outcome_for_id',
        'otherKey' => 'learning_outcome_required_id',
      ],
      'required_by' =>
      [
        'Kironuniversity\Curriculum\Models\LearningOutcome',
        'table' => 'learning_outcome__learning_outcome',
        'otherKey' => 'learning_outcome_for_id',
        'key' => 'learning_outcome_required_id',
      ],
      'course_groups' => [
        'Kironuniversity\Curriculum\Models\CourseGroup',
        'table' => 'course_group__learning_outcome',
      ]
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function scopeModule($query){
      if(Config::has('current_module') && is_numeric(Config::get('current_module')) && Config::get('current_module') > 0){
        $query->where('module_id', '=', Config::get('current_module'));
      }
      return $query;
    }

}
