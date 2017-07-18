<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogSchoolContentsHistoryTeacher
 */
class LogSchoolContentsHistoryTeacher extends Model
{
    protected $table = 'log_school_contents_history_teacher';

    protected $primaryKey = 'history_number';

	public $timestamps = false;

    protected $fillable = [
        'school_contents_number',
        'teacher_number',
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