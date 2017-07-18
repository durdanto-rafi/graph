<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizTargetRangeCommon
 */
class TblQuizTargetRangeCommon extends Model
{
    protected $table = 'tbl_quiz_target_range_common';

    protected $primaryKey = 'common_target_range_number';

	public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'contents_category_number',
        'common_subject_number',
        'common_subject_section_number',
        'common_contents_number'
    ];

    protected $guarded = [];

        
}