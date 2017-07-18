<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchoolAccessRestrictionClassroom
 */
class TblSchoolAccessRestrictionClassroom extends Model
{
    protected $table = 'tbl_school_access_restriction_classroom';

    public $timestamps = false;

    protected $fillable = [
        'school_access_restriction_number',
        'classroom_number'
    ];

    protected $guarded = [];

        
}