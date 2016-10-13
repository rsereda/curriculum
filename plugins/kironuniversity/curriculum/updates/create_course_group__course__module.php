<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateCoursecourse__moduleTable extends Migration
{
    public function up()
    {
        Schema::create('course_group__course__module', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('course__module_id')->unsigned();
            $table->foreign('course__module_id')->references('id')->on('course__module');
            $table->integer('course_group_id')->unsigned();
            $table->foreign('course_group_id')->references('id')->on('course_group');
            $table->unique(['course__module_id', 'course_group_id']);
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('course__module__course');
    }
}
?>
