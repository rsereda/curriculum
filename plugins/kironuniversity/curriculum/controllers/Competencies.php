<?php namespace Kironuniversity\Curriculum\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use DB;
use Input;
use Kironuniversity\Curriculum\Models\CompetencyModule;

/**
 * Competencies Back-end Controller
 */
class Competencies extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Kironuniversity.Curriculum', 'curriculum', 'competencies');
    }

    public function onRelationManageAdd($id){
      $result = $this->asExtension('RelationController')->onRelationManageAdd();
      if(Input::has('_relation_field') && Input::get('_relation_field') ==  'courses'){
        $courses = Input::get('checked');
        foreach($courses as $course){
          $competencyModules =CompetencyModule::where('competency_id', $id)->get();
          foreach($competencyModules as $competencyModule){
            $competencyModule->courses()->attach($course, ['status' => 'new']);
          }
        }
      }
      return $result;
    }

}
