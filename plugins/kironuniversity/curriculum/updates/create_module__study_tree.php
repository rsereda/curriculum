<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateModuleStudyTreeTable extends Migration
{
    public function up()
    {
        Schema::create('module__study_tree', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('module');
            $table->integer('study_tree_id')->unsigned();
            $table->foreign('study_tree_id')->references('id')->on('study_tree');
            $table->unique(['module_id', 'study_tree_id']);
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('module__study_tree');
    }
}
?>
