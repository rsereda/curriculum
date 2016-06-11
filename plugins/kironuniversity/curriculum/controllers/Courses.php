<?php namespace Kironuniversity\Curriculum\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DB;
use Input;
use Kironuniversity\Curriculum\Models\CompetencyModule;

/**
* Courses Back-end Controller
*/
class Courses extends Controller
{

  public $implement = [
    'Backend.Behaviors.FormController',
    'Backend.Behaviors.ListController',
    'Backend.Behaviors.RelationController',
  ];

  public $formConfig = 'config_form.yaml';
  public $listConfig = 'config_list.yaml';
  public $relationConfig = 'config_relation.yaml';

  public function __construct()
  {
    parent::__construct();
    BackendMenu::setContext('Kironuniversity.Curriculum', 'curriculum', 'courses');
  }


  public function onRelationManageAdd($id){
    $result = $this->asExtension('RelationController')->onRelationManageAdd();
    if(Input::has('_relation_field') && Input::get('_relation_field') ==  'competencies'){
      $competencies = Input::get('checked');
      foreach($competencies as $competency){
        $competencyModules =CompetencyModule::where('competency_id', $competency)->get();
        foreach($competencyModules as $competencyModule){
          $competencyModule->courses()->attach($id, ['status' => 'new']);
        }
      }
    }
    return $result;
  }



  public function onRelationButtonUnlink($id){
    if(Input::has('_relation_field') && Input::get('_relation_field') ==  'competencies'){
      $competencies = Input::get('checked');
      foreach($competencies as $competency){
        $competencyModules =CompetencyModule::where('competency_id', $competency)->get();
        foreach($competencyModules as $competencyModule){
          $competencyModule->courses()->detach($id);
        }
      }
    }
    return $this->asExtension('RelationController')->onRelationButtonUnlink();
  }

}
