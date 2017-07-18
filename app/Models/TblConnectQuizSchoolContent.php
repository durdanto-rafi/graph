<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblConnectQuizSchoolContent
 */
class TblConnectQuizSchoolContent extends Model
{
    protected $table = 'tbl_connect_quiz_school_contents';

    public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'school_contents_number'
    ];

    protected $guarded = [];

        
}