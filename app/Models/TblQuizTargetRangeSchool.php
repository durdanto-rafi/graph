<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizTargetRangeSchool
 */
class TblQuizTargetRangeSchool extends Model
{
    protected $table = 'tbl_quiz_target_range_school';

    protected $primaryKey = 'school_target_range_number';

	public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'contents_category_number',
        'school_subject_number',
        'school_subject_section_number',
        'school_contents_number'
    ];

    protected $guarded = [];

        
}