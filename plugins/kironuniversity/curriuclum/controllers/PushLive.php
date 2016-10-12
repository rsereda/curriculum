<?php namespace Kironuniversity\Curriuclum\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Push Live Back-end Controller
 */
class PushLive extends Controller
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

        BackendMenu::setContext('Kironuniversity.Curriuclum', 'curriuclum', 'pushlive');
    }
}