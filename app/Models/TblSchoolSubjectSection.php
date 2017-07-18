<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchoolSubjectSection
 */
class TblSchoolSubjectSection extends Model
{
    protected $table = 'tbl_school_subject_section';

    protected $primaryKey = 'school_subject_section_number';

	public $timestamps = false;

    protected $fillable = [
        'school_subject_number',
        'name',
        'editable',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}