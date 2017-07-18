<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireStudentAnswerQuerySingleChoice
 */
class TblQuestionnaireStudentAnswerQuerySingleChoice extends Model
{
    protected $table = 'tbl_questionnaire_student_answer_query_single_choice';

    public $timestamps = false;

    protected $fillable = [
        'student_answer_query_number',
        'choice_number'
    ];

    protected $guarded = [];

        
}