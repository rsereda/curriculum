<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateClusterlearning_outcomeTable extends Migration
{
    public function up()
    {
        Schema::create('cluster__learning_outcome', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('cluster_id')->unsigned();
            $table->foreign('cluster_id')->references('id')->on('cluster');
            $table->integer('learning_outcome_id')->unsigned();
            $table->foreign('learning_outcome_id')->references('id')->on('learning_outcome');
            $table->unique(['cluster_id', 'learning_outcome_id']);
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('cluster__learning_outcome');
    }
}
?>
