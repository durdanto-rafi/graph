<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCommonSubjectSection
 */
class TblCommonSubjectSection extends Model
{
    protected $table = 'tbl_common_subject_section';

    protected $primaryKey = 'common_subject_section_number';

	public $timestamps = false;

    protected $fillable = [
        'common_subject_number',
        'name',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}