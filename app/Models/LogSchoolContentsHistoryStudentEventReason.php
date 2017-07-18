<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogSchoolContentsHistoryStudentEventReason
 */
class LogSchoolContentsHistoryStudentEventReason extends Model
{
    protected $table = 'log_school_contents_history_student_event_reason';

    protected $primaryKey = 'reason_number';

	public $timestamps = false;

    protected $fillable = [
        'event_number',
        'event_reason_number'
    ];

    protected $guarded = [];

        
}