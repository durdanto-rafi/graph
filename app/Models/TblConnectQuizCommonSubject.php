<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblConnectQuizCommonSubject
 */
class TblConnectQuizCommonSubject extends Model
{
    protected $table = 'tbl_connect_quiz_common_subject';

    public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'common_subject_number'
    ];

    protected $guarded = [];

        
}