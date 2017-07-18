<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchool
 */
class TblSchool extends Model
{
    protected $table = 'tbl_school';

    protected $primaryKey = 'school_number';

	public $timestamps = false;

    protected $fillable = [
        'name',
        'call_sign',
        'max_number_of_admin',
        'max_number_of_teacher',
        'max_number_of_student',
        'max_school_contents_total_giga_byte',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}