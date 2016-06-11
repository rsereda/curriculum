<?php namespace Kironuniversity\Curriculum\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class ChangeCMCStatus extends Migration
{
  public function up()
  {
    DB::statement("ALTER TABLE public.competency__module__course
    DROP CONSTRAINT competency__module__course_status_check,
    ADD CONSTRAINT competency__module__course_status_check CHECK (status::text = ANY (ARRAY['new'::character varying, 'inactive'::character varying, 'rejected'::character varying, 'accepted'::character varying, 'propose'::character varying]::text[]))");
  }

  public function down()
  {

  }
}
