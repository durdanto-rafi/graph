<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblTrialTestName
 */
class TblTrialTestName extends Model
{
    protected $table = 'tbl_trial_test_name';

    protected $primaryKey = 'trial_test_number';

	public $timestamps = false;

    protected $fillable = [
        'name',
        'implementation_day'
    ];

    protected $guarded = [];

        
}