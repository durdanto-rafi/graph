<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblClassroom
 */
class TblClassroom extends Model
{
    protected $table = 'tbl_classroom';

    protected $primaryKey = 'classroom_number';

	public $timestamps = false;

    protected $fillable = [
        'school_number',
        'name',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}