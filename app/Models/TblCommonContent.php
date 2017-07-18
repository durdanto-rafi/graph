<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCommonContent
 */
class TblCommonContent extends Model
{
    protected $table = 'tbl_common_contents';

    protected $primaryKey = 'common_contents_number';

	public $timestamps = false;

    protected $fillable = [
        'common_subject_section_number',
        'name',
        'comment',
        'file_name',
        'contents_extension_number',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}