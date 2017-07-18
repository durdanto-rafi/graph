<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireStudentAnswerQueryLength
 */
class TblQuestionnaireStudentAnswerQueryLength extends Model
{
    protected $table = 'tbl_questionnaire_student_answer_query_length';

    protected $primaryKey = 'student_answer_query_number';

	public $timestamps = false;

    protected $fillable = [
        'length'
    ];

    protected $guarded = [];

        
}