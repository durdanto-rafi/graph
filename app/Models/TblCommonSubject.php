<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCommonSubject
 */
class TblCommonSubject extends Model
{
    protected $table = 'tbl_common_subject';

    protected $primaryKey = 'common_subject_number';

	public $timestamps = false;

    protected $fillable = [
        'name',
        'top_subject_number',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}