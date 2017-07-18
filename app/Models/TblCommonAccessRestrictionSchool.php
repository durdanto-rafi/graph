<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCommonAccessRestrictionSchool
 */
class TblCommonAccessRestrictionSchool extends Model
{
    protected $table = 'tbl_common_access_restriction_school';

    public $timestamps = false;

    protected $fillable = [
        'common_subject_section_number',
        'school_number'
    ];

    protected $guarded = [];

        
}