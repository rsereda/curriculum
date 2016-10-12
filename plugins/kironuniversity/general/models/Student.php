<?php namespace Kironuniversity\General\Models;

use Model;
/**
 * Student Model
 */
class Student extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'student';

    /**
     * @var array Guarded fields
     */


    /**
     * @var array Fillable fields
     */
    protected $guarded = [];

    public $timestamps = false;


    protected $jsonable = ['geocode_result'];

    /**
     * @var array Relations
     */
    public $hasOne = ['auth' => ['Kironuniversity\General\Models\Auth', 'key' => 'user']];

    public $belongsTo = [
    'study_program' => 'Kironuniversity\General\Models\StudyProgram',
    'legal_status' => 'Kironuniversity\General\Models\LegalStatus',
    'country' => ['Kironuniversity\General\Models\Country', 'key' => 'nationality'],];
    public $belongsToMany = [
      'service_offers' => [
        'Kironuniversity\Studentportal\Models\ServiceOffer',
        'key' => 'student_id',
        'table' => 'service_offer_student',
        'otherKey' => 'service_offer_id',
      ],
      'courses' => [
        'Kironuniversity\Curriculum\Models\Course',
        'table' => 'student__course',
      ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    protected function getDateFormat(){
      return 'Y-m-d H:i:sO';
    }

}
