<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCommonAccessRestrictionGrade
 */
class TblCommonAccessRestrictionGrade extends Model
{
    protected $table = 'tbl_common_access_restriction_grade';

    public $timestamps = false;

    protected $fillable = [
        'common_access_restriction_number',
        'grade_number'
    ];

    protected $guarded = [];

        
}