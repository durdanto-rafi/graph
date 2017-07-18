<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCommonAccessRestrictionCourse
 */
class TblCommonAccessRestrictionCourse extends Model
{
    protected $table = 'tbl_common_access_restriction_course';

    public $timestamps = false;

    protected $fillable = [
        'common_access_restriction_number',
        'course_number'
    ];

    protected $guarded = [];

        
}