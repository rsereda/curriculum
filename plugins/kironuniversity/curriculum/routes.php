<?php

  use DB;
  use Kironuniversity\Curriculum\Classes\Curriculum;

  Route::get('updatecurriculumforstudent/{id}', function($id){
    $curriculum = new Curriculum($id);
    $curriculum->buildCurriculum();
    DB::connection('plan')->unprepared('SELECT refreshallmaterializedviews();');
    return 'ok';
  });

 ?>
