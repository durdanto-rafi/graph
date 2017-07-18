<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogSchoolContentsHistoryStudent
 */
class LogSchoolContentsHistoryStudent extends Model
{
    protected $table = 'log_school_contents_history_student';

    protected $primaryKey = 'history_number';

	public $timestamps = false;

    protected $fillable = [
        'school_contents_number',
        'student_number',
        'player3_code',
        'key_word',
        'registered_datetime',
        'contents_download_datetime',
        'history_upload_datetime',
        'duration',
        'play_start_datetime'
    ];

    protected $guarded = [];

        
}