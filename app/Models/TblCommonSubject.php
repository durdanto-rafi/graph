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
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}