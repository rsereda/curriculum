<?php namespace Kironuniversity\Curriculum\Models;

use Model;

/**
* Platform Model
*/
class Platform extends Model
{

  /**
  * @var string The database table used by the model.
  */
  public $table = 'platform';

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


}
