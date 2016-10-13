<?php namespace Kironuniversity\Curriculum\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateStudyProgramView extends Migration
{
  public function up()
  {
    DB::statement("CREATE VIEW study_program AS SELECT id, denomination,
      (SELECT id FROM study_tree stc WHERE stc.parent_id = st.id AND denomination ilike 'prep%') as prep_node_id,
      (SELECT id FROM study_tree stc WHERE stc.parent_id = st.id AND denomination ilike 'core%') as core_node_id
      FROM study_tree as st WHERE nest_depth = 1;");
  }

  public function down()
  {
    DB::statement('DROP MATERIALIZED VIEW study_program');
  }
}
