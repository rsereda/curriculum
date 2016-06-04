<?php namespace Kironuniversity\Curriculum\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
* Study Programs Back-end Controller
*/
class StudyPrograms extends Controller
{
  public $implement = [
    'Backend.Behaviors.FormController',
    'Backend.Behaviors.ListController'
  ];

  public $formConfig = 'config_form.yaml';
  public $listConfig = 'config_list.yaml';

  public function __construct()
  {
    parent::__construct();

    BackendMenu::setContext('Kironuniversity.Curriculum', 'curriculum', 'studyprograms');
  }
}
