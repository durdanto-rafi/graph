<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireTargetAccessRestriction
 */
class TblQuestionnaireTargetAccessRestriction extends Model
{
    protected $table = 'tbl_questionnaire_target_access_restriction';

    protected $primaryKey = 'questionnaire_target_number';

	public $timestamps = false;

    protected $fillable = [
        'questionnaire_number',
        'grade_number',
        'classroom_number',
        'course_number'
    ];

    protected $guarded = [];

        
}