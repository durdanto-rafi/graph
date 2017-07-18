<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizAnswerQueryChoice
 */
class TblQuizAnswerQueryChoice extends Model
{
    protected $table = 'tbl_quiz_answer_query_choice';

    public $timestamps = false;

    protected $fillable = [
        'answer_query_number',
        'selection_number'
    ];

    protected $guarded = [];

        
}