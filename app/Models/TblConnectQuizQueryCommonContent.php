<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblConnectQuizQueryCommonContent
 */
class TblConnectQuizQueryCommonContent extends Model
{
    protected $table = 'tbl_connect_quiz_query_common_contents';

    public $timestamps = false;

    protected $fillable = [
        'quiz_query_number',
        'common_contents_number'
    ];

    protected $guarded = [];

        
}