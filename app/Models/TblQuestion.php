<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestion
 */
class TblQuestion extends Model
{
    protected $table = 'tbl_question';

    protected $primaryKey = 'question_number';

	public $timestamps = false;

    protected $fillable = [
        'common_contents_number',
        'school_contents_number',
        'student_number',
        'teacher_number',
        'text',
        'datetime',
        'enable'
    ];

    protected $guarded = [];

        
}