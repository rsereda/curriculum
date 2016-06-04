<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateCMCTable extends Migration
{
    public function up()
    {
        Schema::create('competency__module__course', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('competency__module_id')->unsigned();
            $table->foreign('competency__module_id')->references('id')->on('competency__module');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('course');
            $table->enum('status',['new','inactive', 'rejected', 'accepted']);
            $table->unique(['competency__module_id', 'course_id']);
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('competency__module__course');
    }
}
?>
