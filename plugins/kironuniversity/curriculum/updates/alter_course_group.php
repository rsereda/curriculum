<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class AlterCourseGroupTable extends Migration
{
    public function up()
    {
        Schema::table('course_group', function(Blueprint $table) {
          $table->integer('module_id')->unsigned();
          $table->foreign('module_id')->references('id')->on('module');
        });
    }

    public function down()
    {

        Schema::table('course_group', function(Blueprint $table) {
          $table->dropColumn('module_id');
        });
    }
}
?>
