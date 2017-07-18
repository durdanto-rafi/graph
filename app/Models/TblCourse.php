<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCourse
 */
class TblCourse extends Model
{
    protected $table = 'tbl_course';

    protected $primaryKey = 'course_number';

	public $timestamps = false;

    protected $fillable = [
        'school_number',
        'name',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}