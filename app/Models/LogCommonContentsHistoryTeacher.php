<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogCommonContentsHistoryTeacher
 */
class LogCommonContentsHistoryTeacher extends Model
{
    protected $table = 'log_common_contents_history_teacher';

    protected $primaryKey = 'history_number';

	public $timestamps = false;

    protected $fillable = [
        'common_contents_number',
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