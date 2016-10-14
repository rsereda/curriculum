<?php namespace Kironuniversity\Curriculum\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Kironuniversity\Curriculum\Classes\Curriculum;
use Kironuniversity\General\Models\Student;
use Queue;
use Config;
/**
 * Push Live Back-end Controller
 */
class PushLive extends Controller
{
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Kironuniversity.Curriculum', 'pushlive', 'pushlive');
    }

    public function index(){

    }

    public function onPush(){
      $result = '';
      $this->genmodules();
      Flash::success('Done');
      return ['#output' => '<p>'.$result.'</p><p>'.$result.'</p>'];
    }

    public function genmodules(){
        $students = Student::orderBy('id')->lists('id');
        foreach($students as $studentID){
          Queue::push('Kironuniversity\Curriculum\Classes\Curriculum@buildCurriculumJob', ['studentID' => $studentID]);
        }
        Queue::push('Kironuniversity\Curriculum\Classes\Curriculum@refreshKironDBJob',['job'=>1]);
    }

    public function refresh(){
      $curriculum = new Curriculum();
      $curriculum->refreshKironDB();
    }
}
