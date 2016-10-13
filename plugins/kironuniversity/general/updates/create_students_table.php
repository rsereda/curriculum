<?php namespace Kironuniversity\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateStudentsTable extends Migration
{

    public function up()
    {
        Schema::create('kironuniversity_general_students', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kironuniversity_general_students');
    }

}
