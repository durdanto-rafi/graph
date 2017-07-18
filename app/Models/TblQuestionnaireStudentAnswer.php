<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireStudentAnswer
 */
class TblQuestionnaireStudentAnswer extends Model
{
    protected $table = 'tbl_questionnaire_student_answer';

    protected $primaryKey = 'student_answer_number';

	public $timestamps = false;

    protected $fillable = [
        'questionnaire_number',
        'student_number',
        'answer_datetime'
    ];

    protected $guarded = [];

        
}