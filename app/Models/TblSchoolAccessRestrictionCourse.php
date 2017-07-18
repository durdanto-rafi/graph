<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchoolAccessRestrictionCourse
 */
class TblSchoolAccessRestrictionCourse extends Model
{
    protected $table = 'tbl_school_access_restriction_course';

    public $timestamps = false;

    protected $fillable = [
        'school_access_restriction_number',
        'course_number'
    ];

    protected $guarded = [];

        
}