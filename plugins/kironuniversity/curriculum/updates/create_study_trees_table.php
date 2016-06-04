<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateStudyTreesTable extends Migration
{
    public function up()
    {
        Schema::create('study_tree', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('denomination')->default('');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('nest_left')->unsigned()->nullable();
            $table->integer('nest_right')->unsigned()->nullable();
            $table->integer('nest_depth')->unsigned()->nullable();
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_tree');
    }
}
