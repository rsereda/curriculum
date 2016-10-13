<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class ReplaceReadyWithStatusModuleTable extends Migration
{
    public function up()
    {
        Schema::table('module', function(Blueprint $table) {
          $table->dropColumn('ready');
          $table->enum('status', ['new','ready','old'])->default('new');        
        });
    }

    public function down()
    {

        Schema::table('module', function(Blueprint $table) {
          $table->dropColumn('status');
        });
    }
}

?>
