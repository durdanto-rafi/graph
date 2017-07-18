<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogSchoolContentsEditTeacher
 */
class LogSchoolContentsEditTeacher extends Model
{
    protected $table = 'log_school_contents_edit_teacher';

    protected $primaryKey = 'log_number';

	public $timestamps = false;

    protected $fillable = [
        'school_contents_number',
        'teacher_number',
        'contents_edit_action_number',
        'datetime'
    ];

    protected $guarded = [];

        
}