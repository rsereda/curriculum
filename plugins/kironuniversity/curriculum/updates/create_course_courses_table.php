<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use DB;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCourseCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('course__course', function(Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->increments('id');
          $table->integer('course_required_id')->unsigned();
          $table->foreign('course_required_id')->references('id')->on('course');
          $table->integer('course_for_id')->unsigned();
          $table->foreign('course_for_id')->references('id')->on('course');
          $table->unique(['course_required_id', 'course_for_id']);
          $table->softDeletes();
          $table->timestamp('created_at')->default(DB::raw('now()'));
          $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('course__course');
    }
}
