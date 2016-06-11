<?php namespace Kironuniversity\Curriculum\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Backend;
use Kironuniversity\Curriculum\Models\StudyTree as StudyTreeModel;
use Kironuniversity\Curriculum\Models\CompetencyModule;
/**
* Study Tree Back-end Controller
*/
class StudyTree extends Controller
{
  public $implement = [
    'Backend.Behaviors.FormController',
    'Backend.Behaviors.ListController',
    'Backend.Behaviors.RelationController',
    'Backend.Behaviors.ReorderController',
  ];

  public $formConfig = 'config_form.yaml';
  public $listConfig = 'config_list.yaml';
  public $relationConfig = 'config_relation.yaml';
  public $reorderConfig = 'config_reorder.yaml';

  public function __construct()
  {
    parent::__construct();
    BackendMenu::setContext('Kironuniversity.Curriculum', 'curriculum', 'studytree');
  }

  public function reorder(){
    BackendMenu::setContext('Kironuniversity.Curriculum', 'curriculum', 'studytreereorder');
    parent::reorder();
  }



  public function renderTree($nodes){
    echo '<ul>';
    foreach($nodes as $node){
      echo '<li>
      <a href="'.Backend::url('kironuniversity/curriculum/studytree/update/'.$node->id).'">'.
      $node->denomination.'</a>';
      if($node->children->isEmpty()){
        if(!$node->modules->isEmpty()){
          echo '<ul>';
          foreach($node->modules as $module){
            echo '<li>
            <a href="'.Backend::url('kironuniversity/curriculum/modules/update/'.$module->id).'">'.
            $module->denomination.'</a>';
            echo '(';
            foreach($module->courses() as $course){
              echo '<a href="'.Backend::url('kironuniversity/curriculum/courses/update/'.$course->id).'">'.
              $course->denomination.'</a>';
            }
            echo ')';
          }
          echo '</ul>';
        }
      }else{
        $this->renderTree($node->children);
      }
      echo '</li>';

    }
    echo '</ul>';
  }

  public function view(){
    $this->vars['roots'] = StudyTreeModel::whereNull('parent_id')->get();
  }
}
