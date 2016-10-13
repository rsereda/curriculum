<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class ReplaceReadyWithStatusCourseGroupTable extends Migration
{
    public function up()
    {
        Schema::table('course_group', function(Blueprint $table) {
          $table->dropColumn('ready');
          $table->enum('status', ['new','ready','old'])->default('new');
        });
    }

    public function down()
    {

        Schema::table('course_group', function(Blueprint $table) {
          $table->dropColumn('status');
        });
    }
}

?>
