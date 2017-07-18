<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizAnswer
 */
class TblQuizAnswer extends Model
{
    protected $table = 'tbl_quiz_answer';

    protected $primaryKey = 'quiz_answer_number';

	public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'school_number',
        'student_number',
        'register_datetime',
        'answer_time',
        'total_score',
        'correct_answer_rate'
    ];

    protected $guarded = [];

        
}