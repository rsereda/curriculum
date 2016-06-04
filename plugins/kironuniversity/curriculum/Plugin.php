<?php namespace Kironuniversity\Curriculum;

use Backend;
use System\Classes\PluginBase;
use Event;

/**
* curriculum Plugin Information File
*/
class Plugin extends PluginBase
{


  /**
  * Returns information about this plugin.
  *
  * @return array
  */
  public function pluginDetails()
  {
    return [
      'name'        => 'curriculum',
      'description' => 'Backend for the curriculum team',
      'author'      => 'kironuniversity',
      'icon'        => 'icon-database'
    ];
  }

  public function boot(){
    Event::listen('backend.menu.extendItems', function($manager) {

      $manager->removeMainMenuItem('October.Cms', 'cms');
      $manager->removeMainMenuItem('October.Cms', 'media');

    });
  }


  public function registerPermissions()
  {
    return [
      'kironuniversity.curriculum.edit_curriculum'       => ['label' => 'Edit Curriculum', 'tab' => 'Curriculum']
    ];
  }

  /**
  * Registers back-end navigation items for this plugin.
  *
  * @return array
  */
  public function registerNavigation()
  {
    return [
      'curriculum' => [
        'label'       => 'Curriculum',
        'url'         => Backend::url('kironuniversity/curriculum/courses'),
        'icon'        => 'icon-graduation-cap',
        'permissions' => ['kironuniversity.curriculum.*'],
        'order'       => 600,

        'sideMenu' => [
          'availablecourses' => [
            'label'       => 'Available Courses',
            'icon'        => 'icon-video-camera',
            'url'         => Backend::url('kironuniversity/curriculum/availablecourses'),
            'permissions' => ['kironuniversity.curriculum.*']
          ],
          'courses' => [
            'label'       => 'Courses',
            'icon'        => 'icon-video-camera',
            'url'         => Backend::url('kironuniversity/curriculum/courses'),
            'permissions' => ['kironuniversity.curriculum.*']
          ],
          'competencies' => [
            'label'       => 'Competency',
            'icon'        => 'icon-puzzle',
            'url'         => Backend::url('kironuniversity/curriculum/competencies'),
            'permissions' => ['kironuniversity.curriculum.*']
          ],
          'modules' => [
            'label'       => 'Modules',
            'icon'        => 'icon-cubes',
            'url'         => Backend::url('kironuniversity/curriculum/modules'),
            'permissions' => ['kironuniversity.curriculum.*']
          ],
          'studytree' => [
            'label' => 'Study Tree',
            'icon' => 'icon-tree',
            'url' => Backend::url('kironuniversity/curriculum/studytree'),
            'permissions' => ['kironuniversity.curriculum.*']
          ],
          'studytreereorder' => [
            'label' => 'Order Study Tree',
            'icon' => 'icon-tree',
            'url' => Backend::url('kironuniversity/curriculum/studytree/reorder'),
            'permissions' => ['kironuniversity.curriculum.*']
          ],
          'partneruniversities' => [
            'label' => 'Partner University',
            'icon' => 'icon-university',
            'url' => Backend::url('kironuniversity/curriculum/partneruniversities'),
          ],
        ]
      ],
      'predefined' => [
        'label'       => 'Predefined',
        'url'         => Backend::url('kironuniversity/curriculum/teachingmethods'),
        'icon'        => 'icon-database',
        'permissions' => ['kironuniversity.curriculum.*'],
        'order'       => 700,

        'sideMenu' => [
          'teachingmethods' => [
            'label' => 'Teaching Methods',
            'icon' => 'icon-cogs',
            'url' => Backend::url('kironuniversity/curriculum/teachingmethods'),
          ],
          'examtypes' => [
            'label' => 'Exam Types',
            'icon' => 'icon-book',
            'url' => Backend::url('kironuniversity/curriculum/examtypes'),
          ],
          'platforms' => [
            'label'       => 'Platforms',
            'icon'        => 'icon-globe',
            'url'         => Backend::url('kironuniversity/curriculum/platforms'),
            'permissions' => ['kironuniversity.curriculum.*']
          ],
          'levels' => [
            'label'       => 'Levels',
            'icon'        => 'icon-tachometer',
            'url'         => Backend::url('kironuniversity/curriculum/levels'),
            'permissions' => ['kironuniversity.curriculum.*']
          ],
          'languages' => [
            'label'       => 'Languages',
            'icon'        => 'icon-flag',
            'url'         => Backend::url('kironuniversity/curriculum/languages'),
            'permissions' => ['kironuniversity.curriculum.*']
          ],
        ],
      ],
    ];
  }

  public function registerSchedule($schedule)
  {
    // Update the AvailableCourse database once a day
    //$schedule->call(function(){(new Controllers\AvailableCourses)->scrapeCourses();})->daily();
  }

}
