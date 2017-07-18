<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireStudentAnswerQueryText
 */
class TblQuestionnaireStudentAnswerQueryText extends Model
{
    protected $table = 'tbl_questionnaire_student_answer_query_text';

    protected $primaryKey = 'student_answer_query_number';

	public $timestamps = false;

    protected $fillable = [
        'text'
    ];

    protected $guarded = [];

        
}