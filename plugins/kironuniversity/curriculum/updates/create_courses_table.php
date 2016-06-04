<?php namespace CSN\Curriculum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateCoursesTable extends Migration
{

    public function up()
    {
        Schema::create('course', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('platform_id')->unsigned();
            $table->text('denomination')->default('');
            $table->integer('course_level_id')->unsigned();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('university')->default('');
            $table->enum('certificate', ['paid', 'free', 'none']);
            $table->float('workload')->nullable();
            $table->integer('weeks');
            $table->float('cp')->nullable();
            $table->text('link');
            $table->text('syllabus')->default('');
            $table->text('short_description')->default('');
            $table->text('long_description')->default('');
            $table->boolean('ready')->default(DB::raw('false'));
            $table->text('lecturer_contacted')->default('');
            $table->text('notes')->default('');
            $table->foreign('course_level_id')->references('id')->on('course_level');
            $table->foreign('platform_id')->references('id')->on('platform');
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('course');
    }

}
