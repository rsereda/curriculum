<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateAvailableCoursesTable extends Migration
{


    public function up()
    {
        Schema::create('available_course', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('denomination')->default('');
            $table->string('url')->unique();
            $table->string('slug');
            $table->string('short_name')->nullable();
            $table->text('description')->nullable();
            $table->text('long_description')->nullable();
            $table->text('syllabus')->nullable();
            $table->string('initiative')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->boolean('exact_date_known');
            $table->string('language')->nullable();
            $table->string('video_intro')->nullable();
            $table->double('length')->nullable();
            $table->boolean('certificate')->nullable();
            $table->boolean('verified_certificate')->nullable();
            $table->double('workload_min')->nullable();
            $table->double('workload_max')->nullable();
            $table->integer('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('course');
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('available_course');
    }

}
