<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class AddDaandOrderToModule extends Migration
{
    public function up()
    {
        Schema::table('module', function(Blueprint $table) {
            $table->text('da_link')->default('');
            $table->integer('rank')->default(100);
        });
    }

    public function down()
    {
      Schema::table('module', function(Blueprint $table) {
          $table->dropColumn('da_link');
          $table->dropColumn('rank');
      });
    }
}
