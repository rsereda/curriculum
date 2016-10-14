<?php namespace Kironuniversity\General;

use Backend;
use Event;
use System\Classes\PluginBase;
use Log;
use Redirect;

/**
* general Plugin Information File
*/
class Plugin extends PluginBase
{

    public $elevated = true;
  /**
  * Returns information about this plugin.
  *
  * @return array
  */
  public function pluginDetails()
  {
    return [
      'name'        => 'general',
      'description' => 'General configuration',
      'author'      => 'kironuniversity',
      'icon'        => 'icon-leaf'
    ];
  }


  public function boot(){



    /*\Backend\Controllers\Auth::extend(function($controller) {
      //ob_get_clean();
      //Redirect::to('/backend/martin/ssologin/google');
      if(!env('DEBUG', false)){
        header('Location: /backend/martin/ssologin/google');
        die();
      }
    });*/




    Event::listen('backend.menu.extendItems', function($manager) {

      $manager->removeMainMenuItem('October.Cms', 'cms');
      $manager->removeSideMenuItem('October.Cms', 'cms', 'pages');

    });
  }

}
