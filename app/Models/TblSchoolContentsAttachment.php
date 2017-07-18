<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSchoolContentsAttachment
 */
class TblSchoolContentsAttachment extends Model
{
    protected $table = 'tbl_school_contents_attachment';

    protected $primaryKey = 'school_contents_attachment_number';

	public $timestamps = false;

    protected $fillable = [
        'school_contents_number',
        'file_name'
    ];

    protected $guarded = [];

        
}