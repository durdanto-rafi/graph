<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblConnectQuizCommonSubjectSection
 */
class TblConnectQuizCommonSubjectSection extends Model
{
    protected $table = 'tbl_connect_quiz_common_subject_section';

    public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'common_subject_section_number'
    ];

    protected $guarded = [];

        
}