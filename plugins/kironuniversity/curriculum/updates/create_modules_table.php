<?php namespace CSN\Curriculum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateModulesTable extends Migration
{

    public function up()
    {
        Schema::create('module', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('denomination');
            $table->text('content');
            $table->float('cp');
            $table->float('duration')->nullable();
            $table->integer('responsible_user_id');
            $table->foreign('responsible_user_id')->references('id')->on('backend_users');
            $table->integer('partner_university_id');
            $table->foreign('partner_university_id')->references('id')->on('partner_university');
            $table->timestamp('created_at')->default(DB::raw('now()'));
            $table->timestamp('updated_at')->default(DB::raw('now()'));
            $table->integer('updated_by');
            $table->foreign('updated_by')->references('id')->on('backend_users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('module');
    }

}
