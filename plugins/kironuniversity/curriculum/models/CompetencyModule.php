<?php namespace Kironuniversity\Curriculum\Models;

use Model;
use Log;
/**
 * CompetencyModule Model
 */
class CompetencyModule extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'competency__module';

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
    public $belongsTo = [
      'module' => 'Kironuniversity\Curriculum\Models\Module',
      'competency' => 'Kironuniversity\Curriculum\Models\Competency',
    ];
    public $belongsToMany = [
            'courses' => ['Kironuniversity\Curriculum\Models\Course', 'table' => 'competency__module__course','key'=>'competency__module_id',
          'pivot' => ['status','id']],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


}
