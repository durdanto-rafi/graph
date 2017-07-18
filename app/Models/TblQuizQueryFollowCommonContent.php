<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizQueryFollowCommonContent
 */
class TblQuizQueryFollowCommonContent extends Model
{
    protected $table = 'tbl_quiz_query_follow_common_contents';

    public $timestamps = false;

    protected $fillable = [
        'quiz_query_number',
        'common_contents_number'
    ];

    protected $guarded = [];

        
}