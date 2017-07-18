<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCommonAccessRestriction
 */
class TblCommonAccessRestriction extends Model
{
    protected $table = 'tbl_common_access_restriction';

    protected $primaryKey = 'common_access_restriction_number';

	public $timestamps = false;

    protected $fillable = [
        'common_subject_section_number',
        'school_number',
        'grade_enable',
        'classroom_enable',
        'course_enable'
    ];

    protected $guarded = [];

        
}