<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class AddTakeToStudyTreeTable extends Migration
{
    public function up()
    {
        Schema::table('study_tree', function(Blueprint $table) {
          $table->integer('take_first')->unsigned()->default(0);
        });
    }

    public function down()
    {

        Schema::table('study_tree', function(Blueprint $table) {
          $table->dropColumn('take_first');
        });
    }
}
?>
