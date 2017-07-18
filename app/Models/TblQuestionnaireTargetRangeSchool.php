<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireTargetRangeSchool
 */
class TblQuestionnaireTargetRangeSchool extends Model
{
    protected $table = 'tbl_questionnaire_target_range_school';

    protected $primaryKey = 'questionnaire_school_target_range_number';

	public $timestamps = false;

    protected $fillable = [
        'questionnaire_number',
        'contents_category_number',
        'school_subject_number',
        'school_subject_section_number'
    ];

    protected $guarded = [];

        
}