<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class AddSoftDelAndReadyToCourseTable extends Migration
{
    public function up()
    {
        Schema::table('course', function(Blueprint $table) {
          $table->softDeletes();
        });
    }

    public function down()
    {

        Schema::table('course', function(Blueprint $table) {
          $table->dropColumn('deleted_at');
        });
    }
}

?>
