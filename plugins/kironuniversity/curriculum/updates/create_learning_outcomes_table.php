<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLearningOutcomesTable extends Migration
{
  public function up()
  {
    Schema::create('kironuniversity_curriculum_learning_outcomes', function(Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->unsigned();
      $table->text('denomination')->default('');
      $table->integer('module_id')->unsigned();
      $table->foreign('module_id')->references('module')->on('id');
      $table->softDeletes();
      $table->timestamp('created_at')->default(DB::raw('now()'));
      $table->timestamp('updated_at')->default(DB::raw('now()'));
    });
  }

  public function down()
  {
    Schema::dropIfExists('kironuniversity_curriculum_learning_outcomes');
  }
}
