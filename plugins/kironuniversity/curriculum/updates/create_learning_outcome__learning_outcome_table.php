<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateCompetencyCompetencyTable extends Migration
{
    public function up()
    {
        Schema::create('learning_outcome__learning_outcome', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('learning_outcome_required_id')->unsigned();
            $table->foreign('learning_outcome_required_id')->references('id')->on('learning_outcome');
            $table->integer('learning_outcome_for_id')->unsigned();
            $table->foreign('learning_outcome_for_id')->references('id')->on('learning_outcome');
            $table->unique(['learning_outcome_required_id', 'learning_outcome_for_id']);
            $table->boolean('ready')->default(false);
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_outcome__learning_outcome');
    }
}
?>
