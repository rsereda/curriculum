<?php namespace Kironuniversity\Curriculum\Models;

use Model;

/**
 * Cluster Model
 */
class Cluster extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cluster';

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
      'competencies' => ['Kironuniversity\Curriculum\Models\Competency', 'table' => 'cluster__competency'],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
