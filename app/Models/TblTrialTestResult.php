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
        'japanese_score',
        'japanese_deviation_value',
        'japanese_deviation_rank',
        'math_score',
        'math_deviation_value',
        'math_deviation_rank',
        'english_score',
        'english_deviation_value',
        'english_deviation_rank',
        'science_score',
        'science_deviation_value',
        'science_deviation_rank',
        'sotial_studies_score',
        'sotial_studies_deviation_value',
        'sotial_studies_deviation_rank',
        'enable'
    ];

    protected $guarded = [];

        
}