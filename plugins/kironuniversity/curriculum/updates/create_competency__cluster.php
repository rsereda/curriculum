<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateClusterCompetencyTable extends Migration
{
    public function up()
    {
        Schema::create('cluster__competency', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('cluster_id')->unsigned();
            $table->foreign('cluster_id')->references('id')->on('cluster');
            $table->integer('competency_id')->unsigned();
            $table->foreign('competency_id')->references('id')->on('competency');
            $table->unique(['cluster_id', 'competency_id']);
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('cluster__competency');
    }
}
?>
