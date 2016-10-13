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
          $table->boolean('hidden')->default(false);
        });
    }

    public function down()
    {

        Schema::table('study_tree', function(Blueprint $table) {
          $table->dropColumn('hidden');
        });
    }
}
?>
