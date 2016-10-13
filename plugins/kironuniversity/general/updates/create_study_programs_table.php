<?php namespace Kironuniversity\General\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateStudyProgramsTable extends Migration
{

    public function up()
    {
        /*Schema::create('study_programs', function($table)
        {
            $table->increments('id');
            $table->timestamps();
        });*/
        //Exists already
    }

    public function down()
    {
        //Schema::dropIfExists('kironuniversity_general_study_programs');
    }

}
