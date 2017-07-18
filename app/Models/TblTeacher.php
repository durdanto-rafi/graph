<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblTeacher
 */
class TblTeacher extends Model
{
    protected $table = 'tbl_teacher';

    protected $primaryKey = 'teacher_number';

	public $timestamps = false;

    protected $fillable = [
        'school_number',
        'teacher_code',
        'classroom_number',
        'name',
        'password',
        'editable',
        'history_viewing_authority',
        'student_edit_authority',
        'access_code',
        'access_datetime',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}