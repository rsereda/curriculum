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
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
