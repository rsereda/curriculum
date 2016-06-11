<?php namespace Kironuniversity\Curriculum\Models;

use Model;

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

    /*public function getDenominationAttribute(){
      return $this->getPath();
    }*/

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
}
