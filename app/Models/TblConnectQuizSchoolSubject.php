<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblConnectQuizSchoolSubject
 */
class TblConnectQuizSchoolSubject extends Model
{
    protected $table = 'tbl_connect_quiz_school_subject';

    public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'school_subject_number'
    ];

    protected $guarded = [];

        
}