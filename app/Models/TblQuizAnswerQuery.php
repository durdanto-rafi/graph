<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizAnswerQuery
 */
class TblQuizAnswerQuery extends Model
{
    protected $table = 'tbl_quiz_answer_query';

    protected $primaryKey = 'quiz_answer_query_number';

	public $timestamps = false;

    protected $fillable = [
        'quiz_answer_number',
        'quiz_query_number',
        'query_type',
        'flg_right',
        'flg_no_answer'
    ];

    protected $guarded = [];

        
}