<?php namespace Kironuniversity\Curriculum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateClustersTable extends Migration
{

    public function up()
    {
        Schema::create('cluster', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('denomination');
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('cluster');
    }

}
