<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblConnectQuizSchoolSubjectSection
 */
class TblConnectQuizSchoolSubjectSection extends Model
{
    protected $table = 'tbl_connect_quiz_school_subject_section';

    public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'school_subject_section_number'
    ];

    protected $guarded = [];

        
}