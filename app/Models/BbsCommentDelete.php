<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BbsCommentDelete
 */
class BbsCommentDelete extends Model
{
    protected $table = 'bbs_comment_delete';

    protected $primaryKey = 'comment_number';

	public $timestamps = false;

    protected $fillable = [
        'user_level',
        'user_number',
        'delete_datetime'
    ];

    protected $guarded = [];

        
}