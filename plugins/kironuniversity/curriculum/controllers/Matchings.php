<?php namespace Kironuniversity\Curriculum\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Excel;
use Kironuniversity\Curriculum\Models\PartnerUniversity;
use Kironuniversity\Curriculum\Models\Module;
/**
* Matchings Back-end Controller
*/
class Matchings extends Controller
{
  /*
  public $implement = [
  'Backend.Behaviors.FormController',
  'Backend.Behaviors.ListController'];

  public $formConfig = 'config_form.yaml';
  public $listConfig = 'config_list.yaml';
  */

  public function __construct()
  {
    parent::__construct();

    BackendMenu::setContext('Kironuniversity.Curriculum', 'matchings', 'matchings');
  }

  public function index(){
    $this->vars['partneruniversities'] = PartnerUniversity::all();

  }

  public function matching($id){
    $partnerUniversity = PartnerUniversity::findOrFail($id);
    //dd($partnerUniversity->study_programs());
    $modules = Module::all();
    $indexedModules = [];
    foreach($modules as $module){
      $indexedModules[$module->id] = $module;
    }
    ini_set('memory_limit', '1024M');

    Excel::create($partnerUniversity->denomination, function($excel) use ($partnerUniversity, $indexedModules) {
      foreach($partnerUniversity->study_programs() as $studyProgram){
        $modules = json_decode($studyProgram->modules);
        $matching = [
          [
            'Feedback Partner University (to be filled in by university)',
            $partnerUniversity->denomination,
            'Semester',
            'Pflicht/Wahlpflicht',
            'Modulbezeichnung',
            'Learning Outcomes',
            'Exam type(s)',
            'CP full module',
            'Matched Courses',
            'Total workload in h',
            'University',
            'Description',
            'MOOC Learning Outcomes',
            'Exam Type(s)',
            'Syllabus',
            'Lecturer(s)',
            'Platform',
            'Link'
          ]
        ];
        foreach($modules as $moduleId){
          $row = array_fill(1,4, null);
          $module = $indexedModules[$moduleId];
          $row[] = $module->denomination;
          //dd($module->competencies);
          $row[] = join(",\n",$module->competencies->lists('denomination'));
          $row[] = null;
          $row[] = $module->cp;
          $courses = $module->courses();
          $ran = false;
          foreach($courses as $course){
            $ran = true;
            $row[] = $course->denomination;
            $row[] = $course->workload;
            $row[] = $course->university;
            $row[] = $course->description;
            $row[] = join(",\n",$course->competencies->lists('denomination'));
            $row[] = join(",\n",$course->examtypes->lists('denomination'));
            $row[] = $course->syllabus;
            $row[] = null;
            $row[] = $course->platform->denomination;
            $row[] = $course->link;
            $matching[] = $row;
            $row = array_fill(1,8, null);
          }
          if(!$ran){
            $matching[] = $row;
          }
        }
        $excel->sheet($studyProgram->denomination, function($sheet) use ($matching){
          $sheet->fromArray($matching, null, 'A1', false, false);
          $sheet->setAutoSize(true);
          $sheet->setWidth('F', 50);
          $sheet->setWidth('M', 50);
          $sheet->setWidth('L', 50);
          $sheet->setWidth('O', 50);
          $lastrow= $sheet->getHighestRow();
          $sheet->getStyle('F2:F'.$lastrow)->getAlignment()->setWrapText(true);
          $sheet->getStyle('M2:M'.$lastrow)->getAlignment()->setWrapText(true);
          $sheet->getStyle('O2:O'.$lastrow)->getAlignment()->setWrapText(true);
          $sheet->getStyle('L2:L'.$lastrow)->getAlignment()->setWrapText(true);

          /*$sheet->cells('I1:I'.$lastrow, function($cells) {
            $cells->setValignment('top');
          });*/
        });

      }
    })->export('xlsx');
  }
}
