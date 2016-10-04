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
