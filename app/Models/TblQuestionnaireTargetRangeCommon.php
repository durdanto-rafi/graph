<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireTargetRangeCommon
 */
class TblQuestionnaireTargetRangeCommon extends Model
{
    protected $table = 'tbl_questionnaire_target_range_common';

    protected $primaryKey = 'questionnaire_common_target_range_number';

	public $timestamps = false;

    protected $fillable = [
        'questionnaire_number',
        'contents_category_number',
        'common_subject_number',
        'common_subject_section_number'
    ];

    protected $guarded = [];

        
}