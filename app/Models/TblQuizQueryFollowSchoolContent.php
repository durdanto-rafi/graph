<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizQueryFollowSchoolContent
 */
class TblQuizQueryFollowSchoolContent extends Model
{
    protected $table = 'tbl_quiz_query_follow_school_contents';

    public $timestamps = false;

    protected $fillable = [
        'quiz_query_number',
        'school_contents_number'
    ];

    protected $guarded = [];

        
}