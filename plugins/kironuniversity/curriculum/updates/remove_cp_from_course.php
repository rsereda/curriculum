<?php namespace Kironuniversity\Curriculum\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class RemoveCPCourse extends Migration
{
  public function up()
  {
    DB::statement('ALTER TABLE "public"."course" DROP COLUMN "cp";');
  }

  public function down()
  {

  }
}
