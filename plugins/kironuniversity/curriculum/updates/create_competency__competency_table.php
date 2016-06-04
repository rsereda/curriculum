<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateCompetencyCompetencyTable extends Migration
{
    public function up()
    {
        Schema::create('competency__competency', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('competency_required_id')->unsigned();
            $table->foreign('competency_required_id')->references('id')->on('competency');
            $table->integer('competency_for_id')->unsigned();
            $table->foreign('competency_for_id')->references('id')->on('competency');
            $table->unique(['competency_required_id', 'competency_for_id']);
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('competency__competency');
    }
}
?>
