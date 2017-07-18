<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizTargetAccessRestriction
 */
class TblQuizTargetAccessRestriction extends Model
{
    protected $table = 'tbl_quiz_target_access_restriction';

    protected $primaryKey = 'quiz_target_number';

	public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'grade_number',
        'classroom_number',
        'course_number'
    ];

    protected $guarded = [];

        
}