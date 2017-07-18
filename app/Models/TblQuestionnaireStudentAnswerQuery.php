<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireStudentAnswerQuery
 */
class TblQuestionnaireStudentAnswerQuery extends Model
{
    protected $table = 'tbl_questionnaire_student_answer_query';

    protected $primaryKey = 'student_answer_query_number';

	public $timestamps = false;

    protected $fillable = [
        'student_answer_number',
        'questionnaire_query_number',
        'query_type'
    ];

    protected $guarded = [];

        
}