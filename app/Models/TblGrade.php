<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblGrade
 */
class TblGrade extends Model
{
    protected $table = 'tbl_grade';

    protected $primaryKey = 'grade_number';

	public $timestamps = false;

    protected $fillable = [
        'school_number',
        'name',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}