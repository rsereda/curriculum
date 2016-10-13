<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateLearningOutcomesTable extends Migration
{
  public function up()
  {
    Schema::create('learning_outcome', function(Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->unsigned();
      $table->text('denomination')->default('');
      $table->integer('module_id')->unsigned();
      $table->foreign('module_id')->references('id')->on('module');
      $table->boolean('ready')->default(false);
      $table->softDeletes();
      $table->timestamp('created_at')->default(DB::raw('now()'));
      $table->timestamp('updated_at')->default(DB::raw('now()'));
    });
  }

  public function down()
  {
    Schema::dropIfExists('learning_outcome');
  }
}
