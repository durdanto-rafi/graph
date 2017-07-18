<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogSchoolContentsHistoryStudentEvent
 */
class LogSchoolContentsHistoryStudentEvent extends Model
{
    protected $table = 'log_school_contents_history_student_event';

    protected $primaryKey = 'event_number';

	public $timestamps = false;

    protected $fillable = [
        'history_number',
        'progress_time',
        'position',
        'event_action_number',
        'speed_number',
        'volume_number'
    ];

    protected $guarded = [];

        
}