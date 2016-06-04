<?php namespace CSN\Curriculum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class CreatePlatformsTable extends Migration
{

    public function up()
    {
        Schema::create('platform', function($table)
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
        Schema::dropIfExists('platform');
    }

}
