<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchoolAccessRestriction
 */
class TblSchoolAccessRestriction extends Model
{
    protected $table = 'tbl_school_access_restriction';

    protected $primaryKey = 'school_access_restriction_number';

	public $timestamps = false;

    protected $fillable = [
        'school_subject_section_number',
        'grade_enable',
        'classroom_enable',
        'course_enable'
    ];

    protected $guarded = [];

        
}