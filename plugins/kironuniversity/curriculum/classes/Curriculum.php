<?php namespace Kironuniversity\Curriculum\Classes;

use Log;
use DB;
use App;
use Config;
use Kironuniversity\Curriculum\Models\CourseModule;
use Kironuniversity\Curriculum\Models\Course;
use Kironuniversity\Curriculum\Models\Module;
use Kironuniversity\Curriculum\Models\CourseGroup;
use Kironuniversity\Curriculum\Models\LearningOutcome;
use Kironuniversity\Curriculum\Models\StudyTree;
use Kironuniversity\Curriculum\Models\StudyProgram;
use Kironuniversity\Curriculum\Classes\LPSolve;


/*
  Helper class for generating the managing and generating the individualized curriculum for students
*/
class Curriculum
{

  protected $modules = [];
  protected $studyProgramID = null;

  public function __construct($studentID = null, $studyProgramID = null){
    if($studentID == null){
      if($studyProgramID == null){

        $this->studyProgramID = StudyProgram::first()->id;
      }else{
        $this->studyProgramID = $studyProgramID;
      }
    }else{
      //Set ID For Student
    }
    $this->loadModules();
  }

  protected function loadModules(){
    $this->modules = Module::has('courses')->studyProgram($this->studyProgramID)->with(['learning_outcomes.course_groups',
    'course_groups' => function($query){
      $query->has('learning_outcomes');
    },'course_groups.courses','courses'])->get();
  }



  public function buildCurriculum(){
    $time_start = microtime(true);
    $f = [];
    $A = [];
    $b = [];
    $e = [];
    $moduleCount = count($this->modules);
    $lastVar = 0;
    $cmIDToVar = [];
    $cgIDToVar = [];
    $coursesCMVars = [];



    //Building Minimum Workload constriants
    foreach($this->modules as $module){
      $constraint = [];
      foreach($module->courses as $course){
        //$constraint[$lastVar] = (int)$course->workload;
        $f[$lastVar] = (int)$course->workload;
        $cmIDToVar[$course->pivot->id] = $lastVar;

        //Store for last constraint
        if(array_key_exists($course->id, $coursesCMVars)){
          $coursesCMVars[$course->id][] = $lastVar;
        }else{
          $coursesCMVars[$course->id] = [$lastVar];
        }
        $lastVar++;

      }
      /* Modules aren't finished yet.
      $A[] = $constraint;
      $b[] = (int)$module->cp*30;
      $e[] = 1; // >=
      */
    }


    //Building CourseGroup Constraint and Vars
    foreach($this->modules as $module){
      foreach($module->course_groups as $course_group){
        $f[$lastVar] = 0;

        $constraint = [$lastVar => 1  ];
        foreach($course_group->courses as $course_module){
          $cmVarID = $cmIDToVar[$course_module->id];
          $A[] = [$cmVarID => -1, $lastVar => 1];
          $e[] = -1; // <=
          $b[] = 0;
          $constraint[$cmVarID] = -1;
        }
        $A[] = $constraint;
        $e[] = 1; // >=
        $b[] = 1 - count($course_group->courses);
        $cgIDToVar[$course_group->id] = $lastVar;
        $lastVar++;
      }
    }



    //Building learning outcome constraints
    foreach($this->modules as $module){
      foreach($module->learning_outcomes as $learning_outcome){
        $constraint = [];
        foreach($learning_outcome->course_groups as $course_group){
          $constraint[$cgIDToVar[$course_group->id]] = 1;
        }
        if(!empty($constraint)){
          $A[] = $constraint;
          $e[] = 1; // >=
          $b[] = 1;
        }
      }
    }

    //Use Course only onces
    foreach($coursesCMVars as $cmVars){
      $constraint = [];
      foreach($cmVars as $var){
        $constraint[$var] = 1;
      }
      $A[] = $constraint;
      $e[] = -1; // >=
      $b[] = 1;
    }

    // Make all Variables integer variables
    $xint = range(1,count($f));
    $upper_bounds = array_fill(0,count($f),1);

    $ret = LPSolve::solve($f,$A,$b,$e,null,$upper_bounds,$xint);
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    dd($time,$coursesCMVars,$cmIDToVar,$A,$e,$b,$f,$ret);
  }





  public function getModules(){
    return $this->modules;
  }
}
