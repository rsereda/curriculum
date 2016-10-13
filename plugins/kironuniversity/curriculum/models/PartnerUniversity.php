<?php namespace Kironuniversity\Curriculum\Models;

use Model;
use DB;
/**
* PartnerUniversity Model
*/
class PartnerUniversity extends Model
{

  /**
  * @var string The database table used by the model.
  */
  public $table = 'partner_university';

  /**
  * @var array Guarded fields
  */
  protected $guarded = ['*'];

  /**
  * @var array Fillable fields
  */
  protected $fillable = [];

  /**
  * @var array Relations
  */
  public $hasOne = [];
  public $hasMany = [];
  public $belongsTo = [];
  public $belongsToMany = [];
  public $morphTo = [];
  public $morphOne = [];
  public $morphMany = [];
  public $attachOne = [];
  public $attachMany = [];

  public function study_programs(){
    return DB::select(DB::raw('SELECT sp.id, sp.denomination, json_agg(distinct m.id) as modules
    FROM study_tree st
    JOIN study_program sp ON st.id = sp.id
    JOIN study_tree st2 ON st2.nest_left >= st.nest_left AND st2.nest_right <= st.nest_right
    JOIN module__study_tree mst ON mst.study_tree_id = st2.id
    JOIN module m ON m.id = mst.module_id and m.partner_university_id = '.$this->id.'
    GROUP BY sp.id, sp.denomination'));
  }

}
