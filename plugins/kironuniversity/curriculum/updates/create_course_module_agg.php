<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateCourseModuleAggTable extends Migration
{
    public function up()
    {
      DB::statement('CREATE VIEW "public"."course__module_agg" AS SELECT cm.*, course.denomination as course_denomination from course__module cm
      join course on cm.course_id = course.id');
    }

    public function down()
    {

    }
}
?>
