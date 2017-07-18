<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblStudent
 */
class TblStudent extends Model
{
    protected $table = 'tbl_student';

    protected $primaryKey = 'student_number';

	public $timestamps = false;

    protected $fillable = [
        'school_number',
        'student_code',
        'name',
        'classroom_number',
        'grade_number',
        'course_number',
        'joining',
        'password',
        'access_code',
        'access_datetime',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}