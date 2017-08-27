<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchoolContentsBlock
 */
class TblSchoolContentsBlock extends Model
{
    protected $table = 'tbl_school_contents_blocks';

    protected $primaryKey = 'number';

	public $timestamps = false;

    protected $fillable = [
        'school_contents_number',
        'first_frame',
        'final_frame'
    ];

    protected $guarded = [];

        
}