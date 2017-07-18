<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCommonAccessRestrictionClassroom
 */
class TblCommonAccessRestrictionClassroom extends Model
{
    protected $table = 'tbl_common_access_restriction_classroom';

    public $timestamps = false;

    protected $fillable = [
        'common_access_restriction_number',
        'classroom_number'
    ];

    protected $guarded = [];

        
}