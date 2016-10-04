<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class Createcourse_grouplearning_outcomeTable extends Migration
{
    public function up()
    {
        Schema::create('course_group__learning_outcome', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('learning_outcome_id')->unsigned();
            $table->foreign('learning_outcome_id')->references('id')->on('learning_outcome');
            $table->integer('course_group_id')->unsigned();
            $table->foreign('course_group_id')->references('id')->on('course_group');
            $table->unique(['learning_outcome_id', 'course_group_id']);
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_outcome__course_group');
    }
}
?>
