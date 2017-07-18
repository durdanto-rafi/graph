<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizQueryCorrectAnswer
 */
class TblQuizQueryCorrectAnswer extends Model
{
    protected $table = 'tbl_quiz_query_correct_answer';

    protected $primaryKey = 'correct_answer_number';

	public $timestamps = false;

    protected $fillable = [
        'selection_number',
        'quiz_query_number'
    ];

    protected $guarded = [];

        
}