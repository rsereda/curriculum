<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateModuleTeachingMethodTable extends Migration
{
    public function up()
    {
        Schema::create('module__teaching_method', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('module');
            $table->integer('teaching_method_id')->unsigned();
            $table->foreign('teaching_method_id')->references('id')->on('teaching_method');
            $table->unique(['module_id', 'teaching_method_id']);
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('module__teaching_method');
    }
}
?>
