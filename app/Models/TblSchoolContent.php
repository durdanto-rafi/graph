<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchoolContent
 */
class TblSchoolContent extends Model
{
    protected $table = 'tbl_school_contents';

    protected $primaryKey = 'school_contents_number';

	public $timestamps = false;

    protected $fillable = [
        'school_subject_section_number',
        'name',
        'comment',
        'first_day',
        'last_day',
        'file_name',
        'user_level_number',
        'teacher_number',
        'contents_extension_number',
        'size',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}