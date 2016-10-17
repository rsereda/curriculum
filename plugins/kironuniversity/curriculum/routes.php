<?php

  use Kironuniversity\Curriculum\Classes\Curriculum;

  Route::get('updatecurriculumforstudent/{student}/{studyprogram}', function($studentID,$studyProgramID){
    $curriculum = new Curriculum($studentID);
    $curriculum->setStudyProgram($studyProgramID);
    $curriculum->buildCurriculum();
    DB::connection('plan')->unprepared('SELECT refreshallmaterializedviews();');
    return 'ok';
  });

 ?>
