<?php namespace Kironuniversity\Curriculum\Models;

use Model;
use DB;
/**
* StudyTree Model
*/
class StudyTree extends Model
{

  use \October\Rain\Database\Traits\NestedTree;


  /**
  * @var string The database table used by the model.
  */
  public $table = 'study_tree';

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
  public $belongsToMany = [
    'modules' => ['Kironuniversity\Curriculum\Models\Module', 'table' => 'module__study_tree']
  ];
  public $morphTo = [];
  public $morphOne = [];
  public $morphMany = [];
  public $attachOne = [];
  public $attachMany = [];


  public function getPathAttribute(){
    return $this->getPath();
  }


  public function getPath(){
    $parents = $this->getParents();
    $path = '';
    foreach($parents as $parent){
      $path .= $parent->denomination.'/';
    }
    return $path .= $this->denomination;
  }

  public function courses(){
    return DB::select(DB::raw('SELECT c.*
      FROM study_tree st
      LEFT JOIN module__study_tree mst ON mst.study_tree_id = st.id
      LEFT JOIN study_tree st2 ON st2.nest_left >= st.nest_left AND st2.nest_right <= st.nest_right
      LEFT JOIN module__study_tree mst2 ON mst2.study_tree_id = st2.id
      LEFT JOIN module m ON m.id = mst2.module_id
      LEFT JOIN competency__module cm ON cm.module_id = m.id
      LEFT JOIN competency__module__course cmc ON cmc.competency__module_id = cm.id
      LEFT JOIN course c ON cmc.course_id = c.id and cmc.status = \'accepted\'
      WHERE st.id = '.$this->id.' and c.id is not null
      GROUP BY c.id;'
    ));
  }
}
