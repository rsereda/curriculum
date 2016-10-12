<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class AddSoftDelAndReadyToCourseGroupTable extends Migration
{
    public function up()
    {
        Schema::table('course_group', function(Blueprint $table) {
          $table->boolean('ready')->default(false);
          $table->softDeletes();
        });
    }

    public function down()
    {

        Schema::table('course_group', function(Blueprint $table) {
          $table->dropColumn('ready');
          $table->dropColumn('deleted_at');
        });
    }
}

?>
