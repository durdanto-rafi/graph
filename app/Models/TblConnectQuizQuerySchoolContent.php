<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblConnectQuizQuerySchoolContent
 */
class TblConnectQuizQuerySchoolContent extends Model
{
    protected $table = 'tbl_connect_quiz_query_school_contents';

    public $timestamps = false;

    protected $fillable = [
        'quiz_query_number',
        'school_contents_number'
    ];

    protected $guarded = [];

        
}