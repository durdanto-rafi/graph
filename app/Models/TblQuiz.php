<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuiz
 */
class TblQuiz extends Model
{
    protected $table = 'tbl_quiz';

    protected $primaryKey = 'quiz_number';

	public $timestamps = false;

    protected $fillable = [
        'school_number',
        'title',
        'description',
        'qualifying_score',
        'finished_message',
        'enable',
        'vertical_index',
        'start_day',
        'last_day',
        'register_datetime',
        'time_limit',
        'repeat_challenge',
        'common_subject_section_number',
        'school_subject_section_number',
        'permission_display_explain',
        'permission_display_answer',
        'permission_display_average',
        'permission_display_rank',
        'permission_display_student_answer',
        'permission_display_correct_answer_rate',
        'permission_display_success_or_failure',
        'permission_watch_after_quiz',
        'permission_display_deviation_value',
        'permission_display_query_correct_or_incorrect',
        'register_admin_number',
        'register_teacher_number'
    ];

    protected $guarded = [];

        
}