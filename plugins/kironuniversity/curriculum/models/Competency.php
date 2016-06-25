<?php namespace Kironuniversity\Curriculum\Models;

use Model;

/**
 * Competency Model
 */
class Competency extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'competency';

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
    public $belongsToMany = [
      'courses' => ['Kironuniversity\Curriculum\Models\Course', 'table' => 'competency__course'],
      'modules' => ['Kironuniversity\Curriculum\Models\Module', 'table' => 'competency__module'],
      'clusters' => ['Kironuniversity\Curriculum\Models\Cluster', 'table' => 'cluster__competency'],
      'required' =>
      [
        'Kironuniversity\Curriculum\Models\Competency',
        'table' => 'competency__competency',
        'key' => 'competency_for_id',
        'otherKey' => 'competency_required_id',
      ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
