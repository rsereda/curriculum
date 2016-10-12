<?php namespace Kironuniversity\General\Models;

use Model;

/**
* Application Model
*/
class Application extends Model
{

  use \October\Rain\Database\Traits\SoftDeleting;

  //protected $dates = [];

  /**
  * @var string The database table used by the model.
  */
  public $table = 'application';

  public $connection = 'plan';

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
  public $hasMany = [
    'status_documents' => 'Kironuniversity\General\Models\StatusDocument'
  ];
  public $belongsTo = ['country' => 'Kironuniversity\General\Models\Country',
  'graduation' => 'Kironuniversity\General\Models\Graduation',
  'study_program' => 'Kironuniversity\General\Models\StudyProgram',
  'application_status' => 'Kironuniversity\General\Models\GeneralStatus',
  'legal_status' => 'Kironuniversity\General\Models\LegalStatus'];
  public $belongsToMany = [];
  public $morphTo = [];
  public $morphOne = [];
  public $morphMany = [];
  public $attachOne = [];
  public $attachMany = [];

  protected function getDateFormat(){
    return 'Y-m-d H:i:sO';
  }


}
