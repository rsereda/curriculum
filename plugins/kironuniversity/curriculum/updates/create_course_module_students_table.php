<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateCourseModuleStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('course__module__student', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('course');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('module');
            $table->integer('student_id')->unsigned();
            //$table->foreign('student_id')->references('id')->on('student');
            $table->unique(['module_id', 'course_id', 'student_id']);
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('course__module__student');
    }
}
