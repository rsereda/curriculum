<?php namespace Kironuniversity\Curriculum\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use BackendAuth;

/**
* Modules Back-end Controller
*/
class Modules extends Controller
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
    BackendMenu::setContext('Kironuniversity.Curriculum', 'curriculum', 'modules');
  }

  public function update($recordId, $context = null)
  {

    // Call the FormController behavior update() method
    return $this->asExtension('FormController')->update($recordId, $context);
  }
}
