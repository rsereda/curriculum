<?php namespace Kironuniversity\Curriculum\Models;

use Model;
use Config;
/**
* CourseModule Model
*/
class CourseModule extends Model
{

  use \October\Rain\Database\Traits\Sortable;

  use \October\Rain\Database\Traits\SoftDelete;
  protected $dates = ['deleted_at'];

  /**
  * @var string The database table used by the model.
  */
  public $table = 'course__module_agg';

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
    'course' => ['Kironuniversity\Curriculum\Models\Course'],
    'module' => ['Kironuniversity\Curriculum\Models\Module'],
  ];
  public $belongsToMany = [];
  public $morphTo = [];
  public $morphOne = [];
  public $morphMany = [];
  public $attachOne = [];
  public $attachMany = [];


  public function getCourseNameAttribute($value){
    return $this->course->denomination;
  }

  public function scopeModule($query){
    if(Config::has('current_module') && is_numeric(Config::get('current_module')) && Config::get('current_module') > 0){      
      $query->where('module_id', '=', Config::get('current_module'));
    }
    return $query;
  }

}
