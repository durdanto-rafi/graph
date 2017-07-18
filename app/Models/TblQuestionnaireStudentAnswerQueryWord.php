<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireStudentAnswerQueryWord
 */
class TblQuestionnaireStudentAnswerQueryWord extends Model
{
    protected $table = 'tbl_questionnaire_student_answer_query_word';

    protected $primaryKey = 'student_answer_query_number';

	public $timestamps = false;

    protected $fillable = [
        'word'
    ];

    protected $guarded = [];

        
}