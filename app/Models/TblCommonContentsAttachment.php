<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblCommonContentsAttachment
 */
class TblCommonContentsAttachment extends Model
{
    protected $table = 'tbl_common_contents_attachment';

    protected $primaryKey = 'common_contents_attachment_number';

	public $timestamps = false;

    protected $fillable = [
        'common_contents_number',
        'file_name'
    ];

    protected $guarded = [];

        
}