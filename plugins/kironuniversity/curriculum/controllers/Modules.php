<?php namespace Kironuniversity\Curriculum\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use BackendAuth;
use Log;
use Input;
use Request;
use DB;
use App;
use Config;
use Kironuniversity\Curriculum\Models\Competency;
use Kironuniversity\Curriculum\Models\CompetencyModule;
use Kironuniversity\Curriculum\Classes\LPSolve;
use Kironuniversity\Curriculum\Classes\Curriculum;
/**
* Modules Back-end Controller
*/
class Modules extends Controller
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
    BackendMenu::setContext('Kironuniversity.Curriculum', 'curriculum', 'modules');
  }

  public function update($recordId, $context = null)
  {

    // Call the FormController behavior update() method

    return $this->asExtension('FormController')->update($recordId, $context);
  }

  public function formBeforeUpdate($model){
    //  dd($this->prepareModelsToSave($model, $this->formWidget->getSaveData()));
  }

  private function makeCMCList($id){
    $competencyModule =CompetencyModule::where('module_id', $id)->get();
    $statusOptions = ['new', 'propose','rejected','accepted', 'inactive'];
    return $this->makePartial('cmclist', ['competencies' => $competencyModule,
    'statusOptions' => $statusOptions]);
  }

  public function renderCMCList(){
    echo $this->makeCMCList($this->params[0]);
  }

  public function onReloadCMCList($id){
    return $this->makeCMCList($id);
  }

  public function onUpdateCMCStatus($id){
    $pivotId = Input::get('pivotId');
    $status = Input::get('status');
    DB::table('competency__module__course')->where('id',$pivotId)->update(['status' => $status]);
  }

  public function reorderExtendQuery($query)
  {
    $query->where('module_id', '=', $this->vars['formModel']->id);
  }

  public function onRelationButtonCreate($id){
    Config::set('current_module', $id);
    return $this->asExtension('RelationController')->onRelationButtonCreate();
  }

  public function onRelationClickViewList($id)
  {
    Config::set('current_module', $id);
    return $this->asExtension('RelationController')->onRelationClickViewList();
  }


  public function genmodules(){


    echo "<pre>";
    for($i=1;$i<=100;$i++){
      $curriculum = new Curriculum();
      $curriculum->buildCurriculum();
    }
    print_r('yes');

    /*$f = Array(-1, -2, -3, -7, -8, -8);
    $A = Array(Array(5, -3, 2, -3, -1, 2), Array(-1, 0, 2, 1, 3, -3), Array(1, 2, -1, 0, 5, -1));
    $b = Array(-5, -1, 3);
    $e = Array(1, 1, 1);
    $xint = Array(1, 2, 3, 4, 5, 6);
    $vub = Array(1, 1, 1, 1, 1, 1);
    $ret = LPSolve::solve($f,$A,$b,$e,null,$vub,$xint);
    print_r($ret);*/

    echo "</pre>";


    die();
  }

  /*public function onRelationManageAdd($id){
  $result = $this->asExtension('RelationController')->onRelationManageAdd();
  if(Input::has('_relation_field') && Input::get('_relation_field') ==  'competencies'){
  $competencies = Input::get('checked');
  foreach($competencies as $competency){
  $competencyModel = Competency::find($competency);
  $courses = $competencyModel->courses->lists('id');
  $competencyModule =CompetencyModule::where('module_id', $id)->where('competency_id', $competency)->first();
  foreach($courses as $course){
  $competencyModule->courses()->attach($course, ['status' => 'new']);
}
}
}
return $result;
}



public function onRelationButtonUnlink($id){
if(Input::has('_relation_field') && Input::get('_relation_field') ==  'competencies'){
$competencies = Input::get('checked');
foreach($competencies as $competency){
$competencyModule =CompetencyModule::where('module_id', $id)->where('competency_id', $competency)->first();
$competencyModule->courses()->sync([]);
}
}
return $this->asExtension('RelationController')->onRelationButtonUnlink();
}
*/


}
