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
use Kironuniversity\Curriculum\Models\CourseModuleStudent;
use Kironuniversity\Curriculum\Classes\LPSolve;
use Kironuniversity\General\Models\Student;


/*
Helper class for generating the managing and generating the individualized curriculum for students
*/
class Curriculum
{

  protected $modules = [];
  protected $student;

  public function __construct($studentID = null, $studyProgramID = null){
    $this->setStudent($studentID = null, $studyProgramID = null);
    $this->loadModules();
  }

  public function fire($job, $data)
  {
    Log::info('Build Curriculum for'. $data['studentID']);
    $this->setStudent($data['studentID']);
    $this->loadModules();
    $this->buildCurriculum();
    $job->delete();
  }


  protected function loadModules(){
    $this->modules = Module::has('courses')->studyProgram($this->student->study_program_id)->with(['learning_outcomes.course_groups',
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
    $varToCM = [];
    $cgIDToVar = [];
    $coursesCMVars = [];


    $taken = $this->student->courses->lists('id');
    //Building Minimum Workload constriants
    foreach($this->modules as $module){
      $constraint = [];
      foreach($module->courses as $course){

        if(in_array($course->id, $taken)){
          //Make taken courses free to use
          $f[$lastVar] = 0;
        } else {
          $f[$lastVar] = (int)$course->workload;
        }
        $cmIDToVar[$course->pivot->id] = $lastVar;
        $varToCM[$lastVar] = ['course_id' => $course->id, 'module_id' => $module->id, 'student_id' => $this->student->id];
        //$constraint[$lastVar] = (int)$course->workload;

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
      foreach($cmVars as $courseID => $var){
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
    if(!is_array($ret) or $ret[3] != 0){
      Log::error('Could not generate optimal solution for student '.$this->student->id);
      Log::error($this->modules);
      Log::error($ret);
    }else{
      //dd($varToCM);
      Log::info('Built Curriculum');
      $cmvars = count($varToCM);
      $cms = [];
      foreach($ret[1] as $var => $val){
        if($var >= $cmvars){
          break;
        }
        if($val == 1){
          $cms[] = $varToCM[$var];
        }
      }
      $this->writeCurriculum($cms);
      //dd($ret,$cmvars,$cms);
    }
    //dd($time,$this->modules,$coursesCMVars,$cmIDToVar,$A,$e,$b,$f,$ret);
  }

  public function getModules(){
    return $this->modules;
  }

  public function setStudent(){
    if($studentID == null){
      $this->student = new Student();
      if($studyProgramID == null){
        $this->student->study_program_id = StudyProgram::first()->id;
      }else{
        $this->student->study_program_id = $studyProgramID;
      }
    }else{
      $this->student = Student::findOrFail($studentID);
    }
  }

  public function writeCurriculum($cms){
    if(!empty($this->student->id) and $this->student->id > 0){
      DB::beginTransaction();
      try{
        CourseModuleStudent::where('student_id',$this->student->id)->delete();
        CourseModuleStudent::insert($cms);
      }
      catch(\Exception $e)
      {
        DB::rollBack();
        throw $e;
      }
      DB::commit();
    }
  }
}
