<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaire
 */
class TblQuestionnaire extends Model
{
    protected $table = 'tbl_questionnaire';

    protected $primaryKey = 'questionnaire_number';

	public $timestamps = false;

    protected $fillable = [
        'school_number',
        'title',
        'description',
        'finished_message',
        'enable',
        'vertical_index',
        'start_day',
        'last_day',
        'user_level_number',
        'register_user_number',
        'register_datetime',
        'type'
    ];

    protected $guarded = [];

        
}