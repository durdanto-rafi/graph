<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblTrialTestResult
 */
class TblTrialTestResult extends Model
{
    protected $table = 'tbl_trial_test_result';

    protected $primaryKey = 'result_number';

	public $timestamps = false;

    protected $fillable = [
        'student_number',
        'trial_test_number',
        'top_subject_number',
        'score',
        'deviation_value',
        'deviation_rank',
        'enable'
    ];

    protected $guarded = [];

        
}