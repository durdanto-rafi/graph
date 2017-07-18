<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireStudentAnswerQueryMultipleChoice
 */
class TblQuestionnaireStudentAnswerQueryMultipleChoice extends Model
{
    protected $table = 'tbl_questionnaire_student_answer_query_multiple_choice';

    public $timestamps = false;

    protected $fillable = [
        'student_answer_query_number',
        'choices_number'
    ];

    protected $guarded = [];

        
}