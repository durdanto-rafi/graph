<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchoolAccessRestrictionGrade
 */
class TblSchoolAccessRestrictionGrade extends Model
{
    protected $table = 'tbl_school_access_restriction_grade';

    public $timestamps = false;

    protected $fillable = [
        'school_access_restriction_number',
        'grade_number'
    ];

    protected $guarded = [];

        
}