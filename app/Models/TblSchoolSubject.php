<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchoolSubject
 */
class TblSchoolSubject extends Model
{
    protected $table = 'tbl_school_subject';

    protected $primaryKey = 'school_subject_number';

	public $timestamps = false;

    protected $fillable = [
        'school_number',
        'name',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}