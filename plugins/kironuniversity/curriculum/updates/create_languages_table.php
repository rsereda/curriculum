<?php namespace CSN\Curriculum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateLanguagesTable extends Migration
{

    public function up()
    {
        Schema::create('language', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('denomination');
            $table->char('code2');
            $table->char('code3');
            $table->char('code3alt');
            $table->string('short');
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('language');
    }

}
