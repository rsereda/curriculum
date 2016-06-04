<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateCompetencyModuleTable extends Migration
{
    public function up()
    {
        Schema::create('competency__module', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('competency_id')->unsigned();
            $table->foreign('competency_id')->references('id')->on('competency');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('module');
            $table->unique(['competency_id', 'module_id']);
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('competency__module');
    }
}
?>
