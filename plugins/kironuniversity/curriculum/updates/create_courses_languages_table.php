<?php namespace CSN\Curriculum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateCoursesLanguagesTable extends Migration
{

    public function up()
    {
        Schema::create('course__language', function($table)
        {
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('language');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('course');
            $table->primary(['language_id', 'course_id']);
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('course__language');
    }

}
